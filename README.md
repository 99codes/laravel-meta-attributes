# Laravel Meta Attributes

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nncodes/laravel-meta-attributes.svg?style=flat-square)](https://packagist.org/packages/nncodes/laravel-meta-attributes)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/nncodes/laravel-meta-attributes/run-tests?label=tests)](https://github.com/99codes/laravel-meta-attributes/actions?query=workflow%3ATests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/nncodes/laravel-meta-attributes.svg?style=flat-square)](https://packagist.org/packages/nncodes/laravel-meta-attributes)


Add meta attributes to Eloquent models

## Installation

You can install the package via composer:

```bash
composer require nncodes/laravel-meta-attributes
```

You need to publish and run the migration:

```bash
php artisan vendor:publish --provider="Nncodes\MetaAttributes\MetaAttributesServiceProvider" --tag="migrations"
php artisan migrate
```

## Preparing your model

To associate meta attributes with a model, the model must implement the following interface and trait:


```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nncodes\MetaAttributes\Concerns\HasMetaAttributes;

class YourModel extends Model
{
    use HasMetaAttributes;
}
```

## Usage

You can set meta attributes to your model like this:

```php
$yourModel = YourModel::find(1);
$yourModel->setMetaAttribute($key, $value);
```

And your can get a meta attribute from your model:

```php
$yourModel->getMetaAttribute($key);
```

You can also check if the model already has a meta attribute:

```php
$yourModel->hasMetaAttribute($key);
```

If you need to delete the meta attribute, it is simple:

```php
$yourModel->forgeMetaAttribute($key);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Leonardo Poletto](https://github.com/leopoletto)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
