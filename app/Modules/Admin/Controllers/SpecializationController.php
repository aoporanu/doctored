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
use App\Modules\Admin\Models\Specialization as Specialization;

/**
 * Description of SpecializationController
 *
 * @author narendraoruganti
 */
class SpecializationController extends AdminIndexController {

    private $_url_key = '/admin/specializations';
    private $_mapping_key = 'ST';

    public function specializations() {
        try {
            $this->setData($this->_url_key, 'view');
            $specializations = Specialization::where('is_delete', 0)->paginate(10);
            return view('Admin::specialization/specializations')->with(['specializations' => $specializations,
                'accessDetails' => $this->accessDetails, 'mapping_key'=>$this->_mapping_key]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function createSpecialization() {
        try {
            $this->setData($this->_url_key, 'add');
            $specializations = Specialization::all();
            return view('Admin::specialization/create_specialization')->with(['specializations' => $specializations]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function addSpecialization(Request $request) {
        try {
            $this->setData($this->_url_key, 'add');
            $this->validate($request, [
                'specialization_name' => ['required'],
                'specialization_shortcode' => ['required']
                    ], [
                'specialization_name.required' => 'Specialization Name is required',
                'specialization_shortcode.required' => 'Specialization Shortcode is required'
            ]);

            $requestParams = $this->filterParameters($request->all());
            $successMessage = 'Added suceessfully';
            $id = isset($requestParams['id']) ? $requestParams['id'] : 0;
            if ($id != 0) {
                $specializations = Specialization::where('id', $id)->where('is_delete', 0)->first();
                $specializations->specialization_name = $request->specialization_name;
                $specializations->specialization_shortcode = $request->specialization_shortcode;
                $specializations->specialization_description = $request->specialization_description;
                $specializations->specialization_parent = $request->specialization_parent;

                $specializations->save();
                $successMessage = 'Updated suceessfully';
            } else {
                $specializationData = new Specialization();
                $specializationData->specialization_name = $request->specialization_name;

                $specializationData->specialization_shortcode = $request->specialization_shortcode;
                $specializationData->specialization_description = $request->specialization_description;
                $specializationData->specialization_parent = $request->specialization_parent;

                $specializationData->save();
            }
            return Redirect::to('/admin/specializations')->with('success', $successMessage);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function editSpecialization($spId) {
        try {
            $this->setData($this->_url_key, 'edit');
            $spIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($spId);
            $id = str_replace($this->_mapping_key, '', $spIdData);
            $specializationDetails = [];
            $specializations = Specialization::all();
            if ($id) {
                $specializations = Specialization::where('id', $id)->where('is_delete', 0)->first();
            }

            return view('Admin::specialization/create_specialization')->with(['specializations' => $specializations]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function viewSpecialization($spId) {
        try {
            $this->setData($this->_url_key, 'view');
            $spIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($spId);
            $id = str_replace($this->_mapping_key, '', $spIdData);
            $specializationDetails = [];
            $specializations = Specialization::where('is_delete', 0)->get()->all();
            if ($id) {
                $specializations = Specialization::where('id', $id)->where('is_delete', 0)->first();
            }
            return view('Admin::specialization/view_specialization')->with(['specializations' => $specializations]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function deleteSpecialization($spId) {
        try {
            $this->setData($this->_url_key, 'delete');
            $spIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($spId);
            $id = str_replace($this->_mapping_key, '', $spIdData);
            if ($id) {
                if ($id)
                    $specializationDetails = Specialization::where('id', $id)->where('is_delete', 0)->first();
                $specializationDetails->is_delete = 1;
                $specializationDetails->save();
                return Redirect::to('/admin/specializations')->with('success', 'Deleted Successfully');
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

}
