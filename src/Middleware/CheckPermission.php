<?php

namespace Codictive\Cms\Middleware;

use Closure;
use Codictive\Cms\Models\Permission;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $bypass = (bool) env('BY_PASS_CHECK_PERMISSION', false);
        if ($bypass) {
            return $next($request); //! WARNING: BYPASS PERMISSION CHECK!
        }

        $permission = Permission::where('slug', $request->route()->getName())->first();
        if (null == $permission) {
            abort(404);
        }

        $user = currentUser();
        if (null == $user) {
            // get guest.
            $guest = guestRole();
            if (null == $guest) {
                abort(403);
            }

            if ($guest->hasPermission($permission)) {
                return $next($request);
            }

            abort(403);
        }

        // User with id 1 is superuser.
        if (1 == $user->id || $user->hasPermission($permission)) {
            return $next($request);
        }

        abort(403);
    }
}
