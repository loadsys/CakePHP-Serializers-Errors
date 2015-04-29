# CakePHP SerializersErrors

[![Latest Version](https://img.shields.io/github/release/loadsys/CakePHP-Serializers-Errors.svg?style=flat-square)](https://github.com/loadsys/CakePHP-Serializers-Errors/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://travis-ci.org/loadsys/CakePHP-Serializers-Errors.svg?branch=master&style=flat-square)](https://travis-ci.org/loadsys/CakePHP-Serializers-Errors)
[![Coverage Status](https://coveralls.io/repos/loadsys/CakePHP-Serializers-Errors/badge.svg)](https://coveralls.io/r/loadsys/CakePHP-Serializers-Errors)
[![Total Downloads](https://img.shields.io/packagist/dt/loadsys/cakephp-serializers-errors.svg?style=flat-square)](https://packagist.org/packages/loadsys/cakephp-serializers-errors)

Basic description of the plugin

## Requirements

## Installation

### Composer

````bash
$ composer require loadsys/cakephp-serializers-errors
````

## Usage ##

* Add this plugin to your application by adding this line to your bootstrap.php

````php
CakePlugin::load('SerializersErrors', array('bootstrap' => true));
````
* Update your `core.php` to use the plugin's ExceptionRenderer in place of the core's

```php
Configure::write('Exception', array(
	'handler' => 'ErrorHandler::handleException',
	'renderer' => 'SerializersErrors.SerializerExceptionRenderer',
	'log' => true,
));
```

## Contributing

### Reporting Issues

Please use [GitHub Isuses](https://github.com/loadsys/CakePHP-Serializers-Errors/issues) for listing any known defects or issues.

### Development

When developing this plugin, please fork and issue a PR for any new development.

The Complete Test Suite for the plugin can be run via this command:

`./lib/Cake/Console/cake test SerializersErrors AllSerializersErrors`

## License ##

[MIT](https://github.com/loadsys/CakePHP-Serializers-Errors/blob/master/LICENSE.md)


## Copyright ##

[Loadsys Web Strategies](http://www.loadsys.com) 2015
