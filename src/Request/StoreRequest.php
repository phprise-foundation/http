<?php

declare(strict_types=1);

namespace Phprise\Http\Request;

use Phprise\DataTransferObject\TransferObjectInterface;
use Phprise\Http\Contract\StoreRequestInterface;
use Phprise\Http\ValueObject\JsonStream;
use Phprise\Http\ValueObject\RequestContext;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * @psalm-suppress ClassMustBeFinal
 * @psalm-suppress UnsafeInstantiation
 */
readonly class StoreRequest extends Request implements StoreRequestInterface
{
    public function __construct(
        UriInterface|RequestContext $uriOrContext,
        private TransferObjectInterface $payload
    ) {
        parent::__construct(
            $uriOrContext instanceof RequestContext
                ? $uriOrContext
                : new RequestContext($uriOrContext)
        );
    }

    #[\Override]
    public function payload(): TransferObjectInterface
    {
        return $this->payload;
    }

    #[\Override]
    public function getMethod(): string
    {
        return 'POST';
    }

    #[\Override]
    public function getBody(): StreamInterface
    {
        return new JsonStream($this->payload);
    }

    #[\Override]
    protected function recompose(RequestContext $context): static
    {
        return new static($context, $this->payload);
    }
}
