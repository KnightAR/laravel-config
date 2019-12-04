# Laravel Config

[![Build Status](https://travis-ci.org/knightar/laravel-config.svg?branch=feature%2F1-setup-build-environment&format=flat-square)](https://travis-ci.org/knightar/laravel-config)
[![Total Downloads](https://poser.pugx.org/knightar/laravel-config/d/total.svg?format=flat-square)](https://packagist.org/packages/knightar/laravel-config)
[![Latest Stable Version](https://poser.pugx.org/knightar/laravel-config/v/stable.svg?format=flat-square)](https://packagist.org/packages/knightar/laravel-config)
[![Latest Unstable Version](https://poser.pugx.org/knightar/laravel-config/v/unstable.svg?format=flat-square)](https://packagist.org/packages/knightar/laravel-config)
[![License](https://poser.pugx.org/knightar/laravel-config/license.svg?format=flat-square)](https://packagist.org/packages/knightar/laravel-config)

A Laravel __runtime__ configuration handler that supports hierarchical configuration,
however when stored, the data is flattened to basic key/value pairs (this allows for more possible storage options)

## Currently in beta

- There's still few remaining bugs. A proper release should be available in the next few days

```php
<?php

use KnightAR\Laravel\Config\Config;

$config = new Config([
    'foo.bar[0]' => 'Hello',
    'foo.bar[1]' => 'World',
    'foo.key'    => 'Value'
]);

$foo = $config->get('foo'); // => ['bar' => ['Hello', 'World'], 'key' => 'Value']
$bar = $config->get('foo.bar'); // => ['Hello', 'World']

```

## Features

- Ability to store the configuration data into any persistent data store (file, db, etc).
  - Provided Storage Adapters include Db, File, Redis.
- Dot notation syntax for configuration hierarchy.
- Values can be simple strings, or arrays of strings.
- Modifier support. Modifers can be registered to manipulate the value at runtime. (aka storing json, datetimes, booleans, etc).
- [ServiceProvider][2] included to configure the component based on the supplied configuration
- Facade support


## Installation

Install the library using [composer][1]:

```sh
$ composer require knightar/laravel-config:^0.3
```

This will provide access to the component via PSR-4. To configure the package as a laravel service, the service provider must be registered with the provided ServiceProvider.

## Configuring Laravel

Once the package has been installed via composer, you need to register the service provider. To do this, edit your `config/app.php` and add a new option under the `providers` key.

```php
KnightAR\Laravel\Config\ServiceProvider::class
```

**Laravel 5.5 and greater** uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider.

Additionally you can register the provided facade.

```php
'RuntimeConfig' => KnightAR\Laravel\Config\Facdes\Config::class,
```
With the service provider registered, this will give access to the config component, however it is _not_ configured to persist any changes you make to the config. To do this, you need to publish the provided config file.

```
php artisan vendor:publish --provider="KnightAR\Laravel\Config\ServiceProvider" --tag="config"
```

This will publish a `config.php` file into your `config` directory. At this point you will need to edit the file and setup how you want to persist your configuration.

Additionally if you plan to store your configuration in a database (such as mysql, etc) you will need to publish the migration which stores the config schema

```
php artisan vendor:publish --provider="KnightAR\Laravel\Config\ServiceProvider" --tag="migrations"
```

[1]: http://getcomposer.org/
[2]: https://laravel.com/docs/master/providers
