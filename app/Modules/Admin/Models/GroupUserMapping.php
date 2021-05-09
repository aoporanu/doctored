<?php
namespace App\Modules\Admin\Models;
use Illuminate\Database\Eloquent\Model;

class GroupUserMapping extends Model {

    protected $table = 'group_user_mapping';
    protected $primaryKey = 'group_user_mapping_id';
    protected $fillable = ['user_id', 'gid'];

}
