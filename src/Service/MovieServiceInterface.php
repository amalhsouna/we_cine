<?php

namespace App\Service;

use App\Entities\Movie;
use App\Entities\MovieList;

interface MovieServiceInterface
{
    public function getPopularFilms(): MovieList;

    public function getMovieList(?array $genreIds): MovieList;

    public function searchMovies(string $query): MovieList;

    public function getMovieById(int $idMovie): Movie;
}
