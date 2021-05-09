<?php
namespace App\Modules\Admin\Models;
use Illuminate\Database\Eloquent\Model;

class GroupHospitalMapping extends Model {

    protected $table = 'group_hospital_mapping';
    protected $primaryKey = 'group_hospital_mapping_id';
    protected $fillable = ['group_id', 'hospital_id'];

}
