<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Big Data',
                'email' => 'bigdata@example.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$YE6F66kj2kiJAj4DZLY88.tfxxcjHafovAxX2g5HDrGP57zZSP8P6',
                'remember_token' => NULL,
                'created_at' => '2018-11-15 18:28:23',
                'updated_at' => '2018-11-15 18:28:23',
            ),
        ));
        
        
    }
}