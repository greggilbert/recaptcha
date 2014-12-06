<?php

namespace Greggilbert\Recaptcha;

/**
 * Handle sending out and receiving a response to validate the captcha
 */
class CheckRecaptchaV2 implements RecaptchaInterface
{

	/**
	 * Call out to reCAPTCHA and process the response
	 * @param string $challenge
	 * @param string $response
	 * @return bool
	 */
	public function check($challenge, $response)
	{
		$parameters = http_build_query(array(
			'secret'        => app('config')->get('recaptcha::config.private_key'),
			'remoteip'		=> app('request')->getClientIp(),
			'response'      => $response,
		));
        
		$curl = curl_init('https://www.google.com/recaptcha/api/siteverify?' . $parameters);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
		$curlResponse = curl_exec($curl);
        $decodedResponse = json_decode($curlResponse, true);
        
		return $decodedResponse['success'];
	}

    public function getTemplate()
    {
        return 'captchav2';
    }
    
    public function getResponseKey()
    {
        return 'g-recaptcha-response';
    }
}