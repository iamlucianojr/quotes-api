<?php

declare(strict_types=1);

namespace App\Tests\Quote\Model;

use App\Quote\Model\Quote;
use PHPUnit\Framework\TestCase;

class QuoteTest extends TestCase
{
    public function testInitializingWithValidValues(): void
    {
        $quote = new Quote('John Doe', 'It is all about context');
        $this->assertEquals('John Doe', $quote->getAuthor());
        $this->assertEquals('It is all about context', $quote->getQuote());
        $this->assertEquals([
            'author' => 'John Doe',
            'quote' => 'It is all about context'
        ], $quote->toArray());
    }

    public function testInitializingFromArrayWithValidValues(): void
    {
        $quote = Quote::fromArray(['author' => 'John Doe', 'quote' => 'It is all about context']);
        $this->assertEquals('John Doe', $quote->getAuthor());
        $this->assertEquals('It is all about context', $quote->getQuote());
        $this->assertEquals([
            'author' => 'John Doe',
            'quote' => 'It is all about context'
        ], $quote->toArray());
    }
}
