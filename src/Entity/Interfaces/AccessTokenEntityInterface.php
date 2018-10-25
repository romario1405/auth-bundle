<?php

declare(strict_types=1);

namespace sonrac\Auth\Entity\Interfaces;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface as BaseAccessTokenEntityInterface;

/**
 * Interface AccessTokenEntityInterface.
 */
interface AccessTokenEntityInterface extends BaseAccessTokenEntityInterface, TimeStampEntityInterface
{
}
