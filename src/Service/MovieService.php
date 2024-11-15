<?php

namespace App\Service;

use App\Entities\Movie;
use App\Entities\MovieList;
use App\Service\Api\AbstractApiClient as ApiAbstractApiClient;

final class MovieService extends ApiAbstractApiClient implements MovieServiceInterface
{
    public function getPopularFilms(): MovieList
    {
        $data = $this->request('movie/popular');

        return $this->serializerInterface->deserialize($data, MovieList::class, 'json');
    }

    public function getMovieList(?array $filters): MovieList
    {
        $movies = $this->request('discover/movie', $filters);

        return $this->serializerInterface->deserialize($movies, MovieList::class, 'json');
    }

    public function searchMovies(string $query): MovieList
    {
        $queryParams = [
            'query' => $query,
        ];

        $moviesData = $this->request('search/movie', $queryParams) ?? [];

        return $this->serializerInterface->deserialize($moviesData, MovieList::class, 'json');
    }

    public function getMovieById(int $movieId): Movie
    {
        try {
            $data = $this->request("movie/$movieId");

            return $this->serializerInterface->deserialize($data, Movie::class, 'json');
        } catch (\Exception $e) {
            return null;
        }
    }
}
