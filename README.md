JSON API Client Bundle
======================

[![Build Status](https://travis-ci.org/eosnewmedia/JSON-API-Client-Bundle.svg?branch=master)](https://travis-ci.org/eosnewmedia/JSON-API-Client-Bundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/400fb709-5390-4dd7-9335-3a78a916e053/mini.png)](https://insight.sensiolabs.com/projects/400fb709-5390-4dd7-9335-3a78a916e053)

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

## Configuration
First enable the bundle in your `AppKernel`:

```php
public function registerBundles()
{
    $bundles = [
        // ...
        new Enm\Bundle\JsonApi\Client\EnmJsonApiClientBundle(),
    ];
    
    // ...
    
    return $bundles;
}
```

then configure your clients in your global config (`config.yml`):

```yaml
enm_json_api_client:
    clients: # requires at least one element, the key will be your client name
        api:
            base_uri: 'http://example.com/api' # the base uri used with this api client
            http_client: 'your_client_service' # optional, the service id of your service which implements Enm\JsonApi\Client\HttpClient\HttpClientInterface"; if not configured the bundle tries to use guzzle as default
            logger: 'logger' # optional, the psr-3 compatible logger service which should be used by this api client
    http_clients:
        guzzle: 'guzzle.client.api' # optional, the guzzle client (service id) which should be used by default (only needed if you want to use the default http client implementation in one of your api clients)
    logger: 'logger' # optional, the psr-3 compatible logger service which should be used by all your api clients (if not overwritten)
```

## Usage

The bundle offers a private service (only used for dependency injection, not for direct calling) for each configured
client. The service name will be `enm.json_api_client.clients.YOUR_CLIENT_NAME`.

The public service is `enm.json_api_client.clients` which is an instance of `Enm\Bundle\JsonApi\Client\JsonApiClientRegistry`.

```php
$clientRegistry = $container->get('enm.json_api_client.clients');
$clientRegistry->apiClient('YOUR_CLIENT_NAME')->createFetchRequest('resourceType', 'resourceId');
```
