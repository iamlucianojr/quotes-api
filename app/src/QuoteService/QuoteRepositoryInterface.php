<?php

declare(strict_types=1);

namespace App\QuoteService;

interface QuoteRepositoryInterface
{
    public function findByCriteria(array $criteria): ?array;
}
