# WP Parser Validate [![Build Status](https://travis-ci.org/keesiemeijer/wp-parser-validate.svg?branch=master)](http://travis-ci.org/keesiemeijer/wp-parser-validate) #

Validate the inline documentation of your functions, methods and hooks against the WordPress PHP Documentation Standards.

Use it as a WordPress plugin (with a [WP-CLI](http://wp-cli.org/) command) or as a standalone application.

Try out [this demo](https://wp-parser-validate.herokuapp.com/) to see it in action. (First load could take a while because it's on a free heroku instance)

Check out [what's currently being validated](https://github.com/keesiemeijer/wp-parser-validate/wiki/What-is-validated)

This plugin is based on the [WP Parser](https://github.com/WordPress/phpdoc-parser) and parses files the same a the parser does.

## Requirements
* PHP 5.4+
* [Composer](https://getcomposer.org/)
* [WP CLI](http://wp-cli.org/)

## Running The Plugin

Clone the repository into your WordPress plugins directory:

```bash
git clone https://github.com/keesiemeijer/wp-parser-validate 
```

After that install the dependencies using composer in the parser directory:

```bash
composer install
```

Activate the plugin:

    wp plugin activate wp-parser-validate

In your site's directory:

    wp parser validate /path/to/source/code

## Running it as a standalone application

Clone the repository
```bash
git clone https://github.com/keesiemeijer/wp-parser-validate 
```

After that install the dependencies using composer in the `wp-parser-validate` directory:
```bash
composer install
```
Copy the `wp-parser-validate` folder to your server and visit it in a browser. There you'll find the same form to validate content as in [the demo](https://wp-parser-validate.herokuapp.com/)

Or use the PHP built-in web server in the `wp-parser-validate` folder 
```bash
php -S localhost:8080
```
And go to http://localhost:8080 in the browser.
