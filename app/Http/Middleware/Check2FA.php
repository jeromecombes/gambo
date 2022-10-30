<?php

namespace App\Http\Middleware;

use App\Helpers\IPAddressHelper;
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
            return redirect()->route('2fa.index');
        }

        return $next($request);
    }

    private function need2fa(Request $request)
    {
        $userAgent = UserAgent::where([
            'user_id' => auth()->user()->id,
            'ip' => IPAddressHelper::get(),
            'agent' => $_SERVER['HTTP_USER_AGENT'],
        ])
        ->where('created_at', '>', now()->subDays(90))
        ->first();

        if (empty($userAgent)) {
            return true;
        }

        return false;
    }
}
