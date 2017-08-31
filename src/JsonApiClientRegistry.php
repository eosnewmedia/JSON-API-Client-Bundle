<?php
declare(strict_types=1);

namespace Enm\Bundle\JsonApi\Client;

use Enm\JsonApi\Client\JsonApiClient;

/**
 * @author Philipp Marien <marien@eosnewmedia.de>
 */
class JsonApiClientRegistry
{
    /**
     * @var JsonApiClient[]
     */
    private $clients = [];

    /**
     * @param string $name
     * @param JsonApiClient $apiClient
     *
     * @return void
     */
    public function addApiClient(string $name, JsonApiClient $apiClient)
    {
        $this->clients[$name] = $apiClient;
    }

    /**
     * @param string $name
     *
     * @return JsonApiClient
     * @throws \RuntimeException
     */
    public function apiClient(string $name): JsonApiClient
    {
        if (array_key_exists($name, $this->clients)) {
            return $this->clients[$name];
        }

        throw new \RuntimeException('No api client available for "' . $name . '"');
    }
}
