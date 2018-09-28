JSON API Client Bundle
======================

[![Build Status](https://travis-ci.org/eosnewmedia/JSON-API-Client-Bundle.svg?branch=master)](https://travis-ci.org/eosnewmedia/JSON-API-Client-Bundle)

The Symfony integration for [enm/json-api-client](https://eosnewmedia.github.io/JSON-API-Client/).

1. [Installation](#installation)
1. [Configuration](#configuration)
1. [Usage](#usage)

## Installation

```bash
composer require enm/json-api-client
```

If you want to use the default http client (guzzle adapter) you could use
```bash
composer require eightpoints/guzzle-bundle
```
or
```bash
composer require e-moe/guzzle6-bundle
```

If you want to use the buzz curl adapter you should
```bash
composer require kriswallsmith/buzz
```
register an instance of `Buzz\Client\Curl` as service and configure your client to use `Enm\JsonApi\Client\HttpClient\BuzzCurlAdapter`.

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
        api:
            base_uri: 'http://example.com/api' # the base uri used with this api client
            http_client: 'your_client_service' # optional, the service id of your service which implements Enm\JsonApi\Client\HttpClient\HttpClientInterface"; if not configured the bundle tries to use guzzle as default
```

## Usage

The bundle offers a private service (only used for dependency injection, not for direct calls via service container) for 
each configured client. The service name will be `enm.json_api_client.YOUR_CLIENT_NAME`.
