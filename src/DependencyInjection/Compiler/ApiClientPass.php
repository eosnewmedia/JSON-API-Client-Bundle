<?php
declare(strict_types=1);

namespace Enm\Bundle\JsonApi\Client\DependencyInjection\Compiler;

use Enm\Bundle\JsonApi\Client\JsonApiClientRegistry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class ApiClientPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('enm.json_api_client.clients')) {
            $clientRegistry = $container->getDefinition('enm.json_api_client.clients');
            if ($clientRegistry->getClass() === JsonApiClientRegistry::class) {
                $clients = $container->findTaggedServiceIds('json_api_client.client');
                foreach ($clients as $id => $tags) {
                    foreach ((array)$tags as $tag => $config) {
                        if (array_key_exists('client_name', $config)) {
                            $clientRegistry->addMethodCall(
                                'addApiClient',
                                [
                                    $config['client_name'],
                                    new Reference($id)
                                ]
                            );
                        }
                    }
                }
            }
        }
    }
}
