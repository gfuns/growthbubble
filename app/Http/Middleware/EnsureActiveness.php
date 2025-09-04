<?php
namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureActiveness
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()) {
            if (Auth::user()->status == "active") {
                return $next($request);
            } else {
                Auth::logout();
                return redirect("/login")->with(["suspended" => "Your account may be inactive or suspended. Please contact us if something is wrong."]);
            }

        } else {
            return route('login');
        }

    }
}
