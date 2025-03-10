<?php

namespace App\Http\Controllers;

use App\Session;
use App\AcademicYear;
use App\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    public function settings() {
        return view('backend.settings.settings');
    }

    public function savesettings(Request $request) {
        try {
            //code...
            // dd($request->all());
            $validatedData = $request->validate([
                'startyear' => 'nullable|integer',
                'endyear' => 'nullable|integer',
                'name' => 'nullable|string',
                'expense_category' => 'nullable|string'
            ]);

            if($validatedData['startyear'] && $validatedData['endyear']) {
                AcademicYear::create([
                    'startyear' => $validatedData['startyear'],
                    'endyear' => $validatedData['endyear']
                ]);
            } elseif ($validatedData['name']) {
                Session::create([
                    'name' => $validatedData['name']
                ]);
            } elseif ($validatedData['expense_category']) {
                ExpenseCategory::create([
                    'expense_category' => $validatedData['expense_category']
                ]);
            } else{
                return redirect()->back()->with('error', 'Error with the input');
            }

            return redirect()->back()->with('success','Settings Saved');                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          
        } catch (\Exception $e) {
            Log::error('An error occurred', [
                'exception' => $e, // Include the exception in the context array
            ]);  

            return redirect()->back()->with('error', 'Error occured saving the settings');
        }
    }
}
