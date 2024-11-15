<?php

namespace App\Controller;

use App\Service\GenderServiceInterface;
use App\Service\MovieServiceInterface;
use App\Service\VideoServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home')]
class MainController extends AbstractController
{
    public function __invoke(
        MovieServiceInterface $movieService,
        VideoServiceInterface $videoService,
        GenderServiceInterface $genderServiceInterface,
    ): Response {
        $genderList = $genderServiceInterface->getGenres();
        $popularMovies = $movieService->getPopularFilms();

        $featuredMovie = $popularMovies->first();
        $mainVideo = $videoService->getVideoList($featuredMovie->getId())->first();

        return $this->render('movies/index.html.twig', [
            'genres' => $genderList,
            'first_popular_movie' => $popularMovies->first() ?? null,  // Ensure the value exists
            'main_video' => $mainVideo,
            'movies' => $popularMovies,
        ]);
    }
}
