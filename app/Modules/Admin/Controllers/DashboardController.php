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
use Session;
use App\Modules\Admin\Controllers\AdminIndexController as AdminController;
use Illuminate\Support\ViewErrorBag;
/**
 * Description of MenusController
 *
 * @author sandeep.jeedula
 */
class DashboardController extends AdminController {

    private $_url_key = '/admin/dashboard';
    //put your code here

    public function __construct() {
//        parent::__construct();
//        $this->getLimitedAccessData($this->_url_key);
    }
    
    public function index() {
        if($this->init() === false)
        {
            return Redirect::to('admin/login');
        }
        $errors = Session::get('errors');
        if($errors && $errors->first()){
            return view('Admin::dashboard')->with('error', $errors->first());
        }
        return view('Admin::dashboard');
    }
}
