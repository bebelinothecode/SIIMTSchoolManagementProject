<?php

namespace App\Http\Controllers;

use App\Expenses;
use App\FeesPaid;
use App\Parents;
use App\Student;
use App\Teacher;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        $roleHandlers = [
            [
                'check' => fn() => $user->hasAnyRole(config('roles.admin_roles')),
                'handler' => fn() => $this->getAdminDashboardData(),
                'view' => 'home'
            ],
            [
                'check' => fn() => $user->hasRole('Teacher'),
                'handler' => fn() => $this->getTeacherDashboardData(),
                'view' => 'home'
            ],
            [
                'check' => fn() => $user->hasRole('Parent'),
                'handler' => fn() => $this->getParentDashboardData(),
                'view' => 'home'
            ],
            [
                'check' => fn() => $user->hasRole('Student'),
                'handler' => fn() => $this->getStudentDashboardData(),
                'view' => 'home'
            ],
            [
                'check' => fn() => $user->hasRole('Supervisor'),
                'handler' => fn() => [],
                'view' => 'dashboard.supervisor'
            ],
        ];

        foreach ($roleHandlers as $rh) {
            if ($rh['check']()) {
                $data = $rh['handler']();
                return view($rh['view'], $data);
            }
        }

        return 'NO ROLE ASSIGNED YET!';
    }

    /**
     * Get dashboard data for admin roles.
     *
     * @return array
     */
    private function getAdminDashboardData()
    {
        $parents = Parents::latest()->get();
        $teachers = Teacher::latest()->get();
        $students = Student::latest()->get();
        $studentsAcademic = Student::where('student_category','Academic')->count();
        $studentsProfessional = Student::where('student_category','Professional')->count();
        $books = DB::table('books')->count();
        $totalFeesCollected = FeesPaid::sum('amount');
        $totalExpensesMade = Expenses::sum('amount');
        $activeAcademicStudentsCount = Student::where('status', 'active')->where('student_category', 'Academic')->count();
        $activeProfessionalStudentsCount = Student::where('status', 'active')->where('student_category', 'Professional')->count();
        $completedProfessionalStudentsCount = Student::where('status', 'graduated')->where('student_category', 'Professional')->count();
        $inactiveProfessionalStudentsCount = Student::where('status', 'defered')->where('student_category', 'Professional')->count();

        return compact('parents','teachers','students','books','totalFeesCollected','totalExpensesMade','studentsAcademic','studentsProfessional','activeAcademicStudentsCount','activeProfessionalStudentsCount','completedProfessionalStudentsCount','inactiveProfessionalStudentsCount');
    }

    /**
     * Get dashboard data for teacher role.
     *
     * @return array
     */
    private function getTeacherDashboardData()
    {
        $user = Auth::user();
        $teacher = Teacher::with(['user','subjects','classes','students'])->withCount('subjects','classes')->findOrFail($user->teacher->id);

        return compact('teacher');
    }

    /**
     * Get dashboard data for parent role.
     *
     * @return array
     */
    private function getParentDashboardData()
    {
        $user = Auth::user();
        $parents = Parents::with(['children'])->withCount('children')->findOrFail($user->parent->id);

        return compact('parents');
    }

    /**
     * Get dashboard data for student role.
     *
     * @return array
     */
    private function getStudentDashboardData()
    {
        $user = Auth::user();
        $student = Student::with(['course','user','parent','attendances'])->findOrFail($user->student->id);

        return compact('student');
    }

    /**
     * PROFILE
     */
    public function profile() 
    {
        return view('profile.index');
    }

    public function profileEdit() 
    {
        return view('profile.edit');
    }

    public function profileUpdate(Request $request) 
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.auth()->id()
        ]);

        if ($request->hasFile('profile_picture')) {
            $profile = Str::slug(auth()->user()->name).'-'.auth()->id().'.'.$request->profile_picture->getClientOriginalExtension();
            $request->profile_picture->move(public_path('images/profile'), $profile);
        } else {
            $profile = 'avatar.png';
        }

        $user = auth()->user();

        $user->update([
            'name'              => $request->name,
            'email'             => $request->email,
            'profile_picture'   => $profile
        ]);

        return redirect()->route('profile');
    }

    /**
     * CHANGE PASSWORD
     */
    public function changePasswordForm()
    {  
        return view('profile.changepassword');
    }

    public function changePassword(Request $request)
    {     
        if (!(Hash::check($request->get('currentpassword'), Auth::user()->password))) {
            return back()->with([
                'msg_currentpassword' => 'Your current password does not matches with the password you provided! Please try again.'
            ]);
        }
        if(strcmp($request->get('currentpassword'), $request->get('newpassword')) == 0){
            return back()->with([
                'msg_currentpassword' => 'New Password cannot be same as your current password! Please choose a different password.'
            ]);
        }

        $this->validate($request, [
            'currentpassword' => 'required',
            'newpassword'     => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        $user->password = bcrypt($request->get('newpassword'));
        $user->save();

        Auth::logout();
        return redirect()->route('login');
    }
}
