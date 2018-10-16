<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Menu;
use GlobalAuth;

class MenuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $menu)
    {
        $menu = Menu::where('route', $menu)->first();

        if (GlobalAuth::user()->can('view', $menu))
            return $next($request);

        return response()->view('errors.tidak_diizinkan', [], 403);
    }
}
