<?php
declare(strict_types=1);

namespace Enm\Bundle\JsonApi\Client\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Throwable;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     * @throws Throwable
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('enm_json_api_client');
        $root = $treeBuilder->getRootNode()->children();

        $root->arrayNode('clients')
            ->useAttributeAsKey('name')
            ->requiresAtLeastOneElement()
            ->prototype('scalar')
            ->info('The base uri which should be used on api calls.');

        return $treeBuilder;
    }
}
