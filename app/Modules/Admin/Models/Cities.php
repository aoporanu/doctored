<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cities extends Model {

    protected $table = 'cities';
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'name'];

    // public static function getPageElements($pageId){
    //     // echo $pageId;
    //     // die;
    //     $page_elements = DB::table('page_elements')->where('page_id', $pageId)->get();
    //    // $page_elements = DB::select("select * from page_elements where page_id=".$pageId);
    //     return $page_elements;
    // }

    // public static function findElementId($elementId){
    //     $page_element = DB::table('page_elements')->where('id', $elementId)->get();
    //     return $page_element;
    // }
}
