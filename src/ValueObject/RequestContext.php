<?php

declare(strict_types=1);

namespace Phprise\Http\ValueObject;

use Phprise\Common\ValueObject\ArrayObject;
use Psr\Http\Message\UriInterface;

/**
 * @psalm-suppress UnsafeInstantiation
 */
final readonly class RequestContext
{
    public function __construct(
        private UriInterface $uri,
        private Headers $headers = new Headers([]),
        private string $protocolVersion = '1.1'
    ) {
    }

    public function uri(): UriInterface
    {
        return $this->uri;
    }

    public function headers(): Headers
    {
        return $this->headers;
    }

    public function protocolVersion(): string
    {
        return $this->protocolVersion;
    }

    public function withUri(UriInterface $uri): static
    {
        return new static($uri, $this->headers, $this->protocolVersion);
    }

    public function withHeaders(Headers $headers): static
    {
        return new static($this->uri, $headers, $this->protocolVersion);
    }

    public function withProtocolVersion(string $version): static
    {
        return new static($this->uri, $this->headers, $version);
    }
}
