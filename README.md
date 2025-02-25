# Laravel Multi Language

[![Latest Version on Packagist](https://img.shields.io/packagist/v/michaelnabil230/laravel-multi-language.svg?style=flat-square)](https://packagist.org/packages/michaelnabil230/laravel-multi-language)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/michaelnabil230/laravel-multi-language/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/michaelnabil230/laravel-multi-language/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/michaelnabil230/laravel-multi-language/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/michaelnabil230/laravel-multi-language/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/michaelnabil230/laravel-multi-language.svg?style=flat-square)](https://packagist.org/packages/michaelnabil230/laravel-multi-language)

A Laravel package for seamless multi-language support, enabling localized routing and language management.

## Installation

You can install the package via composer:

```bash
composer require michaelnabil230/laravel-multi-language
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="multi-language-config"
```

### Middleware Setup

Register the middleware in `bootstrap/app.php`:

```php
return Application::configure(basePath: dirname(__DIR__))
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'localize' => \MichaelNabil230\LaravelMultiLanguage\Http\Middleware\SetLocale::class,
        ]);
    });
```

## Usage

### Routing Setup

```php
// routes/web.php
Route::prefix(LaravelMultiLanguage::prefix())
    ->middleware('localize')
    ->group(function () {
        // Your routes here
    });
```

Example URLs:
- English: `http://yoursite.com/en`, `http://yoursite.com/en/test`
- Arabic: `http://yoursite.com/ar`, `http://yoursite.com/ar/test`
- Auto-detect: `http://yoursite.com` (redirects to default locale)

(Due to technical issues, the search service is temporarily unavailable.)

Here's the updated Helpers section converted to bullet points:

### Helper Methods

- **Get Localized URL**  
  Generate URL for a specific locale:
  ```php
  {{ LaravelMultiLanguage::getLocalizedURL('en') }}
  // Output: http://yoursite.com/en/current-route
  ```

- **Get Supported Locales**  
  Retrieve all supported locales with their properties:
  ```php
  {{ LaravelMultiLanguage::getSupportedLocales() }}
  /* Output: [
     'en' => ['name' => 'English', 'native' => 'English', ...],
     'ar' => ['name' => 'Arabic', 'native' => 'عربى', ...]
  ] */
  ```

- **Get Supported Locale Keys**  
  Get array of supported language codes:
  ```php
  {{ LaravelMultiLanguage::getSupportedLanguagesKeys() }}
  // Output: ['en', 'ar']
  ```

- **Get Current Locale**  
  Retrieve current locale code:
  ```php
  {{ LaravelMultiLanguage::getCurrentLocale() }}
  // Output: en
  ```

- **Get Current Locale Name**  
  Get English name of current locale:
  ```php
  {{ LaravelMultiLanguage::getCurrentLocaleName() }}
  // Output: English
  ```

- **Get Current Locale Native Name**  
  Get native language name:
  ```php
  {{ LaravelMultiLanguage::getCurrentLocaleNative() }}
  // Output: English (for EN) or عربى (for AR)
  ```

- **Get Current Locale Direction**  
  Get text direction (ltr/rtl):
  ```php
  {{ LaravelMultiLanguage::getCurrentLocaleDirection() }}
  // Output: ltr or rtl
  ```

- **Get Current Locale Script**  
  Get ISO 15924 script code:
  ```php
  {{ LaravelMultiLanguage::getCurrentLocaleScript() }}
  // Output: Latn (for Latin script)
  ```
  *For ISO 15924 details, see [Unicode's documentation](http://www.unicode.org/iso15924).*

### Language Selector Example

```blade
<ul>
    @foreach(LaravelMultiLanguage::getSupportedLocales() as $localeCode => $properties)
        <li>
            <a rel="alternate" hreflang="{{ $localeCode }}" 
               href="{{ LaravelMultiLanguage::getLocalizedURL($localeCode) }}">
                {{ $properties['native'] }}
            </a>
        </li>
    @endforeach
</ul>
```

### Listeners Event

If you want to listen to the `SetLocaleEvent` event, you can use the following code:

```php
use MichaelNabil230\LaravelMultiLanguage\Events\SetLocaleEvent;
use Illuminate\Support\Facades\Event;

Event::listen(SetLocaleEvent::class, function (SetLocaleEvent $event) {
    $locale = $event->locale;
});
```

## Advanced Configuration

### Route Caching

Cache routes using:

```bash
php artisan route:trans:cache
```

Update `AppServiceProvider.php`:

```php
use MichaelNabil230\LaravelMultiLanguage\Traits\LoadsTranslatedCachedRoutes;

class AppServiceProvider extends ServiceProvider
{  
    use LoadsTranslatedCachedRoutes;
    
    public function boot(): void
    {
        RouteServiceProvider::loadCachedRoutesUsing(fn () => $this->loadCachedRoutes());
    }
}
```

### Testing Setup

Add to your `TestCase.php`:

```php
use MichaelNabil230\LaravelMultiLanguage\LaravelMultiLanguage;

protected function setUp(): void
{
    $this->setApplicationLocale('en');
    parent::setUp();
}

protected function tearDown(): void
{
    putenv(Localization::ENV_ROUTE_KEY);
    parent::tearDown();
}

protected function setApplicationLocale(string $locale): void
{
    putenv(Localization::ENV_ROUTE_KEY . '=' . $locale);
}
```

## Support

[![Image for sponsor](./.assets/sponsors.png)](https://github.com/sponsors/michaelnabil230)

[![Ko-fi](.assets/ko-fi.png)](https://ko-fi.com/michaelnabil230)[![Buymeacoffee](.assets/buymeacoffee.png)](https://www.buymeacoffee.com/michaelnabil230)[![Paypal](.assets/paypal.png)](https://www.paypal.com/paypalme/MichaelNabil23)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Michael Nabil](https://github.com/michaelnabil230)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
