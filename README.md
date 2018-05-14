# seeuletter-php

[![Packagist version](https://img.shields.io/packagist/v/seeuletter/seeuletter-php.svg)](https://github.com/seeuletter/seeuletter-php)
[![Dependency Status](https://gemnasium.com/badges/github.com/seeuletter/seeuletter-php.svg)](https://gemnasium.com/github.com/seeuletter/seeuletter-php)


Seeuletter.com PHP Client is a simple but flexible wrapper for the [Seeuletter.com](https://www.seeuletter.com) API. See full Seeuletter.com documentation [here](https://docs.seeuletter.com/). For best results, be sure that you're using the latest version of the Seeuletter API and the latest version of the PHP wrapper.

## Table of Contents

- [Getting Started](#getting-started)
  - [Registration](#registration)
  - [Installation](#installation)
  - [Usage](#usage)
- [Examples](#examples)

## Getting Started

Here's a general overview of the Seeuletter services available, click through to read more.


Please read through the official [API Documentation](https://docs.seeuletter.com/?php#) to get a complete sense of what to expect from each endpoint.

### Registration

First, you will need to first create an account at [Seeuletter.com](https://www.seeuletter.com/signup) and obtain your Test and Live API Keys.

Once you have created an account, you can access your API Keys from the [API keys Panel](https://www.seeuletter.com/app/dashboard/keys).

### Installation

The recommended way to install Seeuletter.com PHP Client is through [Composer](http://getcomposer.org).

```bash
// Install Composer
curl -sS https://getcomposer.org/installer | php

// Add Seeuletter.com PHP client as a dependency
composer require seeuletter/seeuletter-php
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

### Usage

#### Create a new Letter
```php
<?php
require 'vendor/autoload.php';

// Provide an API Key in the class constructor
// in order to instantiate the Seeuletter object
$apiKey = 'API Key here';
$seeuletter = new \Seeuletter\Seeuletter($apiKey);

$to_address = array(
  'name'                  => 'Seeuletter',
  'address_line1'         => '30 rue de rivoli',
  'address_line2'         => '',
  'address_city'          => 'Paris',
  'address_country'       => 'France',
  'address_postalcode'    => '75004'
);

$letter = $seeuletter->letters()->create(array(
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

#### Get all Letters

```php
<?php
  require 'vendor/autoload.php';

  $seeuletter = new \Seeuletter\Seeuletter('test_12345678901234567890');

  $letters = $seeuletter->letters()->all();

  print_r($letters);
?>
```

#### Get a specific Letter
```php
<?php
  require 'vendor/autoload.php';

  $seeuletter = new \Seeuletter\Seeuletter('test_12345678901234567890');

  $letter = $seeuletter->letters()->get('LETTER_ID');

  print_r($letter);
?>
```

## Examples

We've provided various examples for you to try out [here](https://github.com/seeuletter/seeuletter-php/tree/master/examples).


=======================

Copyright &copy; 2017 Seeuletter.com

Released under the MIT License, which can be found in the repository in `LICENSE.txt`.
