<?php
namespace App\Modules\Frontend\Models;
use Illuminate\Database\Eloquent\Model;

class ConsultationData extends Model {

    protected $table = 'consultation_data';
    protected $primaryKey = 'id';
    protected $fillable = ['patient_id', 'doctor_id'];

}
