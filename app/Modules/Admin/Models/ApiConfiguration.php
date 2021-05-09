<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class ApiConfiguration extends Model {

    protected $table = 'api_configuration';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'request_type', 'api_url'];

}
