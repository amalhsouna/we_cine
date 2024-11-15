<?php

namespace App\Tests\Functional;

use App\Entities\VideoList;
use App\Service\VideoServiceInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VideoServiceTest extends WebTestCase
{
    public function testGetVideoListWithValidMovieId(): void
    {
        $client = static::createClient();
        $videoService = $client->getContainer()->get(VideoServiceInterface::class);

        $movieId = 123;
        $videoList = $videoService->getVideoList($movieId);

        $this->assertInstanceOf(VideoList::class, $videoList);
    }
}
