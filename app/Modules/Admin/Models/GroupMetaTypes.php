<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class GroupMetaTypes extends Model {

    protected $table = 'group_metatypes';
    protected $primaryKey = 'gmeta_id';
    protected $fillable = ['gmeta_id', 'gmetaname', 'gmetakey'];

}
