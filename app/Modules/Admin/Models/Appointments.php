<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    protected $table = 'appointments';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'doctor_id', 'hospital_id', 'patient_id'];
}
