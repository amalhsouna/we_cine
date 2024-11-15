<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieDetailTest extends WebTestCase
{
    private const FILTER_URL = '/movie/';

    /**
     * @dataProvider movieIdProvider
     */
    public function testMovieDetailsPage(int $movieId, string $expectedContent): void
    {
        $client = static::createClient();
        $client->request('GET', self::FILTER_URL.$movieId);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'text/html; charset=UTF-8');

        // Checks that the response content contains specific elements
        $responseContent = $client->getResponse()->getContent();
        $this->assertStringContainsString($expectedContent, $responseContent, 'The response should contain the expected movie or video data.');
    }

    public static function movieIdProvider(): array
    {
        return [
            [912649, 'Venom: The Last Dance'],
            [1118031, 'Apocalypse Z: The Beginning of the End'],
        ];
    }
}
