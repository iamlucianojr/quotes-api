<?php

declare(strict_types=1);

namespace App\Quote\Repository;

interface QuoteRepositoryInterface
{
    public function fetchAll(): array;

    public function findByCriteria(array $criteria): ?array;
}
