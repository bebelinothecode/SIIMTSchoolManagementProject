<?php

namespace App\Http\Controllers;

use App\Diploma;
use App\Grade;
use App\Enquiry;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class DiplomaController extends Controller
{
    public function diplomaForm() {
        return view('backend.diploma.create');
    }

    public function storeDiplomaForm(Request $request)
    {
        try {
            // Validate request data
            $validatedData = $request->validate([
                'type_of_course' => 'required',
                'code' => 'required|unique:diploma,code',
                'name' => 'required',
                'duration' => 'required',
                'currency' => 'required',
                'fees' => 'required'
            ]);

            // Create the diploma record
            Diploma::create([
                'type_of_course' => $validatedData['type_of_course'],
                'code' => $validatedData['code'],
                'name' => $validatedData['name'],
                'duration' => $validatedData['duration'],
                'currency' => $validatedData['currency'],
                'fees' => $validatedData['fees']
            ]);

            // Redirect with success message
            return redirect()->back()->with('success', 'Diploma created successfully.');
        } catch (QueryException $e) {
            // Log the error for debugging
            Log::error('Database Error: ' . $e->getMessage());

            // Redirect with database error message
            return redirect()->back()->with('error', 'Failed to create diploma. Please try again.');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('General Error: ' . $e->getMessage());

            // Redirect with general error message
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function editDiplomaForm($id) {
        $diploma = Diploma::findOrFail($id);

        return view('backend.diploma.edit', compact('diploma'));
    }

    public function updateDiploma($id, Request $request) {
        try {
            // dd($request->all());

            $validatedData = $request->validate([
                'type_of_course' => 'required|string|max:255',
                'code' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'duration' => 'required|string|max:255',
                'currency' => 'required|string|max:255',
                'fees' => 'required|numeric'
            ]);

            $diploma = Diploma::findOrFail($id);

            // Update the diploma record with the new data
            $diploma->update([
                'type_of_course' => $validatedData['type_of_course'],
                'code' => $validatedData['code'],
                'name' => $validatedData['name'],
                'duration' => $validatedData['duration'],
                'currency' => $validatedData['currency'],
                'fees' => $validatedData['fees']
            ]);
    
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Diploma/Certificate updated successfully!');
        } catch (Exception $e) {
            //throw $th;
            Log::error('Error updating diploma',[$e->getMessage()]);     
            
            return redirect()->back()->with('error', 'Error Updating Diploma/Certificate');

        }
    }

    public function index(Request $request) {
        try {
            //code...
            $query = Diploma::query();

            if ($request->has('search')) {
                $searchTerm = $request->input('search');
        
                // Validate the search term
                if (!empty($searchTerm)) {
                    // Parse and validate the search term
                    $filters = $this->parseSearchTerm($searchTerm);
        
                    // Apply filters dynamically
                    foreach ($filters as $key => $value) {
                        if (in_array($key, ['type_of_course', 'code', 'name', 'duration', 'currency', 'amount'])) { // Allow only valid columns
                            $query->where($key, 'like', '%' . $value . '%');
                        }
                    }
                }
            }
        
            // Paginate results
            $diplomas = $query->latest()->paginate(10);
        
            return view('backend.diploma.index', compact('diplomas'));
        } catch (\Exception $e) {
            //throw $th;
            Log::error('Error deleting diploma',[$e->getMessage()]);

        }
    }

    private function parseSearchTerm($searchTerm)
    {
        $filters = [];
        $terms = explode(' and ', $searchTerm);

        foreach ($terms as $term) {
            if (str_contains($term, '=')) {
                list($key, $value) = explode('=', $term, 2);
                $key = trim($key);
                $value = trim($value);

                // Ensure the key and value are not empty
                if (!empty($key) && !empty($value)) {
                    $filters[$key] = $value;
                }
            }
        }

        return $filters;
    }

    public function getProfessional($id) {
        $details = Diploma::findOrFail($id);

        return response()->json([
            'currency' => $details->currency,
            'amount' =>  $details->fees,
            'duration' => $details->duration
        ]);
    }

    public function getAcademic($id) {
        $details = Grade::findOrFail($id);

        return response()->json([
            'currency' => $details->currency,
            'amount' => $details->fees
        ]);
    }

    public function deleteDiploma($id) {
        try {
            //code...
            $diploma = Diploma::findOrFail($id);

            $diploma->delete();

            return redirect()->back()->with('success','Diploma Course deleted successfully');
        } catch (\Exception $e) {
            //throw $th;
            Log::error('Error deleting diploma',[$e->getMessage()]);

            return redirect()->back()->with('error','Error deleting Diploma course');

        }
    }

    public function editEnquiry($id) {
        $enquiry = Enquiry::findOrFail($id);
        $courses = Grade::all();
        $diplomas = Diploma::all();
        return view('backend.students.editenquiry', compact('enquiry','courses','diplomas'));
    }

    public function updateEnquiry($id, Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'telephone_number' => 'nullable|string|max:255',
                'type_of_course' => 'nullable|string|max:255',
                'course_id' => 'nullable|integer',
                'diploma_id' => 'nullable|integer',
                'bought_forms' => 'nullable|string|max:255',
                'currency' => 'nullable|string|max:255',
                'expected_start_date' => 'nullable|string|max:255',
                'amount_paid' => 'nullable|numeric',
                'method_of_payment' => 'nullable|string|max:255',
                'branch' => 'nullable|string|max:255',
                'source_of_enquiry' => 'nullable|string|max:255',
                'preferred_time' => 'nullable|string|max:255',
            ]);
    
            $enquiry = Enquiry::findOrFail($id);
    
            // Base fields
            $data = [
                'name' => $validatedData['name'],
                'telephone_number' => $validatedData['telephone_number'] ?? null,
                'type_of_course' => $validatedData['type_of_course'] ?? null,
                'bought_forms' => $validatedData['bought_forms'] ?? null,
                'currency' => $validatedData['currency'] ?? null,
                'expected_start_date' => $validatedData['expected_start_date'] ?? null,
                'method_of_payment' => $validatedData['method_of_payment'] ?? null,
                'amount' => $validatedData['amount_paid'] ?? null,
                'branch' => $validatedData['branch'] ?? null,
                'source_of_enquiry' => $validatedData['source_of_enquiry'] ?? null,
                'preferred_time' => $validatedData['preferred_time'] ?? null,
            ];
    
            // Handle course/diploma logic
            if ($validatedData['type_of_course'] === 'Academic') {
                $data['course_id'] = $validatedData['course_id'] ?? null;
                $data['diploma_id'] = null;
            } elseif ($validatedData['type_of_course'] === 'Professional') {
                $data['diploma_id'] = $validatedData['diploma_id'] ?? null;
                $data['course_id'] = null;
            } else {
                $data['course_id'] = null;
                $data['diploma_id'] = null;
            }
    
            $enquiry->update($data);
    
            return redirect()->back()->with('success', 'Enquiry updated successfully!');
        } catch (\Exception $e) {
    
            Log::error('Error updating enquiry', [$e->getMessage()]);     
            return redirect()->back()->with('error', 'Error Updating Enquiry');
    
        }
    }
    
}
