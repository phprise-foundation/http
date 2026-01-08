<?php

declare(strict_types=1);

namespace Phprise\Http\Tests\Unit\Request;

use PHPUnit\Framework\TestCase;
use Phprise\Http\Request\DestroyRequest;
use Phprise\Http\ValueObject\Uri;

final class DestroyRequestTest extends TestCase
{
    public function test_it_should_return_destroy_request_properties(): void
    {
        $uri = new Uri('https://api.example.com/users/123');
        $request = new DestroyRequest($uri);

        $this->assertSame('DELETE', $request->getMethod());
        $this->assertSame('https://api.example.com/users/123', $request->getUri()->toString());
    }
}
