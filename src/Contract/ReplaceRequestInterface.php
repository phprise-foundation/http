<?php

declare(strict_types=1);

namespace Phprise\Http\Contract;

use Phprise\DataTransferObject\TransferObjectInterface;

interface ReplaceRequestInterface extends RequestInterface
{
    public function payload(): TransferObjectInterface;
}
