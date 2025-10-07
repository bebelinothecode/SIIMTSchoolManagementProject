<?php

namespace App\Http\Controllers;

use App\Book;
use App\Grade;
use App\Diploma;
use App\Student;
use App\PastQuestions;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Compilers\Concerns\CompilesRawPhp;


class BookController extends Controller
{
    public function sumOfBooks() {
        $books = DB::table('books')->count();

        return view('dashboard.admin', ['books' => $books]);
    }

    // public function uploadBook(Request $request) {
    //     try {
           
    //             //code...
    //             // dd($request->all());
    //             $validatedData = $request->validate([
    //                 'title' => 'required|string|max:255',
    //                 'author' => 'required|string|max:255',
    //                 'isbn_number' => 'nullable|string',
    //                 'publisher' => 'required|string',
    //                 'file' => 'required|file|mimes:pdf,doc,docx,txt'
    //             ]);

    //         $filePath = $request->file('file')->store('books', 'public');
    
    //         Book::create([
    //             'title' => $validatedData['title'],
    //             'author' => $validatedData['author'],
    //             'publisher' => $validatedData['publisher'],
    //             'isbn_number' => $validatedData['isbn_number'],
    //             'file_path' => $filePath,
    //         ]);
    
    //         return redirect()->back()->with('success', 'Book uploaded successfully!');
    //     } catch (\Exception $e) {
    //         //throw $th;
    //         Log::error("Error occured uploading book".$e);

    //         return redirect()->back()->with('error', 'Book uploaded unsuccessful!');
    //     } 
    // }

    // public function uploadBook(Request $request) {
    //     try {
    //         //code...
    //         $validatedData = $request->validate([
    //             'title' => 'required|string|max:255',
    //             'author' => 'required|string|max:255',
    //             'isbn_number' => 'nullable|string',
    //             'publisher' => 'nullable|string',
    //             'file' => 'required|file|mimes:pdf,doc,docx,txt'
    //         ]);

    //     } catch (ValidationException $e) {
    //         //throw $th;
    //         Log::error('Validation failed:',$e->errors());
    //         throw $e;
    //     }
            
    //     $filePath = $request->file('file')->store('books', 'public');

    //     Book::create([
    //         'title' => $validatedData['title'],
    //         'author' => $validatedData['author'],
    //         'publisher' => $validatedData['publisher'],
    //         'isbn_number' => $validatedData['isbn_number'],
    //         'file_path' => $filePath,
    //     ]);

    //     return redirect()->back()->with('success', 'Book uploaded successfully!');
    // }


    public function uploadBook(Request $request)
{
    try {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'isbn_number' => 'nullable|string',
            'publisher' => 'required|string',
            'book_name' => 'required|file|mimes:pdf,txt,doc,docx,jpg,jpeg,png,csv|max:450000',
        ]);

        // return $validatedData;

        // Only proceed if the file exists and passed validation
        $file = $request->file('book_name'); // This is now guaranteed to exist
        $filePath = $file->store('books', 'public');

        Book::create([
            'title' => $validatedData['title'],
            'author' => $validatedData['author'] ?? null,
            'publisher' => $validatedData['publisher'],
            'isbn_number' => $validatedData['isbn_number'] ?? null,
            'file_path' => $filePath,
        ]);

        Log::info('Book uploaded and saved successfully', ['file_path' => $filePath]);

        return redirect()->back()->with('success', 'Book uploaded successfully!');
    } catch (ValidationException $e) {
        // Catch validation failures separately and log them nicely
        return redirect()->back()
            ->withErrors($e )
            ->withInput()
            ->with('error', 'Validation failed. Please check your input.');
    } catch (Exception $e) {
        Log::error('Error occurred uploading book: '.$e->getMessage(), [
            'trace' => $e->getTraceAsString(),
        ]);

        return redirect()->back()->with('error', 'Book upload unsuccessful!');
    }
}

    

    public function deleteLibraryBook($id)
    {
        $book = Book::findOrFail($id);

        // Optionally delete file from storage
        if ($book->file_path && Storage::disk('public')->exists($book->file_path)) {
            Storage::disk('public')->delete($book->file_path);
        }

        $book->delete();

        return redirect()->back()->with('success', 'Book deleted successfully.');
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

    // public function pastQuestions() {
    //     $courses = Grade::all();

    //     $diplomas = Diploma::all();
        
    //     $dropdownItems = $courses->map(function ($course) {
    //         return ['id' => $course->id, 'name' => $course->course_name];
    //     })->merge($diplomas->map(function ($diploma) {
    //         return ['id' => $diploma->id, 'name' => $diploma->name];
    //     }));

    //     return view('backend.librarybooks.pastquestions', compact('dropdownItems'));
    // }

    public function pastQuestions() {
        $pastQuestions = PastQuestions::paginate(10);

        return view('backend.librarybooks.pastquestions',compact('pastQuestions'));
    }

    public function uploadPastQuestions() {

        $courses = Grade::all();

        $diplomas = Diploma::all();
        
        $dropdownItems = $courses->map(function ($course) {
            return ['id' => $course->id, 'name' => $course->course_name];
        })->merge($diplomas->map(function ($diploma) {
            return ['id' => $diploma->id, 'name' => $diploma->name];
        }));

        return view('backend.librarybooks.uploadpastquestions', compact('dropdownItems'));
    }

    public function uploadExamsQuestions(Request $request) {
    $validatedData = $request->validate([
        'year_of_exams' => 'required|integer',
        'course_name' => 'required|string',
        'exams_paper' => 'required|file|mimes:pdf,txt,doc,docx,jpg,jpeg,png|max:2048',
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

    public function viewQuestionsOnline($id)
    {
        $pastQuestion = PastQuestions::findOrFail($id);
        
        if (!Storage::disk('public')->exists($pastQuestion->exams_paper)) {
            return redirect()->back()->with('error', 'File not found!');
        }
    
        return Storage::disk('public')->download(
            $pastQuestion->exams_paper,
            $pastQuestion->course_name . '_' . $pastQuestion->year_of_exams . '.' . 
            pathinfo($pastQuestion->exams_paper, PATHINFO_EXTENSION)
        );
    }

    public function showAllBooks() {
        $books = Book::paginate(10);

        return view('backend.librarybooks.index',compact('books'));
    }

    public function showAllPastQuestions() {
        $pastQuestions = PastQuestions::paginate(10);

        return view('backend.librarybooks.pastquestions', compact('pastQuestions'));
    }

    public function deletePastQuestion($id) {
        $pastQuestion = PastQuestions::findOrFail($id);

        $pastQuestion->delete();

        return redirect()->back()->with('success', 'Book deleted successfully.');
    }
}