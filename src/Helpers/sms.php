<?php

use Kavenegar\KavenegarApi;
use Codictive\Cms\Models\SystemLog;

/**
 * Send's given message to given receiver via KaveNegar SMS API.
 *
 * @param string $receiver
 * @param string $message
 */
function sendSMS($receiver, $message): bool
{
    try {
        $client = new SoapClient('http://ippanel.com/class/sms/wsdlservice/server.php?wsdl');
        $client->SendSMS(
            kv('keys.sms.send_number'),
            [$receiver],
            $message,
            kv('keys.sms.username'),
            kv('keys.sms.password'),
            '',
            'send'
        );
    } catch (Exception $e) {
        SystemLog::error("[Helpers.sendSMS] Can't send SMS: %s (%d)", $e->getMessage(), $e->getCode());

        return false;
    }

    return true;
}

/**
 * Sends verification code to given receiver.
 *
 * @param string     $receiver
 * @param string     $code
 * @param mixed      $template
 * @param mixed|null $token1
 * @param mixed|null $token2
 *
 * @return bool
 */
function sendTemplateSMS($receiver, $code, $template, $token1 = null, $token2 = null)
{
    try {
        (new KavenegarApi(kv('keys.sms.kavenegar')))->VerifyLookup($receiver, $code, null, null, $template, $token1, $token2);
    } catch (Exception $e) {
        SystemLog::error("[helpers.sendTemplateSMS] Can't send template %s SMS: %s (%d)", $template, $e->getMessage(), $e->getCode());

        return false;
    }

    return true;
}
