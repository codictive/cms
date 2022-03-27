<?php

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
 * @param mixed      $data
 */
function sendTemplateSMS($receiver, $data, $template): bool
{
    if (! $template) {
        SystemLog::error('[Helpers.sendTemplateSMS] Pattern $template is falsy.');

        return false;
    }

    try {
        $client = new SoapClient('http://ippanel.com/class/sms/wsdlservice/server.php?wsdl');
        $client->sendPatternSms(
            kv('keys.sms.send_number'),
            [$receiver],
            kv('keys.sms.username'),
            kv('keys.sms.password'),
            $template,
            $data
        );
    } catch (Exception $e) {
        SystemLog::error("[Helpers.sendTemplateSMS] Can't send SMS: %s (%d)", $e->getMessage(), $e->getCode());

        return false;
    }

    return true;
}
