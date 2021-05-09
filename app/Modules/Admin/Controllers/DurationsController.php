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
use App\Modules\Admin\Models\Durations as Durations;

/**
 * Description of DurationsController
 *
 * @author naresh.p
 */
class DurationsController extends AdminController {

    private $_url_key = '/admin/durations';
	 private $_mapping_key = 'D';

    public function durations() {
        try {
            $this->setData($this->_url_key, 'view');
            if ($this->limitedAccess == 'All') {
                $durations = Durations::where('is_delete', 0)->paginate(10);
            }
			  return view('Admin::durations/durations')->with(['durations' => $durations,
                'accessDetails' => $this->accessDetails, 'mapping_key'=>$this->_mapping_key]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

    public function createDuration() {
        try {
            $this->setData($this->_url_key, 'add');
            $durations = Durations::all();
            return view('Admin::Durations/create_duration')->with(['durations' => $durations]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

	public function editDuration($spId) {
        try {
            $this->setData($this->_url_key, 'edit');
            $spIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($spId);
            $id = str_replace($this->_mapping_key, '', $spIdData);
            $durationDetails = [];
            $durations = Durations::all();
            if ($id) {
                $durations = Durations::where('id', $id)->where('is_delete', 0)->first();
            }
			//print_r($durations);

            return view('Admin::Durations/create_duration')->with(['duration_details' => $durations]);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

	public function addDuration(Request $request) {
        try {
            $this->setData($this->_url_key, 'add');
            $this->validate($request, [
                ]);

            $requestParams = $this->filterParameters($request->all());
            $successMessage = 'Added suceessfully';
            $id = isset($requestParams['id']) ? $requestParams['id'] : 0;
            if ($id != 0) {
                $durations = Durations::where('id', $id)->where('is_delete', 0)->first();
                $durations->shift = $request->shift;
            $durations->s_start = $request->s_start;
			 $durations->s_end = $request->s_end;
                $durations->save();
                $successMessage = 'Updated suceessfully';
            } else {
                $durationData = new Durations();
                $durationData->shift = $request->shift;
  $durationData->s_start = $request->s_start;
  $durationData->s_end = $request->s_end;


                $durationData->save();
            }
            return Redirect::to('/admin/durations')->with('success', $successMessage);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }


	 public function deleteDuration($spId) {
        try {
            $this->setData($this->_url_key, 'delete');
            $spIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($spId);
            $id = str_replace($this->_mapping_key, '', $spIdData);
            if ($id) {
                if ($id)
                    $durationDetails = Durations::where('id', $id)->where('is_delete', 0)->first();
                $durationDetails->is_delete = 1;
                $durationDetails->save();
                return Redirect::to('/admin/durations')->with('success', 'Deleted Successfully');
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }

	 public function statusDuration($spId,$val) {
        try {
            $this->setData($this->_url_key, 'delete');
            $spIdData = \App\Http\Middleware\EncryptUrlParams::decrypt($spId);
            $id = str_replace($this->_mapping_key, '', $spIdData);
            if ($id) {
                if ($id)
                    $durationDetails = Durations::where('id', $id)->where('is_delete', 0)->first();
				if($val==0){
                $durationDetails->is_active = 1;
				}else {
					$durationDetails->is_active = 0;
				}
                $durationDetails->save();
                return Redirect::to('/admin/durations')->with('success', 'Status Updated Successfully');
            }
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
            Log::error($ex->getTraceAsString());
            return Redirect::back()->with('error', $ex->getMessage());
        }
    }






}
