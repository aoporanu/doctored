<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Http\Request;
use Redirect;
use View;
use Exception;
use Session;
use App\Modules\Admin\Controllers\AdminIndexController as AdminController;
use DB;
use App\Modules\Frontend\Models\Slots;
class SlotController extends AdminController {

    private $_url_key = '/admin/slots';

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
        try{
            $configurations = DB::table('slot_configurations as sc')
            ->leftJoin('hospitals as h','h.hospital_id','=','sc.hospital_id')
            ->leftJoin('doctors as d','d.id','=','sc.doctor_id')
            //->where('doctor_id',$did)
            ->select('sc.doctor_id',DB::raw("CONCAT(d.firstname,' ',d.lastname) as doctor_name"),'sc.hospital_id','h.hospital_name','screen_id')->distinct('screen_id')->get()->toArray();

            return view('Admin::slot/slots')->with(compact('configurations'));
        }catch(ErrorException $ex){

        }
    }
    public function slotsdetails(Request $request){
        try{
            //$doctorInfo = json_decode(json_encode(Auth::guard('doctor')->user()),1);
            //$did = $doctorInfo['id'];
            $data = $request->all();
            $screen_id = $data['s'];
            $doctorInfo=[];
            $hospital = base64_decode($data['h']);
            $slots = Slots::select('id','booking_date','booking_start_time','booking_time_long','available_types','is_active')->where('screen_id',$screen_id)
            //->where('doctor_id',$did)
            ->orderBy('booking_date','asc')->get()->toArray();
            $slots_length = Slots::selectRaw('Max(booking_date) as enddate')->selectRaw('MIN(booking_date) as startdate')->where('screen_id',$screen_id)->groupBy('screen_id')->get()->toArray();

             $restructure = array();
              foreach($slots as $sl_key=>$sl_val){
                   $restructure[$sl_val['booking_date']][] = $sl_val;
              }
              return view('Admin::slot/slotdetails')
            ->with(compact('doctorInfo','screen_id','restructure','slots_length','hospital'));

        }catch(ErrorException $ex){

        }
    }

}
