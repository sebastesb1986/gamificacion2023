<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function show($id){

        $question = Question::with(['category' => function($td){
            $td->select(['id', 'name']);
        }])
        ->select('id', 'description', 'category_id')
        ->findOrFail($id);

        $totalQuest = count(Question::all());
 
        return response()->json(['question' => $question, 'totalQuest' => $totalQuest]);

    }
}
