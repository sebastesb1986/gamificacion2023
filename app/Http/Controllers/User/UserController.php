<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use App\Models\Answer;
use App\Models\Gamer;
use App\Models\ResultGamer;

class UserController extends Controller
{
    public function index(Request $request, $id)
    {
        $gamer = Answer::with(['content' => function($td){
            $td->select(['id', 'description', 'value']);
        }])
        ->with(['gamer' => function($td){
            $td->select(['id', 'name', 'grade', 'section', 'date']);
        }])
        ->with(['question' => function($td){
            $td->select(['id', 'description', 'category_id']);
            $td->with(['category' => function($query){
                $query->select(['id', 'name', 'description']);
            }]);
        }])
        ->select('id', 'question_id', 'content_id', 'gamer_id')
        ->where('gamer_id', $id)
        ->get();

        if ($request->ajax()) {

            return Datatables::of($gamer)
            ->addIndexColumn()
            ->addColumn('name', function ($td) {

                return $td->question->category->name;
    
                
             })
             ->addColumn('questDesc', function ($td) {

                return "¿".$td->question->description."?";
    
                
             })
             ->addColumn('contDesc', function ($td) {

                return $td->content->description;
    
                
             })
             ->addColumn('value', function ($td) {

                return $td->content->value;
    
                
             })
            ->rawColumns(['name', 'questDesc','contDesc', 'value', 'gmrName'])
            ->make(true);


        }

        /* Tabla de resultados Gamer */

        // 1. Definimos variables
        $totalSum = 0;
        $maxValue = 0;
        $maxCategorySum = 0;
        $maxCategoryName = '';
        $categorySums = []; // Crear un arreglo para almacenar las sumas por categoría
        
        // 2. Verificar si hay al menos una suma en el arreglo
        if (!empty($categorySums)) {
            // Calcular la diferencia entre las sumas más altas y más bajas
            $difference = $maxCategorySum - min($categorySums);

            // Definir un umbral para considerar las sumas como similares
            $similarityThreshold = 10;

            // Verificar si las sumas son similares
            $areSumsSimilar = $difference <= $similarityThreshold;
        } else {
            $areSumsSimilar = false; // No hay sumas para comparar, por lo tanto, no son similares
        }

        // 3. Ciclo para obtener las estadisticas de un usuario Gamer
        foreach($gamer as $index => $gmr){

            $categoryName = $gmr->question->category->name;
            $categoryDescription = $gmr->question->category->description;
            $categoryId = $gmr->question->category->id;
            $gamerName = $gmr->gamer->name;
            $value = $gmr->content->value;
            
            
            // Si la categoría no existe en el arreglo, la inicializamos
            if (!isset($categorySums[$categoryName])) {
                $categorySums[$categoryName] = 0;
                $categoryDescriptions[$categoryName] = $categoryDescription;
                $categoryIds[$categoryName] = $categoryId;
            }

            // Sumar el valor al acumulador de la categoría
            $categorySums[$categoryName] += $value;

            $totalSum += $gmr->content->value; // Agregar el valor a la suma total

            if ($gmr->content->value > $maxValue) {
                $maxValue = $gmr->content->value; // Actualizar el valor máximo si es necesario
            }
            
        }
        /* Fin Tabla de resultados Gamer */

        return view('gamer.index', compact('id', 'gamerName', 'categoryIds', 'categoryDescriptions', 'totalSum', 'maxValue', 'maxCategorySum', 'maxCategoryName', 'categorySums'));

    }

    // RESULT GAMER
    public function resultGamer(Request $request)
    {
        $values = $request->all();

        $data = [

            'value' => $request->value,
            'gamer_id' => $request->gamer_id,
            'category_id' => $request->category_id,

        ];

        foreach ($values as $value) {
     
            ResultGamer::updateOrCreate(
                [   
                    'gamer_id' => $request->gamer_id,
                    'category_id' => $request->category_id,  // Columna(s) para buscar el registro existente
                        
                ], 
                [
                    'value' => $request->value,
                    'gamer_id' => $request->gamer_id,   // Datos para actualizar o crear
                    'category_id' => $request->category_id
                ] 
            );
        }

    }

    public function showResultGamer(Request $request, $gmrId)
    {
        if ($request->ajax()) {

            $gamer = Answer::with(['content' => function($td){
                $td->select(['id', 'description', 'value']);
            }])
            ->with(['gamer' => function($td){
                $td->select(['id', 'name', 'grade', 'section', 'date']);
            }])
            ->with(['question' => function($td){
                $td->select(['id', 'description', 'category_id']);
                $td->with(['category' => function($query){
                    $query->select(['id', 'name', 'description']);
                }]);
            }])
            ->select('id', 'question_id', 'content_id', 'gamer_id')
            ->where('gamer_id', $gmrId)
            ->get();

            /* Tabla de resultados Gamer */

            // 1. Definimos variables
            $totalSum = 0;
            $maxValue = 0;
            $maxCategorySum = 0;
            $maxCategoryName = '';
            $maxCategoryId = 0;
            $categorySums = []; // Crear un arreglo para almacenar las sumas por categoría
            
            // 2. Verificar si hay al menos una suma en el arreglo
            if (!empty($categorySums)) {
                // Calcular la diferencia entre las sumas más altas y más bajas
                $difference = $maxCategorySum - min($categorySums);

                // Definir un umbral para considerar las sumas como similares
                $similarityThreshold = 10;

                // Verificar si las sumas son similares
                $areSumsSimilar = $difference <= $similarityThreshold;
            } else {
                $areSumsSimilar = false; // No hay sumas para comparar, por lo tanto, no son similares
            }

            // 3. Ciclo para obtener las estadisticas de un usuario Gamer
            foreach($gamer as $index => $gmr){

                $categoryId = $gmr->question->category->id;
                $categoryName = $gmr->question->category->name;
                $categoryDescription = $gmr->question->category->description;
                $gamerName = $gmr->gamer->name;
                $value = $gmr->content->value;
                
                // Si la categoría no existe en el arreglo, la inicializamos
                if (!isset($categorySums[$categoryName])) {
                    $categorySums[$categoryName] = 0;
                    $categoryDescriptions[$categoryName] = $categoryDescription;
                    $categoryIds[$categoryName] = $categoryId;
                }

                // Sumar el valor al acumulador de la categoría
                $categorySums[$categoryName] += $value;

                $totalSum += $gmr->content->value; // Agregar el valor a la suma total
                if ($gmr->content->value > $maxValue) {
                    $maxValue = $gmr->content->value; // Actualizar el valor máximo si es necesario
                }
                
            }

            return response()->json(['categoryIds' => $categoryIds, 'categoryName' => $categoryName,
            'gamerName' => $gamerName,  'categoryDescriptions' =>$categoryDescriptions, 
            'maxCategorySum' => $maxCategorySum,
            'maxCategoryName' => $maxCategoryName , 'categorySums' => $categorySums]);

        }
        /* Fin Tabla de resultados Gamer */

       

    }

    public function gamerByCategs(Request $request, $id)
    {

        $gmrCateg = ResultGamer::with(['gamer' => function($td){
            $td->select(['id', 'name', 'grade', 'section']);
        }])
        ->with(['category' => function($td){
            $td->select(['id', 'name']);
        }])
        ->select('id', 'value', 'gamer_id', 'category_id')
        ->where('category_id', $id)
        ->get();
        

        if($request->ajax())
        {

            return Datatables::of($gmrCateg)
            ->addIndexColumn()
            ->addColumn('categName', function ($td) {

                $href = $td->category->name;
                return $href;
                
             })
             ->addColumn('value', function ($td) {

                $href = $td->value;
                return $href;
                
             })
             ->addColumn('partName', function ($td) {

                $href = $td->gamer->name;
                return $href;
                
             })
             ->addColumn('partGrade', function ($td) {

                $href = $td->gamer->grade;
                return $href;
                
             })
             ->addColumn('partSection', function ($td) {

                $href = $td->gamer->section;
                return $href;
                
             })
            ->rawColumns(['categName', 'partName', 'partGrade', 'partSection'])
            ->make(true);


        }

        return view('gamer.bycateg', compact('gmrCateg', 'id'));

    }

    public function gamerDetails($gamer)
    {

          /* Tabla de resultados Gamer */

        // 1. Definimos variables
        $totalSum = 0;
        $maxValue = 0;
        $maxCategorySum = 0;
        $maxCategoryName = '';
        $categorySums = []; // Crear un arreglo para almacenar las sumas por categoría
        
        
        // 2. Verificar si hay al menos una suma en el arreglo
        if (!empty($categorySums)) {
            // Calcular la diferencia entre las sumas más altas y más bajas
            $difference = $maxCategorySum - min($categorySums);

            // Definir un umbral para considerar las sumas como similares
            $similarityThreshold = 10;

            // Verificar si las sumas son similares
            $areSumsSimilar = $difference <= $similarityThreshold;
        } else {
            $areSumsSimilar = false; // No hay sumas para comparar, por lo tanto, no son similares
        }

        // 3. Ciclo para obtener las estadisticas de un usuario Gamer
        foreach($gamer as $index => $gmr){

            $categoryName = $gmr->question->category->name;
            $categoryDescription = $gmr->question->category->description;
            $gamerName = $gmr->gamer->name;
            $value = $gmr->content->value;
            
            
            // Si la categoría no existe en el arreglo, la inicializamos
            if (!isset($categorySums[$categoryName])) {
                $categorySums[$categoryName] = 0;
                $categoryDescriptions[$categoryName] = $categoryDescription;
            }

            // Sumar el valor al acumulador de la categoría
            $categorySums[$categoryName] += $value;

            $totalSum += $gmr->content->value; // Agregar el valor a la suma total
            if ($gmr->content->value > $maxValue) {
                $maxValue = $gmr->content->value; // Actualizar el valor máximo si es necesario
            }

            /*return [

                $totalSum, $maxValue, $maxCategorySum, $maxCategoryName , $categorySums

            ];*/

            return [

                'totalSum' => $totalSum, 
                'maxValue' => $maxValue, 
                'maxCategorySum' => $maxCategorySum, 
                'maxCategoryName' => $maxCategoryName , 
                'categorySums' => $categorySums

            ];
            
        }
        /* Fin Tabla de resultados Gamer */

    }
}
