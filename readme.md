# Xerox

A Laravel PHP package for automatic page caching.

- May 27, 2015: New v1.1.0 for use with Laravel 5.

## Install

Open ``app/Http/Kernal.php`` and register the middleware:

```php
'Travis\Xerox\Middleware',
```

Open ``config/app.php`` and register the provider:

```php
'Travis\Xerox\Provider',
```

## Config

This package is designed to use config files:

```bash
$ php artisan vender:publish
```

Then edit ``config/xerox.php`` as needed.

## Usage

After installation, pages are being cached automatically.  Things to remember:

- You can set the cache cooldown via the config file.
- You can ignore certain URIs via the config file.
- Only ``GET`` requests with a response code of ``200`` are cached.

You should be good to go.