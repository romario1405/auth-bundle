<?php

declare(strict_types=1);

namespace sonrac\Auth\Entity\Interfaces;

use League\OAuth2\Server\Entities\UserEntityInterface as BaseUserEntityInterface;

/**
 * Interface UserEntityInterface
 *
 * @package sonrac\Auth\Entity\Interfaces
 */
interface UserEntityInterface extends TimeStampEntityInterface, BaseUserEntityInterface
{

}
