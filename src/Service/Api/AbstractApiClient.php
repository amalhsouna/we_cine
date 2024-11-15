<?php

namespace App\Service\Api;

use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractApiClient
{
    public function __construct(protected HttpClientInterface $client,
        protected SerializerInterface $serializerInterface,
        protected LoggerInterface $logger,
        protected string $tmdbApiKey, protected string $tmdbApiUrl)
    {
    }

    // Generic method to make a request to the API client
    protected function request(string $endpoint, array $query = [], string $method = 'GET'): string
    {
        try {
            $response = $this->client->request($method, "{$this->tmdbApiUrl}/$endpoint", [
                'query' => $query,
                'headers' => [
                    'Authorization' => 'Bearer '.$this->tmdbApiKey,
                    'accept' => 'application/json',
                ],
            ]);

            if ($response->getStatusCode() >= 400) {
                $this->logger->alert($response->getContent());

                return '';
            }
        } catch (ClientExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface $e) {
            $this->logger->alert($e->getResponse()->getContent(false));
        } catch (TransportExceptionInterface $e) {
            $this->logger->alert('Erreur appel api: '.$this->tmdbApiUrl / $endpoint.' '.$e->getMessage());
        }

        return $response->getContent();
    }
}
