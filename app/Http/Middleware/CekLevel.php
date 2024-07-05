<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param mixed $level  [1. admin | 2. kasir]
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$level)
    {
        $modSelect = $level[0] ?? '';
        $role_id = auth()->user()->role_id;
        $modLists = \App\Models\Role::find($role_id);
        if($modLists){
            $modulelists = json_decode($modLists->modulelists,true);
            if (in_array($modSelect, $modulelists)) {
                return $next($request);
            }
        }

        return redirect()->route('dashboard');
    }
}
