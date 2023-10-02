<?php

namespace App\Http\Controllers\Survey;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::select('id', 'name', 'description')->get();

        if ($request->ajax()) {

            return Datatables::of($categories)
            ->addIndexColumn()
            ->addColumn('details', function ($td) {

                $href = '<a href="'.route('gamer.categs', $td->id).'" class="btn btn-primary btn-circle btn-sm" target="_blank"><i class="fas fa-gamepad"></i></a>';
                return $href;
                
             })
            ->rawColumns(['details'])
            ->make(true);

        }

        return view('category.index');

    }
}
