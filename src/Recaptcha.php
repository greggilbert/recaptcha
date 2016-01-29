<?php

namespace Greggilbert\Recaptcha;

class Recaptcha
{

    protected $service;

    protected $config = [ ];

    protected $dataParameterKeys = [ 'theme', 'type', 'callback', 'tabindex', 'expired-callback' ];


    public function __construct($service, $config)
    {
        $this->service = $service;
        $this->config  = $config;
    }

    /**
     * Render the recaptcha
     *
     * @param array $options
     *
     * @return view
     */
    public function render($options = [ ])
    {
        $mergedOptions = array_merge($this->config['options'], $options);

        $data = [
            'public_key' => value($this->config['public_key']),
            'options'    => $mergedOptions,
            'dataParams' => $this->extractDataParams($mergedOptions),
        ];

        if (array_key_exists('lang', $mergedOptions) && "" !== trim($mergedOptions['lang'])) {
            $data['lang'] = $mergedOptions['lang'];
        }

        $view = $this->getView($options);

        return app('view')->make($view, $data);
    }

    /**
     * Generate the view path
     *
     * @param array $options
     *
     * @return string
     */
    protected function getView($options = [ ])
    {
        $view = 'recaptcha::' . $this->service->getTemplate();

        $configTemplate = $this->config['template'];

        if (array_key_exists('template', $options)) {
            $view = $options['template'];
        } elseif ("" !== trim($configTemplate)) {
            $view = $configTemplate;
        }

        return $view;
    }

    /**
     * Extract the parameters to be converted to data-* attributes
     * See the docs at https://developers.google.com/recaptcha/docs/display
     *
     * @param array $options
     *
     * @return array
     */
    protected function extractDataParams($options = [ ])
    {
        return array_only($options, $this->dataParameterKeys);
    }
}
