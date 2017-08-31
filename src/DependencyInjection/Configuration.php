<?php
declare(strict_types=1);

namespace Enm\Bundle\JsonApi\Client\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     * @throws \Exception
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('enm_json_api_client')->children();

        /** @var ArrayNodeDefinition $clients */
        $clients = $root->arrayNode('clients')
            ->useAttributeAsKey('name')
            ->requiresAtLeastOneElement()
            ->prototype('array');

        $client = $clients->addDefaultsIfNotSet()->children();
        $client->scalarNode('base_uri')
            ->isRequired()
            ->cannotBeEmpty()
            ->info('The base uri which should be used on api calls.');

        $client->scalarNode('http_client')
            ->defaultNull()
            ->info('The service id for the service which is an instance of HttpClientInterface and should be used for all requests with this client. Can be empty guzzle is configured and should be used.');


        $client->scalarNode('logger')
            ->defaultNull()
            ->info('The psr-3 compatible logger service which should be used by this api client');

        $http = $root->arrayNode('http_clients')
            ->addDefaultsIfNotSet()
            ->children();

        $http->scalarNode('guzzle')
            ->defaultNull()
            ->info('The guzzle http client service which should be used for the default http client (guzzle adapter).');

        $root->scalarNode('logger')
            ->defaultNull()
            ->info('The psr-3 compatible logger service which should be used by your api clients.');

        return $treeBuilder;
    }
}
