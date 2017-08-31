<?php
declare(strict_types=1);

namespace Enm\Bundle\JsonApi\Client\DependencyInjection;

use Enm\Bundle\JsonApi\Client\JsonApiClientRegistry;
use Enm\JsonApi\Client\HttpClient\GuzzleAdapter;
use Enm\JsonApi\Client\JsonApiClient;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class EnmJsonApiClientExtension extends ConfigurableExtension
{
    const GUZZLE_ADAPTER_SERVICE = 'enm.json_api_client.http.guzzle';

    /**
     * @param array $mergedConfig
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        // configure default client if guzzle service is available via configuration
        $guzzleService = (string)$mergedConfig['http_clients']['guzzle'];
        if ($guzzleService !== '' && $container->hasDefinition($guzzleService)) {
            $guzzleAdapter = new Definition(
                GuzzleAdapter::class,
                [
                    new Reference($guzzleService)
                ]
            );

            $guzzleAdapter->setPublic(false);
            $guzzleAdapter->setLazy(true);

            $container->setDefinition(self::GUZZLE_ADAPTER_SERVICE, $guzzleAdapter);
        }

        // configure a json api client for each configuration
        $clients = (array)$mergedConfig['clients'];
        $logger = (string)$mergedConfig['logger'];
        foreach ($clients as $name => $configuration) {
            $adapter = (string)$configuration['http_client'];
            if ($adapter === '') {
                $adapter = self::GUZZLE_ADAPTER_SERVICE;
            }

            $client = new Definition(JsonApiClient::class,
                [
                    (string)$configuration['base_uri'],
                    new Reference($adapter)
                ]
            );

            $client->setPublic(false);
            $client->setLazy(true);
            $client->addTag('json_api_client.client', ['client_name' => $name]);

            $clientLogger = (string)$configuration['logger'];
            if ($clientLogger !== '' && $container->hasDefinition($clientLogger)) {
                $client->addMethodCall('setLogger', [new Reference($clientLogger)]);
            } elseif ($logger !== '' && $container->hasDefinition($logger)) {
                $client->addMethodCall('setLogger', [new Reference($logger)]);
            }

            $container->setDefinition('enm.json_api_client.clients.' . $name, $client);
        }

        $container->setDefinition(
            'enm.json_api_client.clients',
            new Definition(JsonApiClientRegistry::class)
        );
    }
}
