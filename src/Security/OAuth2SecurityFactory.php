<?php

declare(strict_types=1);

namespace sonrac\Auth\Security;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class OAuth2SecurityFactory.
 */
class OAuth2SecurityFactory implements SecurityFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint): array
    {
        $providerID = 'security.authentication.provider.sonrac_oauth.'.$id;

        $container->setDefinition($providerID, new ChildDefinition(OAuth2AuthenticationProvider::class))
            ->setArgument(0, new Reference($userProvider));

        $listenedID = 'security.authentication.listener.sonrac_oauth.'.$id;
        $container->setDefinition($listenedID, new ChildDefinition(OAuth2Listener::class));

        return [$providerID, $listenedID, $defaultEntryPoint];
    }

    /**
     * {@inheritdoc}
     */
    public function getPosition()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'oauth2';
    }

    public function addConfiguration(NodeDefinition $builder)
    {
    }
}
