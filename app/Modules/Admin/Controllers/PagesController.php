<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use App\Modules\Admin\Controllers\AdminIndexController as AdminController;
use Redirect;
use View;
use Log;
use Exception;
use App\Modules\Admin\Models\Pages as Pages;
use App\Modules\Admin\Models\PageElements as PageElements;

class PagesController extends AdminController {
    private $_url_key = '/admin/pages';

    public function pages(Request $request) {
        try {
            $this->setData($this->_url_key, 'view');
            //search code starts added by Narendra
            $isSearch = false;
            if ($request->isMethod('post')) {
                $q = $request->q;
                $isSearch = true;
                if ($q != "") {
                    $pages = pages::where('is_delete', 0)->where('title', 'ILIKE', '%' . $q . '%')->paginate(10);
                }
            } else {

                $pages = pages::where('is_delete', 0)->paginate(10);
            }
            return view('Admin::pages/pages')->with(['pages' => $pages, 'accessDetails' => $this->accessDetails, 'isSearch' => $isSearch]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function createPage() {
        try {
            $this->setData($this->_url_key, 'add');
            $pages = pages::where('is_delete', 0)->get()->all();
            return view('Admin::pages/create_page')->with(['pages' => $pages]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function addPage(Request $request) {
        try {
            $this->setData($this->_url_key, 'add');
            $requestParams = $this->filterParameters($request->all());
            $pageId = isset($requestParams['id']) ? $requestParams['id'] : 0;
            $successMessage = 'Added suceessfully';
            if ($pageId != 0) {
                $page_details = Pages::where('id', $pageId)->where('is_delete', 0)->first();
                $page_details->title = $request->title;
                $page_details->slug = $request->slug;
                $page_details->description = $request->description;

                if ($request->hasFile('banner')) {
                    if ($request->file('banner')->isValid()) {
                        try {
                            $this->validate($request, [
                                'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                            ]);

                            $file = $request->file('banner');
                            $name = $file->getClientOriginalName();
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
                $successMessage = 'Updated suceessfully';
            } else {
                $pageData = new Pages();
                $pageData->title = $request->title;
                $pageData->slug = $request->slug;
                $pageData->description = $request->description;
                if ($request->hasFile('banner')) {
                    if ($request->file('banner')->isValid()) {
                        try {
                            $this->validate($request, [
                                'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                            ]);
                            $file = $request->file('banner');
                            $name = $file->getClientOriginalName();
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
            return Redirect::to('admin/pages/')->with('success', $successMessage);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function editPage(Request $request) {
        try {
            $this->setData($this->_url_key, 'edit');
            $requestParams = $request->all();
            $pageId = isset($requestParams['id']) ? $requestParams['id'] : 0;
            $pageDetails = [];
            $page_elements = [];
            $page_element = [];
            $pages = Pages::all();
            if ($pageId) {
                $pageDetails = Pages::where('id', $pageId)->where('is_delete', 0)->first();
                $page_elements = PageElements::getPageElements($pageId);
            }else{
                return Redirect::back()->with('error', 'Page id not found');
            }
            return view('Admin::pages/create_page')->with(['pages' => $pages, 'page_details' => $pageDetails, 'page_elements' => $page_elements, 'page_element' => $page_element]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function viewPage(Request $request) {
        try {
            $this->setData($this->_url_key, 'view');
            $requestParams = $request->all();
            $pageId = isset($requestParams['id']) ? $requestParams['id'] : 0;
            $pageDetails = [];
            $page_elements = [];
            $page_element = [];
            $pages = Pages::all();
            if ($pageId) {
                $pageDetails = Pages::where('id', $pageId)->where('is_delete', 0)->first();
                $page_elements = PageElements::getPageElements($pageId);
            }else{
                return Redirect::back()->with('error', 'Page id not found');
            }
            return view('Admin::pages/view_page')->with(['pages' => $pages, 'page_details' => $pageDetails, 'page_elements' => $page_elements, 'page_element' => $page_element]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function editPageElement(Request $request) {
        try {
            $this->setData($this->_url_key, 'edit');
            $requestParams = $request->all();
            $elementId = isset($requestParams['id']) ? $requestParams['id'] : 0;

            if ($elementId) {
                $page_element = PageElements::where('id', $elementId)->where('is_delete', 0)->first();
            }else{
                return Redirect::back()->with('error', 'Page Element not found');
            }
            return json_encode($page_element);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function deletePage(Request $request) {
        try {
            $this->setData($this->_url_key, 'delete');
            $requestParams = $request->all();
            $pageId = isset($requestParams['id']) ? $requestParams['id'] : 0;
            if ($pageId) {
                $pageDetails = Pages::where('id', $pageId)->where('is_delete', 0)->first();
                $pageDetails->is_delete = 1;
                $pageDetails->save();
                return Redirect::to('admin/pages/');
            }else{
                return Redirect::back()->with('error', 'Page id not found');
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function deletePageElement(Request $request) {
        try {
            $this->setData($this->_url_key, 'delete');
            $requestParams = $this->filterParameters($request->all());
            $elementId = isset($requestParams['id']) ? $requestParams['id'] : 0;
            if ($elementId) {
                $elementDetails = PageElements::where('id', $elementId)->where('is_delete', 0)->first();
                $elementDetails->is_delete = 1;
                $elementDetails->save();
                return json_encode($elementDetails);
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function createPageElement(Request $request) {
        try {
            $this->setData($this->_url_key, 'add');
            $requestParams = $request->all();
            $pageelementId = isset($requestParams['id']) ? $requestParams['id'] : 0;
            if ($pageelementId != 0) {
                $element_details = PageElements::where('id', $pageelementId)->where('is_delete', 0)->first();
                $element_details->page_id = $request->page_id;
                $element_details->element_type = $request->element_type;
                $element_details->element_key = $request->element_key;
                $element_details->element_name = $request->element_name;

                if ($request->element_type == "text") {
                    $element_details->element_value = $request->element_value;
                }

                if ($request->hasFile('elementimage')) {
                    if ($request->file('elementimage')->isValid()) {
                        try {
                            $this->validate($request, [
                                'elementimage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                            ]);
                            $file = $request->file('elementimage');
                            $name = $file->getClientOriginalName();
                            $request->file('elementimage')->move("answers", $name);
                            $element_details->element_value = $name;
                        } catch (Illuminate\Filesystem\FileNotFoundException $e) {

                        }
                    }
                }
                $element_details->is_delete = 0;
                $element_details->save();
                return json_encode($element_details);
            } else {
                $element_details = new PageElements();
                $element_details->page_id = $request->page_id;
                $element_details->element_type = $request->element_type;
                $element_details->element_key = $request->element_key;
                $element_details->element_name = $request->element_name;

                if ($request->element_type == "text") {
                    $element_details->element_value = $request->element_value;
                }

                if ($request->hasFile('elementimage')) {
                    if ($request->file('elementimage')->isValid()) {
                        try {
                            $this->validate($request, [
                                'elementimage' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                            ]);
                            $file = $request->file('elementimage');
                            $name = $file->getClientOriginalName();
                            $request->file('elementimage')->move("answers", $name);
                            $element_details->element_value = $name;
                        } catch (Illuminate\Filesystem\FileNotFoundException $e) {

                        }
                    }
                }
                $element_details->is_delete = 0;
                $element_details->save();

                return json_encode($element_details);
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }
}
?>
