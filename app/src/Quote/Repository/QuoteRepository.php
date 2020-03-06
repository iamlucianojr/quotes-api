<?php

declare(strict_types=1);

namespace App\Quote\Repository;

use App\Collection\DataSourceCollection;
use App\Quote\DataSource\DataSourceInterface;
use App\Quote\Model\QuoteInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\String\UnicodeString;

final class QuoteRepository implements QuoteRepositoryInterface
{
    private DataSourceCollection $dataSourceCollection;

    private SluggerInterface $slugger;

    public function __construct(
        DataSourceCollection $dataSourceCollection,
        SluggerInterface $slugger
    ) {
        $this->dataSourceCollection = $dataSourceCollection;
        $this->slugger = $slugger;
    }

    public function findByCriteria(array $criteria): ?array
    {
        $quotes = [];
        foreach ($this->fetchAll() as $quote) {
            if ($this->isSameAuthor($criteria, $quote)) {
                $quotes[] = $quote;
            }
        }

        return $quotes;
    }

    private function isSameAuthor(array $criteria, QuoteInterface $quote): bool
    {
        return $this->getAuthorSlug($quote->getAuthor()) === $this->getAuthorSlug($criteria['author']);
    }

    private function getAuthorSlug(string $author): string
    {
        return (new UnicodeString($this->slugger->slug($author)->toString()))->trim()->lower()->toString();
    }

    public function fetchAll(): ?array
    {
        $quotesCollection = [];
        foreach ($this->dataSourceCollection->all() as $dataSource) {
            if (!$dataSource instanceof DataSourceInterface) {
                continue;
            }

            if (empty($dataSource->getQuotes()->items())) {
                continue;
            }

            foreach ($dataSource->getQuotes()->items() as $quote) {
                if (!$quote instanceof QuoteInterface) {
                    continue;
                }

                $quotesCollection[] = $quote;
            }
        }

        return $quotesCollection;
    }
}
