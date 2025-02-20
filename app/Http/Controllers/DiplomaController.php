<?php

namespace App\Http\Controllers;

use App\Diploma;
use App\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class DiplomaController extends Controller
{
    // public function index() {
    //     $diplomas = Diploma::all();

    //     return view('backend.diploma.index',compact('diplomas'));
    // }

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

    public function editDiploma($id) {
        $diploma = Diploma::findOrFail($id);

        return view('backend.diploma.edit', compact('diploma'));
    }

    public function updateDiploma($id, Request $request) {
        try {
            dd($request->all());
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function index(Request $request)
    {
        $query = Diploma::query();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');

            // Parse and validate the search term
            $filters = $this->parseSearchTerm($searchTerm);

            // Apply filters dynamically
            foreach ($filters as $key => $value) {
                if (in_array($key, ['type_of_course', 'code', 'name', 'duration', 'currency', 'amount'])) { // Allow only valid columns
                    $query->where($key, 'like', '%' . $value . '%');
                }
            }
        }

        // Paginate results
        $diplomas = $query->latest()->paginate(5);

        return view('backend.diploma.index', compact('diplomas'));
    }

    private function parseSearchTerm($searchTerm)
    {
        $filters = [];
        $terms = explode(' and ', $searchTerm);

        foreach ($terms as $term) {
            if (str_contains($term, '=')) {
                list($key, $value) = explode('=', $term, 2);
                $filters[trim($key)] = trim($value);
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
            'fees' => $details->fees,
            'currency' => $details->currency,
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
            Log::error('Error deleting diploma',$e->getMessage());
        }
    }
}
