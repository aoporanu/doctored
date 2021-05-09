<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorMetaTypes extends Model {

    protected $table = 'doctor_metatypes';
    protected $primaryKey = 'dmeta_id';
    protected $fillable = ['dmeta_id', 'dmetaname', 'dmetakey'];

}
