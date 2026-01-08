<?php

declare(strict_types=1);

namespace Phprise\Http\ValueObject;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

final readonly class NativeResponse implements ResponseInterface
{
    public function __construct(
        private int $statusCode,
        private Headers $headers,
        private StreamInterface $body,
        private string $reasonPhrase = '',
        private string $protocolVersion = '1.1'
    ) {
    }

    #[\Override]
    public function getProtocolVersion(): string
    {
        return $this->protocolVersion;
    }

    #[\Override]
    public function withProtocolVersion(string $version): static
    {
        return new static($this->statusCode, $this->headers, $this->body, $this->reasonPhrase, $version);
    }

    #[\Override]
    public function getHeaders(): array
    {
        return $this->headers->toArray();
    }

    #[\Override]
    public function hasHeader(string $name): bool
    {
        return $this->headers->has($name);
    }

    #[\Override]
    public function getHeader(string $name): array
    {
        return $this->headers->get($name);
    }

    #[\Override]
    public function getHeaderLine(string $name): string
    {
        return implode(', ', $this->getHeader($name));
    }

    #[\Override]
    public function withHeader(string $name, $value): static
    {
        /** @psalm-suppress MixedArgumentTypeCoercion */
        return new static($this->statusCode, $this->headers->with($name, $value), $this->body, $this->reasonPhrase, $this->protocolVersion);
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
        return new static($this->statusCode, $this->headers->without($name), $this->body, $this->reasonPhrase, $this->protocolVersion);
    }

    #[\Override]
    public function getBody(): StreamInterface
    {
        return $this->body;
    }

    #[\Override]
    public function withBody(StreamInterface $body): static
    {
        return new static($this->statusCode, $this->headers, $body, $this->reasonPhrase, $this->protocolVersion);
    }

    #[\Override]
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    #[\Override]
    public function withStatus(int $code, string $reasonPhrase = ''): static
    {
        return new static($code, $this->headers, $this->body, $reasonPhrase, $this->protocolVersion);
    }

    #[\Override]
    public function getReasonPhrase(): string
    {
        return $this->reasonPhrase;
    }
}
