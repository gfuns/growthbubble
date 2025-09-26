<?php
namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerOnboarding
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->onboarding_status == "awaiting payment") {
            return redirect()->route("onboarding.payment");
        } else if (Auth::user()->onboarding_status == "pending") {
            return redirect()->route("onboarding.instructions");
        } else {
            return $next($request);
        }
    }
}
