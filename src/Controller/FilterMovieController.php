<?php

namespace App\Controller;

use App\Service\MovieServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movie', name: 'movie_list')]
class FilterMovieController extends AbstractController
{
    public function __invoke(Request $request, MovieServiceInterface $movieService): Response
    {
        $genreIds = $request->query->get('genres', '');

        $filters = [
            'with_genres' => $genreIds,
        ];

        $movies = $movieService->getMovieList($filters);

        return $this->render('movies/list_movies.html.twig', [
            'movies' => $movies,
        ]);
    }
}
