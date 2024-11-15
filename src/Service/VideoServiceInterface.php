<?php

namespace App\Service;

use App\Entities\VideoList;

interface VideoServiceInterface
{
    public function getVideoList(int $idMovie): VideoList;
}
