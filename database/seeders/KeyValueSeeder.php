<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KeyValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        kv('app.name', 'Codictive CMS');
        kv('app.slogan', 'A Laravel Based Content Management System');
        kv('site.base_url', 'https://codictive.net');

        kv('auth.guest_role', 'guest');
        kv('auth.default_role', 'registered');
        kv('auth.session_expire_days', 90);
        kv('auth.verify_email_token_expire_days', 5);
        kv('auth.reset_password_token_expire_hours', 18);

        kv('keys.recaptcha.site_key', '6LeIoUkeAAAAABTwpv_N6R-h1g9CJnxHUCRNVrtj');
        kv('keys.recaptcha.secret_key', '6LeIoUkeAAAAABO4IwuCc3AEypeDChVL3Xmf0KCT');
    }
}
