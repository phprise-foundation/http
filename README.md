# PHPRise HTTP

The HTTP component applying the OTAKU philosophy and following the PSR-12, PSR-7, PSR-18, and PSR-14.

## Installation

```bash
composer require phprise/http
```

## Quick Start (Native Implementation)

PHPRise HTTP comes with a **NativeClient** based on PHP's cURL extension, allowing you to send requests without external weight (like Guzzle).

### Synchronous Requests

```php
use Phprise\Http\Connector;
use Phprise\Http\Client\NativeClient;
use Phprise\Http\Request\ListRequest;
use Phprise\Http\ValueObject\Uri;

$connector = new Connector(new NativeClient());

$request = new ListRequest(new Uri('https://jsonplaceholder.typicode.com/posts'));
$response = $connector->send($request);

echo $response->getStatusCode(); // 200
```

### Asynchronous Requests

```php
use Phprise\Http\AsyncConnector;
use Phprise\Http\Client\NativeClient;

$async = new AsyncConnector(new NativeClient());
$promise = $async->send($request);

$promise->then(function ($response) {
    echo $response->getStatusCode();
});

$promise->wait();
```

## Advanced Usage

### 1. The Connector

The `Connector` wraps any PSR-18 Client.

```php
use Phprise\Http\Connector;

$connector = new Connector($anyPsr18Client);
```

### 2. Semantic Requests

Requests are **semantic-first** and implement `Psr\Http\Message\RequestInterface` directly.

| Request Type | Method | Purpose |
|--------------|--------|---------|
| `ListRequest` | GET | List resources with query params. |
| `ShowRequest` | GET | Fetch a single resource. |
| `StoreRequest`| POST | Create a new resource with a DTO. |
| `UpdateRequest`| PATCH| Partial update with a DTO. |
| `ReplaceRequest`| PUT | Complete replacement with a DTO. |
| `DestroyRequest`| DELETE| Remove a resource. |

### 3. Data Transfer Objects (DTO)

Stateful requests (`Store`, `Update`, `Replace`) require a payload implementing `Phprise\DataTransferObject\TransferObjectInterface`.

```php
use Phprise\Http\Request\StoreRequest;
use Phprise\Http\ValueObject\Uri;

$request = new StoreRequest(new Uri($url), $myDto);
```

### 4. Intercepting Responses (Events)

Use `EventedConnector` for PSR-14 event dispatching.

```php
use Phprise\Http\EventedConnector;

$connector = new EventedConnector($baseConnector, $eventDispatcher);
```

## Philosophy
We follow **The OTAKU Manifesto: Fluid Structure Design**.

1. **O** - Own your Discipline (Strict Typing)
2. **T** - Tools for Composition (Deeply composed objects)
3. **A** - Armor the Core (Business value over infra)
4. **K** - Keep Infrastructure Silent (PSR-7 integration)
5. **U** - Universal Language (Semantic constructors)

## License
MIT License
