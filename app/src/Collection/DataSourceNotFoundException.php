<?php

declare(strict_types=1);

namespace App\Collection;

use RuntimeException;
use Throwable;

class DataSourceNotFoundException extends RuntimeException
{
    public function __construct(string $dataSource, Throwable $previous = null)
    {
        $message = sprintf('The data source "%s" was not found or does not exist.', $dataSource);

        parent::__construct($message, 0, $previous);
    }
}
