<?php

declare(strict_types=1);

namespace Phprise\Http\Tests\Unit\Request;

use PHPUnit\Framework\TestCase;
use Phprise\Http\Request\StoreRequest;
use Phprise\Http\ValueObject\Uri;
use Phprise\DataTransferObject\TransferObjectInterface;

final class StoreRequestTest extends TestCase
{
    public function test_it_should_return_store_request_properties(): void
    {
        $uri = new Uri('https://api.example.com/users');
        $payload = $this->createMock(TransferObjectInterface::class);
        $payload->method('toArray')->willReturn(['name' => 'John Doe']);

        $request = new StoreRequest($uri, $payload);

        $this->assertSame($payload, $request->payload());
        $this->assertSame('POST', $request->getMethod());
        $this->assertSame('https://api.example.com/users', $request->getUri()->toString());
        $this->assertSame('{"name":"John Doe"}', $request->getBody()->getContents());
    }
}
