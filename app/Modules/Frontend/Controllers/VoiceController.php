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
        $this->_auth_token = env('AUTH_TOKEN');

        //The twilio number you purchased
        $this->_from = env('TWILIO_PHONE_NUMBER');

        // Initialize the Programmable Voice API
        try {
            $this->_client = new Client($this->_account_sid, $this->_auth_token);
        } catch (ConfigurationException $e) {
            Log::error($e->getMessage());
        }
    }

    public function initiateCall(Request $request)
    {
        $this->_account_sid = env('ACCOUNT_SID');
        $this->_auth_token = env('AUTH_TOKEN');

        //The twilio number you purchased
        $this->_from = '+12063095596';

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

        $dial = $response->dial(null, ['callerId' => $this->_from]);
        $phoneNumberToDial = $request->number_to_call;
        $phoneNumberToDial = '+40771331910';

        if (isset($phoneNumberToDial)) {
            $dial->number($phoneNumberToDial);
        } else {
            $dial->client('support_agent');
        }
        return $response;
    }
}
