# phprise/http

The Assembly Repository is a meta-package that orchestration the union of Atoms. It does not contain logic itself.

## Installation

Install the package via composer:

```bash
composer require phprise/http
```

## Usage


### Quick Start (Native Implementation)

PHPRise HTTP comes with a **NativeClient** based on PHP's cURL extension, allowing you to send requests without external weight (like Guzzle).

#### Synchronous Requests

```php
use Phprise\Http\Connector\Connector;
use Phprise\Http\Client\NativeClient;
use Phprise\Http\Request\ListRequest;
use Phprise\Http\ValueObject\Uri;

$connector = new Connector(new NativeClient());

$request = new ListRequest(new Uri('https://jsonplaceholder.typicode.com/posts'));
$response = $connector->send($request);

echo $response->getStatusCode(); // 200
```

#### Asynchronous Requests

```php
use Phprise\Http\Connector\AsyncConnector;
use Phprise\Http\Client\NativeClient;

$async = new AsyncConnector(new NativeClient());
$promise = $async->send($request);

$promise->then(function ($response) {
    echo $response->getStatusCode();
});

$promise->wait();
```

### Advanced Usage

#### 1. The Connector

The `Connector` wraps any PSR-18 Client.

```php
use Phprise\Http\Connector\Connector;

$connector = new Connector($anyPsr18Client);
```

#### 2. Semantic Requests

Requests are **semantic-first** and implement `Psr\Http\Message\RequestInterface` directly.

| Request Type | Method | Purpose |
|--------------|--------|---------|
| `ListRequest` | GET | List resources with query params. |
| `ShowRequest` | GET | Fetch a single resource. |
| `StoreRequest`| POST | Create a new resource with a DTO. |
| `UpdateRequest`| PATCH| Partial update with a DTO. |
| `ReplaceRequest`| PUT | Complete replacement with a DTO. |
| `DestroyRequest`| DELETE| Remove a resource. |

#### 3. Data Transfer Objects (DTO)

Stateful requests (`Store`, `Update`, `Replace`) require a payload implementing `Phprise\DataTransferObject\TransferObjectInterface`.

```php
use Phprise\Http\Request\StoreRequest;
use Phprise\Http\ValueObject\Uri;

$request = new StoreRequest(new Uri($url), $myDto);
```

#### 4. Intercepting Responses (Events)

Use `EventedConnector` for PSR-14 event dispatching.

```php
use Phprise\Http\Connector\EventedConnector;

$connector = new EventedConnector($baseConnector, $eventDispatcher);
```


## Philosophy
We follow **The OTAKU Manifesto: Fluid Structure Design**.

1. **O** - Own your Discipline (Be strict with yourself)
2. **T** - Tools for Composition (Compose like Unix)
3. **A** - Armor the Core (Protect the heart of the business)
4. **K** - Keep Infrastructure Silent (Infrastructure is just a detail)
5. **U** - Universal Language & Contracts (Speak the user's language via clear contracts)

Please read more about it in [PHILOSOPHY.md](PHILOSOPHY.md).

## License
MIT License

Free to use, modify, and distribute.

## Contributing
See how to contribute in [CONTRIBUTING.md](CONTRIBUTING.md).

## Code of Conduct
See our code of conduct in [CODE_OF_CONDUCT.md](CODE_OF_CONDUCT.md).

## Security
See our security policy in [SECURITY.md](SECURITY.md).
