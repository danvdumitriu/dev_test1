<?php

namespace App\Http\Controllers;

use App\Tree;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TreeController extends Controller
{
    public $whitelist_tree_fields = ["name","title","children","expanded","user_id"];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function formatTree($data, $user_id = null)
    {
        if(!is_array($data)) $data = $data->toArray();

        $traverse = function (&$data) use (&$traverse, $user_id) {
            foreach ($data as &$item) {

                foreach($item as $field_name => &$value) {

                    if($field_name == "expanded") {
                        $value = $value?true:false;
                    }

                    if(!in_array($field_name, $this->whitelist_tree_fields)) unset($item[$field_name]);


                    $traverse($item["children"]);
                }

                if($user_id) $item["user_id"] = $user_id;
                elseif(!$user_id && isset($item["user_id"])) unset($item["user_id"]);

            }

        };

        $traverse($data);
        return $data;
    }

    public function getTree()
    {
        $user_id = null;
        if(Auth::check()) $user_id = Auth::user()->id;

        $data = Tree::where("user_id", $user_id)->get()->toTree();

        if(count($data) < 1)
            $data = Tree::where("user_id", null)->get()->toTree(); //default data
        
        $data = $this->formatTree($data);

        return Response::json(["treeData" => $data]);

    }

    public function saveTree(Request $request)
    {
        if(!Auth::check()) return Response::json(['error' => "Unauthorized"], 401);

        $user_id = Auth::user()->id;

        $tree_array = $request->toArray();
        $tree_array = $this->formatTree($tree_array["treeData"], $user_id);

        Tree::where("user_id",$user_id)->delete();
        Tree::rebuildTree($tree_array);
        
        return $this->getTree();

    }
}
