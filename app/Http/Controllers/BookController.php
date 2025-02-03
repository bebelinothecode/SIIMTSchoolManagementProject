<?php

namespace App\Http\Controllers;

use App\Book;
use App\PastQuestions;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function sumOfBooks() {
        $books = DB::table('books')->count();

        return view('dashboard.admin', ['books' => $books]);
    }

    public function uploadBook(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx',
        ]);

        $filePath = $request->file('file')->store('books', 'public');

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'isbn_number' => $request->isbn_number,
            'file_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Book uploaded successfully!');
    }

    public function displayBooks() {
        return view('backend.librarybooks.index');
    }

    public function download($id) {
        $book = Book::findOrFail($id);

        return response()->download(storage_path('app/public/' . $book->file_path));
    }

    public function viewOnline($id) {
        $book = Book::findOrFail($id);

        return response()->file(storage_path('app/public/' . $book->file_path));
    }

    public function edit($id) {
        $book = Book::findOrFail($id);

        $students = Student::all();

        return view('backend.librarybooks.edit', compact('book', 'students'));
    }

    public function deleteBook(Book $book) {
        $book->delete();

        return redirect()->route('librarybooks')->with('success', 'Book deleted successfully.');
    }

    public function showCreateBook() {
        return view('backend.librarybooks.create');
    }

    public function searchBooks(Request $request) {
        $query = $request->search_term;

        $books = DB::table('pdf')
            ->where('isbn_number', 'LIKE', "%{$query}%")
            ->orWhere('author', 'LIKE', "%{$query}%")
            ->orWhere('title', 'LIKE', "%{$query}%")
            ->get();
        
        return view('backend.librarybooks.index', [
            'books' => $books,
            'sessions' => Session::all(), // Pass sessions for the dropdown
        ]);
    }

    public function pastQuestions() {
        return view('backend.librarybooks.pastquestions');
    }

    public function uploadPastQuestions() {
        return view('backend.librarybooks.uploadpastquestions');
    }

    public function uploadExamsQuestions(Request $request) {
        // Validate the request
    $validatedData = $request->validate([
        'year_of_exams' => 'required|integer',
        'course_name' => 'required|string',
        'exams_paper' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
    ]);

    // Store the uploaded file
    $filePath = $request->file('exams_paper')->store('past_questions', 'public');

    // Save the data to the database
    PastQuestions::create([
        'year_of_exams' => $validatedData['year_of_exams'],
        'course_name' => $validatedData['course_name'],
        'exams_paper' => $filePath,
    ]);

    // Redirect back with a success message
    return redirect()->back()->with('success', 'Past Questions uploaded successfully!');
    }

    public function searchPastQuestions(Request $request) {
        $validatedData = $request->validate([
            'year_of_exams' => 'required',
            'course_name' => 'required'
        ]);

        $year_of_exmas = $validatedData['year_of_exams'];
        $course_name = $validatedData['course_name'];

        $query = PastQuestions::query();

        if (!empty($year_of_exmas)) {
            $query->where('year_of_exams', $year_of_exmas);
        }

        if (!empty($course_name)) {
            $query->where('course_name', 'LIKE', '%' . $course_name . '%');
        }

        $results = $query->get();

        return view('backend.librarybooks.pastquestions', compact('results'));
    }

    public function viewQuestionsOnline($id) {
        $question = PastQuestions::findOrFail($id);

        return response()->file(storage_path('app/public/' . $question->file_path));
    }
}