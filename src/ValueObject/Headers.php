<?php

declare(strict_types=1);

namespace Phprise\Http\ValueObject;

/**
 * @psalm-suppress UnsafeInstantiation
 */
final readonly class Headers
{
    /**
     * @param array<string, array<int, string>> $headers
     */
    public function __construct(
        private array $headers = []
    ) {
    }

    public function has(string $name): bool
    {
        return isset($this->headers[strtolower($name)]);
    }

    /**
     * @return array<int, string>
     */
    public function get(string $name): array
    {
        return $this->headers[strtolower($name)] ?? [];
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function toArray(): array
    {
        return $this->headers;
    }

    /**
     * @param string|array<int, string> $value
     */
    public function with(string $name, string|array $value): static
    {
        $newHeaders = $this->headers;
        /** @psalm-suppress MixedPropertyTypeCoercion */
        $newHeaders[strtolower($name)] = is_array($value) ? $value : [$value];
        return new static($newHeaders);
    }

    public function without(string $name): static
    {
        $newHeaders = $this->headers;
        unset($newHeaders[strtolower($name)]);
        return new static($newHeaders);
    }
}
