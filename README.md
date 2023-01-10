# SMSPortal Laravel Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/softsmart/smsportal-laravel.svg?style=flat-square)](https://packagist.org/packages/softsmart/smsportal-laravel)
[![Total Downloads](https://img.shields.io/packagist/dt/softsmart/smsportal-laravel.svg?style=flat-square)](https://packagist.org/packages/softsmart/smsportal-laravel)

Third party package created to consume the SMSPortal RESTful API to send SMS's to phone numbers.

## Installation

You can install the package via composer:

```bash
composer require softsmart/smsportal-laravel
```

Set these `.env` variables:
```dotenv
SMSPORTAL_BASE_URL=https://rest.smsportal.com/v1
SMSPORTAL_CLIENT_ID=
SMSPORTAL_SECRET=
SMSPORTAL_TEST_MODE=true/false
```

You can find your client id & secret in your [SMSPortal control panel](https://cp.smsportal.com/app/#/login).

## Usage

``` php
// To send a message to a single phone number
SMSPortal::sendMessage('0112223333', 'Hello world!');

// To send a message to a single phone number later
// NOTES: even though replacements is not used for single SMS we still need to
// account for its place (this may change with named parameters in PHP8 in later versions)
// date time is a string in GMT+2 timezone
SMSPortal::sendMessage('0112223333', 'Hello world!', [], "2023-01-12 12:34:33");
```

``` php
// To send a message to a multiple phone numbers (without text replacements)

$numbers = [
    "0000000000",
    "00000000001",
];

SMSPortal::sendMessage($numbers, 'Hello world!');

// To send a message to a multiple phone numbers later
// NOTES: must account for replacements place (this may change with named parameters in PHP8 in later versions)
// date time is a string in GMT+2 timezone
SMSPortal::sendMessage($numbers, 'Hello world!', [], "2023-01-12 12:34:33");

```


``` php
// To send a message to a multiple phone numbers (with text replacements)
// Replacements must be an array of array arrays with a key attribute and a value attribute
// Its up to you to determine the key, in this is its ::first_name:: but it could be {first_name}, etc.

$numbers = [
    "0000000000",
    "0000000001",
];

$replacements = [
    // first replacement
    [
        [
            "key"   => "::first_name::",
            "value" => "John"
        ],
        [
            "key"   => "::weather::",
            "value" => "hot",
        ]
    ],
    // second replacement
    [
        [
            "key"   => "::first_name::",
            "value" => "Alice"
        ],
        [
            "key"   => "::weather::",
            "value" => "cold",
        ]
    ],
]

SMSPortal::sendMessage($numbers, 'Hello ::first_name::, today is ::weather::!', $replacements);

// To send a message to a multiple phone numbers later
// date time is a string in GMT+2 timezone
SMSPortal::sendMessage($numbers, 'Hello ::first_name::, today is ::weather::!', $replacements, "2023-01-12 12:34:33");

```


### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please make use of the issue tracker.

## Credits

- [John McMurray](https://github.com/jsmcm)
- [Jadon Brown](https://github.com/schemeza)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
