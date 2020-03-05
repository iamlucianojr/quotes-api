<?php

declare(strict_types=1);

namespace App\Tests\DataSource;

use App\DataSource\TextCollectionDataSource;
use App\DataSource\TextCollectionDataSourceIsNotReadable;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class TextCollectionDataSourceTest extends TestCase
{
    private HttpClientInterface $httpClientMock;

    protected function setUp()
    {
        parent::setUp();
    }

//    public function testInitializationWithWrongUrl(): void
//    {
//        $response = new MockResponse('', ['http_code' => Response::HTTP_NOT_FOUND]);
//        $this->httpClientMock = new MockHttpClient($response);
//        $url = 'http://foo.bar.eee';
//
//        $this->expectException(TextCollectionDataSourceIsNotReadable::class);
//        $this->expectException(ClientException::class);
//        $dataSource = new TextCollectionDataSource(
//            $this->httpClientMock,
//            $url
//        );
//    }

    public function testInitializationWithValidUrl(): void
    {
        $data = file_get_contents(__DIR__ . '/../../resources/quotes.json');
        $response = new MockResponse($data);
        $clientMock = new MockHttpClient($response);
        $url = 'https://raw.githubusercontent.com/iPresence/backend_test/master/quotes.json';

        $dataSource = new TextCollectionDataSource(
            $clientMock,
            $url
        );

        $this->assertNotEmpty($dataSource->getQuotes());
        $this->assertCount(102, $dataSource->getQuotes());
    }
}
