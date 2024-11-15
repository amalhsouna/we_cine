<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SerachTest extends WebTestCase
{
    private const FILTER_URL = '/movie/autocomplete';

    /**
     * @dataProvider searchTermProvider
     */
    public function testAutocomplete(string $searchTerm, int $expectedStatusCode): void
    {
        $client = static::createClient();

        $client->request('GET', self::FILTER_URL, ['term' => $searchTerm]);

        $this->assertResponseStatusCodeSame($expectedStatusCode);
    }

    public static function searchTermProvider(): array
    {
        return [
            ['Inception', 200],  // Recherche avec un terme courant (attendu OK)
            ['NonExistentMovie', 200],  // Recherche avec un terme inexistant (attendu OK)
            ['', 200],  // Recherche avec un terme vide (attendu OK)
        ];
    }
}
