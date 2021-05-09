<?php
namespace App\Modules\Admin\Models;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model {

    protected $table = 'roles';
    protected $primaryKey = 'role_id';
    protected $fillable = ['role_id', 'role_name'];

}
