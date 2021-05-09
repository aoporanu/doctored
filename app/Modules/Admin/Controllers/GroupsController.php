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
use Illuminate\Support\Facades\Validator as Validator;
use App\Modules\Admin\Controllers\AdminIndexController as AdminController;
use App\Modules\Admin\Models\Groups as Groups;
use App\Modules\Admin\Models\Specialization as Specialization;
use App\Modules\Admin\Models\SpecializationMapping as SpecializationMapping;
use App\Modules\Admin\Models\MetatypeData as MetatypeData;

/**
 * Description of GroupsController
 *
 * @author sandeep.jeedula
 */
class GroupsController extends AdminController {

    private $_url_key = '/admin/groups';
    private $_mapping_type = 'group';
    private $_mapping_key = 'G';

    //put your code here

    public static function getGroupName($groupId) {
        try {
            $groupDetails = Groups::where('group_id', $groupId)->where('is_delete', 0)->first();
            return $groupDetails->group_name;
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function groups() {
        try {
            $this->setData($this->_url_key, 'view');
            if ($this->limitedAccess == 'All') {
                $groups = Groups::orderBy('group_id', 'asc')->where('is_delete', 0)->paginate(10);
            } else {
                $groups = $this->getGroupsByGroup();
            }
            return view('Admin::groups/groups')->with(['groups' => $groups, 'accessDetails' => $this->accessDetails, 'mapping_key'=>$this->_mapping_key]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function createGroup() {
        try {
            $this->setData($this->_url_key, 'add');
            $specializations = \App\Modules\Admin\Models\GroupMetaTypes::all()->where('is_active', 1)->where('is_delete', 0);
            $specializationList = [];
            return view('Admin::groups/create_group')->with(['specializations' => $specializations, 'specializationList' => $specializationList]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function addGroup(Request $request) {
        try {
            $this->setData($this->_url_key, 'add');
            $successMessage = 'Added suceessfully';
            if ($request->isMethod('post')) {
                $requestParams = $this->filterParameters($request->all());
                $groupId = isset($requestParams['group_id']) ? $requestParams['group_id'] : 0;
                if ($groupId != 0) {
                    $request->validate([
                        'group_name' => ['required', 'regex:/^[A-Za-z0-9_@.#&+-]*$/'],
                        'group_name' => 'unique:group,group_name,' . $groupId . ',group_id',
                        'phone' => 'required|numeric|digits_between:10,12',
                        'licence' => 'required|digits_between:7,7|unique:group,licence,' . $groupId . ',group_id',
                        'email' => 'required|email|unique:group,email,' . $groupId . ',group_id',
                    ]);
                    $groupDetails = Groups::where('group_id', $groupId)->where('is_delete', 0)->first();
                    $groupDetails->group_name = $request->group_name;
                    // $groupDetails->logo = $request->logo;
                    if ($request->hasFile('logo')) {
                        if ($request->file('logo')->isValid()) {
                            try {
                                $request->validate([
                                    'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',
                                ]);
                                $file = $request->file('logo');
                                $logo = $file->getClientOriginalName();
                                $request->file('logo')->move("uploads", $logo);
                                $groupDetails->logo = $logo;
                            } catch (Illuminate\Filesystem\FileNotFoundException $e) {

                            }
                        }
                    }
                    if ($request->hasFile('banner')) {
                        if ($request->file('banner')->isValid()) {
                            try {
                                $request->validate([
                                    'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',
                                ]);
                                $file = $request->file('banner');
                                $banner = $file->getClientOriginalName();
                                $request->file('banner')->move("uploads", $banner);
                                $groupDetails->banner = $banner;
                            } catch (Illuminate\Filesystem\FileNotFoundException $e) {

                            }
                        }
                    }
                    $groupDetails->group_description = $request->group_description;
                    $groupDetails->group_business_name = $request->group_business_name;
                    $groupDetails->address = $request->address;
                    $groupDetails->address_long = $request->address_long;
                    $groupDetails->address_place = $request->address_place;
                    $groupDetails->address_lat = $request->address_lat;
                    $groupDetails->phone = $request->phonecode.'-'.$request->phone;
                    $groupDetails->email = $request->email;
                    $groupDetails->licence = $request->licence;
                    $groupDetails->updated_by = $this->userId;
                    $groupDetails->is_delete = 0;
                    $groupDetails->save();
                    $successMessage = 'Updated suceessfully';
                } else {
                    $request->validate([
                        'group_name' => ['required', 'regex:/^[A-Za-z0-9_@.#&+-]*$/'],
                        'phone' => 'required|numeric|digits_between:10,12|unique:group',
                        'email' => 'required|email|unique:group',
                        'licence' => 'required|digits_between:7,7|unique:group,licence',
                    ]);
                    $groupIncrementData = Groups::orderBy('gid', 'desc')->first();
                    $groupData = new Groups();
                    $groupData->group_name = $request->group_name;
                    if ($request->hasFile('logo')) {
                        if ($request->file('logo')->isValid()) {
                            try {
                                $request->validate([
                                    'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',
                                ]);
                                $file = $request->file('logo');
                                $logo = $file->getClientOriginalName();
                                $request->file('logo')->move("uploads", $logo);
                                $groupData->logo = $logo;
                            } catch (Illuminate\Filesystem\FileNotFoundException $e) {

                            }
                        }
                    }
                    if ($request->hasFile('banner')) {
                        if ($request->file('banner')->isValid()) {
                            try {
                                $request->validate([
                                    'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',
                                ]);
                                $file = $request->file('banner');
                                $banner = $file->getClientOriginalName();
                                $request->file('banner')->move("uploads", $banner);
                                $groupData->banner = $banner;
                            } catch (Illuminate\Filesystem\FileNotFoundException $e) {

                            }
                        }
                    }
                    $groupData->group_description = $request->group_description;
                    $groupData->group_business_name = $request->group_business_name;
                    $groupData->address = $request->address;
                    $groupData->address_long = $request->address_long;
                    $groupData->address_place = $request->address_place;
                    $groupData->address_lat = $request->address_lat;
                    $groupData->phone = $request->phonecode.'-'.$request->phone;
                    $groupData->email = $request->email;
                    $groupData->licence = $request->licence;
                    $groupData->created_by = $this->userId;
					if(isset($groupIncrementData->gid)){
                    $groupData->gid = ($groupIncrementData->gid + 1);
					}else{
						  $groupData->gid = 100001;
					}
                    $groupData->is_delete = 0;
                    $groupData->save();
                    $groupId = $groupData->group_id;
                }
                $specializations = \App\Modules\Admin\Models\GroupMetaTypes::all()->where('is_active', 1)->where('is_delete', 0);
//                if(!empty($specializations)){
//                    foreach($specializations as $spec){
//                        if(isset($requestParams[$spec->gmetaname])){
//                            $metaData = MetatypeData::where('metatype_data.mapping_type', $this->_mapping_type)
//                            ->where('metatype_data.is_active', 1)
//                            ->where('metatype_data.mapping_type_id', $groupId)
//                            ->where('metatype_data.mapping_type_data_id', $spec->gmeta_id)
//                            ->first();
////                            echo "<pre>";print_r($metaData);die;
//                            if($metaData)
//                            {
//                                $metaData->mapping_type_data_value = $requestParams[$spec->gmetaname];
//                                $metaData->updated_by = $this->_user_id;
//                                $metaData->save();
//                            }else{
//                                $metatypeData = new MetatypeData();
//                                $metatypeData->mapping_type = $this->_mapping_type;
//                                $metatypeData->mapping_type_id = $groupId;
//                                $metatypeData->mapping_type_data_id = $spec->gmeta_id;
//                                $metatypeData->mapping_type_data_value = $requestParams[$spec->gmetaname];
//                                $metatypeData->created_by = $this->_user_id;
//                                $metatypeData->updated_by = 0;
//                                $metatypeData->save();
//                            }
//                        }
//                    }
//                }
                $this->saveMetaTypeData($groupId, $this->_mapping_type, $specializations, $requestParams);
//                if (isset($requestParams['specialization']) && count($requestParams['specialization']) > 0) {
//                    foreach ($requestParams['specialization'] as $specilizationId) {
//                        if ($specilizationId > 0) {
//
//                            $specilizationData = new SpecializationMapping();
//                            $specilizationData->mapping_type = $this->_mapping_type;
//                            $specilizationData->mapping_type_id = $groupId;
//                            $specilizationData->specialization_id = $specilizationId;
//                            $specilizationData->created_by = $this->_user_id;
//                            $specilizationData->updated_by = 0;
//                            $specilizationData->save();
//                        }
//                    }
//                } elseif (isset($requestParams['specialization']) && count($requestParams['specialization']) == 0) {
//                    $specializationData = SpecializationMapping::join('group_metatypes', 'group_metatypes.gmeta_id', '=', 'specialization_mapping.specialization_mapping_id')
//                            ->where('specialization_mapping.mapping_type', $this->_mapping_type)
//                            ->where('group_metatypes.is_active', 1)
//                            ->where('specialization_mapping.is_active', 1)
//                            ->where('specialization_mapping.mapping_type_id', $groupId)->delete();
//                }
            } else {
                return Redirect::back()->withErrors('Invalid access page!');
            }
            return Redirect::to('admin/groups')->with('success', $successMessage);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage())->withInput($request->all());
        }
    }

    public function editGroup($groupId) {
        try {
            $this->setData($this->_url_key, 'edit');
            $groupIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($groupId);
            $group_id = str_replace($this->_mapping_key, '', $groupIdData);
            $groupDetails = [];
            if ($group_id) {
                $groupDetails = Groups::where('group_id', $group_id)->where('is_delete', 0)->first();
            }
            $specializations = \App\Modules\Admin\Models\GroupMetaTypes::all()->where('is_active', 1)->where('is_delete', 0);
            $specializationList = [];
            $metaData = MetatypeData::join('group_metatypes', 'group_metatypes.gmeta_id', '=', 'metatype_data.mapping_type_data_id')
                            ->where('metatype_data.mapping_type', $this->_mapping_type)
                            ->where('metatype_data.is_active', 1)
                            ->where('group_metatypes.is_active', 1)
                            ->where('metatype_data.mapping_type_id', $group_id)
                    ->get()->all();
//            echo "<pre>";print_r($metaData);die;
            $metaDataElements = [];
            if ($metaData) {
                foreach ($metaData as $metaDataInfo) {
                    $metaDataElements[$metaDataInfo->gmetaname] = $metaDataInfo->mapping_type_data_value;
                }
            }
            $specializationData = SpecializationMapping::join('group_metatypes', 'group_metatypes.gmeta_id', '=', 'specialization_mapping.specialization_mapping_id')
                            ->where('specialization_mapping.mapping_type', $this->_mapping_type)
                            ->where('group_metatypes.is_active', 1)
                            ->where('specialization_mapping.is_active', 1)
                            ->where('specialization_mapping.mapping_type_id', $group_id)->get()->all();
            if ($specializationData) {
                foreach ($specializationData as $specializationInfo) {
                    $specializationList[] = $specializationInfo->gmeta_id;
                }
            }
            return view('Admin::groups/create_group')->with(['group_details' => $groupDetails,
                'specializations' => $specializations, 'specializationList' => $specializationList, 'metaTypeData' => $metaDataElements]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function viewGroup($groupId) {
        try {
            $this->setData($this->_url_key, 'view');
            $groupIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($groupId);
            $group_id = str_replace($this->_mapping_key, '', $groupIdData);
            $groupDetails = [];
            if ($group_id) {
                $groupDetails = Groups::where('group_id', $group_id)->where('is_delete', 0)->first();
            }else {
                return Redirect::back()->with('error', 'Data not found');
            }
            $specializations = \App\Modules\Admin\Models\GroupMetaTypes::all()->where('is_active', 1)->where('is_delete', 0);
            $specializationList = [];
            $metaData = MetatypeData::join('group_metatypes', 'group_metatypes.gmeta_id', '=', 'metatype_data.mapping_type_data_id')
                            ->where('metatype_data.mapping_type', $this->_mapping_type)
                            ->where('metatype_data.is_active', 1)
                            ->where('group_metatypes.is_active', 1)
                            ->where('metatype_data.mapping_type_id', $group_id)
                    ->get()->all();
            $metaDataElements = [];
            if ($metaData) {
                foreach ($metaData as $metaDataInfo) {
                    $metaDataElements[$metaDataInfo->gmetaname] = $metaDataInfo->mapping_type_data_value;
                }
            }
            return view('Admin::groups/view_group')->with(['group_details' => $groupDetails, 'specializations' => $specializations,
                'specializationList' => $specializationList, 'metaTypeData' => $metaDataElements,
                'mapping_key' => $this->_mapping_key]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function deleteGroup($groupId) {
        try {
            $this->setData($this->_url_key, 'delete');
            $groupIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($groupId);
            $group_id = str_replace($this->_mapping_key, '', $groupIdData);
            if ($group_id) {
                $groupDetails = Groups::where('group_id', $group_id)->where('is_delete', 0)->first();
                $groupDetails->is_delete = 1;
                $groupDetails->save();
                return Redirect::to('admin/groups/');
            }else {
                return Redirect::back()->with('error', 'Data not found');
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

}
