<?php
namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Google2fa
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

        if (isset(Auth::user()->auth_2fa)) {
            if (Auth::user()->auth_2fa == "GoogleAuth") {

                if (Session::has("myGoogle2fa")) {
                    return $next($request);
                } else {
                    return response()->view("google2fa.index");
                }

            } else {
                if (Session::has("myValid2fa")) {
                    return $next($request);
                } else {
                    return response()->view("google2fa.twofactor");
                }
            }
        } else {
            return $next($request);
        }

    }
}
