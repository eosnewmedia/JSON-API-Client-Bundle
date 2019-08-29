<?php
declare(strict_types=1);

namespace Enm\Bundle\JsonApi\Client\DependencyInjection;

use Enm\JsonApi\Client\JsonApiClient;
use Enm\JsonApi\Serializer\Deserializer;
use Enm\JsonApi\Serializer\DocumentDeserializerInterface;
use Enm\JsonApi\Serializer\DocumentSerializerInterface;
use Enm\JsonApi\Serializer\Serializer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;
use Throwable;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class EnmJsonApiClientExtension extends ConfigurableExtension
{
    /**
     * @param array $mergedConfig
     * @param ContainerBuilder $container
     * @throws Throwable
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $container->autowire(Serializer::class)->setPublic(false);
        $container->setAlias(DocumentSerializerInterface::class, Serializer::class)->setPublic(false);

        $container->autowire(Deserializer::class)->setPublic(false);
        $container->setAlias(DocumentDeserializerInterface::class, Deserializer::class)->setPublic(false);

        foreach ($mergedConfig['clients'] as $name => $baseUri) {
            $client = $container->autowire('enm.json_api_client.' . $name, JsonApiClient::class);
            $client->addArgument($baseUri);
            $client->setPublic(false);
        }
    }
}
