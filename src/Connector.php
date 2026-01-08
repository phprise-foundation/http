<?php

declare(strict_types=1);

namespace Phprise\Http;

use Phprise\Http\Contract\PsrRequestConverterInterface;
use Phprise\Http\Contract\RequestInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

final readonly class Connector
{
    public function __construct(
        private ClientInterface $client
    ) {
    }

    public function send(RequestInterface $request): ResponseInterface
    {
        return $this->client->sendRequest($request);
    }
}
