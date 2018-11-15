<?php

namespace App\Http\Controllers;

use App\Tree;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TreeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('home');
    }

    public function saveTree(Request $request) {
        if(!Auth::check()) return Response::json(['error' => "Unauthorized"], 401);

        //$data = ["some"=>"data"];

        $tree_array = $request->toArray();

        //echo "<pre>"; var_dump($tree_array["treeData"]); exit;

        Tree::truncate();
        $node = Tree::rebuildTree($tree_array["treeData"]);


        return Response::json(
            $node
        );
    }
}
