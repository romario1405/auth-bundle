<?php

declare(strict_types=1);

namespace sonrac\Auth\Security;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Class OAuth2AuthenticationProvider.
 */
class OAuth2AuthenticationProvider implements AuthenticationProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function authenticate(TokenInterface $token)
    {
        throw new AuthenticationException('The WSSE authentication failed.');
    }

    /**
     * {@inheritdoc}
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof Oauth2Token;
    }
}
