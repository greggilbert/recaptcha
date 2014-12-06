<?php

namespace Greggilbert\Recaptcha;

/**
 * Handle sending out and receiving a response to validate the captcha
 */
class CheckRecaptchaV2
{

	/**
	 * Call out to reCAPTCHA and process the response
	 * @param string $challenge
	 * @param string $response
	 * @return array(bool, string)
	 */
	public function check($challenge, $response)
	{
		$parameters = http_build_query(array(
			'secret'	=> app('config')->get('recaptcha::config.private_key'),
			'remoteip'		=> app('request')->getClientIp(),
			'challenge'		=> $challenge,
			'response' => $response,
		));

		if (!app('config')->get('recaptcha::config.no_curl', false)) {
            $curl = curl_init("https://www.google.com/recaptcha/api/siteverify?" . $parameters); // . http_build_query($parameters));
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            $googleresponse = curl_exec($curl);
        } else {
            $googleresponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?'.$parameters);
        }
		
        $responseArr = json_decode($googleresponse,true);
		return $responseArr['success'];
	}

}