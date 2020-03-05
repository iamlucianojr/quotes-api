<?php

declare(strict_types=1);

namespace App\DataSource;

interface DataSourceInterface
{
    public function getQuotes(): ?array;
}
