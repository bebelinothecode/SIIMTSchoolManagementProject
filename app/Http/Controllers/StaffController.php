<?php

namespace App\Http\Controllers;

use App\Staff;
use App\StaffSalary;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Exception;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::with('user');

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $staff = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('backend.staff.index', compact('staff'));
    }

    public function create()
    {
        return view('backend.staff.create');
    }

    public function store(Request $request)
    {
        try {

            // dd($request->all());
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'position' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'employment_type' => 'required|in:Full-time,Part-time,Contract',
                'address' => 'required|string',
                'gender' => 'required|in:male,female,other',
                'date_of_birth' => 'required|date',
                'start_employment_date' => 'required|date',
                'end_employment_date' => 'nullable|date|after:start_employment_date',
                'status' => 'required|in:Active,Inactive,Terminated',
            ]);

            DB::beginTransaction();

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            $user->staff()->create($validatedData);

            // Assign role based on position if it matches a role name
            $roleName = $validatedData['position'];
            if (\Spatie\Permission\Models\Role::where('name', $roleName)->exists()) {
                $user->assignRole($roleName);
            }

            DB::commit();

            return redirect()->route('staff.index')->with('success', 'Staff created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating staff: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'An error occurred while creating the staff. Please try again.']);
        }
    }

    public function show($id)
    {
        $staff = Staff::with('user')->findOrFail($id);
        return view('backend.staff.show', compact('staff'));
    }

    public function edit($id)
    {
        $staff = Staff::with('user')->findOrFail($id);
        return view('backend.staff.edit', compact('staff'));
    }

    public function update(Request $request, $id)
    {
        try {
            $staff = Staff::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $staff->user_id,
                'position' => 'required|string|max:255',
                'phone_number' => 'required|string|max:20',
                'employment_type' => 'required|in:Full-time,Part-time,Contract',
                'address' => 'required|string',
                'gender' => 'required|in:male,female,other',
                'date_of_birth' => 'required|date',
                'start_employment_date' => 'required|date',
                'end_employment_date' => 'nullable|date|after:start_employment_date',
                'status' => 'required|in:Active,Inactive,Terminated',
            ]);

            DB::beginTransaction();

            $staff->user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
            ]);

            $staff->update($validatedData);

            // Update role based on new position
            $roleName = $validatedData['position'];
            if (\Spatie\Permission\Models\Role::where('name', $roleName)->exists()) {
                $staff->user->syncRoles([$roleName]);
            } else {
                $staff->user->syncRoles([]); // Remove roles if position doesn't match any role
            }

            DB::commit();

            return redirect()->route('staff.index')->with('success', 'Staff updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating staff: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'An error occurred while updating the staff. Please try again.']);
        }
    }

    public function destroy($id)
    {
        try {
            $staff = Staff::findOrFail($id);
            $user = $staff->user;

            $staff->delete();
            $user->removeRole('Staff');
            $user->delete();

            return redirect()->route('staff.index')->with('success', 'Staff deleted successfully');
        } catch (Exception $e) {
            Log::error('Error deleting staff: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An error occurred while deleting the staff. Please try again.']);
        }
    }

    // Salary Management Methods
    public function salaryIndex(Request $request)
    {
        $query = StaffSalary::with('staff.user');

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('staff.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $salaries = $query->orderBy('payment_date', 'desc')->paginate(10);

        return view('backend.staff.salary.index', compact('salaries'));
    }

    public function salaryCreate()
    {
        $staff = Staff::with('user')->get();
        return view('backend.staff.salary.create', compact('staff'));
    }

    public function salaryStore(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'staff_id' => 'required|exists:staff,id',
                'amount' => 'required|numeric|min:0',
                'payment_date' => 'required|date',
                'month' => 'required|string',
                'year' => 'required|string',
                'status' => 'required|in:Paid,Pending,Overdue',
                'notes' => 'nullable|string',
            ]);

            StaffSalary::create($validatedData);

            return redirect()->route('staff.salary.index')->with('success', 'Salary record created successfully');
        } catch (Exception $e) {
            Log::error('Error creating salary: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'An error occurred while creating the salary record. Please try again.']);
        }
    }

    public function salaryShow($id)
    {
        $salary = StaffSalary::with('staff.user')->findOrFail($id);
        return view('backend.staff.salary.show', compact('salary'));
    }

    public function salaryEdit($id)
    {
        $salary = StaffSalary::findOrFail($id);
        $staff = Staff::with('user')->get();
        return view('backend.staff.salary.edit', compact('salary', 'staff'));
    }

    public function salaryUpdate(Request $request, $id)
    {
        try {
            $salary = StaffSalary::findOrFail($id);

            $validatedData = $request->validate([
                'staff_id' => 'required|exists:staff,id',
                'amount' => 'required|numeric|min:0',
                'payment_date' => 'required|date',
                'month' => 'required|string',
                'year' => 'required|string',
                'status' => 'required|in:Paid,Pending,Overdue',
                'notes' => 'nullable|string',
            ]);

            $salary->update($validatedData);

            return redirect()->route('staff.salary.index')->with('success', 'Salary record updated successfully');
        } catch (Exception $e) {
            Log::error('Error updating salary: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'An error occurred while updating the salary record. Please try again.']);
        }
    }

    public function salaryDestroy($id)
    {
        try {
            $salary = StaffSalary::findOrFail($id);
            $salary->delete();

            return redirect()->route('staff.salary.index')->with('success', 'Salary record deleted successfully');
        } catch (Exception $e) {
            Log::error('Error deleting salary: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An error occurred while deleting the salary record. Please try again.']);
        }
    }
}