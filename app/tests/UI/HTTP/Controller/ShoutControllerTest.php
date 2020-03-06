<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class ShoutControllerTest extends WebTestCase
{
    public function testShoutGivenAnAuthorAndLimit2ShouldReturn2QuotesFormatted(): void
    {
        $client = self::createClient();
        $client->request(Request::METHOD_GET, '/shout/steve-jobs?limit=2');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertNotEmpty($client->getResponse()->getContent());
        $this->assertJson($client->getResponse()->getContent());
        $response = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertNotEmpty($response);
        $this->assertIsArray($response);
        $this->assertCount(2, $response);
    }

    public function testShoutGivenAnAuthorAndLimit1ShouldReturn1QuotesFormatted(): void
    {
        $client = self::createClient();
        $client->request(Request::METHOD_GET, '/shout/steve-jobs?limit=1');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertNotEmpty($client->getResponse()->getContent());
        $this->assertJson($client->getResponse()->getContent());
        $response = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertNotEmpty($response);
        $this->assertIsArray($response);
        $this->assertCount(1, $response);
    }

    public function testShoutGivenLimitGreaterThan10(): void
    {
        $client = self::createClient();
        $client->request(Request::METHOD_GET, '/shout/steve-jobs?limit=11');
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
        $response = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertArrayHasKey('type', $response);
        $this->assertArrayHasKey('title', $response);
        $this->assertArrayHasKey('errors', $response);
    }

    public function testShoutGivenLimitLessThan0(): void
    {
        $client = self::createClient();
        $client->request(Request::METHOD_GET, '/shout/steve-jobs?limit=-1');
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
        $response = json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->assertArrayHasKey('type', $response);
        $this->assertArrayHasKey('title', $response);
        $this->assertArrayHasKey('errors', $response);
    }

}
