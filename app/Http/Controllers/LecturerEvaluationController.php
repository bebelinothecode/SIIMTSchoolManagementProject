<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LecturerEvaluationSubmission;
use App\LecturerEvaluationDetail;


class LecturerEvaluationController extends Controller
{
    public function index()
    {
        $submissions = LecturerEvaluationSubmission::with('student')->latest()->paginate(20);

        return $submissions;

        return view('backend.teachers.evaluation', compact('submissions'));
    }

    public function show($id)
    {
        $submission = LecturerEvaluationSubmission::with(['student','details'])->findOrFail($id);

        return view('backend.teachers.evaluation', compact('submission'));
    }

     public function byLecturer()
    {
        $evaluations = LecturerEvaluationDetail::select(
                'lecturer_name',
                \DB::raw('AVG(clarity) as avg_clarity'),
                \DB::raw('AVG(knowledge) as avg_knowledge'),
                \DB::raw('AVG(punctuality) as avg_punctuality'),
                \DB::raw('COUNT(*) as total_evaluations')
            )
            ->groupBy('lecturer_name')
            ->get();

        return view('admin.evaluations.by_lecturer', compact('evaluations'));
    }
    //
}
