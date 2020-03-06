<?php

declare(strict_types=1);

namespace App\Quote\DataSource;

use App\Quote\Collection\QuoteCollection;
use App\Quote\Collection\QuoteCollectionInterface;

final class QuotesRestDataSource implements DataSourceInterface
{
    private array $data;

    private string $dataSourceUrl;

    public function __construct(string $dataSourceUrl)
    {
        $this->data = [];
        $this->dataSourceUrl = $dataSourceUrl;
    }

    public function getQuotes(): QuoteCollectionInterface
    {
        return QuoteCollection::fromArray([]);
    }
}
