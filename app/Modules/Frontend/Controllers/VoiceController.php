<?php

namespace App\Modules\Frontend\Controllers;

use Illuminate\Http\Response;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Twilio\Exceptions\RestException;

class VoiceController extends Controller
{
    private Client $_client;
    private $_account_sid;
    private $_auth_token;
    private $_from;

    public function __construct()
    {
        $this->middleware('auth:patient');

        // Twilio credentials
        $this->_account_sid = env('ACCOUNT_SID');
//        $this->_account_sid = 'ACf845507f7a707d3abea134806c1bb143';
        $this->_auth_token = env('AUTH_TOKEN');
//        $this->_auth_token = 'dbccbd5ed0c9951cbb3f0b6b58bf52f1';

        //The twilio number you purchased
        $this->_from = env('TWILIO_PHONE_NUMBER');
//        $this->_from = '+18166702395';

        // Initialize the Programmable Voice API
        try {
            $this->_client = new Client($this->_account_sid, $this->_auth_token);
        } catch (ConfigurationException $e) {
            Log::error($e->getMessage());
        }
    }

    public function initiateCall(Request $request)
    {
        $this->_account_sid = 'AC2151d44ff5385f9be64e31f59e5f02ec';
//        $this->_account_sid = 'ACf845507f7a707d3abea134806c1bb143';
        $this->_auth_token = '3e4a51bb1c11489e002628ff9888704a';
//        $this->_auth_token = 'dbccbd5ed0c9951cbb3f0b6b58bf52f1';

        //The twilio number you purchased
        $this->_from = '+12063095596';
//        $this->_from = '+18166702395';

        // Initialize the Programmable Voice API
        try {
            $this->_client = new Client($this->_account_sid, $this->_auth_token);
        } catch (ConfigurationException $e) {
            Log::error($e->getMessage());
        }
        if (!empty($request->all()) && $request->number_to_call !== null) {
            $phone_number = $request->number_to_call;
        }
        $this->_from = auth()->user()->phone;
        // If phone number is valid and exists

        if ($phone_number) {
            // Initiate call and record call
            try {
                $call = $this->_client->account->calls->create(
                    $phone_number,
                    $this->_from, // Valid Twilio phone number
                    array(
                        "record" => true,
                        "url" => "https://demo.twilio.com/docs/voice.xml"));
                if ($call) {
                    echo 'Call initiated successfully';
                } else {
                    echo 'Call failed!';
                }
            } catch (RestException $ex) {
                echo 'Something went wrong, a log entry has been generated ';
                echo "\n";
                echo $ex->getMessage();
                Log::error($ex->getMessage());
            }

        }
    }


    /**
     * Process a new call
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function newCall(Request $request): VoiceResponse|Response
    {
        $response = new VoiceResponse();
//        $callerIdNumber = config('services.twilio')['number'];

        $dial = $response->dial(null, ['callerId' => $this->_from]);
        $phoneNumberToDial = $request->number_to_call;
        $phoneNumberToDial = '+40771331910';

        if (isset($phoneNumberToDial)) {
            dump($dial->number($phoneNumberToDial));
            $dial->number($phoneNumberToDial);
        } else {
            $dial->client('support_agent');
        }
        return $response;
    }
}
