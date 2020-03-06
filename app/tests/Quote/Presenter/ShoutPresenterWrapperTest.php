<?php

declare(strict_types=1);

namespace App\Tests\Quote\Presenter;

use App\Quote\Model\Quote;
use App\Quote\Presenter\ShoutPresenterWrapper;
use PHPUnit\Framework\TestCase;

final class ShoutPresenterWrapperTest extends TestCase
{
    public function testAuthorGivenValidQuoteShouldReturnAuthorTitle(): void
    {
        $quote = new Quote('luciano-junior',
            'If you want to go fast, go alone. If you want to go far, go with others.');
        $presenterWrapper = new ShoutPresenterWrapper($quote);

        $this->assertEquals('Luciano Junior', $presenterWrapper->getAuthor());
    }

    public function testQuoteGivenValidQuoteShouldReturnQuoteWithExclamationMarkInTheEnd(): void
    {
        $quote = new Quote('phil-karlton',
            'There are only two hard things in Computer Science: cache invalidation and naming things.');
        $presenterWrapper = new ShoutPresenterWrapper($quote);

        $this->assertEquals('THERE ARE ONLY TWO HARD THINGS IN COMPUTER SCIENCE: CACHE INVALIDATION AND NAMING THINGS!',
            $presenterWrapper->getQuote()
        );
    }

    /**
     * @dataProvider textCollectionDataProvider
     *
     * @param string $author
     * @param string $text
     */
    public function testFormatterUsingQuotesCollection(string $author, string $text): void
    {
        $quote = new Quote($author, $text);
        $formatter = new ShoutPresenterWrapper($quote);
        $this->assertStringEndsWith('!', $formatter->getQuote());
        $this->assertStringContainsStringIgnoringCase(trim(substr($text, 0, -1)), substr($formatter->getQuote(), 0, -1));
    }


    public function textCollectionDataProvider(): array
    {
        $rawData = file_get_contents(__DIR__ . '/../../resources/quotes.json');
        $data = json_decode($rawData, true, 512, JSON_THROW_ON_ERROR);

        return $data['quotes'];
    }
}
