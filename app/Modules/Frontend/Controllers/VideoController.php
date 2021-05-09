<?php


namespace App\Modules\Frontend\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class VideoController extends Controller
{
    private ?Client $_client = null;
    private $_accountSid;
    private $_auth_token;
    private $_from;

    public function __construct()
    {
        $this->middleware('auth:patient');

        // Twilio credentials
        $this->_accountSid = env('ACCOUNT_SID');
        $this->_auth_token = env('AUTH_TOKEN');

        //The twilio number you purchased
        $this->_from = env('TWILIO_PHONE_NUMBER');


        // Initialize the Programmable Voice API
        try {
            $this->setClient(new Client($this->_accountSid, $this->_auth_token));
        } catch (ConfigurationException $e) {
            Log::error($e->getMessage());
        }
        parent::__construct();
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->_client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->_client = $client;
    }

    /**
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function videoCall()
    {
        $this->middleware('auth:patient');

        // Twilio credentials
        $this->_accountSid = 'ACf845507f7a707d3abea134806c1bb143';
        $this->_auth_token = 'dbccbd5ed0c9951cbb3f0b6b58bf52f1';

        //The twilio number you purchased
        $this->_from = env('TWILIO_PHONE_NUMBER');


        // Initialize the Programmable Voice API
        try {
            $this->setClient(new Client($this->_accountSid, $this->_auth_token));
        } catch (ConfigurationException $e) {
            Log::error($e->getMessage());
        }

        $rooms = $this->getClient()->video->rooms;

        return view('Frontend::video/call');

    }

    /**
     * @return mixed
     */
    public function getAccountSid(): mixed
    {
        return $this->_accountSid;
    }

    /**
     * @param mixed $accountSid
     */
    public function setAccountSid(mixed $accountSid): void
    {
        $this->_accountSid = $accountSid;
    }

    /**
     * @return mixed
     */
    public function getAuthToken(): mixed
    {
        return $this->_auth_token;
    }

    /**
     * @param mixed $auth_token
     */
    public function setAuthToken(mixed $auth_token): void
    {
        $this->_auth_token = $auth_token;
    }


}
