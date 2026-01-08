<?php

declare(strict_types=1);

namespace Phprise\Http\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Phprise\Http\Connector;
use Phprise\Http\Contract\RequestInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

final class ConnectorTest extends TestCase
{
    public function test_it_should_send_request_via_client(): void
    {
        $client = $this->createMock(ClientInterface::class);
        $request = $this->createMock(RequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $client->expects($this->once())
            ->method('sendRequest')
            ->with($request)
            ->willReturn($response);

        $connector = new Connector($client);
        $this->assertSame($response, $connector->send($request));
    }
}
