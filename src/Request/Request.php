<?php

declare(strict_types=1);

namespace Phprise\Http\Request;

use Phprise\Http\Contract\RequestInterface;
use Phprise\Http\ValueObject\RequestContext;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\StreamInterface;

abstract readonly class Request implements RequestInterface
{
    public function __construct(
        protected RequestContext $context
    ) {
    }

    #[\Override]
    public function getProtocolVersion(): string
    {
        return $this->context->protocolVersion();
    }

    #[\Override]
    public function withProtocolVersion(string $version): static
    {
        return $this->recompose($this->context->withProtocolVersion($version));
    }

    #[\Override]
    public function getHeaders(): array
    {
        return $this->context->headers()->toArray();
    }

    #[\Override]
    public function hasHeader(string $name): bool
    {
        return $this->context->headers()->has($name);
    }

    #[\Override]
    public function getHeader(string $name): array
    {
        return $this->context->headers()->get($name);
    }

    #[\Override]
    public function getHeaderLine(string $name): string
    {
        return implode(', ', $this->getHeader($name));
    }

    #[\Override]
    public function withHeader(string $name, $value): static
    {
        /** @psalm-suppress DocblockTypeContradiction */
        if (!is_string($value) && !is_array($value)) {
             throw new \InvalidArgumentException('Header value must be string or array');
        }
        /** @psalm-suppress MixedArgumentTypeCoercion */
        $headers = $this->context->headers()->with($name, $value);
        return $this->recompose($this->context->withHeaders($headers));
    }

    #[\Override]
    public function withAddedHeader(string $name, $value): static
    {
        $current = $this->getHeader($name);
        $new = array_merge($current, is_array($value) ? $value : [$value]);
        return $this->withHeader($name, $new);
    }

    #[\Override]
    public function withoutHeader(string $name): static
    {
        $headers = $this->context->headers()->without($name);
        return $this->recompose($this->context->withHeaders($headers));
    }

    #[\Override]
    abstract public function getBody(): StreamInterface;

    #[\Override]
    public function withBody(StreamInterface $body): static
    {
        return $this;
    }

    #[\Override]
    public function getRequestTarget(): string
    {
        return $this->getUri()->getPath() . ($this->getUri()->getQuery() ? '?' . $this->getUri()->getQuery() : '');
    }

    #[\Override]
    public function withRequestTarget(string $requestTarget): static
    {
        return $this;
    }

    #[\Override]
    abstract public function getMethod(): string;

    #[\Override]
    public function withMethod(string $method): static
    {
        return $this;
    }

    #[\Override]
    public function getUri(): UriInterface
    {
        return $this->context->uri();
    }

    #[\Override]
    public function withUri(UriInterface $uri, bool $preserveHost = false): static
    {
        return $this->recompose($this->context->withUri($uri));
    }

    abstract protected function recompose(RequestContext $context): static;
}
