<?php declare(strict_types=1);
namespace Fingo\Bundle\PipedriveBundle\Services;

use Pipedrive\Client;

class PipedriveProvider implements PipedriveProviderInterface
{
    private ?Client $client = null;

    private string $apiToken;

    private string $clientId;

    private string $clientSecret;

    private string $redirectUri;

    public function __construct(
        string $clientId,
        string $clientSecret,
        string $redirectUri,
        string $apiToken
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;
        $this->apiToken = $apiToken;
    }

    public function getClient(): Client
    {
        if ($this->client === null) {
            $this->client = new Client($this->clientId, $this->clientSecret, $this->redirectUri, $this->apiToken);
        }

        return $this->client;
    }
}