<?php

namespace Database\Seeders;

use Codictive\Cms\Models\Role;
use Illuminate\Database\Seeder;
use Codictive\Cms\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach (config('permissions') as $k => $p) {
            $perm = Permission::create(['slug' => $k, 'description' => $p['description']]);

            if ($p['guest']) {
                Role::guest()->permissions()->attach($perm->id);
            }
        }

        Role::bySlug('admin')->permissions()->attach(Permission::all());
    }
}
