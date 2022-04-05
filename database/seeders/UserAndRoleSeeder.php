<?php

namespace Database\Seeders;

use Codictive\Cms\Models\Role;
use Codictive\Cms\Models\User;
use Illuminate\Database\Seeder;

class UserAndRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admin = Role::create(['name' => 'مدیر سیستم', 'slug' => 'admin']);
        Role::create(['name' => 'کاربر عادی', 'slug' => 'registered']);
        Role::create(['name' => 'مهمان', 'slug' => 'guest']);
        Role::create(['name' => 'اپراتور', 'slug' => 'operator']);

        $u = User::create([
            'name'            => 'Matrix',
            'email'           => 'ir.ma3x@gmail.com',
            'mobile'          => '09011836263',
            'password'        => '$2y$10$IVOOy2QZjOBTL/uPKTqf4u83kK9UQYXxwFNvm1Ytu6Vm1Dp5Vp9Sa',
        ]);
        $u->roles()->attach($admin);
        $u->profile()->create(['name' => $u->name, 'is_approved' => true]);
        $u->is_verified = true;
        $u->save();

        $u = User::create([
            'name'            => 'Moriella',
            'email'           => 'best.oflikee@gmail.com',
            'mobile'          => '09920657178',
            'password'        => '$2y$10$IVOOy2QZjOBTL/uPKTqf4u83kK9UQYXxwFNvm1Ytu6Vm1Dp5Vp9Sa',
        ]);
        $u->roles()->attach($admin);
        $u->profile()->create(['name' => $u->name, 'is_approved' => true]);
        $u->is_verified = true;
        $u->save();
    }
}
