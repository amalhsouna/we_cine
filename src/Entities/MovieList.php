<?php

namespace App\Entities;

class MovieList implements \IteratorAggregate
{
    /**
     * @var int
     */
    private $page;

    /**
     * @var array<Movie>
     */
    private $results;

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): MovieList
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return Movie[]
     */
    public function getResults(): array
    {
        return $this->results;
    }

    /**
     * @param Movie[] $results
     */
    public function setResults(array $results): MovieList
    {
        $this->results = $results;

        return $this;
    }

    public function first(): ?Movie
    {
        $first = reset($this->results);

        return false !== $first ? $first : null;
    }

    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->results);
    }
}
