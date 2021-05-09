<?php
namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Redirect;
use View;
use Log;
use Exception;
use App\Modules\Admin\Models\Cities as Cities;

use Illuminate\Support\Facades\Session;

class CitiesController extends Controller {
	public function cities() {
        $cities = Cities::paginate(10);
        return view('Admin::cities/cities')->with(['cities' => $cities]);
    }
	
	public function createPage() {
        $pages = pages::all();
        return view('Admin::pages/create_page')->with(['pages' => $pages]);
    }

    public function addPage(Request $request) {
      
        $requestParams = $request->all();
        // echo "<pre>";print_R($requestParams);die;
       $pageId = isset($requestParams['id']) ? $requestParams['id'] : 0;
        if ($pageId != 0) {
            $page_details = Pages::where('id', $pageId)->where('is_delete', 0)->first();
            $page_details->title = $request->title;
            $page_details->slug = $request->slug;
            $page_details->description = $request->description;

            if ($request->hasFile('banner')) {
                if($request->file('banner')->isValid()) {
                    try {
                        $this->validate($request, [
                            'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                        ]);
                       
                        $file = $request->file('banner');
                        $name =  $file->getClientOriginalName();
                        $request->file('banner')->move("uploads", $name);
                        $page_details->banner = $name;
                    } catch (Illuminate\Filesystem\FileNotFoundException $e) {
            
                    }
                }
            }
            


            $page_details->meta_keyword = $request->meta_keyword;
            $page_details->meta_description = $request->meta_description;
            $page_details->meta_author = $request->meta_author;
            $page_details->meta_viewport = $request->meta_viewport;
            $page_details->is_delete = 0;
            $page_details->save();
        } else {
            $pageData = new Pages();
            $pageData->title = $request->title;
            $pageData->slug = $request->slug;
            $pageData->description = $request->description;

           

            if ($request->hasFile('banner')) {
                if($request->file('banner')->isValid()) {
                    try {
                        $this->validate($request, [
                            'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                        ]);
                        $file = $request->file('banner');
                        $name =  $file->getClientOriginalName();
                        $request->file('banner')->move("uploads", $name);
                        $pageData->banner = $name;
                    } catch (Illuminate\Filesystem\FileNotFoundException $e) {
            
                    }
                }
            }

            


            $pageData->meta_keyword = $request->meta_keyword;
            $pageData->meta_description = $request->meta_description;
            $pageData->meta_author = $request->meta_author;
            $pageData->meta_viewport = $request->meta_viewport;
            $pageData->is_delete = 0;
            $pageData->save();
        }
        return Redirect::to('admin/pages/');
    }

    public function editPage(Request $request) {
        $requestParams = $request->all();
//        echo "<pre>";print_R($requestParams);die;
        $pageId = isset($requestParams['id']) ? $requestParams['id'] : 0;
        $pageDetails = [];
        $page_elements = [];
        $page_element = [];
        $pages = Pages::all();
        if($pageId)
        {
            $pageDetails = Pages::where('id', $pageId)->where('is_delete', 0)->first();
            $page_elements = PageElements::getPageElements($pageId);
        }
//        echo "<pre>";print_R($menus);die;
        return view('Admin::pages/create_page')->with(['pages' => $pages, 'page_details' => $pageDetails,'page_elements'=>$page_elements,'page_element'=>$page_element]);
    }

    public function viewPage(Request $request) {
        $requestParams = $request->all();
//        echo "<pre>";print_R($requestParams);die;
        $pageId = isset($requestParams['id']) ? $requestParams['id'] : 0;
        $pageDetails = [];
        $page_elements = [];
        $page_element = [];
        $pages = Pages::all();
        if($pageId)
        {
            $pageDetails = Pages::where('id', $pageId)->where('is_delete', 0)->first();
            $page_elements = PageElements::getPageElements($pageId);
        }
//        echo "<pre>";print_R($menus);die;
        return view('Admin::pages/view_page')->with(['pages' => $pages, 'page_details' => $pageDetails,'page_elements'=>$page_elements,'page_element'=>$page_element]);
    }

    public function editPageElement(Request $request) {
        $requestParams = $request->all();
//        echo "<pre>";print_R($requestParams);die;
        $elementId = isset($requestParams['id']) ? $requestParams['id'] : 0;
       
        if($elementId)
        {
            $page_element = PageElements::where('id', $elementId)->where('is_delete', 0)->first();
        }
        return json_encode($page_element);
    }

    public function deletePage(Request $request) {
        $requestParams = $request->all();
        $pageId = isset($requestParams['id']) ? $requestParams['id'] : 0;
        if($pageId)
        {
            $pageDetails = Pages::where('id', $pageId)->where('is_delete', 0)->first();
            $pageDetails->is_delete = 1;
            $pageDetails->save();
            return Redirect::to('admin/pages/');
        }
    }

    public function deletePageElement(Request $request) {
        $requestParams = $request->all();
        // print_r($requestParams);
        // die;
        $elementId = isset($requestParams['id']) ? $requestParams['id'] : 0;
        if($elementId)
        {
            $elementDetails = PageElements::where('id', $elementId)->where('is_delete', 0)->first();
            $elementDetails->is_delete = 1;
            $elementDetails->save();
            return json_encode($elementDetails);
        }
    }


    public function createPageElement(Request $request) {
      
       $requestParams = $request->all();
       $pageelementId = isset($requestParams['id']) ? $requestParams['id'] : 0;
        if ($pageelementId != 0) {
            $element_details = PageElements::where('id', $pageelementId)->where('is_delete', 0)->first();
            $element_details->page_id = $request->page_id;
            $element_details->element_type = $request->element_type;
            $element_details->element_key = $request->element_key;
            $element_details->element_name = $request->element_name;

            if($request->element_type=="text"){
                $element_details->element_value = $request->element_value;
            }

            if ($request->hasFile('elementimage')) {
                if($request->file('elementimage')->isValid()) {
                    try {
                        $this->validate($request, [
                            'elementimage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                        ]);
                        $file = $request->file('elementimage');
                        $name =  $file->getClientOriginalName();
                        $request->file('elementimage')->move("answers", $name);
                        $element_details->element_value = $name;
                    } catch (Illuminate\Filesystem\FileNotFoundException $e) {
            
                    }
                }
            }
           
            

            $element_details->is_delete = 0;
            $element_details->save();
            return  json_encode($element_details);
           
        } else {
            $element_details = new PageElements();
            $element_details->page_id = $request->page_id;
            $element_details->element_type = $request->element_type;
            $element_details->element_key = $request->element_key;
            $element_details->element_name = $request->element_name;

            if($request->element_type=="text"){
                $element_details->element_value = $request->element_value;
            }

            if ($request->hasFile('elementimage')) {
                if($request->file('elementimage')->isValid()) {
                    try {
                        $this->validate($request, [
                            'elementimage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                        ]);
                        $file = $request->file('elementimage');
                        $name =  $file->getClientOriginalName();
                        $request->file('elementimage')->move("answers", $name);
                        $element_details->element_value = $name;
                    } catch (Illuminate\Filesystem\FileNotFoundException $e) {
            
                    }
                }
            }
            $element_details->is_delete = 0;
            $element_details->save();

            return  json_encode($element_details);
        }

    }
}
?>