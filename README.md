# lifebot-php


Lifebot.fr PHP Client is a simple but flexible wrapper for the [Lifebot.fr](https://www.lifebot.fr) API. See full Lifebot.fr documentation [here](https://docs.lifebot.fr/). For best results, be sure that you're using the latest version of the Lifebot API and the latest version of the PHP wrapper.

## Table of Contents

- [Getting Started](#getting-started)
  - [Registration](#registration)
  - [Installation](#installation)
  - [Usage](#usage)
- [Examples](#examples)

## Getting Started

Here's a general overview of the Lifebot services available, click through to read more.


Please read through the official [API Documentation](https://docs.lifebot.fr/) to get a complete sense of what to expect from each endpoint.

### Registration

First, you will need to first create an account at [Lifebot.fr](https://www.lifebot.fr/signup) and obtain your Test and Live API Keys.

Once you have created an account, you can access your API Keys from the [Settings Panel](https://www.lifebot.fr/app/dashboard/keys).

### Installation

The recommended way to install Lifebot.fr PHP Client is through [Composer](http://getcomposer.org).

```bash
// Install Composer
curl -sS https://getcomposer.org/installer | php

// Add Lifebot.fr PHP client as a dependency
composer require lifebot-api/lifebot-php
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

### Usage

```php
<?php
require 'vendor/autoload.php';

// Provide an API Key in the class constructor
// in order to instantiate the Lifebot object
$apiKey = 'API Key here';
$lifebot = new \Lifebot\Lifebot($apiKey);

$to_address = array(
  'name'                  => 'Lifebot',
  'address_line1'         => '30 rue de rivoli',
  'address_line2'         => '',
  'address_city'          => 'Paris',
  'address_country'       => 'France',
  'address_postalcode'    => '75004'
);

$letter = $lifebot->letters()->create(array(
  'to'                  => $to_address,
  'source_file'         => '@test.pdf',
  'description'         => 'Test Letters',
  'color'               => 'bw',
  'source_file_type'    => 'file',
  'postage_type'        => 'verte'
));

print_r($letter);

?>
```

## Examples

We've provided various examples for you to try out [here](https://github.com/lifebot-api/lifebot-php/tree/master/examples).


=======================

Copyright &copy; 2017 Lifebot.fr

Released under the MIT License, which can be found in the repository in `LICENSE.txt`.
