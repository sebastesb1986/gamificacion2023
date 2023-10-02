<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\Content;

class AnswerController extends Controller
{
    public function index()
    {
        $answers = Answer::with(['content' => function($td){
            $td->select(['id', 'description', 'value']);
        }])
        ->select('id', 'question_id', 'content_id', 'gamer_id')
        ->get();

        return response()->json(['answers' => $answers]);
    }

    public function getContent()
    {
        $content = Content::select('id', 'description', 'value')->get();

        return response()->json(['content' => $content]);
    }

    public function getAnswerGamer($gmrId, $qstId)
    {
        $answers = Answer::with(['content' => function($td){
                                $td->select(['id', 'description', 'value']);
                            }])
                            ->select('id', 'question_id', 'content_id', 'gamer_id')
                            ->where([
                                ['gamer_id', $gmrId],
                                ['question_id', $qstId]
                            ])
                            ->get();

        return response()->json(['answers' => $answers]);
    }

    public function store(Request $request)
    {
        $data = [

            'question_id' => $request->question_id,
            'content_id' => $request->content_id,
            'gamer_id' => $request->gamer_id

        ];


        $answer = Answer::updateOrCreate(
            [   
                'question_id' => $request->question_id,  // Columna(s) para buscar el registro existente
                'gamer_id' => $request->gamer_id     
            ], 
            $data// Datos para actualizar o crear
        );
    }
}
