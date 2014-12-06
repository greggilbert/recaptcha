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
    
    /**
     * Return template to render for reCAPTCHA
     * Note that this will be prepended with recaptcha::
     */
    public function getTemplate();
}
