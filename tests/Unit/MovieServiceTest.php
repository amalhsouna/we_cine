<?php

namespace App\Tests\Service;

use App\Entities\Movie;
use App\Entities\MovieList;
use App\Service\MovieService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class MovieServiceTest extends TestCase
{
    private MovieService $movieService;
    private MockObject $httpClientMock;
    private MockObject $serializerMock;

    protected function setUp(): void
    {
        // Dependances Mock
        $this->httpClientMock = $this->createMock(HttpClientInterface::class);
        $this->serializerMock = $this->createMock(SerializerInterface::class);

        $this->movieService = new MovieService(
            $this->createMock(HttpClientInterface::class),
            $this->createMock(SerializerInterface::class),
            $this->createMock(LoggerInterface::class),
            'fake-api-key',
            ''
        );
    }

    public function testGetPopularFilms(): void
    {
        $mockData = '{"results": [{"id": 1, "title": "Popular Movie"}]}';
        $movieList = $this->createMovieListMock(1, 'movie-test');

        $responseMock = $this->createResponseMock($mockData);

        $this->httpClientMock
            ->method('request')
            ->with('movie/popular')
            ->willReturn($responseMock);

        $this->serializerMock
            ->method('deserialize')
            ->with($mockData, MovieList::class, 'json')
            ->willReturn($movieList);

        $this->assertInstanceOf(MovieList::class, $movieList);
    }

    public function testGetMovieList(): void
    {
        $filters = ['genre' => 'comedy'];
        $mockData = '{"results": [{"id": 1, "title": "Comedy Movie"}]}';
        $movieList = $this->createMovieListMock(1, 'movie-test2');

        $responseMock = $this->createResponseMock($mockData);

        $this->httpClientMock
            ->method('request')
            ->with('discover/movie', $filters)
            ->willReturn($responseMock);

        $this->serializerMock
            ->method('deserialize')
            ->with($mockData, MovieList::class, 'json')
            ->willReturn($movieList);

        $this->assertInstanceOf(MovieList::class, $movieList);
    }

    public function testSearchMovies(): void
    {
        $query = 'Inception';
        $mockData = '{"results": [{"id": 1, "title": "Inception"}]}';
        $movieList = $this->createMovieListMock(1, 'movie-test-search');

        $responseMock = $this->createResponseMock($mockData);

        $this->httpClientMock
            ->method('request')
            ->with('search/movie', ['query' => $query])
            ->willReturn($responseMock);

        $this->serializerMock
            ->method('deserialize')
            ->with($mockData, MovieList::class, 'json')
            ->willReturn($movieList);

        $this->assertInstanceOf(MovieList::class, $movieList);
    }

    public function testGetMovieById(): void
    {
        $movieId = 1;
        $mockData = '{"id": 1, "title": "Movie Title"}';
        $movie = $this->createMovieMock($movieId, 'movie-test-id');

        $responseMock = $this->createResponseMock($mockData);

        $this->httpClientMock
            ->method('request')
            ->with("movie/$movieId")
            ->willReturn($responseMock);

        $this->serializerMock
            ->method('deserialize')
            ->with($mockData, Movie::class, 'json')
            ->willReturn($movie);

        $this->assertInstanceOf(Movie::class, $movie);
    }

    private function createMovieListMock(int $id, string $posterPath): MovieList
    {
        $movie = $this->createMovieMock($id, $posterPath);
        $movieList = new MovieList();
        $movieList->setResults([$movie]);

        return $movieList;
    }

    private function createMovieMock(int $id, string $posterPath): Movie
    {
        $movie = new Movie();
        $movie->setId($id);
        $movie->setPosterPath($posterPath);

        return $movie;
    }

    private function createResponseMock(string $mockData): MockObject
    {
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getContent')->willReturn($mockData);

        return $responseMock;
    }
}
