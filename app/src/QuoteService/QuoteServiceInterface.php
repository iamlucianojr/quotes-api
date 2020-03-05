<?php

namespace App\QuoteService;

interface QuoteServiceInterface
{
    public function getQuotes(string $author, int $limit = 1): array;
}
