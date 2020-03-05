<?php

declare(strict_types=1);

namespace App\QuoteService;

use App\Shared\ValueObjectInterface;
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

    public static function emptyList(): self
    {
        return new self();
    }

    public function push(QuoteInterface $item): self
    {
        $copy = clone $this;
        $copy->items[] = $item;

        return $copy;
    }

    public function pop(): self
    {
        $copy = clone $this;
        array_pop($copy->items);

        return $copy;
    }

    public function first(): ?QuoteInterface
    {
        return $this->items[0] ?? null;
    }

    public function last(): ?QuoteInterface
    {
        if (0 === count($this->items)) {
            return null;
        }

        return $this->items[count($this->items) - 1];
    }

    public function contains(QuoteInterface $item): bool
    {
        foreach ($this->items as $existingItem) {
            if ($existingItem->equals($item)) {
                return true;
            }
        }

        return false;
    }

    public function equals(QuoteInterface $other): bool
    {
        if (!$other instanceof self) {
            return false;
        }

        return $this->toArray() === $other->toArray();
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

    public function __toString(): string
    {
        return (string)json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }

    public function count(): int
    {
        return count($this->items);
    }
}
