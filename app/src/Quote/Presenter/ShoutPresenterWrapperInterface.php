<?php

declare(strict_types=1);

namespace App\Quote\Presenter;

interface ShoutPresenterWrapperInterface
{
    public function getAuthor(): string;

    public function getQuote(): string;

    public function toArray(): array;
}
