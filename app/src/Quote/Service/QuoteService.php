<?php

declare(strict_types=1);

namespace App\Quote\Service;

use App\Quote\Model\QuoteInterface;
use App\Quote\Presenter\ShoutPresenterWrapper;
use App\Quote\Repository\QuoteRepositoryInterface;

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

        if (empty($quotes)) {
            return [];
        }

        return $quotes;
    }

    public function getQuotesFormatted(string $author, int $limit = 1): array
    {
        return $this->transformQuotesUsingPresenterWrapper($this->getQuotes($author, $limit));
    }

    private function transformQuotesUsingPresenterWrapper(array $quotes): array
    {
        return array_map(static function (QuoteInterface $quote) {
            return (new ShoutPresenterWrapper($quote))->toArray();
        }, $quotes);
    }
}
