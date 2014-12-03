<?php

namespace Greggilbert\Recaptcha;

/**
 * Handle sending out and receiving a response to validate the captcha
 */
class CheckRecaptcha
{
    const SERVER		= 'http://www.google.com/recaptcha/api';
    const SERVER_SECURE	= 'https://www.google.com/recaptcha/api';
    const ENDPOINT		= '/recaptcha/api/verify';
	const ENDPOINTV2	= '/recaptcha/api/siteverify';
    const VERIFY_SERVER	= 'www.google.com';
	
	/**
	 * Call out to reCAPTCHA and process the response
	 * @param string $challenge
	 * @param string $response
	 * @return array(bool, string)
	 */
	public function check($challenge, $response)
	{
		$parameters = http_build_query(array(
			'privatekey'	=> app('config')->get('recaptcha::private_key'),
			'remoteip'		=> app('request')->getClientIp(),
			'challenge'		=> $challenge,
			'response' => $response,
		));
		
		var_dump($parameters);
		
		$curl = curl_init("https://www.google.com/recaptcha/api/siteverify?" . http_build_query($parameters));
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 1);
		
		$response = curl_exec($curl);

		var_dump($response);

		return explode("\n", $apiResponse[1]);
	}

}
