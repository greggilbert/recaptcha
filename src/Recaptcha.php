<?php

namespace Greggilbert\Recaptcha;

class Recaptcha
{
    protected $service;
    
    protected $config = array();
    
    public function __construct($service, $config)
    {
        $this->service = $service;
        $this->config = $config;
    }
    
    public function render($options = array())
    {
        $mergedOptions = array_merge($this->config, $options);
        
        $data = array(
            'public_key'    => $this->config['public_key'],
            'options'       => $mergedOptions,
        );

        if(array_key_exists('lang', $mergedOptions) && "" !== trim($mergedOptions['lang']))
        {
            $data['lang'] = $mergedOptions['lang'];
        }

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
        
        return app('view')->make($view, $data);
    }

}
