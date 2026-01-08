<?php

declare(strict_types=1);

namespace Phprise\Http\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Phprise\Http\Client\NativeClient;
use Phprise\Http\Connector;
use Phprise\Http\Request\ListRequest;
use Phprise\Http\Request\ShowRequest;
use Phprise\Http\ValueObject\Uri;

final class RealRequestIntegrationTest extends TestCase
{
    public function test_it_should_fetch_list_of_posts_from_real_api(): void
    {
        $client = new NativeClient();
        $connector = new Connector($client);

        $request = new ListRequest(
            new Uri('https://jsonplaceholder.typicode.com/posts')
        );

        $response = $connector->send($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty((string) $response->getBody());

        $data = json_decode((string) $response->getBody(), true);
        $this->assertIsArray($data);
        $this->assertGreaterThan(0, count($data));
    }

    public function test_it_should_fetch_single_post_from_real_api(): void
    {
        $client = new NativeClient();
        $connector = new Connector($client);

        $request = new ShowRequest(
            new Uri('https://jsonplaceholder.typicode.com/posts/1')
        );

        $response = $connector->send($request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty((string) $response->getBody());

        $data = json_decode((string) $response->getBody(), true);
        $this->assertIsArray($data);
        $this->assertEquals(1, $data['id']);
    }

    public function test_it_should_fetch_list_of_posts_asynchronously(): void
    {
        $client = new NativeClient();
        $connector = new \Phprise\Http\AsyncConnector($client);

        $request = new ListRequest(
            new Uri('https://jsonplaceholder.typicode.com/posts')
        );

        $promise = $connector->send($request);
        $response = $promise->wait();

        $this->assertInstanceOf(\Psr\Http\Message\ResponseInterface::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode((string) $response->getBody(), true);
        $this->assertIsArray($data);
        $this->assertGreaterThan(0, count($data));
    }
}
