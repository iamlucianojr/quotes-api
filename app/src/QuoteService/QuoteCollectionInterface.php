<?php

namespace App\QuoteService;

interface QuoteCollectionInterface
{
    public static function fromArray(array $items): QuoteCollection;

    public static function fromItems(QuoteInterface ...$items): QuoteCollection;

    public static function emptyList(): QuoteCollection;

    public function push(QuoteInterface $item): QuoteCollection;

    public function pop(): QuoteCollection;

    public function first(): ?QuoteInterface;

    public function last(): ?QuoteInterface;

    public function contains(QuoteInterface $item): bool;

    public function items(): array;

    public function toArray(): array;

    public function count(): int;
}
