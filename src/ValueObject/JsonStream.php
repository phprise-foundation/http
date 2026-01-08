<?php

declare(strict_types=1);

namespace Phprise\Http\ValueObject;

use Phprise\DataTransferObject\TransferObjectInterface;
use Psr\Http\Message\StreamInterface;

final readonly class JsonStream implements StreamInterface
{
    public function __construct(
        private TransferObjectInterface $to
    ) {
    }

    #[\Override]
    public function __toString(): string
    {
        $encoded = json_encode($this->to->toArray());
        return $encoded !== false ? $encoded : '{}';
    }

    #[\Override]
    public function close(): void
    {
    }

    #[\Override]
    public function detach(): mixed
    {
        return null;
    }

    #[\Override]
    public function getSize(): ?int
    {
        return strlen($this->__toString());
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
        return substr($this->__toString(), 0, $length);
    }

    #[\Override]
    public function getContents(): string
    {
        return $this->__toString();
    }

    #[\Override]
    public function getMetadata(?string $key = null): mixed
    {
        return $key === null ? [] : null;
    }
}
