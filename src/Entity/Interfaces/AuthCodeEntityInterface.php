<?php

declare(strict_types=1);

namespace sonrac\Auth\Entity\Interfaces;

use League\OAuth2\Server\Entities\AuthCodeEntityInterface as BaseAuthCodeEntityInterface;

/**
 * Interface AuthCodeEntityInterface
 *
 * @package sonrac\Auth\Entity\Interfaces
 */
interface AuthCodeEntityInterface extends TimeStampEntityInterface, BaseAuthCodeEntityInterface
{

}
