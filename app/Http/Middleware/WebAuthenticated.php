<?php
namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Session;
use Symfony\Component\HttpFoundation\Response;

class WebAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->status == "active") {
                return $next($request);
            } else {
                Auth::logout();
                Session::flash("deletionProcessMessage", "Your Account Is Currentky Suspended.");
                return response()->view("auth.login");
            }
        } else {
            return response()->view("auth.login");
        }
    }
}
