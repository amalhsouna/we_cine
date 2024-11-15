<?php

namespace App\Entities;

class VideoList implements \IteratorAggregate
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var array<Video>
     */
    private $results = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): VideoList
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Video[]
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * @param Video[] $results
     */
    public function setResults(array $results): VideoList
    {
        $this->results = $results;

        return $this;
    }

    public function first(): ?Video
    {
        $first = reset($this->results);

        return false !== $first ? $first : null;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->results);
    }
}
