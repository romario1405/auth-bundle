<?php

declare(strict_types=1);

namespace sonrac\Auth\Entity\Interfaces;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface as BaseAccessTokenEntityInterface;

/**
 * Interface AccessTokenEntityInterface
 *
 * @package sonrac\Auth\Entity
 */
interface AccessTokenEntityInterface extends BaseAccessTokenEntityInterface, TimeStampEntityInterface
{

}
