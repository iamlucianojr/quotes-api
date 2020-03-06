<?php

declare(strict_types=1);

namespace App\Quote\Model;

use Webmozart\Assert\Assert;

final class Quote implements QuoteInterface
{
    private string $author;
    private string $quote;

    public function __construct(
        string $author,
        string $quote
    ) {
        $this->author = $author;
        $this->quote = $quote;
    }

    public static function fromArray(array $data): self
    {
        Assert::keyExists($data, 'author');
        Assert::keyExists($data, 'quote');

        return new self($data['author'], $data['quote']);
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getQuote(): string
    {
        return $this->quote;
    }

    public function toArray(): array
    {
        return [
            'author' => $this->author,
            'quote' => $this->quote,
        ];
    }
}
