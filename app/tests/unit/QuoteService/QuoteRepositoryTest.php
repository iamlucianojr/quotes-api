<?php

declare(strict_types=1);

namespace App\Tests\QuoteService;

use App\Collection\DataSourceCollection;
use App\DataSource\TextCollectionDataSource;
use App\QuoteService\QuoteRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\NativeHttpClient;

final class QuoteRepositoryTest extends TestCase
{

    public function testFindByAuthor(): void
    {
        $repository = new QuoteRepository(new DataSourceCollection([
            new TextCollectionDataSource(new NativeHttpClient(), 'https://raw.githubusercontent.com/iPresence/backend_test/master/quotes.json')
        ]));

        $quotes = $repository->findByCriteria(['author' => 'Steve Jobs']);
        $this->assertNotEmpty($quotes);
        $this->assertCount(2, $quotes);
    }
}
