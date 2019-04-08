<?php

namespace App\Http\Middleware;

use Closure;

class RedirectLinkWithSlug
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
        if($request->topic && ! $request->slug){
            return redirect()->to($request->topic->link());
        }
        return $next($request);
    }
}
