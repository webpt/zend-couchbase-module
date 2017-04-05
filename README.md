# webpt/zend-couchbase-module

Provides an abstract factory for instantiating named \CouchbaseBucket objects.

## Installation
```bash
composer require webpt/zend-couchbase-module
```

## Usage

The following snippet will produce a \CouchbaseBucket object for the `localhost` cluster `default` bucket:

```php
$bucket = $serviceLocator->get('couchbase.localhost.default');
```

See the module configuration for a functional sample configuration which can be copied into differently named and configured clusters and buckets.
Cluster configuration can be shared by buckets, but only the instantiated buckets will be shared in the service manager.

## Contributing
```
composer update && composer test:units
```

This library attempts to comply with [PSR-1][], [PSR-2][], and [PSR-4][]. If
you notice compliance oversights, please send a patch via pull request.

[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md
