<?php

declare(strict_types=1);

namespace Phprise\Http\Contract;

use Phprise\Common\ValueObject\ArrayObject;

interface ListRequestInterface extends RequestInterface
{
    public function query(): ArrayObject;
}
