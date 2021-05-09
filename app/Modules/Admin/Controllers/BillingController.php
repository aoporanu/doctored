<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Redirect;
use View;
use Log;
use Exception;
use Session;
use App\Modules\Admin\Controllers\AdminIndexController as AdminController;

class BillingController extends AdminController {

    private $_url_key = '/admin/billing';

    public function __construct() {
        $this->getAccessDetails($this->_url_key);
    }

    public function init()
    {
        if(!Session::has('user_id'))
        {
            Redirect::to('admin/login');
            return false;
        }
        if(!$this->limitedAccess && Session::has('limited_access'))
        {
            $this->limitedAccess = Session::get('limited_access');
        }else{
            $this->getLimitedAccessData($this->_url_key);
        }
        if(!$this->groupId)
        {
            $this->groupId = Session::get('group_id');
        }
        if(!$this->userId)
        {
            $this->userId = Session::get('user_id');
        }
        return true;
    }

    public function index()
    {
        return view('Admin::billing/billing');
    }

}
