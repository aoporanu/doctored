<?php

namespace App\Http\Middleware;

use Closure;

class EncryptUrlParams {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        return $next($request);
    }

    public static function encrypt($params) {
        if ($params) {
            $iv = substr(hash('sha256', env('SALT')), 0, 16);
            $encryptedValue = openssl_encrypt($params, 'AES-256-CBC', hash('sha256', env('SALT')), 0, $iv);
            return str_replace('/', '+++++', $encryptedValue);
        }
        return $params;
    }

    public static function decrypt($params) {
        if ($params) {
            $iv = substr(hash('sha256', env('SALT')), 0, 16);
            return openssl_decrypt(str_replace('+++++', '/', $params), 'AES-256-CBC', hash('sha256', env('SALT')), 0, $iv);
        }
        return $params;
    }

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
