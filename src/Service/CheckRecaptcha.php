<?php

namespace Greggilbert\Recaptcha\Service;

/**
 * Handle sending out and receiving a response to validate the captcha
 */
class CheckRecaptcha implements RecaptchaInterface
{

    const SERVER = 'http://www.google.com/recaptcha/api';
    const SERVER_SECURE = 'https://www.google.com/recaptcha/api';
    const ENDPOINT = '/recaptcha/api/verify';
    const VERIFY_SERVER = 'www.google.com';

    /**
     * Call out to reCAPTCHA and process the response
     *
     * @param string $challenge
     * @param string $response
     *
     * @return bool
     */
    public function check($challenge, $response)
    {
        $parameters = http_build_query([
            'privatekey' => value(app('config')->get('recaptcha.private_key')),
            'remoteip'   => app('request')->getClientIp(),
            'challenge'  => $challenge,
            'response'   => $response,
        ]);

        $http_request = "POST " . self::ENDPOINT . " HTTP/1.0\r\n";
        $http_request .= "Host: " . self::VERIFY_SERVER . "\r\n";
        $http_request .= "Content-Type: application/x-www-form-urlencoded;\r\n";
        $http_request .= "Content-Length: " . strlen($parameters) . "\r\n";
        $http_request .= "User-Agent: reCAPTCHA/PHP\r\n";
        $http_request .= "\r\n";
        $http_request .= $parameters;

        $apiResponse = '';

        if (false == ( $fs = @fsockopen(self::VERIFY_SERVER, 80) )) {
            throw new \Exception('Could not open socket');
        }

        fwrite($fs, $http_request);

        while ( ! feof($fs)) {
            $apiResponse .= fgets($fs, 1160); // One TCP-IP packet
        }

        fclose($fs);

        $apiResponse = explode("\r\n\r\n", $apiResponse, 2);

        list( $passed, $responseText ) = explode("\n", $apiResponse[1]);

        return ( 'true' === trim($passed) );
    }

    public function getTemplate()
    {
        return 'captcha';
    }

    public function getResponseKey()
    {
        return 'recaptcha_challenge_field';
    }
}
