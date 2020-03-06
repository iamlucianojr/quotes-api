<?php

declare(strict_types=1);

namespace App\Quote\DataSource;

use App\Quote\Collection\QuoteCollectionInterface;

interface DataSourceInterface
{
    public function getQuotes(): QuoteCollectionInterface;
}
