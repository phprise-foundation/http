<?php

declare(strict_types=1);

namespace Phprise\Http\Contract;

use Phprise\Http\Contract\RequestInterface;
use Phprise\DataTransferObject\TransferObjectInterface;

interface StoreRequestInterface extends RequestInterface
{
    public function payload(): TransferObjectInterface;
}
