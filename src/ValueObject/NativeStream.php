<?php

declare(strict_types=1);

namespace Phprise\Http\ValueObject;

use Psr\Http\Message\StreamInterface;

final readonly class NativeStream implements StreamInterface
{
    public function __construct(private string $content)
    {
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->content;
    }

    #[\Override]
    public function close(): void
    {
    }

    #[\Override]
    public function detach()
    {
        return null;
    }

    #[\Override]
    public function getSize(): ?int
    {
        return strlen($this->content);
    }

    #[\Override]
    public function tell(): int
    {
        return 0;
    }

    #[\Override]
    public function eof(): bool
    {
        return true;
    }

    #[\Override]
    public function isSeekable(): bool
    {
        return false;
    }

    #[\Override]
    public function seek(int $offset, int $whence = SEEK_SET): void
    {
    }

    #[\Override]
    public function rewind(): void
    {
    }

    #[\Override]
    public function isWritable(): bool
    {
        return false;
    }

    #[\Override]
    public function write(string $string): int
    {
        return 0;
    }

    #[\Override]
    public function isReadable(): bool
    {
        return true;
    }

    #[\Override]
    public function read(int $length): string
    {
        return substr($this->content, 0, $length);
    }

    #[\Override]
    public function getContents(): string
    {
        return $this->content;
    }

    #[\Override]
    public function getMetadata(?string $key = null)
    {
        return $key === null ? [] : null;
    }
}
