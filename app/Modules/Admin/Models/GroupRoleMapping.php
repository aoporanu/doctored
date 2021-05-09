<?php
namespace App\Modules\Admin\Models;
use Illuminate\Database\Eloquent\Model;

class GroupRoleMapping extends Model {

    protected $table = 'group_role_mapping';
    protected $primaryKey = 'group_role_mapping_id';
    protected $fillable = ['role_id', 'gid'];

}
