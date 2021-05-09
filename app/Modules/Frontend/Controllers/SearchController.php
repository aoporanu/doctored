<?php
namespace App\Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use View;
use Session;
use Illuminate\Support\Facades\DB;
use App\Modules\Frontend\Models\Contacts as Contact;
use App\Modules\Admin\Models\Patients as Patient;
use App\Modules\Admin\Models\Hospitals;
use App\Modules\Admin\Models\Groups;
use App\Modules\Admin\Models\GroupHospitalMapping;
use App\Modules\Frontend\Models\Doctor;
use App\Modules\Frontend\Models\Slots as Slots;
use App\Modules\Admin\Models\Pages as Pages;
use App\Modules\Admin\Models\PageElements as PageElements;
use App\Modules\Admin\Models\LanguageMapping as LanguageMapping;
use App\Modules\Admin\Models\Languages as Languages;
use App\Modules\Admin\Models\SpecializationMapping as SpecializationMapping;
use App\Modules\Admin\Models\Specialization as Specialization;

use Log;

//use App\Frontend\Contact;
use Mail;

/*
 use App\Page;
use App\Page_elements;

*/

class SearchController extends Controller
{

    public function index(Request $request)
    {
        try
        {
		              $search_type = $request->input('t');
            if ($search_type == '')
            {
                return redirect('/');
            }

            if (($request->input('v') == ''))
            {
                $search_val = '';

            }
            else
            {
                $search_val = $request->input('v');
            }
            //Group related List search
            if ($search_type == 'g')
            {
                $results = array();
                if ($search_val == '')
                {
                    //Code to load all groups
                    $results = Groups::where('is_active', 1)->where('is_delete', '!=', 1)
                        ->orderBy('gid', 'ASC')
                        ->get()
                        ->toArray();

                }
                else
                {
                    $search_val_caps = ucfirst($search_val);
                    $search_val_lower = strtolower($search_val);

                    $results = Groups::where('group_name', 'like', '%' . $search_val_caps . '%')->orWhere('group_name', 'like', '%' . $search_val_lower . '%')->where('is_active', 1)
                        ->where('is_delete', '!=', 1)
                        ->orderBy('gid', 'ASC')
                        ->get()
                        ->toArray();

                }
                //  print_r($results);exit;
                return view('Frontend::search/group_list')
                    ->with('results', $results);
            }
            //End of Group related List search
            //Hospital relared List Search
            if ($search_type == 'h')
            {
                $results = array();
                if ($search_val == '')
                {
                    //Code to load all Hospital
                    $results = Hospitals::where('is_active', 1)->where('is_delete', '!=', 1)
                        ->orderBy('hospital_id', 'ASC')
                        ->get()
                        ->toArray();

                }
                else
                {
                    $search_val_caps = ucfirst($search_val);
                    $search_val_lower = strtolower($search_val);

                    $results = Hospitals::where('hospital_name', 'like', '%' . $search_val_caps . '%')->orWhere('hospital_name', 'like', '%' . $search_val_lower . '%')->where('is_active', 1)
                        ->where('is_delete', '!=', 1)
                        ->orderBy('hospital_id', 'ASC')
                        ->get()
                        ->toArray();

                }
                //  print_r($results);exit;
                return view('Frontend::search/hospital_list')
                    ->with('results', $results);
            }
			//End Hospital relared List Search
			
			//Doctor relared List Search
            if ($search_type == 'd')
            {
				
				//$LanguageMapping = LanguageMapping::all();
				//$Languages = Languages::all()->toArray();
				
				
        
                $results = array();
                if ($search_val == '')
                {
                    //Code to load all Doctors
                    $results = Doctor::where('is_active', 1)->where('is_delete', '!=', 1)
						->where('is_verified', 1)
						->select('doctors.*')
                        ->orderBy('id', 'ASC')
                        ->get()
                        ->toArray();
			
                }
                else
                {
                    $s = explode(' ',$search_val);
					if(count($s)>2){
					$search_name_first = $s[count($s)-2];
                    $search_name_last = $s[count($s)-1];
					}
					else if(count($s)==2){
						$search_name_first = $s[0];
                    $search_name_last = $s[1];
					}else{
						$search_name_first = $s[0];$search_name_last = $s[0];
					}
					//echo $search_name_first."--".$search_name_last;
					$firstname_caps = ucfirst($search_name_first);
					$firstname_lower = strtolower($search_name_first);
			if($search_name_last=='' ){ $search_name_last = $search_name_first;} 
					$lastname_caps = ucfirst($search_name_last);
					
					$lastname_lower = strtolower($search_name_last);
					 
				
                    $results = Doctor::where('firstname', 'like', '%' . $firstname_caps . '%')
						->orWhere('firstname', 'like', '%' . $firstname_lower . '%')
						->orWhere('lastname', 'like', '%' . $lastname_caps . '%')
						->orWhere('lastname', 'like', '%' . $lastname_lower . '%')
						->where('is_active', 1)
                        ->where('is_delete', '!=', 1)
                        ->where('is_verified', 1)
                        ->orderBy('id', 'ASC')
                        ->get()
                        ->toArray();

                }
                  //print_r($results);exit;
                return view('Frontend::search/doctors_list')
                    ->with(compact('results'));
            } 


            
        }
        catch(ErrorException $ex)
        {
            Log::error($ex->getMessage() . ' ' . $ex->getTraceAsString());
        }

    }
}


		 
		
		 
  