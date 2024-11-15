<?php

namespace App\Service;

use App\Entities\GenreList;
use App\Service\Api\AbstractApiClient as ApiAbstractApiClient;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class GenderService extends ApiAbstractApiClient implements GenderServiceInterface
{
    public function __construct(
        protected CacheInterface $cache,
        protected HttpClientInterface $client,
        protected SerializerInterface $serializerInterface,
        protected LoggerInterface $logger,
        string $tmdbApiKey,
        string $tmdbApiUrl,
    ) {
        parent::__construct($client, $serializerInterface, $logger, $tmdbApiKey, $tmdbApiUrl);
    }

    public function getGenres(): GenreList
    {
        return $this->cache->get('movie_genres', function (ItemInterface $item) {
            $item->expiresAfter(86400); // 86400 secondes = 1 jour
            $data = $this->request('genre/movie/list', ['language' => 'en']);

            $this->logger->info('Genres stored in cache');

            return $this->serializerInterface->deserialize($data, GenreList::class, 'json');
        });
    }
}
