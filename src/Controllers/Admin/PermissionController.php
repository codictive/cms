<?php

namespace Codictive\Cms\Controllers\Admin;

use Codictive\Cms\Models\Role;
use Codictive\Cms\Models\Permission;
use Codictive\Cms\Traits\RequiresUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Codictive\Cms\Controllers\Controller;

class PermissionController extends Controller
{
    use RequiresUser;

    /**
     * Displays roles permissions edit form.
     *
     * @return view
     */
    public function index()
    {
        $roles       = Role::with('permissions')->get();
        $permissions = Permission::orderBy('slug')->get();

        return view('admin.permissions', ['roles' => $roles, 'permissions' => $permissions]);
    }

    /**
     * Stores roles permisisons.
     *
     * @return redirectt
     */
    public function store(Request $request)
    {
        $rolePermissions = [];
        $values          = $request->all();
        foreach ($values as $key => $val) {
            if ('_token' == $key) {
                continue;
            }
            $pairs             = explode(',', $key);
            if (count($pairs) != 2) {
                continue;
            }

            $rolePermissions[] = ['permission_id' => $pairs[0], 'role_id' => $pairs[1]];
        }

        DB::table('role_permissions')->truncate();
        DB::table('role_permissions')->insert($rolePermissions);

        return redirect()->route('admin.permissions.index')->with('success', 'مجوزهای دسترسی ذخیره شد.');
    }
}
