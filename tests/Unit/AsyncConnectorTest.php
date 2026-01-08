<?php

declare(strict_types=1);

namespace Phprise\Http\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Phprise\Http\AsyncConnector;
use Phprise\Http\Contract\RequestInterface;
use Http\Client\HttpAsyncClient;
use Http\Promise\Promise;

final class AsyncConnectorTest extends TestCase
{
    public function test_it_should_send_request_asynchronously(): void
    {
        $client = $this->createMock(HttpAsyncClient::class);
        $request = $this->createMock(RequestInterface::class);
        $promise = $this->createMock(Promise::class);

        $client->expects($this->once())
            ->method('sendAsyncRequest')
            ->with($request)
            ->willReturn($promise);

        $connector = new AsyncConnector($client);
        $this->assertSame($promise, $connector->send($request));
    }
}
