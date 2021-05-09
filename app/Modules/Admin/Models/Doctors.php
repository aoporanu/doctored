<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Doctors extends Model {

    protected $table = 'doctors';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'title','firstname','lastname','phone','email'];

}

?>