<?php
namespace App\Modules\Frontend\Models;
use Illuminate\Database\Eloquent\Model;

class HospitalDoctorMapping extends Model {

    protected $table = 'hospital_doctor_mapping';
    protected $primaryKey = 'hd_mapping_id';
    protected $fillable = ['hospital_id', 'doctor_id'];

}
