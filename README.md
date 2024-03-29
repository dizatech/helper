# Dizatech Helper
Dizatech is a package developed to add validation, banking and view helpers to Laravel projects with Iranian/Persian projects' needs in mind. This package is highly inspired by the works of my dear friend and colleague @imvahid.

## Installation
1. Require the package via composer
```bash
composer require dizatech/helper
```

2. Run the following command to publish package files
```bash
php artisan vendor:publish --provider=Dizatech\Helper\DizatechHelperServiceProvider
```

## Validation Rules

### National Code
برای اعتبار سنجی کد ملی شخص حقیقی

Add ``new NationalCode()`` to validation rules array.
String passed for validation must be 10 characters long. National codes with zero(s) in the begining should be passed as string with their leading zeros. It's recommended to zero-pad national codes before using them for any purpose, including validation.

#### Zero-padding example
###### Bare php:
```php
$national_code = str_pad($code, 10, '0', STR_PAD_LEFT);
```
###### Inside Laravel reuest file:
```php
<?php

namespace App\Http\Requests;

use Dizatech\Helper\Rules\NationalCode;
use Illuminate\Foundation\Http\FormRequest;

class MyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'national_code' => ['required', new NationalCode()],
        ];
    }

    public function prepareForValidation()
    {
        if ($this->has('national_code')) {
            $this->merge([
                'national_code' => str_pad($this->national_code, 10, '0', STR_PAD_LEFT)
            ]);
        }
    }
}
```

###### Validation in laravel controller:
```php
public function handleForm(Request $request)
{
    if ($request->has('national_code')) {
        $request->merge(
            ['national_code' => str_pad($this->national_code, 10, '0', STR_PAD_LEFT)]
        );
    }
    $rules = [
        'national_code' => ['required', new NationalCode()],
    ];
    $request->validate($rules);
});
```
### National Id
برای اعتبار سنجی شناسه ملی شخص حقوقی

Add ``new Nationalid()`` to validation rules array.
String passed for validation must be 11 characters long.

### Internationalization
If you haven't run ``php artisan vendor:publish`` command yet, first run the floowing command to publish language files:
```bash
php artisan vendor:publish --provider=Dizatech\Helper\DizatechHelperServiceProvider
```
Language files will be copied to ``en`` and ``fa`` folders inside ``lang`` folder of your project. You can customize error message as desired. Make sure you set coorect locale for your app in ``config/app.php``.
For Farsi it shuld be set as:
```php
'locale' => 'fa'
```
