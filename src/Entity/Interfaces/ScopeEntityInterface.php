<?php

declare(strict_types=1);

namespace sonrac\Auth\Entity\Interfaces;

use League\OAuth2\Server\Entities\ScopeEntityInterface as BaseScopeEntityInterface;

/**
 * Interface ScopeEntityInterface
 *
 * @package sonrac\Auth\Entity\Interfaces
 */
interface ScopeEntityInterface extends TimeStampEntityInterface, BaseScopeEntityInterface
{

}
