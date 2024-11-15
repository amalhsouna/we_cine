<?php

namespace App\Controller;

use App\Service\MovieServiceInterface;
use App\Service\VideoServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movie/{movieId<\d+>}', name: 'movie_view')]
class MovieDetailController extends AbstractController
{
    public function __construct(
        private MovieServiceInterface $movieService,
        private VideoServiceInterface $videoService,
    ) {
    }

    public function __invoke(int $movieId): Response
    {
        $movie = $this->movieService->getMovieById($movieId);
        $video = $this->videoService->getVideoList($movieId)->first();

        return $this->render('movies/movie_details.html.twig', [
            'movie' => $movie,
            'video' => $video,
        ]);
    }
}
