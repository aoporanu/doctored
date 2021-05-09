<?php

namespace App\Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;

class GenerateAccessTokenController extends Controller
{
    public function generate_token()
    {
        $accountSid = 'ACf845507f7a707d3abea134806c1bb143';
        $apiKeyID = 'SKe1b6923331fa13e9df3a96fc488cd3cb';
        $apiSecretID = 'PVfVN4pdg1IuPH3YhfMZd480wlrCkXWw';

        $identity = \request()->identity;
        $roomName = \request()->room_name;

        $token = new AccessToken(
            $accountSid,
            $apiKeyID,
            $apiSecretID,
            3000,
            $identity,
            $roomName
        );

        $grant = new VideoGrant();
        $token->addGrant($grant);

        $result = [
            'identity' => $identity,
            'token' => $token->toJWT()
        ];

        return response()->json($result);
    }
}
