<?php

declare(strict_types=1);

namespace App\Quote\DataSource;

use App\Quote\Collection\QuoteCollection;
use App\Quote\Collection\QuoteCollectionInterface;

final class DummyDataSource implements DataSourceInterface
{
    private QuoteCollectionInterface $quotes;

    public function __construct(array $data = [])
    {
        if (empty($data)) {
            $data = [
                [
                    'author' => 'Dreamer',
                    'quote' => 'Everything is possible',
                ],
                [
                    'author' => 'AI',
                    'quote' => 'ETL: Extract, Transform and Load',
                ],
            ];
        }

        $this->quotes = QuoteCollection::fromArray($data);
    }

    public function getQuotes(): QuoteCollectionInterface
    {
        return $this->quotes;
    }
}
