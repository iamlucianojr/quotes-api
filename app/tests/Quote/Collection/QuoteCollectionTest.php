<?php

declare(strict_types=1);

namespace App\Tests\Quote\Collection;

use App\Quote\Collection\QuoteCollection;
use App\Quote\Model\Quote;
use PHPUnit\Framework\TestCase;

final class QuoteCollectionTest extends TestCase
{
    public function testInitializingFromArrayWithValidValues(): void
    {
        $quoteCollection = QuoteCollection::fromArray([
            [
                'author' => 'Ewa Sandlers',
                'quote' => 'The answer for everything is 42',
            ],
        ]);

        $this->assertCount(1, $quoteCollection->items());
        $this->assertEquals(1, $quoteCollection->count());
        $this->assertIsArray($quoteCollection->toArray());
    }

    public function testInitializingFromItemsWithValidValues(): void
    {
        $quoteOne = new Quote('Kent Beck', 'I\'m not a great programmer; I\'m just a good programmer with great habits.');
        $quoteTwo = new Quote('Kent Beck', 'Do The Simplest Thing That Could Possibly Work');
        $quoteCollection = QuoteCollection::fromItems($quoteOne, $quoteTwo);

        $this->assertCount(2, $quoteCollection->items());
        $this->assertEquals(2, $quoteCollection->count());
        $this->assertIsArray($quoteCollection->toArray());
    }
}
