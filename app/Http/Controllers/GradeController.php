<?php

namespace App\Http\Controllers;

// use Log;
use App\Grade;
use App\Subject;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Log;

class GradeController extends Controller
{   
    //This controller is for subjects
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {
    //     $query = Subject::with('course');

    //     if ($request->has('search')) {
    //         $searchTerm = $request->input('search');
    
    //         // Parse the search term into key-value pairs
    //         $filters = $this->parseSearchTerm($searchTerm);
    
    //         // Apply filters based on the parsed key-value pairs
    //         foreach ($filters as $key => $value) {
    //             $query->where($key, 'like', '%' . $value . '%');
    //         }
    //     }

    //     $classes = $query->latest()->paginate(10);

    //     return view('backend.classes.index', compact('classes'));
    // }


    // private function parseSearchTerm($searchTerm)
    // {
    //     $filters = [];
    //     $terms = explode(' and ', $searchTerm);

    //     foreach ($terms as $term) {
    //         if (str_contains($term, '=')) {
    //             list($key, $value) = explode('=', $term, 2);
    //             $filters[trim($key)] = trim($value);
    //         }
    //     }

    //     return $filters;
    // }

    // ------

    // public function index(Request $request)
    // {
    //     $query = Subject::with('course');

    //     if ($request->filled('search')) {
    //         $searchTerm = $request->input('search');
            
    //         try {
    //             $filters = $this->parseSearchTerm($searchTerm);
    //             $this->applyFilters($query, $filters);
    //         } catch (\Exception $e) {
    //             Log::error('Search parsing error: ' . $e->getMessage());
    //             // Optionally, notify the user of the error
    //         }
    //     }

    //     $classes = $query->latest()->paginate(3);

    //     return view('backend.classes.index', compact('classes'))
    //         ->with('search', $request->input('search'));
    // }

    // private function parseSearchTerm($searchTerm)
    // {
    //     $filters = [];
        
    //     if (empty($searchTerm)) {
    //         return $filters;
    //     }

    //     $terms = explode(' and ', strtolower($searchTerm));

    //     foreach ($terms as $term) {
    //         if (str_contains($term, '=')) {
    //             list($key, $value) = array_map('trim', explode('=', $term, 2));
                
    //             // Basic sanitization
    //             $key = preg_replace('/[^a-z_]/', '', $key);
    //             $value = strip_tags($value);
                
    //             if (!empty($key) && !empty($value)) {
    //                 $filters[$key] = $value;
    //             }
    //         }
    //     }

    //     return $filters;
    // }

    // private function applyFilters($query, $filters)
    // {
    // $validColumns = ['id', 'subject_name', 'subject_code', 'semester', 'level', 'credit_hours'];

    // $query->where(function($q) use ($filters, $validColumns) {
    //     foreach ($filters as $key => $value) {
    //         if (in_array($key, $validColumns)) {
    //             // For numeric columns, use exact match
    //             if (in_array($key, ['id', 'semester', 'level', 'credit_hours'])) {
    //                 $q->orWhere($key, '=', $value);
    //             } else {
    //                 // For text columns, use partial match
    //                 $q->orWhere($key, 'like', '%' . $value . '%');
    //             }
    //         }

    //         // Search in related course table (if applicable)
    //         if ($key === 'course_name') {
    //             $q->orWhereHas('course', function($courseQuery) use ($value) {
    //                 $courseQuery->where('course_name', 'like', '%' . $value . '%');
    //             });
    //         }
    //     }
    // });
    // }

    // -------

//     public function index(Request $request)
// {
//     // Start a fresh query for each request
//     $query = Subject::with('course');

//     if ($request->filled('search')) {
//         $searchTerm = $request->input('search');
        
//         try {
//             $filters = $this->parseSearchTerm($searchTerm);
//             $this->applyFilters($query, $filters);
//         } catch (\Exception $e) {
//             Log::error('Search parsing error: ' . $e->getMessage());
//             // Optionally, notify the user of the error
//         }
//     }

//     $classes = $query->latest()->paginate(10);

//     return view('backend.classes.index', compact('classes'))
//         ->with('search', $request->input('search'));
// }

// private function parseSearchTerm($searchTerm)
// {
//     $filters = [];
    
//     if (empty($searchTerm)) {
//         return $filters;
//     }

//     $terms = explode(' and ', strtolower($searchTerm));

//     foreach ($terms as $term) {
//         if (str_contains($term, '=')) {
//             list($key, $value) = array_map('trim', explode('=', $term, 2));
            
//             // Basic sanitization
//             $key = preg_replace('/[^a-z_]/', '', $key);
//             $value = strip_tags($value);
            
//             if (!empty($key) && !empty($value)) {
//                 $filters[$key] = $value;
//             }
//         }
//     }

//     return $filters;
// }

// private function applyFilters($query, $filters)
// {
//     $validColumns = ['id', 'subject_name', 'subject_code', 'semester', 'level', 'credit_hours'];

//     // Use `where` instead of `orWhere` to ensure strict filtering
//     $query->where(function($q) use ($filters, $validColumns) {
//         foreach ($filters as $key => $value) {
//             if (in_array($key, $validColumns)) {
//                 // For numeric columns, use exact match
//                 if (in_array($key, ['id', 'semester', 'level', 'credit_hours'])) {
//                     $q->where($key, '=', $value);
//                 } else {
//                     // For text columns, use partial match
//                     $q->where($key, 'like', '%' . $value . '%');
//                 }
//             }

//             // Search in related course table (if applicable)
//             if ($key === 'course_name') {
//                 $q->whereHas('course', function($courseQuery) use ($value) {
//                     $courseQuery->where('course_name', 'like', '%' . $value . '%');
//                 });
//             }
//         }
//     });
// }

// -----

    public function index(Request $request)
    {
        // Start a fresh query for each request
        $query = Subject::with('course');

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            
            try {
                $filters = $this->parseSearchTerm($searchTerm);
                $this->applyFilters($query, $filters);
            } catch (\Exception $e) {
                Log::error('Search parsing error: ' . $e->getMessage());
                // Optionally, notify the user of the error
            }
        }

        $classes = $query->latest()->paginate(10);

        return view('backend.classes.index', compact('classes'))
            ->with('search', $request->input('search'));
    }

    private function parseSearchTerm($searchTerm)
    {
        $filters = [];
        
        if (empty($searchTerm)) {
            return $filters;
        }

        $terms = explode(' and ', strtolower($searchTerm));

        foreach ($terms as $term) {
            if (str_contains($term, '=')) {
                list($key, $value) = array_map('trim', explode('=', $term, 2));
                
                // Basic sanitization
                $key = preg_replace('/[^a-z_]/', '', $key);
                $value = strip_tags($value);
                
                if (!empty($key) && !empty($value)) {
                    $filters[$key] = $value;
                }
            }
        }

        return $filters;
    }

    private function applyFilters($query, $filters)
    {
    $validColumns = ['id', 'subject_name', 'subject_code', 'semester', 'level', 'credit_hours'];

    // Use `where` instead of `orWhere` to ensure strict filtering
    $query->where(function($q) use ($filters, $validColumns) {
        foreach ($filters as $key => $value) {
            if (in_array($key, $validColumns)) {
                // For numeric columns, use exact match
                if (in_array($key, ['id', 'semester', 'level', 'credit_hours'])) {
                    $q->where($key, '=', $value);
                } else {
                    // For text columns, use partial match
                    $q->where($key, 'like', '%' . $value . '%');
                }
            }

            // Search in related course table (if applicable)
            if ($key === 'course_name') {
                $q->whereHas('course', function($courseQuery) use ($value) {
                    $courseQuery->where('course_name', 'like', '%' . $value . '%');
                });
            }
        }
    });
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teachers = Teacher::with('user')->get();

        $courses = Grade::all();
        
        return view('backend.classes.create', compact('teachers', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $validatedData = $request->validate([
            'subject_name'     => 'required',
            'subject_code'     => 'required',
            // 'course_id'        => 'required',
            'level'            => 'required',
            'semester'         => 'required',
            'credit_hours'     => 'required',
        ]);

        Subject::create([
            'subject_name'  => $validatedData['subject_name'],
            'subject_code'  => $validatedData['subject_code'],
            // 'course_id'     => $validatedData['course_id'],
            'level'         => $validatedData['level'],
            'semester'      => $validatedData['semester'],
            'credit_hours'  => $validatedData['credit_hours'],
        ]);

        return redirect()->back()->with('success', 'Subject created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function show(Grade $grade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subjects = Subject::findOrFail($id);

        $teachers = Teacher::with('user')->get();

        $courses = Grade::all();

        return view('backend.classes.edit', compact('subjects','teachers','courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());

        $validatedData = $request->validate([
            'subject_name'  => 'required',
            'subject_code'  => 'required',
            'course_id'     => 'required',
            'level'         => 'required',
            'semester'      => 'required',
            'credit_hours'  => 'required'
        ]);

        // dd($validatedData);

        $class = Subject::findOrFail($id);

        // dd($class);

        $class->update([
            'subject_name'  => $validatedData['subject_name'],
            'subject_code'  => $validatedData['subject_code'],
            'course_id'     => $validatedData['course_id'],
            'level'         => $validatedData['level'],
            'semester'      => $validatedData['semester'],
            'credit_hours'  => $validatedData['credit_hours']
        ]);

        return redirect()->back()->with('success', 'Subject details updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grade  $grade
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        
        $subject->delete();

        return redirect()->back()->with('success', 'Subject deleted successfully!');
    }

    /*
     * Assign Subjects to Grade 
     * 
     * @return \Illuminate\Http\Response
     */
    public function assignSubject($classid)
    {
        $subjects   = Subject::latest()->get();
        $assigned   = Grade::with(['subjects','students'])->findOrFail($classid);

        return view('backend.classes.assign-subject', compact('classid','subjects','assigned'));
    }

    /*
     * Add Assigned Subjects to Grade 
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAssignedSubject(Request $request, $id)
    {
        $class = Grade::findOrFail($id);

        $class->subjects()->sync($request->selectedsubjects);

        return redirect()->route('classes.index');
    }

    public function test4() {
        $classes = Subject::with('course')->paginate(10);

        return $classes;
    }

    // public function 
}
