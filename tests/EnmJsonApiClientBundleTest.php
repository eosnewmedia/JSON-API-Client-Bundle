<?php
declare(strict_types=1);

namespace Enm\Bundle\JsonApi\Client\Tests;

use Enm\Bundle\JsonApi\Client\DependencyInjection\EnmJsonApiClientExtension;
use Enm\Bundle\JsonApi\Client\EnmJsonApiClientBundle;
use Enm\JsonApi\Client\JsonApiClient;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class EnmJsonApiClientBundleTest extends TestCase
{
    public function testConfigurationWithDefaultClient()
    {
        $container = new ContainerBuilder();
        $container->setDefinition('guzzle', new Definition(Client::class));
        $container->setDefinition('logger', new Definition(NullLogger::class));

        (new EnmJsonApiClientExtension())->load(
            [
                'enm_json_api_client' => [
                    'clients' => [
                        'test' => [
                            'base_uri' => 'http://example.com'
                        ]
                    ],
                    'http_clients' => [
                        'guzzle' => 'guzzle'
                    ],
                    'logger' => 'logger'
                ]
            ],
            $container
        );

        (new EnmJsonApiClientBundle())->build($container);

        $container->compile();

        self::assertFalse($container->has('enm.json_api_client.clients.test')); // private service should not be available
        self::assertInstanceOf(
            JsonApiClient::class,
            $container->get('enm.json_api_client.clients')->apiClient('test')
        );
    }
}
