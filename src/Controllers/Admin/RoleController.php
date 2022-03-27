<?php

namespace Codictive\Cms\Controllers\Admin;

use Codictive\Cms\Models\Role;
use Codictive\Cms\Models\Permission;
use Codictive\Cms\Traits\RequiresUser;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Codictive\Cms\Controllers\Controller;

class RoleController extends Controller
{
    use RequiresUser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.roles.index', ['roles' => Role::get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:roles',
        ]);

        $role = Role::create($request->all());

        return redirect()->route('admin.roles.index')->with('success', "نقش {$role->name} ایجاد شد.");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Role $role
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('admin.roles.edit', ['role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Role $role
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
            'slug' => ['required', Rule::unique('roles')->ignore($role->id)],
        ]);

        $role->update($request->all());

        return redirect()->route('admin.roles.index')->with('info', "نقش {$role->name} ذخیره شد.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Role $role
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('admin.roles.index')->with('warning', "نقش {$role->name} حذف شد.");
    }

    /**
     * Displays role permissions form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPermissions(Role $role)
    {
        $roles       = Role::all();
        $permissions = Permission::orderBy('slug')->get();

        return view('admin.roles.permissions', ['role' => $role, 'roles' => $roles, 'permissions' => $permissions]);
    }

    /**
     * Stores role permissions.
     *
     * @return \Illuminate\Http\Response
     */
    public function storePermissions(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'array',
        ]);

        $role->permissions()->detach();
        if ($request->input('permissions')) {
            foreach ($request->input('permissions') as $p) {
                $role->permissions()->attach($p);
            }
        }

        return redirect()->route('admin.roles.index')->with('info', "مجوزهای نقش {$role->name} ذخیره شد.");
    }
}
