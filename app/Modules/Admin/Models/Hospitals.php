<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Hospitals extends Model {

    protected $table = 'hospitals';
    protected $primaryKey = 'hospital_id';
    protected $fillable = ['hospital_id', 'hospital_name'];
    public $sortable = ['hospital_name', 'hospitalcode', 'hospital_business_name'];

}
