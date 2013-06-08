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

Options passed into `Form::captcha` will always supercede the configuration.
