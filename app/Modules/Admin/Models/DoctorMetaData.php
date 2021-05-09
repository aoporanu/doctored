<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorMetaData extends Model
{
    protected $table = 'doctors_meta';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'doc_id','doc_mtype_id','meta_key_type'];
}
