<?php

namespace App\Http\Middleware;

use Closure;

class IsPublicProject
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
        if ($request->project->private) {
            abort(404);
        }

        return $next($request);
    }
}
