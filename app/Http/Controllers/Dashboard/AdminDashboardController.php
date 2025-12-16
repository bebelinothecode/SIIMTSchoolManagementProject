<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Parents;
use App\Teacher;
use App\Student;
use App\Expenses;
use App\FeesPaid;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
      public function index()
    {
        $parents = Parents::latest()->get();
        $teachers = Teacher::latest()->get();
        $students = Student::latest()->get();

        $studentsAcademic = Student::where('student_category','Academic')->count();
        $studentsProfessional = Student::where('student_category','Professional')->count();

        $books = DB::table('books')->count();
        $totalFeesCollected = FeesPaid::sum('amount');
        $totalExpensesMade = Expenses::sum('amount');

        return view('dashboard.admin', compact(
            'parents',
            'teachers',
            'students',
            'books',
            'totalFeesCollected',
            'totalExpensesMade',
            'studentsAcademic',
            'studentsProfessional'
        ));
    }
}
