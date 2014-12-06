<?php

namespace Greggilbert\Recaptcha;

interface RecaptchaInterface
{
    /**
	 * Call out to reCAPTCHA and process the response
	 * @param string $challenge
	 * @param string $response
	 * @return array(bool, string)
	 */
	public function check($challenge, $response);
}
