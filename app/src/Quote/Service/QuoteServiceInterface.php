<?php

declare(strict_types=1);

namespace App\Quote\Service;

interface QuoteServiceInterface
{

    public function getQuotes(string $author, int $limit = 1): array;

    public function getQuotesFormatted(string $author, int $limit = 1): array;
}
