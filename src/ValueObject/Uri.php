<?php

declare(strict_types=1);

namespace Phprise\Http\ValueObject;

use Psr\Http\Message\UriInterface;

final readonly class Uri implements UriInterface
{
    public function __construct(
        private string $uri
    ) {
    }

    public function toString(): string
    {
        return $this->uri;
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->uri;
    }

    #[\Override]
    public function getScheme(): string
    {
        $scheme = parse_url($this->uri, PHP_URL_SCHEME);
        return is_string($scheme) ? $scheme : '';
    }

    #[\Override]
    public function getAuthority(): string
    {
        $authority = $this->getHost();
        $userInfo = $this->getUserInfo();
        if ($userInfo !== '') {
            $authority = $userInfo . '@' . $authority;
        }
        $port = $this->getPort();
        if ($port !== null) {
            $authority .= ':' . $port;
        }
        return $authority;
    }

    #[\Override]
    public function getUserInfo(): string
    {
        $user = parse_url($this->uri, PHP_URL_USER);
        $user = is_string($user) ? $user : '';
        $pass = parse_url($this->uri, PHP_URL_PASS);
        $pass = is_string($pass) ? $pass : null;
        return $user . ($pass !== null ? ':' . $pass : '');
    }

    #[\Override]
    public function getHost(): string
    {
        $host = parse_url($this->uri, PHP_URL_HOST);
        return is_string($host) ? $host : '';
    }

    #[\Override]
    public function getPort(): ?int
    {
        $port = parse_url($this->uri, PHP_URL_PORT);
        return is_int($port) ? $port : null;
    }

    #[\Override]
    public function getPath(): string
    {
        $path = parse_url($this->uri, PHP_URL_PATH);
        return is_string($path) ? $path : '';
    }

    #[\Override]
    public function getQuery(): string
    {
        $query = parse_url($this->uri, PHP_URL_QUERY);
        return is_string($query) ? $query : '';
    }

    #[\Override]
    public function getFragment(): string
    {
        $fragment = parse_url($this->uri, PHP_URL_FRAGMENT);
        return is_string($fragment) ? $fragment : '';
    }

    #[\Override]
    public function withScheme(string $scheme): static
    {
        return new static(str_replace($this->getScheme(), $scheme, $this->uri));
    }

    #[\Override]
    public function withUserInfo(string $user, ?string $password = null): static
    {
        // Minimal implementation for now
        return $this;
    }

    #[\Override]
    public function withHost(string $host): static
    {
        return new static(str_replace($this->getHost(), $host, $this->uri));
    }

    #[\Override]
    public function withPort(?int $port): static
    {
        return $this;
    }

    #[\Override]
    public function withPath(string $path): static
    {
        return new static(str_replace($this->getPath(), $path, $this->uri));
    }

    #[\Override]
    public function withQuery(string $query): static
    {
        return new static(str_replace($this->getQuery(), $query, $this->uri));
    }

    #[\Override]
    public function withFragment(string $fragment): static
    {
        return new static(str_replace($this->getFragment(), $fragment, $this->uri));
    }
}
