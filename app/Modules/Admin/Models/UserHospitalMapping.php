<?php
namespace App\Modules\Admin\Models;
use Illuminate\Database\Eloquent\Model;

class UserHospitalMapping extends Model {

    protected $table = 'user_hospital_mapping';
    protected $primaryKey = 'user_hospital_mapping_id';
    protected $fillable = ['user_id', 'hospital_id'];

}
