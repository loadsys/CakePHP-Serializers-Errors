# CakePHP SerializersErrors

[![Latest Version](https://img.shields.io/github/release/loadsys/CakePHP-Serializers-Errors.svg?style=flat-square)](https://github.com/loadsys/CakePHP-Serializers-Errors/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://travis-ci.org/loadsys/CakePHP-Serializers-Errors.svg?branch=master&style=flat-square)](https://travis-ci.org/loadsys/CakePHP-Serializers-Errors)
[![Coverage Status](https://coveralls.io/repos/loadsys/CakePHP-Serializers-Errors/badge.svg)](https://coveralls.io/r/loadsys/CakePHP-Serializers-Errors)
[![Total Downloads](https://img.shields.io/packagist/dt/loadsys/cakephp-serializers-errors.svg?style=flat-square)](https://packagist.org/packages/loadsys/cakephp-serializers-errors)

Used to serialize CakePHP Errors and Exceptions, primarily as HTML, JSON or JSON API.

Adds two new Exception Classes to extend from to get [JSON API](http://jsonapi.org/format/#errors) formatted error messages.

## Requirements

* CakePHP 2.3+
* PHP 5.4+

## Installation

### Composer

````bash
$ composer require loadsys/cakephp-serializers-errors:~1.0
````

## Usage

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

* Once this is done Exceptions are rendered as possible, [JSON API errors](http://jsonapi.org/format/#errors), 
JSON formated errors or standard HTML responses, differing on the request `Accepts` Header. 
* So if you use:
 - `Accepts: application/vnd.api+json` JSON API Errors are returned
 - `Accepts: application/json` JSON Errors are returned
 - `Accepts: */*` Normal CakePHP HTML Style Errors are returned
* If you build custom Exceptions that extend `BaseSerializerException` you get 
Exceptions that enable the full feature set of [JSON API errors](http://jsonapi.org/format/#errors)
in addition to be rendering in the pattern described above.

## Sample Responses

Here are some sample response for the different Exception classes.

### BaseSerializerException

#### Accepts: application/vnd.api+json

Matches the format expected in [JSON API](http://jsonapi.org/format/#errors)

```php
throw new BaseSerializerException("This is a message.", "Something failed", 400, "Custom ID For Error", "http://docs.domain.com/api/v1/custom-id-for-error", array(), array())
```

```javascript
{
	"errors": [
		{
			"id": "Custom ID For Error",
			"href": "http://docs.domain.com/api/v1/custom-id-for-error",
			"status": "401",
			"code": "401",
			"title": "Title of the Error",
			"detail": "More Detailed information",
			"links": [],
			"paths": []
		}
	]
}
```

#### Accepts: application/json

```php
throw new BaseSerializerException("This is a message.", "Something failed", 400, "Custom ID For Error", "http://docs.domain.com/api/v1/custom-id-for-error", array(), array())
```

```javascript
{
	"id": "Custom ID For Error",
	"href": "http://docs.domain.com/api/v1/custom-id-for-error",
	"status": "400",
	"code": "400",
	"detail": "Something failed",
	"links": [],
	"paths": []
}
```

### ValidationBaseSerializerException

#### Accepts: application/vnd.api+json

Matches the format expected in [JSON API](http://jsonapi.org/format/#errors)

```php
throw new ValidationBaseSerializerException("This is a message.", $this->ModelName->invalidFields(), 422, "Custom ID For Error", "http://docs.domain.com/api/v1/custom-id-for-error", array(), array())
```

```javascript
{
	"errors": {
		"id": "Custom ID For Error",
		"href": "http://docs.domain.com/api/v1/custom-id-for-error",
		"status": "400",
		"code": "400",
		"title": "This is a message.",
		"detail": {
			"username": [
				"Username can not be empty",
				"Username can only be alphanumeric characters"
			],
			"first_name": [
				"First Name must be longer than 4 characters"
			]
		},
		"links": [],
		"paths": []
	}
}
```

#### Accepts: application/json

Matches the format expected in [Ember.js DS.Errors Class](http://emberjs.com/api/data/classes/DS.Errors.html)

```php
$invalidFields = $this->ModelName->invalidFields();
throw new ValidationBaseSerializerException("This is a message.", $invalidFields, 422, "Custom ID For Error", "http://docs.domain.com/api/v1/custom-id-for-error", array(), array())
```

```javascript
{
	"errors": {
		"name": [
			"Name must not be empty.", 
			"Name must be only alphanumeric characters"
		],
		"status": [
			"Status? must be true or false."
		],
		"SubModel": [
			{
				"options": [
					"Options must take the form `first|second|third` and `formula` must be empty."
				]
			}
		]
	}
}
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
