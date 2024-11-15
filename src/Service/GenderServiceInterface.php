<?php

namespace App\Service;

use App\Entities\GenreList;

interface GenderServiceInterface
{
    public function getGenres(): GenreList;
}
