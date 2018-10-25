<?php

declare(strict_types=1);

namespace sonrac\Auth\Entity\Interfaces;

use League\OAuth2\Server\Entities\RefreshTokenEntityInterface as BaseRefreshTokenEntityInterface;

interface RefreshTokenEntityInterface extends TimeStampEntityInterface, BaseRefreshTokenEntityInterface
{
}
