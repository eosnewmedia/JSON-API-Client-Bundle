<?php
declare(strict_types=1);

namespace Enm\Bundle\JsonApi\Client\Tests;

use Enm\Bundle\JsonApi\Client\DependencyInjection\EnmJsonApiClientExtension;
use Enm\Bundle\JsonApi\Client\EnmJsonApiClientBundle;
use Enm\JsonApi\Client\JsonApiClient;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class EnmJsonApiClientBundleTest extends TestCase
{
    public function testConfigurationWithDefaultClient(): void
    {
        $container = new ContainerBuilder();
        $container->autowire(Client::class);
        $container->setAlias(ClientInterface::class, Client::class);

        (new EnmJsonApiClientExtension())->load(
            [
                'enm_json_api_client' => [
                    'clients' => [
                        'test' => [
                            'base_uri' => 'http://example.com/api'
                        ],
                        'api' => [
                            'base_uri' => 'http://example.com/secondApi',
                        ]
                    ],
                ]
            ],
            $container
        );

        (new EnmJsonApiClientBundle())->build($container);

        self::assertTrue($container->hasDefinition('enm.json_api_client.test'));
        self::assertEquals(JsonApiClient::class, $container->getDefinition('enm.json_api_client.test')->getClass());
        try {
            $container->compile();
        } catch (\Exception $e) {
            self::fail($e->getMessage());
        }
    }
}
