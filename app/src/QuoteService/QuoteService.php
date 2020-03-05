<?php

declare(strict_types=1);

namespace App\QuoteService;

final class QuoteService implements QuoteServiceInterface
{
    private QuoteRepositoryInterface $repository;

    public function __construct(
        QuoteRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function getQuotes(string $author, int $limit = 1): array
    {
        $quotes = $this->repository->findByCriteria([
            'author' => trim($author),
            'limit' => $limit
        ]);

        return $quotes;
    }
}
