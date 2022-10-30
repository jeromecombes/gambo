<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Helpers\IPAddressHelper;
use App\Models\UserAgent;
use App\Models\UserCode;

class TwoFAController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        auth()->user()->generateCode();
        return view('2fa');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'=>'required',
        ]);

        $find = UserCode::where('user_id', auth()->user()->id)
                        ->where('code', $request->code)
                        ->where('updated_at', '>=', now()->subMinutes(2))
                        ->first();

        if (!is_null($find)) {
            Session::put('user_2fa', auth()->user()->id);

            UserAgent::firstOrCreate([
                'user_id' => auth()->user()->id,
                'ip' => IPAddressHelper::get(),
                'agent' => $_SERVER['HTTP_USER_AGENT'],
            ]);

            UserAgent::whereDate( 'created_at', '<=', now()->subDays(90))->delete();

            return redirect()->route('home');
        }

        return back()->with('error', 'You entered wrong code.');
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function resend()
    {
        auth()->user()->generateCode();
        $partialEmail = auth()->user()->partialEmail;
        return back()->with('success', "We sent your code to your email address ($partialEmail).");
    }
}
