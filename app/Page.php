<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
    protected $table = 'pages';

    public function elements(){
        return $this->hasMany('App\Page_elements', 'foreign_key');

    }

}
