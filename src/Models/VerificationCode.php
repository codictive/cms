<?php

namespace Codictive\Cms\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    public const CONTEXT_LOGIN  = 'login',
    CONTEXT_PASSEWORD_RESET     = 'password_reset',
    CONEXT_CHANGE_MOBILE        = 'change_mobile';

    protected $fillable = ['context', 'recipient', 'code'];

    /**
     * Generates code, stores it and sends SMS to given mobile number.
     *
     * @param string $mobile
     * @param string $context
     */
    public static function saveAndSend($mobile, $context): bool
    {
        $code = random_int(10000, 99999);
        VerificationCode::create([
            'context'   => $context,
            'recipient' => $mobile,
            'code'      => $code,
        ]);

        return sendTemplateSMS($mobile, $code, kv('auth.verification_sms_template'));
    }

    /**
     * Checks whether if given code matches mobile and context.
     *
     * @param string $mobile
     * @param string $code
     * @param string $context
     */
    public static function check($mobile, $code, $context): bool
    {
        return VerificationCode::where('recipient', $mobile)
            ->where('code', $code)
            ->where('context', $context)
            ->where('created_at', '>=', Carbon::now()->subSeconds((int) kv('auth.verification_sms.expires_at')))
            ->count() != 0;
    }
}
