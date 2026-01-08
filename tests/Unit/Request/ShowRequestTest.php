<?php

declare(strict_types=1);

namespace Phprise\Http\Tests\Unit\Request;

use PHPUnit\Framework\TestCase;
use Phprise\Http\Request\ShowRequest;
use Phprise\Http\ValueObject\Uri;

final class ShowRequestTest extends TestCase
{
    public function test_it_should_return_show_request_properties(): void
    {
        $uri = new Uri('https://api.example.com/users/123');
        $request = new ShowRequest($uri);

        $this->assertSame($uri, $request->getUri());
        $this->assertSame('GET', $request->getMethod());
    }
}
