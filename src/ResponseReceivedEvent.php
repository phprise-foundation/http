<?php

declare(strict_types=1);

namespace Phprise\Http;

use Psr\Http\Message\ResponseInterface;

final readonly class ResponseReceivedEvent
{
    public function __construct(
        private ResponseInterface $response
    ) {
    }

    public function response(): ResponseInterface
    {
        return $this->response;
    }
}
