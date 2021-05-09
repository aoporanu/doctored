<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use App\Modules\Admin\Controllers\AdminIndexController as AdminIndexController;
use Redirect;
use View;
use Log;
use Exception;
use Illuminate\Support\Facades\Session;
use App\Modules\Admin\Models\GroupMetaTypes as GroupMetaTypes;

/**
 * Description of GroupMetaTypesController
 *
 * @author Narendra Oruganti
 */
class GroupMetaTypesController extends AdminIndexController {

    private $_url_key = '/admin/settings/groupmetatypes';
    private $_mapping_key = 'GMT';

    public function groupMetaTypes() {
        try {
            $this->setData($this->_url_key, 'view');
            $metatypes = GroupMetaTypes::where('is_delete', 0)->paginate(10);
            return view('Admin::groups/groupmetatypes')->with(['metatypes' => $metatypes,
                    'accessDetails' => $this->accessDetails, 'mapping_key'=>$this->_mapping_key]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function createGroupMetaType() {
        try {
            $this->setData($this->_url_key, 'add');
            $metatypes = GroupMetaTypes::all();
            return view('Admin::groups/create_groupmetatypes')->with(['metatypes' => $metatypes]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function addGroupMetaType(Request $request) {
        try {
            $this->setData($this->_url_key, 'add');
            $this->validate($request, [
                'gmetaname' => ['required'],
                'gmetakey' => ['required']
                    ], [
                'gmetaname.required' => 'Group meta Name is required',
                'gmetakey.required' => 'Groupmeta Key is required'
            ]);

            $requestParams = $this->filterParameters($request->all());
            $gmeta_id = isset($requestParams['gmeta_id']) ? $requestParams['gmeta_id'] : 0;
            $successMessage = 'Added suceessfully';
            if ($gmeta_id != 0) {
                $metatypes = GroupMetaTypes::where('gmeta_id', $gmeta_id)->where('is_delete', 0)->first();
                $metatypes->gmetaname = ucwords($request->gmetaname);
                $metatypes->gmetakey = ucwords($request->gmetakey,"-");
                $metatypes->gmeta_lang_code = $request->gmeta_lang_code;
                $metatypes->gmeta_icon = $request->gmeta_icon;

                $metatypes->save();
                $successMessage = 'Updated suceessfully';
            } else {
                $metaData = new GroupMetaTypes();
                $metaData->gmetaname = ucwords($request->gmetaname);
                $metaData->gmetakey = ucwords($request->gmetakey,"-");
                $metaData->gmeta_lang_code = $request->gmeta_lang_code;
                $metaData->gmeta_icon = $request->gmeta_icon;
                $metaData->is_active = 1;

                $metaData->save();
            }
            return Redirect::to('admin/settings/groupmetatypes')->with('success', $successMessage);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function editGroupMetaType($pmetaId) {
        try {
            $this->setData($this->_url_key, 'edit');
            $pmetaIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($pmetaId);
            $gmeta_id = str_replace($this->_mapping_key, '', $pmetaIdData);
            $metatypes = [];

            if ($gmeta_id) {
                $metatypes = GroupMetaTypes::where('gmeta_id', $gmeta_id)->where('is_delete', 0)->first();
            }

            return view('Admin::groups/create_groupmetatypes')->with(['metatypes' => $metatypes]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function viewGroupMetaType($pmetaId) {
        try {
            $this->setData($this->_url_key, 'view');
            $pmetaIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($pmetaId);
            $gmeta_id = str_replace($this->_mapping_key, '', $pmetaIdData);
            $metatypes = [];

            if ($gmeta_id) {
                $metatypes = GroupMetaTypes::where('gmeta_id', $gmeta_id)->where('is_delete', 0)->first();
            }

            return view('Admin::groups/view_groupmetatypes')->with(['metatypes' => $metatypes, 'mapping_key'=>$this->_mapping_key]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function deleteGroupMetaType($gmetaId) {
        try {
            $this->setData($this->_url_key, 'delete');
            $gmetaIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($gmetaId);
            $gmeta_id = str_replace($this->_mapping_key, '', $gmetaIdData);
            if ($gmeta_id) {
                if ($gmeta_id)
                    $menuDetails = GroupMetaTypes::where('gmeta_id', $gmeta_id)->where('is_delete', 0)->first();
                $menuDetails->is_delete = 1;
                $menuDetails->save();
                return Redirect::to('admin/settings/groupmetatypes')->with('success', 'Deleted Successfully');
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

}
