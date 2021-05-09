<?php

namespace App\Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\DoctorSaveRequest;
use App\Http\Requests\PatientSaveRequest;
use App\Modules\Admin\Models\Doctors as Doctor;
use App\Modules\Admin\Models\Patients as Patient;
use App\Modules\Admin\Models\ProcessLogs as ProcessLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mail;
use Redirect;
use Session;
use View;

class RegisterController extends Controller
{
    public function home()
    {
        return view('Frontend::home');
    }

    public function register(PatientSaveRequest $request)
    {
        die('xxx');
        $phoneCodes = DB::select('select * from countries');
        if ($request->isMethod('post')) {
            session()->put('tab_name', 'mem_link');

            $input = $request->all();
            $max = DB::table('patients')->max('id');
            if ($max == '') {
                $max = 1;
            } else {
                $max++;
            }
            $patient_code = 'PMEFR' . date('y') . (1000 + $max);
            $patientData = new Patient();
            $patientData->patientcode = $patient_code;
            $patientData->firstname = $request->firstname;
            $patientData->lastname = $request->lastname;
            $patientData->phone = $request->phone;
            $patientData->email = $request->email;
            $patientData->password = Hash::make($request->password);
            $patientData->visitor = $this->getUserIpAddr();
            DB::enableQueryLog();

            if ($patientData->save()) {
                $process_log['patient_data'] = $patientData;

//                \Mail::send(
//                    'Frontend::activation_email',
//                    array(
//                        'firstname' => $request->firstname,
//                        'email' => $request->email,
//                        'password' => $request->password,
//                        'patient_code' => $patient_code
//                    ),
//                    function ($message) use ($request) {
//                        $message->subject('Registration Successful.');
//                        $message->from(getenv('MAIL_FROM_ADDRESS'));
//                        $message->to($request->email);
//                    }
//                );

                \Mail::send(
                    'Frontend::activation_admin_email',
                    array(
                        'firstname' => $request->firstname,
                        'lastname' => $request->lastname,
                        'email' => $request->email,
                        'patient_code' => $patient_code
                    ),
                    function ($message) use ($request) {
                        $message->subject('Member registered');
                        $message->from(getenv('MAIL_FROM_ADDRESS'));
                        $message->to(getenv('MAIL_FROM_ADDRESS')); //admin email
                    }
                );
                // dd(DB::getQueryLog());
                session()->forget('tag_name');
                $failed_array['user_data'] = $patientData;
                $this->logProcess(
                    0,
                    'register_patient',
                    'Notify',
                    json_encode($failed_array)
                );
                return back()->with(
                    'success',
                    'Thank you for registering with us!');
            } else {

                $failed_array['user_data'] = $patientData;
                $this->logProcess(
                    0,
                    'register_patient',
                    'Notify',
                    json_encode($failed_array)
                );
                return back()->with(
                    'error',
                    'Something went wrong!');

            }
        }

        return view('Frontend::register', compact('phoneCodes'));
    }

    public function register_doctor(DoctorSaveRequest $request)
    {
        if ($request->isMethod('post')) {
            session()->put('tab_name', 'doc_link');

            $max = DB::table('doctors')->max('id');
            if ($max == '') {
                $max = 1;
            } else {
                $max++;
            }
            $doctor_code = 'DMEFR' . date('y') . (1000 + $max);
            $doctorData = new Doctor();
            $doctorData->doctorcode = $doctor_code;
            $doctorData->firstname = $request->firstname;
            $doctorData->lastname = $request->lastname;
            $doctorData->phone = $request->phone;
            $doctorData->email = $request->email;
            $doctorData->licence = $request->licence;
            $doctorData->opt_clinic = $request->is_clinic;
            $doctorData->password = Hash::make($request->password);
            $doctorData->visitor = $this->getUserIpAddr();
            //Recommended : Add failed log for else case  as a array add all steps error to it
            $failed_array = array();
            $process_log = array();
            if ($doctorData->save()) {
                $process_log['doctor_data'] = $doctorData; //log

                //logic to send communication to Admin
                \Mail::send(
                    'Frontend::admin_doctor_verification',
                    array(
                        'doctorData' => $doctorData
                    ),
                    function ($message) use ($request) {
                        $message->subject('Doctor Verification Required');
                        $message->from(getenv('MAIL_FROM_ADDRESS'));
                        $message->to(getenv('MAIL_FROM_ADDRESS'));
                    }
                );

                //logic to send communication to Admin
                \Mail::send(
                    'Frontend::doctor_notification_one',
                    array(
                        'doctorName' =>
                            $doctorData->title . " " . $doctorData->firstname
                    ),
                    function ($message) use ($request) {
                        $message->subject('Account Created');
                        $message->from(getenv('MAIL_FROM_ADDRESS'));
                        $message->to($request->email);
                    }
                );
            } else {
                $failed_array['user_data'] = $doctorData;
            }

            /*---------------------------------------------*/
            //store logs --method name,fail/notify,data,date
            if (count($failed_array) > 0) {
                $this->logProcess(
                    0,
                    'register_doctor',
                    'Error',
                    json_encode($failed_array)
                ); //LogProcess($userid,$method,$type,$data)
            }

            if (count($process_log) > 0) {
                $this->logProcess(
                    0,
                    'register_doctor',
                    'Notify',
                    json_encode($process_log)
                ); //LogProcess($userid,$method,$type,$data)
            }
            /*---------------------------------------------*/

            //Mails
            $msg = 'Thank you for registering with us!';
            session()->forget('tag_name');
            return back()->with('success', $msg);
        }
    }

    public function getUserIpAddr()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }

    public function logProcess($userid, $method, $type, $data)
    {
        $ProcessLogData = new ProcessLog();
        $ProcessLogData->user_id = $userid;
        $ProcessLogData->method = $method;

        $ProcessLogData->log_type = $type;
        $ProcessLogData->log = $data;
        $ProcessLogData->save();
    }
}

?>
