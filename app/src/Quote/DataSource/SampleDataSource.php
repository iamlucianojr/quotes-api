<?php

declare(strict_types=1);

namespace App\Quote\DataSource;

use App\Quote\Collection\QuoteCollection;
use App\Quote\Collection\QuoteCollectionInterface;
use App\Quote\DataSource\Exception\DataSourceException;
use App\Quote\DataSource\Exception\DataSourceIsNotReadableException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Webmozart\Assert\Assert;

final class SampleDataSource implements DataSourceInterface
{
    private const KEY = 'SampleDataSource';

    private HttpClientInterface $httpClient;

    private QuoteCollectionInterface $quotes;

    private AdapterInterface $cache;

    private LoggerInterface $logger;

    private string $url;

    public function __construct(
        HttpClientInterface $httpClient,
        AdapterInterface $cache,
        LoggerInterface $logger,
        string $dataSourceUrl
    ) {
        $this->httpClient = $httpClient;
        $this->cache = $cache;
        $this->url = $dataSourceUrl;
        $this->logger = $logger;

        $cachedItem = $this->cache->getItem(self::KEY);

        if ($cachedItem->get() instanceof QuoteCollectionInterface) {
            $this->quotes = $cachedItem->get();
            $this->logger->info('Data fetched from cache', ['DataSource' => self::KEY]);
        }

        if (false === $cachedItem->isHit()) {
            $this->fetchQuotesFromSource();
            $cachedItem->set($this->quotes);
            $this->cache->save($cachedItem);
        }
    }

    public function getQuotes(): QuoteCollectionInterface
    {
        return $this->quotes;
    }

    private function transformResponseInQuotesCollection(ResponseInterface $rawDataResponse): array
    {
        if (Response::HTTP_OK !== $rawDataResponse->getStatusCode()) {
            return [];
        }

        $data = json_decode($rawDataResponse->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if (empty($data)) {
            return [];
        }

        Assert::keyExists($data, 'quotes');

        return $data['quotes'];
    }

    private function fetchQuotesFromSource(): void
    {
        try {
            $rawDataResponse = $this->httpClient->request(Request::METHOD_GET, $this->url);
        } catch (TransportExceptionInterface | ClientException $e) {
            throw new DataSourceException(sprintf('Could not fetch quotes from %s data source', __CLASS__));
        }

        if (Response::HTTP_NOT_FOUND === $rawDataResponse->getStatusCode()) {
            throw new DataSourceIsNotReadableException(sprintf('The url %s provided is not readable or reachable', $this->url));
        }

        $this->logger->info('Raw data fetched from text collection quotes api', ['DataSource' => self::KEY]);

        $this->quotes = QuoteCollection::fromArray($this->transformResponseInQuotesCollection($rawDataResponse));
    }
}
