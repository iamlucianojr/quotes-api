<?php

declare(strict_types=1);

namespace App\Tests\Quote\DataSource;

use App\Quote\DataSource\Exception\DataSourceIsNotReadableException;
use App\Quote\DataSource\SampleDataSource;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Cache\Adapter\NullAdapter;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class SampleDataSourceTest extends TestCase
{
    private HttpClientInterface $httpClientMock;

    public function testInitializationWithWrongUrl(): void
    {
        $response = new MockResponse('', ['http_code' => Response::HTTP_NOT_FOUND]);
        $this->httpClientMock = new MockHttpClient($response);
        $url = 'http://foo.bar.xyz';

        $this->expectException(DataSourceIsNotReadableException::class);
        new SampleDataSource(
            $this->httpClientMock,
            new NullAdapter(),
            new NullLogger(),
            $url
        );
    }

    public function testInitializationWithValidUrl(): void
    {
        $data = file_get_contents(__DIR__ . '/../../resources/quotes.json');
        $response = new MockResponse($data);
        $clientMock = new MockHttpClient($response);
        $url = 'https://raw.githubusercontent.com/iPresence/backend_test/master/quotes.json';

        $dataSource = new SampleDataSource(
            $clientMock,
            new NullAdapter(),
            new NullLogger(),
            $url
        );

        $this->assertNotEmpty($dataSource->getQuotes());
        $this->assertCount(102, $dataSource->getQuotes()->items());
    }
}
