<?php

declare(strict_types=1);

namespace App\Dto;

final class ShoudRequestDto
{
    private string $author;
    private int $limit;

    public function __construct()
    {
        $this->author = '';
        $this->limit = 0;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }
}
