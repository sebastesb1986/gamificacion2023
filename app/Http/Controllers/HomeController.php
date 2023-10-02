<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Gamer;
use App\Models\Question;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['people', 'store']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user =  auth()->user();

        return view('home')->with(['user' => $user]);
    }

    public function people()
    {
        return view('people');
    }

    public function store(Request $request)
    {
        $data = [
                    'name' => $request->name,
                    'grade' => $request->grade,
                    'section' => $request->section,
                    'date' => date('Y-m-d')

                ];

        $gamer = Gamer::Create($data);


     
        return response()->json(['gamer' => $gamer]);
   
    }


   
}
