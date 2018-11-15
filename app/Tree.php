<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;


class Tree extends Model
{
    use NodeTrait;

    protected $fillable = ["title","name","expanded","user_id"];


    //
}

