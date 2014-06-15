# Xerox

A Laravel PHP package for automatic page caching.  Attaches to your ``before`` and ``after`` filters, so its easy.

### Provider

Register the service provider in your ``app/config/app.php`` file:

```php
'Travis\Xerox\Provider'
```

### Config

Copy the config file to ``app/config/packages/travis/xerox/config.php`` and input the necessary information.

## Usage

Modify your ``before`` and ``after`` filters:

```php
App::before(function($request)
{
    return Travis\Xerox::before($request);
});

App::after(function($request, $response)
{
    return Travis\Xerox::after($request, $response);
});
```

- You can ignore certain URIs from being cached via the config file.
- Only ``GET`` requests with a response code of ``200`` are cached.

You should be good to go.