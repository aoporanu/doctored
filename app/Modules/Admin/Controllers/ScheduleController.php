<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Redirect;
use View;
use Exception;
use Session;
use App\Modules\Admin\Controllers\AdminIndexController as AdminController;

class ScheduleController extends AdminController {

    private $_url_key = '/admin/schedule';

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
        return view('Admin::schedule/schedules');
    }

}
