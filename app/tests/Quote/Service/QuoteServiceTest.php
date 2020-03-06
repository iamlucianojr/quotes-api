<?php

declare(strict_types=1);

namespace App\Tests\Quote\Service;

use App\Collection\DataSourceCollection;
use App\Quote\DataSource\DummyDataSource;
use App\Quote\Repository\QuoteRepository;
use App\Quote\Service\QuoteService;
use App\Quote\Service\QuoteServiceInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\String\Slugger\AsciiSlugger;

final class QuoteServiceTest extends TestCase
{
    private QuoteServiceInterface $service;

    protected function setUp()
    {
        parent::setUp();
        $this->service = new QuoteService(
            $repository = new QuoteRepository(
                new DataSourceCollection([
                    new DummyDataSource([
                        [
                            'author' => 'Steve Jobs',
                            'quote' => 'Apple is the best'
                        ],
                        [
                            'author' => 'Steve Jobs',
                            'quote' => 'Bell Labs is the best'
                        ]

                    ])
                ]),
                new AsciiSlugger()
            )
        );
    }

    public function testGetQuotesGivenAuthorSlug(): void
    {
        $this->assertIsArray($this->service->getQuotes('steve-jobs'));
    }
}
