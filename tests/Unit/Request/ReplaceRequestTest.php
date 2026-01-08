<?php

declare(strict_types=1);

namespace Phprise\Http\Tests\Unit\Request;

use PHPUnit\Framework\TestCase;
use Phprise\Http\Request\ReplaceRequest;
use Phprise\DataTransferObject\TransferObjectInterface;
use Psr\Http\Message\UriInterface;

final class ReplaceRequestTest extends TestCase
{
    public function test_it_should_return_replace_request_properties(): void
    {
        $uri = $this->createMock(UriInterface::class);
        $payload = $this->createMock(TransferObjectInterface::class);

        $request = new ReplaceRequest($uri, $payload);

        $this->assertSame($payload, $request->payload());
        $this->assertSame('PUT', $request->getMethod());
    }
}
