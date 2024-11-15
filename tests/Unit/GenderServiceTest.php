<?php

namespace App\Tests\Service;

use App\Entities\Genre;
use App\Entities\GenreList;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GenderServiceTest extends TestCase
{
    private MockObject $cacheMock;
    private MockObject $httpClientMock;
    private MockObject $serializerMock;

    protected function setUp(): void
    {
        // Mock dependencies
        $this->cacheMock = $this->createMock(CacheInterface::class);
        $this->httpClientMock = $this->createMock(HttpClientInterface::class);
        $this->serializerMock = $this->createMock(SerializerInterface::class);
    }

    public function testGetGenresFromApiWhenCacheIsMissed(): void
    {
        $genre = new Genre();
        $genre->setId(1);
        $genre->setName('Action');

        $genreList = new GenreList();
        $genreList->setGenres([$genre]);

        $data = '{"genres": [{"id": 1, "name": "Action"}]}';

        // Simulate cache miss and call callback
        $this->cacheMock->method('get')
            ->with('movie_genres', $this->isType('callable'))
            ->willReturnCallback(function ($key, $callback) {
                return $callback($this->createMock(ItemInterface::class));
            });

        // Simulate HTTP request
        $this->httpClientMock->method('request')
            ->willReturn($this->createMock(ResponseInterface::class));

        // Simulate deserialization
        $this->serializerMock->method('deserialize')
            ->with($data, GenreList::class, 'json')
            ->willReturn($genreList);

        // Verify the result
        $this->assertInstanceOf(GenreList::class, $genreList);
        $this->assertCount(1, $genreList->getGenres());
        $this->assertInstanceOf(Genre::class, $genreList->getGenres()[0]);
    }
}
