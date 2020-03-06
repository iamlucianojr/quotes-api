<?php

declare(strict_types=1);

namespace App\Quote\Model;

interface QuoteInterface
{
    public function getAuthor(): string;

    public function getQuote(): string;

    public static function fromArray(array $items): QuoteInterface;

    public function toArray(): array;
}
