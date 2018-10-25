<?php

declare(strict_types=1);

namespace sonrac\Auth\Security;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class Oauth2Token extends AbstractToken
{
    public $created;

    public $digest;

    public $nonce;

    public function __construct(array $roles = [])
    {
        parent::__construct($roles);

        $this->setAuthenticated(\count($roles) > 0);
    }

    public function getCredentials()
    {
        return '';
    }
}
