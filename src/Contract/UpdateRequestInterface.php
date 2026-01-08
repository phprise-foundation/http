<?php

declare(strict_types=1);

namespace Phprise\Http\Contract;

use Phprise\DataTransferObject\TransferObjectInterface;

interface UpdateRequestInterface extends RequestInterface
{
    public function payload(): TransferObjectInterface;
}
