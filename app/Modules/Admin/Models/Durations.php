<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Durations extends Model {

    protected $table = 'durations';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'shift', 's_start','s_end'];

}
