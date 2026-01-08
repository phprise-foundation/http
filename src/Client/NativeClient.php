<?php

declare(strict_types=1);

namespace Phprise\Http\Client;

use Http\Client\HttpAsyncClient;
use Http\Promise\FulfilledPromise;
use Http\Promise\Promise;
use Phprise\Http\ValueObject\Headers;
use Phprise\Http\ValueObject\NativeResponse;
use Phprise\Http\ValueObject\NativeStream;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final readonly class NativeClient implements ClientInterface, HttpAsyncClient
{
    #[\Override]
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $ch = $this->initCurl($request);
        $response = $this->executeCurl($ch);
        $info = $this->getCurlInfo($ch);
        curl_close($ch);

        return $this->buildResponse($response, $info);
    }

    #[\Override]
    public function sendAsyncRequest(RequestInterface $request): Promise
    {
        try {
            return new FulfilledPromise($this->sendRequest($request));
        } catch (\Throwable $e) {
            return new \Http\Promise\RejectedPromise($e);
        }
    }

    /**
     * @return \CurlHandle
     */
    private function initCurl(RequestInterface $request)
    {
        $ch = curl_init((string) $request->getUri());
        if ($ch === false) {
            throw new \RuntimeException('Could not initialize curl');
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request->getMethod());
        curl_setopt($ch, CURLOPT_POSTFIELDS, (string) $request->getBody());
        /** @psalm-suppress MixedArgumentTypeCoercion */
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->formatHeaders($request->getHeaders()));
        curl_setopt($ch, CURLOPT_HEADER, true);

        return $ch;
    }

    /**
     * @param \CurlHandle $ch
     */
    private function executeCurl($ch): string
    {
        $response = curl_exec($ch);
        if (is_string($response)) {
            return $response;
        }

        $error = curl_error($ch);
        curl_close($ch);
        throw new \RuntimeException('Curl error: ' . $error);
    }

    /**
     * @param \CurlHandle $ch
     * @return array{header_size: int, http_code: int}
     */
    private function getCurlInfo($ch): array
    {
        return [
            'header_size' => (int) curl_getinfo($ch, CURLINFO_HEADER_SIZE),
            'http_code' => (int) curl_getinfo($ch, CURLINFO_HTTP_CODE),
        ];
    }

    /**
     * @param array{header_size: int, http_code: int} $info
     */
    private function buildResponse(string $response, array $info): ResponseInterface
    {
        return new NativeResponse(
            $info['http_code'],
            $this->parseHeaders(substr($response, 0, $info['header_size'])),
            new NativeStream(substr($response, $info['header_size']))
        );
    }

    /**
     * @param array<string, array<int, string>> $headers
     * @return array<int, string>
     */
    private function formatHeaders(array $headers): array
    {
        $formatted = [];
        foreach ($headers as $name => $values) {
            $formatted = array_merge($formatted, $this->formatHeaderValues($name, $values));
        }
        return $formatted;
    }

    /**
     * @param array<int, string> $values
     * @return array<int, string>
     */
    private function formatHeaderValues(string $name, array $values): array
    {
        $formatted = [];
        foreach ($values as $value) {
            $formatted[] = sprintf('%s: %s', $name, $value);
        }
        return $formatted;
    }

    private function parseHeaders(string $headerContent): Headers
    {
        $headers = [];
        $lines = explode("\r\n", $headerContent);
        foreach ($lines as $line) {
            $headers = $this->parseHeaderLine($headers, $line);
        }
        return new Headers($headers);
    }

    /**
     * @param array<string, array<int, string>> $headers
     * @return array<string, array<int, string>>
     */
    private function parseHeaderLine(array $headers, string $line): array
    {
        $parts = explode(':', $line, 2);
        if (count($parts) === 2) {
            $headers[trim($parts[0])][] = trim($parts[1]);
        }
        return $headers;
    }
}
