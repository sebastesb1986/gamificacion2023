<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Gamer;
use App\Models\Question;
use App\Models\Content;
use App\Models\Answer;


class SurveyController extends Controller
{
    public function index(Request $request)
    {

        $gamers = Gamer::select(['id', 'name', 'grade', 'section', 'date'])->get();

        if ($request->ajax()) {

            return Datatables::of($gamers)
            ->addIndexColumn()
            ->addColumn('details', function ($td) {

                $href = '<a href="'.route('gamer.index', $td->id).'" class="btn btn-primary btn-circle btn-sm" target="_blank"><i class="fas fa-gamepad"></i></a>';
                return $href;
                
             })
            ->rawColumns(['details'])
          
            ->make(true);

        }

        return view('survey.survey');

    }

}
