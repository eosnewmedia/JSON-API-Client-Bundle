<?php
declare(strict_types=1);

namespace Enm\Bundle\JsonApi\Client\DependencyInjection;

use Enm\JsonApi\Client\HttpClient\BuzzCurlAdapter;
use Enm\JsonApi\Client\HttpClient\GuzzleAdapter;
use Enm\JsonApi\Client\JsonApiClient;
use Enm\JsonApi\Serializer\Deserializer;
use Enm\JsonApi\Serializer\DocumentDeserializerInterface;
use Enm\JsonApi\Serializer\DocumentSerializerInterface;
use Enm\JsonApi\Serializer\Serializer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class EnmJsonApiClientExtension extends ConfigurableExtension
{
    /**
     * @param array $mergedConfig
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $container->autowire(Serializer::class)->setPublic(false);
        $container->setAlias(DocumentSerializerInterface::class, Serializer::class)->setPublic(false);

        $container->autowire(Deserializer::class)->setPublic(false);
        $container->setAlias(DocumentDeserializerInterface::class, Deserializer::class)->setPublic(false);

        $container->autowire(GuzzleAdapter::class)->setPublic(false);
        $container->autowire(BuzzCurlAdapter::class)->setPublic(false);

        foreach ($mergedConfig['clients'] as $name => $config) {
            $client = $container->autowire('enm.json_api_client.' . $name, JsonApiClient::class);
            $client->addArgument($config['base_uri']);
            $client->addArgument(new Reference($config['http_client']));
            $client->setPublic(false);
        }
    }
}
