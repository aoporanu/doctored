<?php

    namespace App\Modules\Frontend\Models;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use App\Notifications\ResetPasswordNotification;

    class Patient extends Authenticatable
    {
        use Notifiable;

        protected $guard = 'patient';
        //protected $table = 'patients';
        protected $fillable = [
            'email', 'password',
        ];

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
            $this->notify(new ResetPasswordNotification($token));
        }
    }