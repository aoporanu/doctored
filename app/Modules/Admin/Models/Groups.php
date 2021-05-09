<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model {

    protected $table = 'group';
    protected $primaryKey = 'group_id';
    protected $fillable = ['group_id', 'group_name'];

}
