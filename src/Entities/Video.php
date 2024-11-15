<?php

namespace App\Entities;

class Video
{
    private $id;

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $site;

    /**
     * @var int
     */
    private $size;
    /**
     * @var string
     */
    private $type;

    /**
     * @var bool
     */
    private $official;

    /**
     * @var string
     */
    private $publishedAt;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Video
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

    public function setName(string $name): Video
    {
        $this->name = $name;

        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): Video
    {
        $this->key = $key;

        return $this;
    }

    public function getSite(): string
    {
        return $this->site;
    }

    public function setSite(string $site): Video
    {
        $this->site = $site;

        return $this;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): Video
    {
        $this->size = $size;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): Video
    {
        $this->type = $type;

        return $this;
    }

    public function isOfficial(): bool
    {
        return $this->official;
    }

    public function setOfficial(bool $official): Video
    {
        $this->official = $official;

        return $this;
    }

    public function getPublishedAt(): string
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(string $publishedAt): Video
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }
}
