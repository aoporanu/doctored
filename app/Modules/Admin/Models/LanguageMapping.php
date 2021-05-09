<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class LanguageMapping extends Model {
    protected $table = 'lang_mapping';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'module_mapping_type_id'];
}
