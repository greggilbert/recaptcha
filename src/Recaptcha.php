<?php

namespace Greggilbert\Recaptcha;

class Recaptcha
{
    protected $service;

    protected $config = array();

    protected $dataParameterKeys = array('theme', 'type', 'callback');

    public function __construct($service, $config)
    {
        $this->service = $service;
        $this->config = $config;
    }

    /**
     * Render the recaptcha
     * @param array $options
     * @return view
     */
    public function render($options = array())
    {
        $mergedOptions = array_merge($this->config['options'], $options);

        if(false == $this->config['explicit'])
        {
            $data = array(
                'public_key'    => $this->config['public_key'],
                'options'       => $mergedOptions,
                'dataParams'    => $this->extractDataParams($mergedOptions),
            );

            if(array_key_exists('lang', $mergedOptions) && "" !== trim($mergedOptions['lang']))
            {
                $data['lang'] = $mergedOptions['lang'];
            }
        }
        else
        {
            if(!array_key_exists('id', $options))
            {
                $options['id'] = 'g-recaptcha';
            }

            $data = $options;
        }

        $view = $this->getView($options);

        return app('view')->make($view, $data);
    }

    /**
     * Render the recaptcha expliit javascript
     * @param array $options
     * @return view
     */
    public function includeJS($options = array())
    {
        $data = array();

        $mergedOptions = array_merge(array('sitekey' => $this->config['public_key']), $options);

        if(array_key_exists('parameters', $options) && is_array($options['parameters']))
        {
            $data['parameters'] = '&' . http_build_query($options['parameters']);
            unset($options['parameters']);
        }

        $data['options'] = $mergedOptions;

        $view = 'recaptcha::captchav2explicitjs';

        return app('view')->make($view, $data);
    }


    /**
     * Generate the view path
     * @param array $options
     * @return string
     */
    protected function getView($options = array())
    {
        $view = 'recaptcha::' . $this->service->getTemplate();

        $configTemplate = $this->config['template'];

        if(array_key_exists('template', $options))
        {
            $view = $options['template'];
        }
        elseif("" !== trim($configTemplate))
        {
            $view = $configTemplate;
        }

        return $view;
    }

    /**
     * Extract the parameters to be converted to data-* attributes
     * See the docs at https://developers.google.com/recaptcha/docs/display
     * @param array $options
     * @return array
     */
    protected function extractDataParams($options = array())
    {
        return array_only($options, $this->dataParameterKeys);
    }


}
