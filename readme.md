# Xerox

A Laravel PHP package for automatic page caching.

- Updated for Laravel 5 on May 23, 2015.

## Config

You can use either the ``.env`` or config file method of settings variables.

When using the ``.env`` method:

```php
XEROX_COOLDOWN = 5,
XEROX_IGNORE = [
	'test',
],
```

## Usage

Add the middleware to your ``bootstrap/app.php`` file:

```php
$app->middleware([
	'Travis\\Xerox\\Middleware',
]);
```

Things to consider:

- You can set the cache time via the config file.
- You can ignore certain URIs via the config file.
- Only ``GET`` requests with a response code of ``200`` are cached.

You should be good to go.