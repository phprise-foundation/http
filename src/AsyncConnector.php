<?php

declare(strict_types=1);

namespace Phprise\Http;

use Http\Client\HttpAsyncClient;
use Phprise\Http\Contract\RequestInterface;
use Http\Promise\Promise;

final readonly class AsyncConnector
{
    public function __construct(
        private HttpAsyncClient $client
    ) {
    }

    public function send(RequestInterface $request): Promise
    {
        return $this->client->sendAsyncRequest($request);
    }
}
