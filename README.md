Recaptcha
=========

A reCAPTCHA Validator for Laravel 4.

## Installation

Add the following line to the `require` section of `composer.json`:

```json
{
    "require": {
        "greggilbert/recaptcha": "dev-master"
    }
}
```

## Laravel 4 Setup

1. Add `Greggilbert\Recaptcha\RecaptchaServiceProvider` to the service provider list in `app/config/app.php`.
2. Run `php artisan config:publish greggilbert/recaptcha`.
3. In `app/config/packages/greggilbert/recaptcha/config.php`, enter your reCAPTCHA public and private keys.
4. Add the following line into `app/lang/[lang]/validation.php`:

```php
    "recaptcha" => 'The :attribute field is not correct.',
```

## Usage

1. In your form, use `Form::captcha()` to echo out the markup.
2. In your validation rules, add the following:

```php
    $rules = array(
        // ...
        'recaptcha_response_field' => 'required|recaptcha',
    };
```

It's also recommended to add `required` when validating.

## Customization

reCAPTCHA allows for customization of the widget through a number of options, listed [at the official documentation](https://developers.google.com/recaptcha/docs/customization). You can configure the output of the captcha in several ways.

In the `config.php`, you can create an `options` array to set the default behavior. For example:

```php
    // ...
    'options' => array(
		'theme' => 'white',
	),
```

would default all the reCAPTCHAs to the white theme. If you want to further customize, you can pass options through the Form option:

```php
echo Form::captcha(array('theme' => 'blackglass'));
```

Alternatively, if you want to set a default template instead of the standard one, you can use the config:

```php
    // ...
    'template' => 'customCaptcha',
```

or you can pass it in through the Form option:

```php
echo Form::captcha(array('template' => 'customCaptcha'));
```

Options passed into `Form::captcha` will always supercede the configuration.

To change the language of the captcha, simply pass in a language as part of the options:

```php
    'options' => array(
        'lang' => 'fr',
	),
```

You can do this both in the config and through the `Form::captcha()` call.

## V2 (No CAPTCHA reCAPTCHA) Support

To make use of the new reCAPTCHA (see https://developers.google.com/recaptcha/docs/display), you will need to enable the v2 setting in the config:

```php
    // ...
    'v2' => true,
```

Note that you will also have to generate a new set of keys if you have previously used reCAPTCHA v1. You can request keys at: https://www.google.com/recaptcha/admin#list

The validation rules will also need to be modified to the below:

```php
    $rules = array(
        // ...
        'g-recaptcha-response' => 'required|recaptcha',
    };
```

## For non-curl Support

If you dont want to use curl, you can set the no_curl option in the config:

```php
    // ...
    'no_curl' => true,
```

## Limitation

Because of Google's way of displaying the recaptcha, this package won't work if you load your form from an ajax call.
If you need to do it you should use [that method provided by Google]('https://developers.google.com/recaptcha/docs/display?csw=1') : 
