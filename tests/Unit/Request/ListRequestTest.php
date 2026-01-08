<?php

declare(strict_types=1);

namespace Phprise\Http\Tests\Unit\Request;

use PHPUnit\Framework\TestCase;
use Phprise\Http\Request\ListRequest;
use Phprise\Http\ValueObject\Uri;
use Phprise\Common\ValueObject\ArrayObject;

final class ListRequestTest extends TestCase
{
    public function test_it_should_return_list_request_properties(): void
    {
        $uri = new Uri('https://api.example.com/users');
        $query = new ArrayObject(['page' => 1]);
        $request = new ListRequest($uri, $query);

        $this->assertSame($query, $request->query());
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame('https://api.example.com/users', $request->getUri()->toString());
    }
}
