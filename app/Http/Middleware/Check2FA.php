<?php

namespace App\Http\Middleware;

use App\Models\UserAgent;
use Closure;
use Illuminate\Http\Request;
use Session;

class Check2FA
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->need2fa($request) and !Session::has('user_2fa')) {
//            return redirect()->route('2fa.index');
// TEST
            error_log("check is needed");
        }

        // TEST TODO move this after two factor control
        $userAgent = UserAgent::firstOrCreate([
            'user_id' => auth()->user()->id,
            'ip' => $this->getIPAddress(),
            'agent' => $_SERVER['HTTP_USER_AGENT'],
        ]);

        return $next($request);

    }

    private function need2fa(Request $request)
    {
        UserAgent::whereDate( 'created_at', '<=', now()->subDays(90))->delete();

        $userAgent = UserAgent::where([
            'user_id' => auth()->user()->id,
            'ip' => $this->getIPAddress(),
            'agent' => $_SERVER['HTTP_USER_AGENT'],
        ])->first();

        if (empty($userAgent)) {
            return true;
        }

        return false;
    }

    private function getIPAddress() {
        // Whether ip is from the share internet
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        // Whether ip is from the proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        // Whether ip is from the remote address
        else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}
