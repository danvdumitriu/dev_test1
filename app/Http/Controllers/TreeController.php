<?php

namespace App\Http\Controllers;

use App\Tree;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\GoneHttpException;

class TreeController extends Controller
{
    public $whitelist_tree_fields = ["name","title","children","expanded"];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function formatTree($data)
    {
        $data = $data->toArray();

        $traverse = function (&$data) use (&$traverse) {
            foreach ($data as &$item) {
                foreach($item as $field_name => &$value) {

                    if($field_name == "expanded") {
                        $value = $value?true:false;
                    }

                    if(!in_array($field_name, $this->whitelist_tree_fields)) unset($item[$field_name]);

                    $traverse($item["children"]);
                }
            }

        };

        $traverse($data);
        return $data;
    }

    public function getTree()
    {
        if(!Auth::check()) return Response::json(['error' => "Unauthorized"], 401);

        $data = Tree::get()->toTree();
        $data = $this->formatTree($data);


        return Response::json(["treeData"=>$data]);

    }

    public function saveTree(Request $request)
    {
        if(!Auth::check()) return Response::json(['error' => "Unauthorized"], 401);

        $tree_array = $request->toArray();

        Tree::truncate();
        Tree::rebuildTree($tree_array["treeData"]);
        
        return $this->getTree();

    }
}
