<?php

namespace App\Http\Controllers;

use App\Leave;
use App\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $query = Leave::with('staff.user');

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('staff.user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $leaves = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('backend.leaves.index', compact('leaves'));
    }

    public function create()
    {
        $staff = Staff::with('user')->get();
        return view('backend.leaves.create', compact('staff'));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'staff_id' => 'required|exists:staff,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'reason' => 'required|string|max:1000',
                'status' => 'required|in:pending,approved,rejected',
            ]);

            Leave::create($validatedData);

            return redirect()->route('leaves.index')->with('success', 'Leave record created successfully');
        } catch (Exception $e) {
            Log::error('Error creating leave: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'An error occurred while creating the leave record. Please try again.']);
        }
    }

    public function show($id)
    {
        $leave = Leave::with('staff.user')->findOrFail($id);
        return view('backend.leaves.show', compact('leave'));
    }

    public function edit($id)
    {
        $leave = Leave::findOrFail($id);
        $staff = Staff::with('user')->get();
        return view('backend.leaves.edit', compact('leave', 'staff'));
    }

    public function update(Request $request, $id)
    {
        try {
            $leave = Leave::findOrFail($id);

            $validatedData = $request->validate([
                'staff_id' => 'required|exists:staff,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'reason' => 'required|string|max:1000',
                'status' => 'required|in:pending,approved,rejected',
            ]);

            $leave->update($validatedData);

            return redirect()->route('leaves.index')->with('success', 'Leave record updated successfully');
        } catch (Exception $e) {
            Log::error('Error updating leave: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'An error occurred while updating the leave record. Please try again.']);
        }
    }

    public function destroy($id)
    {
        try {
            $leave = Leave::findOrFail($id);
            $leave->delete();

            return redirect()->route('leaves.index')->with('success', 'Leave record deleted successfully');
        } catch (Exception $e) {
            Log::error('Error deleting leave: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An error occurred while deleting the leave record. Please try again.']);
        }
    }
}
