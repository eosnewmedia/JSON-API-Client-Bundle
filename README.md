JSON API Client Bundle
======================

The Symfony integration for [enm/json-api-client](https://eosnewmedia.github.io/JSON-API-Client/).

1. [Installation](#installation)
1. [Configuration](#configuration)
1. [Usage](#usage)

## Installation

```bash
composer require enm/json-api-client-bundle
```

It's recommended to install `kriswallsmith/buzz` as http-client and `nyholm/psr7` for http factories.

```sh
composer require kriswallsmith/buzz nyholm/psr7
```

You can also use any HTTP client which implements [PSR-18](https://www.php-fig.org/psr/psr-18/).

## Configuration

```php
<?php
// config/bundles.php
    return [
        // ...
         Enm\Bundle\JsonApi\Client\EnmJsonApiClientBundle::class =>['all'=>true],
        // ...
    ];
```

```yaml
enm_json_api_client:
    clients: # requires at least one element, the key will be your client name
        api: 'http://example.com/api'
```

## Usage

The bundle offers a private service (only used for dependency injection, not for direct calls via service container) for 
each configured client. The service name will be `enm.json_api_client.YOUR_CLIENT_NAME`.
