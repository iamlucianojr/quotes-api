<?php

declare(strict_types=1);

namespace App\Quote\Presenter;

use App\Quote\Model\QuoteInterface;
use Symfony\Component\String\ByteString;

final class ShoutPresenterWrapper implements ShoutPresenterWrapperInterface
{
    private QuoteInterface $quote;

    public function __construct(QuoteInterface $quote)
    {
        $this->quote = $quote;
    }

    public function getAuthor(): string
    {
        return (new ByteString($this->quote->getAuthor()))->trim()->replace('-', ' ')->title(true)->toString();
    }

    public function getQuote(): string
    {
        return (new ByteString($this->quote->getQuote()))
            ->trim()
            ->upper()
            ->trimEnd('.')
            ->ensureEnd('!')
            ->toString();
    }

    public function toArray(): array
    {
        return [
            'author' => $this->getAuthor(),
            'quote' => $this->getQuote(),
        ];
    }
}
