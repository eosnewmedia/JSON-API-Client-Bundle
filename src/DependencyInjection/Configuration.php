<?php
declare(strict_types=1);

namespace Enm\Bundle\JsonApi\Client\DependencyInjection;

use Enm\JsonApi\Client\HttpClient\GuzzleAdapter;
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
            ->defaultValue(GuzzleAdapter::class)
            ->info('The http client for this api client instance.');

        return $treeBuilder;
    }
}
