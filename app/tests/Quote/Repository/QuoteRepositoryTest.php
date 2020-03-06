<?php

declare(strict_types=1);

namespace App\Tests\Quote\Repository;

use App\Collection\DataSourceCollection;
use App\Quote\DataSource\DummyDataSource;
use App\Quote\Repository\QuoteRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\String\Slugger\AsciiSlugger;

final class QuoteRepositoryTest extends TestCase
{

    public function testFindByAuthor(): void
    {
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
        );

        $quotes = $repository->findByCriteria(['author' => 'Steve Jobs']);
        $this->assertNotEmpty($quotes);
        $this->assertCount(2, $quotes);
    }
}
