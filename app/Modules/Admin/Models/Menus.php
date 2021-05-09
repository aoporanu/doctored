<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model {

    protected $table = 'menus';
    protected $primaryKey = 'menu_id';
    protected $fillable = ['menu_id', 'menu_name', 'parent_id'];

}
