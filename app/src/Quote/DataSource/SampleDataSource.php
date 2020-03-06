<?php

declare(strict_types=1);

namespace App\Quote\DataSource;

use App\Quote\Collection\QuoteCollection;
use App\Quote\Collection\QuoteCollectionInterface;
use App\Quote\DataSource\Exception\DataSourceException;
use App\Quote\DataSource\Exception\DataSourceIsNotReadableException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Webmozart\Assert\Assert;

final class SampleDataSource implements DataSourceInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private HttpClientInterface $httpClient;

    private QuoteCollectionInterface $quotes;

    public function __construct(
        HttpClientInterface $httpClient,
        string $dataSourceUrl
    ) {
        $this->httpClient = $httpClient;

        try {
            $rawDataResponse = $this->httpClient->request(Request::METHOD_GET, $dataSourceUrl);
        } catch (TransportExceptionInterface | ClientException $e) {
            throw new DataSourceException(
                sprintf('Could not fetch quotes from %s data source', __CLASS__)
            );
        }

        if ($rawDataResponse->getStatusCode() === Response::HTTP_NOT_FOUND) {
            throw new DataSourceIsNotReadableException(
                sprintf('The url %s provided is not readable or reachable', $dataSourceUrl)
            );
        }

//        $this->logger->info('raw data fetched from text collection quotes api');
        $this->quotes = QuoteCollection::fromArray($this->transformResponseInQuotesCollection($rawDataResponse));
    }

    public function getQuotes(): QuoteCollectionInterface
    {
        return $this->quotes;
    }

    private function transformResponseInQuotesCollection(ResponseInterface $rawDataResponse): array
    {
        if ($rawDataResponse->getStatusCode() !== Response::HTTP_OK) {
            return [];
        }

        $data = json_decode($rawDataResponse->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if (empty($data)) {
            return [];
        }

        Assert::keyExists($data, 'quotes');

        return $data['quotes'];
    }
}
