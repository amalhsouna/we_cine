<?php

namespace App\Controller;

use App\Service\MovieServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movie/autocomplete', name: 'movie_autocomplete')]
class SerachController extends AbstractController
{
    public function __invoke(Request $request, MovieServiceInterface $movieService): Response
    {
        $movies = $movieService->searchMovies($request->query->get('term', ''));

        return $this->json($movies);
    }
}
