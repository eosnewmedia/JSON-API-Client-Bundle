<?php
declare(strict_types=1);

namespace Enm\Bundle\JsonApi\Client\Tests;

use Enm\Bundle\JsonApi\Client\JsonApiClientRegistry;
use Enm\JsonApi\Client\JsonApiClient;
use PHPUnit\Framework\TestCase;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class JsonApiClientRegistryTest extends TestCase
{

    public function testRegistry()
    {
        $registry = new JsonApiClientRegistry();
        /** @var JsonApiClient $client */
        $client = $this->createMock(JsonApiClient::class);
        $registry->addApiClient('test', $client);
        self::assertInstanceOf(JsonApiClient::class, $registry->apiClient('test'));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testMissingClient()
    {
        (new JsonApiClientRegistry())->apiClient('test');
    }
}
