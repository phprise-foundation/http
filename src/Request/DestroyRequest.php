<?php

declare(strict_types=1);

namespace Phprise\Http\Request;

use Phprise\Http\Contract\DestroyRequestInterface;
use Phprise\Http\ValueObject\EmptyStream;
use Phprise\Http\ValueObject\RequestContext;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;

/**
 * @psalm-suppress ClassMustBeFinal
 * @psalm-suppress UnsafeInstantiation
 */
readonly class DestroyRequest extends Request implements DestroyRequestInterface
{
    public function __construct(
        UriInterface|RequestContext $uriOrContext
    ) {
        parent::__construct(
            $uriOrContext instanceof RequestContext
                ? $uriOrContext
                : new RequestContext($uriOrContext)
        );
    }

    #[\Override]
    public function getMethod(): string
    {
        return 'DELETE';
    }

    #[\Override]
    public function getBody(): StreamInterface
    {
        return new EmptyStream();
    }

    #[\Override]
    protected function recompose(RequestContext $context): static
    {
        return new static($context);
    }
}
