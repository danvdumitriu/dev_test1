<?php

use Illuminate\Database\Seeder;

class TreesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('trees')->delete();
        
        \DB::table('trees')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Europa',
                'title' => 'Europa',
                'expanded' => 1,
                'created_at' => '2018-11-15 15:45:39',
                'updated_at' => '2018-11-15 15:45:39',
                '_lft' => 1,
                '_rgt' => 18,
                'parent_id' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Norge',
                'title' => 'Norge',
                'expanded' => 1,
                'created_at' => '2018-11-15 15:45:39',
                'updated_at' => '2018-11-15 15:45:39',
                '_lft' => 2,
                '_rgt' => 9,
                'parent_id' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Stavanger',
                'title' => 'Stavanger',
                'expanded' => 1,
                'created_at' => '2018-11-15 15:45:39',
                'updated_at' => '2018-11-15 15:45:39',
                '_lft' => 3,
                '_rgt' => 4,
                'parent_id' => 2,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Oslo',
                'title' => 'Oslo',
                'expanded' => 0,
                'created_at' => '2018-11-15 15:45:39',
                'updated_at' => '2018-11-15 15:45:39',
                '_lft' => 5,
                '_rgt' => 6,
                'parent_id' => 2,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Bergen',
                'title' => 'Bergen',
                'expanded' => 0,
                'created_at' => '2018-11-15 15:45:39',
                'updated_at' => '2018-11-15 15:45:39',
                '_lft' => 7,
                '_rgt' => 8,
                'parent_id' => 2,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Danmark',
                'title' => 'Danmark',
                'expanded' => 1,
                'created_at' => '2018-11-15 15:45:39',
                'updated_at' => '2018-11-15 15:45:39',
                '_lft' => 10,
                '_rgt' => 17,
                'parent_id' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Hirtshals',
                'title' => 'Hirtshals',
                'expanded' => 1,
                'created_at' => '2018-11-15 15:45:39',
                'updated_at' => '2018-11-15 15:45:39',
                '_lft' => 11,
                '_rgt' => 12,
                'parent_id' => 6,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Ålborg',
                'title' => 'Ålborg',
                'expanded' => 0,
                'created_at' => '2018-11-15 15:45:39',
                'updated_at' => '2018-11-15 15:45:39',
                '_lft' => 13,
                '_rgt' => 14,
                'parent_id' => 6,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Give',
                'title' => 'Give',
                'expanded' => 0,
                'created_at' => '2018-11-15 15:45:39',
                'updated_at' => '2018-11-15 15:45:39',
                '_lft' => 15,
                '_rgt' => 16,
                'parent_id' => 6,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Asia',
                'title' => 'Asia',
                'expanded' => 1,
                'created_at' => '2018-11-15 15:45:39',
                'updated_at' => '2018-11-15 15:45:39',
                '_lft' => 19,
                '_rgt' => 34,
                'parent_id' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Japan',
                'title' => 'Japan',
                'expanded' => 1,
                'created_at' => '2018-11-15 15:45:39',
                'updated_at' => '2018-11-15 15:45:39',
                '_lft' => 20,
                '_rgt' => 27,
                'parent_id' => 10,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Tokio',
                'title' => 'Tokio',
                'expanded' => 1,
                'created_at' => '2018-11-15 15:45:39',
                'updated_at' => '2018-11-15 15:45:39',
                '_lft' => 21,
                '_rgt' => 22,
                'parent_id' => 11,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Kobe',
                'title' => 'Kobe',
                'expanded' => 1,
                'created_at' => '2018-11-15 15:45:39',
                'updated_at' => '2018-11-15 15:45:39',
                '_lft' => 23,
                '_rgt' => 24,
                'parent_id' => 11,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Hiroshima',
                'title' => 'Hiroshima',
                'expanded' => 0,
                'created_at' => '2018-11-15 15:45:39',
                'updated_at' => '2018-11-15 15:45:39',
                '_lft' => 25,
                '_rgt' => 26,
                'parent_id' => 11,
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Kina',
                'title' => 'Kina',
                'expanded' => 1,
                'created_at' => '2018-11-15 15:45:39',
                'updated_at' => '2018-11-15 15:45:39',
                '_lft' => 28,
                '_rgt' => 33,
                'parent_id' => 10,
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Beijing',
                'title' => 'Beijing',
                'expanded' => 0,
                'created_at' => '2018-11-15 15:45:39',
                'updated_at' => '2018-11-15 15:45:39',
                '_lft' => 29,
                '_rgt' => 30,
                'parent_id' => 15,
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Shanghai',
                'title' => 'Shanghai',
                'expanded' => 0,
                'created_at' => '2018-11-15 15:45:39',
                'updated_at' => '2018-11-15 15:45:39',
                '_lft' => 31,
                '_rgt' => 32,
                'parent_id' => 15,
            ),
        ));


        $big_data = [];
        $max = 600;
        for($i=18;$i<=$max;$i++) {
            $name = "Item $i";
            $record = [
                "id" => $i,
                "user_id" => 1,
                "name" => $name,
                "title" => $name,
                "expanded" => 1,
                "parent_id" => $this->setParentId($i, $max)
            ];
            $big_data[] = $record;
        }

        \DB::table('trees')->insert($big_data);

        
        
    }

    public function setParentId($id,$max) {
        if($id<50) return null;
        if($id<500) return rand(18,50);
        return rand(51,100);
    }
}