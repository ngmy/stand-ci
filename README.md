# Stand CI

[![Latest Stable Version](https://poser.pugx.org/ngmy/stand-ci/v/stable.svg)](https://packagist.org/packages/ngmy/stand-ci)
[![Total Downloads](https://poser.pugx.org/ngmy/stand-ci/downloads.svg)](https://packagist.org/packages/ngmy/stand-ci)
[![Latest Unstable Version](https://poser.pugx.org/ngmy/stand-ci/v/unstable.svg)](https://packagist.org/packages/ngmy/stand-ci)
[![License](https://poser.pugx.org/ngmy/stand-ci/license.svg)](https://packagist.org/packages/ngmy/stand-ci)

Stand CI is a continuous integration tool designed for Laravel 5 application.
It can easily be integrated into your Laravel 5 application.

## Integrated Tools

Stand CI has integrated the following tools:

  * [PHPUnit](https://phpunit.de/) - A unit testing framework

  * [PhpMetrics](http://www.phpmetrics.org/) - A tool to generate reports about such as complexity, maintenability, instability of code

  * [PHPMD](http://phpmd.org/) - A tool to detect potential problems in code

  * [PHPCPD](https://github.com/sebastianbergmann/phpcpd) - A tool to detect duplicate code

  * [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) - A tool to detect coding standard violations

  * [phpDocumentor](http://www.phpdoc.org/) - A tool to generate documentation of code

## Requirements

Stand CI has the following requirements:

  * PHP 5.4+

  * Laravel 5.0+

## Installation

Add the package to your `composer.json` and run `composer update`:

```json
{
    "require-dev": {
        "ngmy/stand-ci": "dev-master"
    }
}
```

Add the following to the list of service providers in `config/app.php`:

```php
'Ngmy\StandCi\StandCiServiceProvider',
```

Run the following command:

```
$ php artisan stand-ci:install
```

## Usage

### via Web Browser

You can access the Stand CI dashborard via your web browser directly, by typing in the following URL:

```
http://your.laravel.site.domain/stand-ci/builds
```

After you open the dashboard, you can start the build, by click the "Build" button.

### via Command Line

#### Build

You can start the build, by running the following command:

```
$ sudo -u your_web_server_user -H php artisan stand-ci:build
```

#### Housekeeping

You can discard old builds, by running the following command:

```
$ sudo -u your_web_server_user -H php artisan stand-ci:housekeep
```

This will discard older than the most recent 20 builds.

You can also specify the maximum number of builds to keep, by using the `--max-builds` option:

```
$ sudo -u your_web_server_user -H php artisan stand-ci:housekeep --max-builds=5
```

**Note:** You must be running these commands as your web server user. Otherwise, you will not be able to housekeep using the browser.

### via Crontab

Example: The following will build at one minute past midnight each day:

```
01 00 * * * sudo -u your_web_server_user -H php /path/to/your/laravel/project/artisan stand-ci:build; sudo -u your_web_server_user -H php /path/to/your/laravel/project/artisan stand-ci:housekeep
```

## Other Features

### Build Notification

If you wish to be notified when the build fails, set the sender and receiver, and the `pretend` option to `false`, in your `config/packages/ngmy/stand-ci/ngmy-stand-ci-notification.php` configuration file.
