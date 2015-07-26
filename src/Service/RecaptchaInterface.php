<?php

namespace Greggilbert\Recaptcha\Service;

interface RecaptchaInterface
{

    /**
     * Call out to reCAPTCHA and process the response
     *
     * @param string $challenge
     * @param string $response
     *
     * @return bool
     */
    public function check($challenge, $response);

    /**
     * Return template to render for reCAPTCHA
     * Note that this will be prepended with recaptcha::
     * @return string
     */
    public function getTemplate();

    /**
     * Return response key as specified in view.
     * @return string
     */
    public function getResponseKey();
}
