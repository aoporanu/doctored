<?php
namespace App\Modules\Frontend\Models;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model {

    protected $table = 'contacts';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'firstname','lastname','phone','email','description'];

}
