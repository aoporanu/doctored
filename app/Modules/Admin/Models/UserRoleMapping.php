<?php
namespace App\Modules\Admin\Models;
use Illuminate\Database\Eloquent\Model;

class UserRoleMapping extends Model {

    protected $table = 'user_role_mapping';
    protected $primaryKey = 'user_role_mapping_id';
    protected $fillable = ['user_id', 'role_id'];

}
