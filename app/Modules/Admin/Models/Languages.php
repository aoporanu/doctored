<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Languages extends Model {
    protected $table = 'languages';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = ['id', 'value'];
}
