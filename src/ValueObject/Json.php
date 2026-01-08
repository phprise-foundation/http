<?php

declare(strict_types=1);

namespace Phprise\Http\ValueObject;

use JsonSerializable;

final readonly class Json implements JsonSerializable
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(
        private array $data
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    #[\Override]
    public function jsonSerialize(): array
    {
        return $this->data;
    }

    public function toString(): string
    {
        return json_encode($this->data, JSON_THROW_ON_ERROR);
    }
}
