<?php

declare(strict_types=1);

namespace App\QuoteService;

interface QuoteInterface
{
    public static function fromArray(array $items);
    public function getAuthor(): string;
    public function getQuote(): string;
}
