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
2. Run `php artisan vendor:publish --provider="Greggilbert\Recaptcha\RecaptchaServiceProvider"`.
3. In `/config/recaptcha.php`, enter your reCAPTCHA public and private keys.
  * If you are not using the most recent version of reCAPTCHA, set `version` to 1. 
  * If you are upgrading to v2 of reCAPTCHA, note that your keys from the previous version will not work, and you need to generate a new set in [the reCAPTCHA admin](https://www.google.com/recaptcha/admin).
4. The package ships with a default validation message, but if you want to customize it, add the following line into `resources/lang/[lang]/validation.php`:
  
  ```php
      'recaptcha' => 'The :attribute field is not correct.',
  ```

## Usage

### v2 (No Captcha)
1. In your form, use `{!! Recaptcha::render() !!}` to echo out the markup.
2. In your validation rules, add the following:

```php
    $rules = [
        // ...
        'g-recaptcha-response' => 'required|recaptcha',
    ];
```

### v1 (Legacy)
1. In your form, use `{!! Recaptcha::render() !!}` to echo out the markup.
2. In your validation rules, add the following:

```php
    $rules = [
        // ...
        'recaptcha_response_field' => 'required|recaptcha',
    ];
```

It's also recommended to add `required` when validating.

### How to show error message in view ?

Add this code in fails section.

```
return Redirect::to('/your/route/here')->withErrors($validationvariablehere);
```

Like this example.

```
<?php
class UsersController extends \BaseController {
	public function handleRegister(){
		$data = Input::all();
		$rules = array(
			'g-recaptcha-response' => 'required|recaptcha',
		);
		$validator = Validation::make($data,$rules);
		if ($validator->passes()){
			// success code here
		}else{
			return Redirect::to('/your/route/here')->withErrors($validator);
		}
	}
}
?>
```

Add this code in view.

```
{{ Form::captcha() }}
@if ($errors->has('g-recaptcha-response')) <small class="error"> The captcha field is required and make sure captcha is correct. </small> @endif
```

In the above tutorial i use zurb foundation, so i use `<small class="error"> your error text here </small>`.
Please make sure `$errors->has('g-recaptcha-response)`

## Customization

reCAPTCHA v2 allows for customization of the widget through a number of options, listed [at the official documentation](https://developers.google.com/recaptcha/docs/display). You can configure the output of the captcha through six allowed keys: `theme`, `type`, `lang`, `callback`, `tabindex` and `expired-callback`.

In the config file, you can create an `options` array to set the default behavior. For example:

```php
    // ...
    'options' => [
		'lang' => 'ja',
	],
```

would default the language in all the reCAPTCHAs to Japanese. If you want to further customize, you can pass options through the render option:

```php
echo Recaptcha::render([ 'lang' => 'fr' ]);
```

Options passed into `Recaptcha::render` will always supercede the configuration.

### Language

To change the language of the captcha, simply pass in a language as part of the options:

```php
    'options' => [
        'lang' => 'fr',
	],
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
echo Recaptcha::render([ 'template' => 'customCaptcha' ]);
```

### v1 customization

For the v1 customization options, consult [the old documentation](https://developers.google.com/recaptcha/old/docs/customization) and apply accordingly.

## Limitation

Because of Google's way of displaying the reCAPTCHA, this package won't work if you load your form from an AJAX call.
If you need to do it, you should use one of [the alternate methods provided by Google](https://developers.google.com/recaptcha/docs/display?csw=1).
