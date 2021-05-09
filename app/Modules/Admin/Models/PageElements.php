<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

use DB;

class PageElements extends Model {

    protected $table = 'page_elements';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'page_id'];

    public static function getPageElements($pageId){
        $page_elements = DB::table('page_elements')->where('page_id', $pageId)->where('is_delete',0)->get();
        return $page_elements;
    }
}
