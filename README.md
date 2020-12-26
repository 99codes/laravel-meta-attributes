# Laravel Meta Attributes

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nncodes/laravel-meta-attributes.svg?style=flat-square)](https://packagist.org/packages/nncodes/laravel-meta-attributes)
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

/**
 * Store the meta value using type auto discover
 * 
 * @note types: boolean, integer, double, string, 
 * object, array, collection, date, datetime.
*/

$yourModel->setMeta($key)->value($value);

//For all other types you can specify using casting methods.

$yourModel->setMeta('departament')->asString('IT');

$yourModel->setMeta('salaryInteger')->asInteger(1489);

$yourModel->setMeta('salaryFloat')->asFloat(1489.909);

$yourModel->setMeta('salaryDecimal')->asDecimal(1489.9, $digitgs = 2);

$yourModel->setMeta('salaryDouble')->asDouble(1489.90);

$yourModel->setMeta('salaryPerSecond')->asReal(0.00001);

$yourModel->setMeta('favoriteColors')->asArray([
    'red', 'blue', 'yellow', 'white'
]);

$yourModel->setMeta('tastes')->asCollection([
	['name' => 'Coffee', 'type' => 'Beverage', 'rate' => 9],
  	['name' => 'Rice', 'type' => 'Food', 'rate' => 7],
]);

$yourModel->setMeta('skills')->asObject([
    'PHP' => 'Very Good', 
    'Laravel' => 'Very Good', 
    'MySQL' => 'Good'
]);

$yourModel->setMeta('isAdult')->asBoolean(true);

$yourModel->setMeta('nid')->asEncrypted('FL-104050'); 

$yourModel->setMeta('birthdate')->asDate(
    '1991-01-29', 
    $format = 'Y-m-d H:i:s'
);

$yourModel->setMeta('lastLoginAt')->asDatetime(
    '2020-01-01 10:10:10',
    $format = 'Y-m-d H:i:s'
);

$yourModel->setMeta('createdAt')->asTimestamp($timestamp = time());

```
And your can get a meta attribute from your model:

```php
$yourModel->getMeta($key); //Eloquent object
$yourModel->getMetaValue($key, $fallback = null); //Only the value
```

To get the collection of meta attributes from your from:

```php
$yourModel->getMetas();
```

Or you can access all meta attributes as an object:

```php
$yourModel->meta->birthdate;
$yourModel->meta->createdAt;
```

You can also check if the model already has a meta attribute:

```php
$yourModel->hasMeta($key);
```

If you need to delete the meta attribute, it is simple:

```php
$yourModel->forgeMeta($key);
```

## Credits

- [Leonardo Poletto](https://github.com/leopoletto)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
