<?php

namespace App\Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Redirect;
use View;
use Session;
use Illuminate\Support\Facades\DB;
use App\Modules\Frontend\Models\Cities as Cities;
use App\Modules\Frontend\Models\States as States;
use App\Modules\Frontend\Models\Countries as Countries;

class CommonController extends Controller
{
    public function getCountries()
    {
        $countries = Countries::select('id', 'sortname', 'name', 'phonecode')->get();
        return JsonResponse::create($countries);
    }

    public function getStates($sortname = null)
    {

        $country = Countries::select('id')->where('sortname', $sortname)->first(0)->toarray();

        $id = ($country['id']);

        if ($id != '') {
            //
            if (is_numeric($id)) {
                $states = States::select('id', 'name', 'country_id')->where('country_id', $id)->get();
            } else {
                echo "Invalid";
                exit;
            }
        } else {
            $states = States::select('id', 'name', 'country_id')->get();
        }
        return JsonResponse::create($states, 200);
    }

    /**
     * @param int|null $id
     * @return JsonResponse
     */
    public function getCities(int $id = null)
    {

        if ($id != '') {
            if (is_numeric($id)) {
                $cities = Cities::select('id', 'name', 'state_id')->where('state_id', $id)->get();
            } else {
                echo "Invalid";
                exit;
            }
        } else {
            $cities = Cities::select('id', 'name', 'state_id')->get();
        }

        return JsonResponse::create($cities);
    }

    public function testc()
    {
        return view('Frontend::testc');
    }

    public function getTimezones()
    {
        $zones = DB::table('timezones')
            ->select('id', 'countrycode', DB::raw("concat('(UTC',replace(UTC_offset,':00',''),') ',TimeZone)  as utc"))
            ->where('countrycode', '!=', '')->get()->toJson();
        echo $zones;
    }
}
