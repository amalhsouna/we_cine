<?php

namespace App\Entities;

class Genre
{
    private $id;

    /**
     * @var string
     */
    private $name;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Genre
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Genre
    {
        $this->name = $name;

        return $this;
    }
}
