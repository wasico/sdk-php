# Wasi SDK PHP

You can sign up for a **Wasi account** at https://wasi.co and get your **id_company** and **wasi_token**

* [Requirements](#requirements)
* [Installation](#installation)
    * [Composer](#composer)
    * [First configuration](#first-configuration)
* [Usage](#usage)
    * [Find one element](#find-one-element)
    * [Filter and get elements](#filter-and-get-elements)

## Requirements

PHP 7.1.* and later.

## Installation

### Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require wasico/sdk-php
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):

```php
require_once('vendor/autoload.php');
```

Or add manually to your composer.json file for constant update
```php
"wasico/sdk-php": ">=0.0.1"
```

### First configuration

Set your configuration only one time in execution time

```php
\Wasi\SDK\Configuration::set([
    'v'          => 1, //API version here
    'id_company' => 123456, //Your id_company here
    'wasi_token' => 'AbCd_eFgH_IjKl_MnOp', //Your WasiToken here
]);
```

## Usage

### Find one element

```php
$property = \Wasi\SDK\Models\Property::find(123456); //Replace 123456 with the id_property
```

### Filter and get elements

```php
$properties = ->where('title', 'Hotel')->get(); //use in **where** method the filters
```