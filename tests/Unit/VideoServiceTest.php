<?php

namespace App\Tests\Service;

use App\Entities\Video;
use App\Entities\VideoList;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class VideoServiceTest extends TestCase
{
    private MockObject $httpClientMock;
    private MockObject $serializerMock;

    protected function setUp(): void
    {
        // Mock dependencies
        $this->httpClientMock = $this->createMock(HttpClientInterface::class);
        $this->serializerMock = $this->createMock(SerializerInterface::class);
    }

    public function testGetVideoListReturnsVideoList(): void
    {
        $movieId = 123;
        $responseData = '{"results": [{"id": "1", "key": "xyz"}]}'; // Mocked response data
        $video = new Video();
        $video->setId(1);
        $video->setName('video-test');
        $video->setName('xyz');

        $videoList = new VideoList();
        $videoList->setResults([$video]);
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->method('getContent')
            ->willReturn($responseData); // Mocking the JSON response

        // Mock the request() method to return the mocked ResponseInterface
        $this->httpClientMock
            ->method('request')
            ->with('GET', "movie/$movieId/videos")
            ->willReturn($responseMock);

        // Mock the serializer to return a VideoList object
        $this->serializerMock
        ->method('deserialize')
        ->with($responseData, VideoList::class, 'json')
        ->willReturn($videoList);

        // Check that the result is an instance of VideoList
        $this->assertInstanceOf(VideoList::class, $videoList);
        $this->assertCount(1, $videoList->getResults());
        $this->assertInstanceOf(Video::class, $videoList->getResults()[0]);
    }
}
