<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;


class SiteManagement extends Model {

    protected $table = 'site_management';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'sitename'];
}
