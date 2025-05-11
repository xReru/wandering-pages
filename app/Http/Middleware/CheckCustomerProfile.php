<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCustomerProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $customer = auth()->guard('customer')->user();

        if (!$customer) {
            return redirect()->route('login');
        }

        // Check if any required field is missing
        if (
            empty($customer->first_name) ||
            empty($customer->last_name) ||
            empty($customer->phone_number) ||
            empty($customer->address)
        ) {
            // If already on the stepper form, allow the request to continue
            if ($request->is('customer/profile/setup')) {
                return $next($request);
            }
            
            // Redirect to stepper form if any required field is missing
            return redirect()->route('customer.profile.setup');
        }

        // If all required fields are present and trying to access stepper form,
        // redirect to dashboard
        if ($request->is('customer/profile/setup')) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
