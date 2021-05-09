<?php

    namespace App\Modules\Frontend\Models;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use App\Notifications\DoctorResetPasswordNotification;

    class Doctor extends Authenticatable
    {
        use Notifiable;

        protected $guard = 'doctor';
        protected $table = 'doctors';
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
            $this->notify(new DoctorResetPasswordNotification($token));
        }
    }