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

        kv('keys.recaptcha.site_key', '6LcFWRkfAAAAAPEYN5ZuCW6O0NoucBf1Zv6WDCGd');
        kv('keys.recaptcha.secret_key', '6LcFWRkfAAAAADIK9OF8bp9l_6j1TOtdMd0HARMK');

        kv('auth.verification_sms.expires_at', '300');
        kv('keys.sms.kavenegar', '66433646386645635258757969636B6933467A327A556B71555847335051583061586C743943694E5350493D');
        kv('auth.verification_sms_template', 'RushanaAuth');
        kv('auth.session_expire_days', '365');
    }
}
