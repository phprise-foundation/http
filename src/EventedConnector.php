<?php

declare(strict_types=1);

namespace Phprise\Http;

use Phprise\Http\Contract\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class EventedConnector
{
    public function __construct(
        private Connector $connector,
        private EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function send(RequestInterface $request): ResponseInterface
    {
        // We could dispatch a BeforeSendEvent here
        $response = $this->connector->send($request);
        // We could dispatch an AfterSendEvent here
        $this->eventDispatcher->dispatch(new ResponseReceivedEvent($response));

        return $response;
    }
}
