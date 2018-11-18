<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\TreeController as TreeController;
use Faker\Factory as Faker;

class TreeTest extends TestCase
{
    public $tree_input = [];
    public $tree_expected = [];

    public function generateTreeNode($seed, $user_id=false, $expanded_int=false, $more_fields=false) {
        $faker = Faker::create();
        $faker->seed($seed);

        $title = $faker->text(10);
        $expanded = $faker->boolean();

        $node = [
            "title" => $title,
            "name" => $title,
            "expanded" => $expanded,
            "children" => []
        ];

        if($user_id) {
            $node["user_id"] = $user_id;
        }

        if($expanded_int) {
            $node["expanded"] = $expanded?1:0;
        }

        if($more_fields) {
            $node["some_field1"] = "some_value1";
            $node["some_field2"] = "some_value2";
        }

        return $node;

    }

    public function generateTestTree($user_id=false) {
        for($i=1;$i<=10;$i++) {
            $treenode = $this->generateTreeNode($i,$user_id);
            if($i<5) {
                $treenode["children"][] = $this->generateTreeNode($i,$user_id);
            }
            $this->tree_expected[] = $treenode;
        }

        for($i=1;$i<=10;$i++) {
            $treenode = $this->generateTreeNode($i,1, true, true);
            if($i<5) {
                $treenode["children"][] = $this->generateTreeNode($i,1, true, true);
            }
            $this->tree_input[] = $treenode;
        }

    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testFormatTreeWithoutUserId()
    {
        $this->generateTestTree();

        $tree_controller = new TreeController();
        $processed_data = $tree_controller->formatTree($this->tree_input);

        $this->assertEquals($this->tree_expected, $processed_data);
    }

    public function testFormatTreeWithUserId()
    {

        $this->generateTestTree(1);

        $tree_controller = new TreeController();
        $processed_data = $tree_controller->formatTree($this->tree_input,1);

        $this->assertEquals($this->tree_expected, $processed_data);
    }
}
