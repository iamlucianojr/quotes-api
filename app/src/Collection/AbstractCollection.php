<?php

declare(strict_types=1);

namespace App\Collection;

abstract class AbstractCollection
{
    protected iterable $items;

    public function __construct(iterable $items = [])
    {
        $this->items = $items;
    }

    public function all(): array
    {
        $items = $this->items;

        if (is_array($items)) {
            return $items;
        }

        return iterator_to_array($items);
    }
}
