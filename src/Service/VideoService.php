<?php

namespace App\Service;

use App\Entities\VideoList;
use App\Service\Api\AbstractApiClient;

final class VideoService extends AbstractApiClient implements VideoServiceInterface
{
    public function getVideoList(int $movieId): VideoList
    {
        try {
            $data = $this->request("movie/$movieId/videos");

            return $this->serializerInterface->deserialize($data, VideoList::class, 'json');
        } catch (\Exception $e) {
            return new VideoList();
        }
    }
}
