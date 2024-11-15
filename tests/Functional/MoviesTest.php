<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MoviesTest extends WebTestCase
{
    private const FILTER_URL = '/movie';

    /**
     * @dataProvider movieFilterProvider
     */
    public function testMovieListFilter(array $queryParams): void
    {
        $client = static::createClient();
        $url = self::FILTER_URL.(empty($queryParams) ? '' : '?'.http_build_query($queryParams));

        $client->request('GET', $url);
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'text/html; charset=UTF-8');

        $responseContent = $client->getResponse()->getContent();
        $this->assertStringContainsString('<div class="card d-flex flex-row align-items-start">', $responseContent, 'The response should contain movie items.');
    }

    public static function movieFilterProvider(): array
    {
        return [
            'Filter with genres Drama and Comedy' => [
                'queryParams' => ['genres' => '18'], // Drame et Comédie
            ],
            'Filter without genres' => [
                'queryParams' => [], // empty genre
            ],
        ];
    }
}
