Recaptcha
=========

A reCAPTCHA Validator for Laravel 5.

> (Looking for a Laravel 4 version? Pull the latest 1.x tag. For Laravel 5.0, pull the latest 2.0 tag.)

## Installation

Add the following line to the `require` section of `composer.json`:

```json
{
    "require": {
        "greggilbert/recaptcha": "dev-master"
    }
}
```

## Setup

1. In `/config/app.php`, add the following to `providers`:

  ```
  Greggilbert\Recaptcha\RecaptchaServiceProvider::class,
  ```
  and the following to `aliases`:
  ```
  'Recaptcha' => Greggilbert\Recaptcha\Facades\Recaptcha::class,
  ```
2. Run `php artisan vendor:publish`.
3. In `/config/recaptcha.php`, enter your reCAPTCHA public and private keys.
  * If you are not using the most recent version of reCAPTCHA, set `version` to 1.
  * If you are upgrading to v2 of reCAPTCHA, note that your keys from the previous version will not work, and you need to generate a new set in [the reCAPTCHA admin](https://www.google.com/recaptcha/admin).
4. The package ships with a default validation message, but if you want to customize it, add the following line into `resources/lang/[lang]/validation.php`:

  ```php
      "recaptcha" => 'The :attribute field is not correct.',
  ```

## Usage

### v2 (No Captcha)
1. In your form, use `{!! Recaptcha::render() !!}` to echo out the markup.
2. In your validation rules, add the following:

```php
    $rules = array(
        // ...
        'g-recaptcha-response' => 'required|recaptcha',
    );
```

### v2 (No Captcha) Explicit
1. In `/config/recaptcha.php` set `explicit` to `true`.
2. In your form, use `{!! Recaptcha::render(['id' => 'my-recaptcha-id']) !!}` to echo out the markup (default `id` is `g-recaptcha`).
3. Before the close body tag, include the javascript configuration and the Google library include `{!! Recaptcha::includeJS() !!}`, you can sent optional parameter to override configuration values or set new url parameters, like a callback or the recaptcha language `{!! Recaptcha::includeJS(['theme' => 'clear', ['parameters' => ['hl' => App::getLocale(), 'onload' => 'onloadCallback'] ]]) !!}`.
4. Render explicity the No Captcha, your configuration values will be stored in the global javascript variable `RecaptchaOptions`: `grecaptcha.render(id, RecaptchaOptions);`. For futher understand check [the official documentation](https://developers.google.com/recaptcha/docs/display#explicit_render).

### v1 (Legacy)
1. In your form, use `{!! Recaptcha::render() !!}` to echo out the markup.
2. In your validation rules, add the following:

```php
    $rules = array(
        // ...
        'recaptcha_response_field' => 'required|recaptcha',
    );
```

It's also recommended to add `required` when validating.

## Customization

reCAPTCHA v2 allows for customization of the widget through a number of options, listed [at the official documentation](https://developers.google.com/recaptcha/docs/display). You can configure the output of the captcha through four allowed keys: `theme`, `type`, `lang`, and `callback`.

In the config file, you can create an `options` array to set the default behavior. For example:

```php
    // ...
    'options' => array(
		'lang' => 'ja',
    // Only apply for explicit render
    'parameters' => array(
      'onload' => 'onloadCallback',
      'hl' => App::getLocale(),
      //....
    ),
	),
```

would default the language in all the reCAPTCHAs to Japanese. If you want to further customize, you can pass options through the render option:

```php
echo Recaptcha::render(array('lang' => 'fr'));
```

Options passed into `Recaptcha::render` will always supercede the configuration.

### Language

To change the language of the captcha, simply pass in a language as part of the options:

```php
    'options' => array(
        'lang' => 'fr',
	),
```

For a list of valid language codes, consulting [the official documentation](https://developers.google.com/recaptcha/docs/language).

### Custom template

Alternatively, if you want to set a default template instead of the standard one, you can use the config:

```php
    // ...
    'template' => 'customCaptcha',
```

or you can pass it in through the Form option:

```php
echo Recaptcha::render(array('template' => 'customCaptcha'));
```

### v1 customization

For the v1 customization options, consult [the old documentation](https://developers.google.com/recaptcha/old/docs/customization) and apply accordingly.

## Limitation

Because of Google's way of displaying the reCAPTCHA, this package won't work if you load your form from an AJAX call.
If you need to do it, you should use one of [the alternate methods provided by Google](https://developers.google.com/recaptcha/docs/display?csw=1).
