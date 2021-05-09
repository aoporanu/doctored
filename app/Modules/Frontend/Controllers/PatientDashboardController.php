<?php

namespace App\Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Auth;

class PatientDashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:patient');
        parent::__construct();
    }

    public function patientDashboard()
    {
        $info = json_decode(json_encode(Auth::guard('patient')->user()), 1);
        $doctors = DB::select('select * from doctors');
        return view('Frontend::patient/patient_dashboard', compact('info', 'doctors'));
    }
}
