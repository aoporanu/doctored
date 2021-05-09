<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationTypes extends Model {

    protected $table = 'consultation_types';
    protected $primaryKey = 'ctype_id';
    // protected $fillable = ['id', 'specialization_name', 'specialization_shortcode'];

}
