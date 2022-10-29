<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Traits\CryptTrait;
use App\Models\Student;
use Exception;
use Twilio\Rest\Client;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable, CryptTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'access' => 'array',
    ];

    public function getAccessAttribute($value)
    {
        if (empty($value)) {
            return array();
        }

        return json_decode($value);
    }

    public function setAccessdAttribute($value)
    {
        $this->attributes['access'] = json_encode($value);
    }

    public function getFirstnameAttribute($value)
    {
        if ($this->admin) {
            return $this->decrypt($value, false);
        } else {
            return Student::where('user_id', $this->id)->first()->firstname ?? null;
        }
    }

    public function getDisplayNameAttribute($value)
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getLastnameAttribute($value)
    {
        if ($this->admin) {
            return $this->decrypt($value, false);
        } else {
            return Student::where('user_id', $this->id)->first()->lastname ?? null;
        }
    }

    public function setFirstnameAttribute($value)
    {
        $this->attributes['firstname'] = $this->encrypt($value, false);
    }

    public function setLastnameAttribute($value)
    {
        $this->attributes['lastname'] = $this->encrypt($value, false);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function generateCode()
    {
        $code = rand(100000, 999999);

        UserCode::updateOrCreate(
            [ 'user_id' => auth()->user()->id ],
            [ 'code' => $code ]
        );

        $receiverNumber = auth()->user()->phone;
        $message = "Your VWPP verification code is ". $code;

        try {

            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");

            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number,
                'body' => $message]);

        } catch (Exception $e) {
            info("Error: ". $e->getMessage());
        }
    }
}
