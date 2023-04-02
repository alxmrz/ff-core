<?php

declare(strict_types=1);

namespace FF\router;

use FF\http\RequestInterface;

interface RouterInterface
{
    public function parseRequest(RequestInterface $request);
}
