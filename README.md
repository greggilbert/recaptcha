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
        'recaptcha_response_field' => 'recaptcha',
    };
```

It's also recommended to add `required` when validating.
