<?php

declare(strict_types=1);

namespace App\QuoteService;

use App\Collection\DataSourceCollection;
use App\DataSource\DataSourceInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

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
        foreach ($this->dataSourceCollection->all() as $dataSource) {
            if (!$dataSource instanceof DataSourceInterface) {
                continue;
            }

            foreach ($dataSource->getQuotes() as $quote) {
                if (!$quote instanceof QuoteInterface) {
                    continue;
                }

                if ($this->isSameAuthor($criteria, $quote)) {
                    $quotes[] = $quote;
                }
            }
        }

        return $quotes;
    }

    private function isSameAuthor(array $criteria, QuoteInterface $quote): bool
    {
        return strtolower($this->slugger->slug($quote->getAuthor())->toString()) === strtolower(trim($criteria['author']));
    }
}
