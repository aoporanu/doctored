<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class PatientMetaTypes extends Model {

    protected $table = 'patient_metatypes';
    protected $primaryKey = 'pmeta_id';
    protected $fillable = ['pmeta_id', 'pmetaname', 'pmetakey'];

}
