<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Redirect;
use View;
use Log;
use Exception;
use Session;
use App\Modules\Admin\Controllers\AdminIndexController as AdminController;
use App\Modules\Admin\Models\Menus as Menus;

/**
 * Description of MenusController
 *
 * @author sandeep.jeedula
 */
class MenusController extends AdminController {

    private $_url_key = '/admin/menus';
    private $_mapping_key = 'M';

    public static function getMenuName($menuId) {
        try {
            $menuDetails = Menus::where('menu_id', $menuId)->where('is_delete', 0)->first();
            return $menuDetails->menu_name;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function menus() {
        try {
            $this->setData($this->_url_key, 'view');
            if ($this->limitedAccess == 'All') {
                $menus = Menus::where('is_delete', 0)->orderBy('sort_order', 'ASC')->paginate(10);
            }
            return view('Admin::menus/menus')->with(['menus' => $menus,
                'accessDetails' => $this->accessDetails, 'mapping_key'=>$this->_mapping_key]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function createMenu() {
        try {
            $this->setData($this->_url_key, 'add');
            $menus = Menus::where('is_delete', 0)->orderBy('sort_order', 'ASC')->get()->all();
            $sortOrder = Menus::max('sort_order');
            return view('Admin::menus/create_menu')->with(['menus' => $menus, 'sortOrder' => ($sortOrder+1)]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function addMenu(\Illuminate\Http\Request $request) {
        try {
            $this->setData($this->_url_key, 'add');
//            try{
                $request->validate([
//                    'menu_name' => 'required|unique:menus,menu_name,'.$request->menu_id.',menu_id',
                    'menu_url' => 'required',
                    'sort_order' => 'required'
                ]);
//            } catch (\Illuminate\Validation\ValidationException $e) {
//                return Redirect::back()->withErrors($e->errors())->withInput();
//            }
            $requestParams = $this->filterParameters($request->all());
            $successMessage = 'Added suceessfully';
            $menuId = isset($requestParams['menu_id']) ? $requestParams['menu_id'] : 0;
            if ($menuId != 0) {
//                $menuIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($menuId);
//                $menu_id = str_replace($this->_mapping_key, '', $menuIdData);
                $menuDetails = Menus::where('menu_id', $menuId)->where('is_delete', 0)->first();
                $successMessage = 'Updated suceessfully';
            } else {
                $menuDetails = new Menus();
            }
            $menuDetails->menu_name = $request->menu_name;
            $menuDetails->menu_description = $request->menu_description;
            $menuDetails->menu_url = $request->menu_url;
            $menuDetails->parent_id = $request->parent_id;
            $menuDetails->sort_order = $request->sort_order;
            $menuDetails->menu_icon = $request->menu_icon;
            $menuDetails->save();
            return Redirect::to('admin/menus')->with('success', $successMessage);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage())->withInput();
        }
    }

    public function editMenu($menuId) {
        try {
            $this->setData($this->_url_key, 'edit');
            $menuIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($menuId);
            $menu_id = str_replace($this->_mapping_key, '', $menuIdData);
            $menuDetails = [];
            $menus = Menus::all();
            if ($menu_id) {
                $menuDetails = Menus::where('menu_id', $menu_id)->where('is_delete', 0)->first();
            }else{
                return Redirect::back()->with('error', 'Menu not found');
            }
            return view('Admin::menus/create_menu')->with(['menus' => $menus, 'menu_details' => $menuDetails, 'menuId' => $menuId]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function viewMenu($menuId) {
        try {
            $this->setData($this->_url_key, 'view');
            $menuIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($menuId);
            $menu_id = str_replace($this->_mapping_key, '', $menuIdData);
            $menuDetails = [];
            $menus = Menus::all();
            if ($menu_id) {
                $menuDetails = Menus::where('menu_id', $menu_id)->where('is_delete', 0)->first();
            }
            return view('Admin::menus/view_menu')->with(['menus' => $menus, 'menu_details' => $menuDetails]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function deleteMenu($menuId) {
        try {
            $this->setData($this->_url_key, 'delete');
            $menuIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($menuId);
            $menu_id = str_replace($this->_mapping_key, '', $menuIdData);
            if ($menu_id) {
                $menuDetails = Menus::where('menu_id', $menu_id)->where('is_delete', 0)->first();
                $menuDetails->is_delete = 1;
                $menuDetails->save();
                return Redirect::to('admin/menus')->with('success', 'Deleted Successfully');
            } else {
                return Redirect::back()->with('error', 'Invalid Id!');
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

}
