<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\UserResetPasswordNotification;

class Users extends Authenticatable {
	use Notifiable;
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    protected $fillable = ['user_id', 'user_name', 'email'];
	  protected $hidden = [
            'password', 'remember_token',
        ];
	/**
         * Send the password reset notification.
         *
         * @param  string  $token
         * @return void
         */
        public function sendPasswordResetNotification($token)
        {
			
            $this->notify(new UserResetPasswordNotification($token));
        }

}
