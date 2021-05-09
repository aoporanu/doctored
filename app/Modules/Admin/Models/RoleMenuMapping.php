<?php
namespace App\Modules\Admin\Models;
use Illuminate\Database\Eloquent\Model;

class RoleMenuMapping extends Model {

    protected $table = 'role_action_mapping';
    protected $primaryKey = 'role_action_mapping_id';
    protected $fillable = ['role_id', 'menu_id', 'limited_to'];

}
