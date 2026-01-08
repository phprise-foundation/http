<?php

declare(strict_types=1);

namespace Phprise\Http\Tests\Unit\Request;

use PHPUnit\Framework\TestCase;
use Phprise\Http\Request\UpdateRequest;
use Phprise\DataTransferObject\TransferObjectInterface;
use Psr\Http\Message\UriInterface;

final class UpdateRequestTest extends TestCase
{
    public function test_it_should_return_update_request_properties(): void
    {
        $uri = $this->createMock(UriInterface::class);
        $payload = $this->createMock(TransferObjectInterface::class);

        $request = new UpdateRequest($uri, $payload);

        $this->assertSame($payload, $request->payload());
        $this->assertSame('PATCH', $request->getMethod());
    }
}
