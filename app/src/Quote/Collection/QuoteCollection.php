<?php

declare(strict_types=1);

namespace App\Quote\Collection;

use App\Quote\Model\Quote;
use App\Quote\Model\QuoteInterface;
use Countable;

final class QuoteCollection implements Countable, QuoteCollectionInterface
{
    /** @var QuoteInterface[] */
    private array $items;

    public function __construct(QuoteInterface ...$items)
    {
        $this->items = $items;
    }

    public static function fromArray(array $items): self
    {
        return new self(...array_map(static function (array $items) {
            return Quote::fromArray($items);
        }, $items));
    }

    public static function fromItems(QuoteInterface ...$items): self
    {
        return new self(...$items);
    }

    public function items(): array
    {
        return $this->items;
    }

    public function toArray(): array
    {
        return array_map(static function (QuoteInterface $item) {
            return $item->toArray();
        }, $this->items);
    }

    public function count(): int
    {
        return count($this->items);
    }
}
