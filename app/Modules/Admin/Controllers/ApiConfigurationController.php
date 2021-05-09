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
use App\Http\Controllers\Controller;
use Redirect;
use View;
use Log;
use Exception;
use Illuminate\Support\Facades\Session;
use App\Modules\Admin\Models\ApiConfiguration as ApiConfiguration;

/**
 * Description of ApiConfigurationController
 *
 * @author Narendra Oruganti
 */
class ApiConfigurationController extends AdminIndexController {

    private $_url_key = '/admin/settings/apiconfigurations';
    private $_mapping_key = 'API';

    public function apiConfigurations() {
        $this->setData($this->_url_key, 'view');
        $configurations = ApiConfiguration::where('is_delete', 0)->paginate(10);
        return view('Admin::api/apiconfigurations')->with(['configurations' => $configurations,
                    'accessDetails' => $this->accessDetails, 'mapping_key' => $this->_mapping_key]);
    }

    public function createApiConfigurations() {
        $this->setData($this->_url_key, 'add');
        $configurations = ApiConfiguration::all();
        return view('Admin::api/create_apiconfigurations')->with(['configurations' => $configurations]);
    }

    public function addApiConfiguration(Request $request) {
        $this->setData($this->_url_key, 'add');
        $this->validate($request, [
            'request_type' => ['required'],
            'environment' => ['required'],
            'api_type' => ['required'],
            'api_url' => ['required'],
            'api_key' => ['required'],
            'api_token' => ['required'],
            'username' => ['required'],
            'password' => ['required']
                ], [
            'request_type.required' => 'Request Type is required',
            'environment.required' => 'Environment  is required',
            'api_type.required' => 'API Type  is required',
            'api_url.required' => 'API URL  is required',
            'api_key.required' => 'API KEY  is required',
            'api_token.required' => 'API Token  is required',
            'username.required' => 'User Name  is required',
            'password.required' => 'Password  is required'
        ]);

        $requestParams = $request->all();
//        echo "<pre>";print_R($requestParams);die;
        $id = isset($requestParams['id']) ? $requestParams['id'] : 0;
        if ($id != 0) {
            $configurations = ApiConfiguration::find($id);
            $configurations->request_type = $request->request_type;
            $configurations->environment = $request->environment;
            $configurations->api_type = $request->api_type;
            $configurations->api_url = $request->api_url;
            $configurations->api_key = $request->api_key;
            $configurations->api_token = $request->api_token;
            $configurations->username = $request->username;
            $configurations->password = $request->password;
            $configurations->param1_key = $request->param1_key;
            $configurations->param1_value = $request->param1_value;
            $configurations->param2_key = $request->param2_key;
            $configurations->param2_value = $request->param2_value;
            $configurations->created = Session::get('user_id');

            $configurations->save();
        } else {
            $configurationData = new ApiConfiguration();
            $configurationData->request_type = $request->request_type;
            $configurationData->environment = $request->environment;
            $configurationData->api_type = $request->api_type;
            $configurationData->api_url = $request->api_url;
            $configurationData->api_key = $request->api_key;
            $configurationData->api_token = $request->api_token;
            $configurationData->username = $request->username;
            $configurationData->password = $request->password;
            $configurationData->param1_key = $request->param1_key;
            $configurationData->param1_value = $request->param1_value;
            $configurationData->param2_key = $request->param2_key;
            $configurationData->param2_value = $request->param2_value;
            $configurationData->updated = Session::get('user_id');
            $configurationData->save();
        }
        return Redirect::to('admin/settings/apiconfigurations');
    }

    public function editApiConfigurations($id) {
        $this->setData($this->_url_key, 'edit');
//        $requestParams = $request->all();
//
//        $id = isset($requestParams['id']) ? $requestParams['id'] : 0;
        $IdData = \App\Http\Middleware\EncryptUrlParams::decrypt($id);
        $id = str_replace($this->_mapping_key, '', $IdData);
        $configurations = [];

        if ($id) {
            $configurations = ApiConfiguration::find($id);
        }

        return view('Admin::api/create_apiconfigurations')->with(['configurations' => $configurations]);
    }

    public function viewApiConfigurations($id) {
        $this->setData($this->_url_key, 'view');
//        $requestParams = $request->all();
//
//        $requestParams = $request->all();
//
//        $id = isset($requestParams['id']) ? $requestParams['id'] : 0;
        $IdData = \App\Http\Middleware\EncryptUrlParams::decrypt($id);
        $id = str_replace($this->_mapping_key, '', $IdData);
        $configurations = [];

        if ($id) {
            $configurations = ApiConfiguration::find($id);
        }

        return view('Admin::api/view_apiconfigurations')->with(['configurations' => $configurations, 'mapping_key' => $this->_mapping_key]);
    }

    public function deleteApiConfigurations($id) {
        $this->setData($this->_url_key, 'delete');
//        $requestParams = $request->all();
//        $id = isset($requestParams['id']) ? $requestParams['id'] : 0;
        $IdData = \App\Http\Middleware\EncryptUrlParams::decrypt($id);
        $id = str_replace($this->_mapping_key, '', $IdData);
        if ($id) {
            $configurations = ApiConfiguration::find($id);
            $configurations->is_delete = 1;
            $configurations->save();
            return Redirect::to('admin/settings/apiconfigurations');
        }
    }

}
