<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalMetaTypes extends Model
{
    protected $table = 'hospital_metatypes';
    protected $primaryKey = 'hmeta_id';
    protected $fillable = ['hmeta_id', 'hmetaname', 'hmetakey'];
}
