<?php

declare(strict_types=1);

namespace sonrac\Auth\Entity\Interfaces;

use League\OAuth2\Server\Entities\ClientEntityInterface as BaseClientEntityInterface;

/**
 * Interface ClientEntityInterface
 *
 * @package sonrac\Auth\Entity\Interfaces
 */
interface ClientEntityInterface extends TimeStampEntityInterface, BaseClientEntityInterface
{

}
