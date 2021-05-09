<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Patients extends Model {

    protected $table = 'patients';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'title','firstname','lastname','gender','dob','photo','phone','email'];

}

?>