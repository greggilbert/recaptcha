<?php namespace Greggilbert\Recaptcha;

use Illuminate\Support\ServiceProvider;

/**
 * Service provider for the Recaptcha class
 * 
 * @author     Greg Gilbert
 * @link       https://github.com/greggilbert

 */
class RecaptchaServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->addValidator();
    }
    
    /**
     * Extends Validator to include a recaptcha type
     */
    public function addValidator()
    {
        $validator = $this->app['Validator'];
        
        $validator::extend('recaptcha', function($attribute, $value, $parameters)
        {
            $captcha = app('Greggilbert\Recaptcha\Service\RecaptchaInterface');
            $challenge = app('Input')->get($captcha->getResponseKey());
            
            return $captcha->check($challenge, $value);
        });
    }
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->bindRecaptcha();
        $this->handleConfig();
    }
    
    protected function bindRecaptcha()
    {
        
        $this->app->bind('recaptcha', function()
        {
            if(app('config')->get('recaptcha.version', false) === 2 || app('config')->get('recaptcha.v2', false))
            {
                return new Service\CheckRecaptchaV2;
            }
            
            return new Service\CheckRecaptcha;
        });
        
    }
    
    protected function handleConfig()
    {
        $packageConfig = __DIR__.'/../../config/recaptcha.php';
        $destinationConfig = config_path('recaptcha.php');
        
        $this->publishes(array(
            $packageConfig => $destinationConfig,
        ));
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'recaptcha',
        ];
    }
    
    
    /**
     * Extends Form to include a recaptcha macro
     */
    public function addFormMacro()
    {
        // @FIXME - Form no longer included in L5
        app('form')->macro('captcha', function($options = array())
        {
            $configOptions = app('config')->get('recaptcha::options', array());
            
            $mergedOptions = array_merge($configOptions, $options);
            
            $data = array(
                'public_key'    => app('config')->get('recaptcha::public_key'),
                'options'        => $mergedOptions,
            );
            
            if(array_key_exists('lang', $mergedOptions) && "" !== trim($mergedOptions['lang']))
            {
                $data['lang'] = $mergedOptions['lang'];
            }
            
            $view = 'recaptcha::' . app('Greggilbert\Recaptcha\Service\RecaptchaInterface')->getTemplate();
            
            $configTemplate = app('config')->get('recaptcha::template', '');
            
            if(array_key_exists('template', $options))
            {
                $view = $options['template'];
            }
            elseif("" !== trim($configTemplate))
            {
                $view = $configTemplate;
            }
                        
            return app('view')->make($view, $data);
        });
    }
    

}
