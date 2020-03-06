<?php

declare(strict_types=1);

namespace App\Quote\Collection;

use App\Quote\Model\QuoteInterface;

interface QuoteCollectionInterface
{
    public static function fromArray(array $items): QuoteCollection;

    public static function fromItems(QuoteInterface ...$items): QuoteCollection;

    public function items(): array;

    public function toArray(): array;
}
