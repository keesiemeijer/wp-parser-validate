# WP Parser Validate

[![Build Status](https://travis-ci.org/keesiemeijer/wp-parser-validate.svg?branch=master)](http://travis-ci.org/keesiemeijer/wp-parser-validate)

A [WP-CLI package](http://wp-cli.org/package-index/) to validate the inline documentation of your functions, methods and hooks against the WordPress [PHP Documentation Standards](https://make.wordpress.org/core/handbook/best-practices/inline-documentation-standards/php/).

It can also be used as a web app. Check out [this demo](https://wp-parser-validate.herokuapp.com/) to see it in action. (First load could take a while because it's on a free heroku instance)


See [what's currently being validated](https://github.com/keesiemeijer/wp-parser-validate/wiki/What-is-validated) by this package.

This plugin uses the [WP Parser](https://github.com/WordPress/phpdoc-parser) to parse files.

## Usage
```bash
wp parser validate /path/to/source/code
```

## Requirements
* PHP 5.4+
* [Composer](https://getcomposer.org/)
* [WP CLI](http://wp-cli.org/)

## Installing

Installing this package requires WP-CLI v0.23.0 or greater. Update to the latest stable release with wp cli update. When this package is added to the WP-CLI [package index](http://wp-cli.org/package-index/) you can install it directly through WP-CLI. For now use this method

Clone the repository:

```bash
git clone https://github.com/keesiemeijer/wp-parser-validate 
```

And install it with WP-CLI:

```bash
wp package install path/to/wp-parser-validate/directory
```

## Web App

To install the web app Clone the repository
```bash
git clone https://github.com/keesiemeijer/wp-parser-validate
```

Go to the `wp-parser-validate` directory
```bash
cd wp-parser-validate
```

After that install the dependencies using composer:
```bash
composer install
```
Copy the `wp-parser-validate` folder to a server or to your localhost and visit it in a browser.

Or use the PHP built-in web server in the `wp-parser-validate` folder. 
```bash
php -S localhost:8080
```
And go to http://localhost:8080 in the browser.
