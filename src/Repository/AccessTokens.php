<?php

declare(strict_types=1);

namespace sonrac\Auth\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use Psr\Container\ContainerInterface;
use sonrac\Auth\Entity\AccessToken;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class AccessTokens.
 *
 * @method AccessToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccessToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccessToken[]    findAll()
 * @method AccessToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccessTokens extends ServiceEntityRepository implements AccessTokenRepositoryInterface
{
    use TokenEntityTrait;

    /**
     * Access token entity classname.
     *
     * @var string
     */
    private $container;

    /**
     * AccessTokens constructor.
     *
     * @param \Symfony\Bridge\Doctrine\RegistryInterface $registry
     * @param ContainerInterface                         $container
     */
    public function __construct(RegistryInterface $registry, ContainerInterface $container)
    {
        $this->container = $container;
        parent::__construct($registry, AccessToken::class);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        /** @var \sonrac\Auth\Entity\Client $clientEntity */
        $token = $this->container->get(AccessTokenEntityInterface::class);

        $token->setGrantType($this->container->get('request_stack')->pop()->get('grant_type'));

        $token->setClient($clientEntity);

        if ($userIdentifier) {
            $this->setUserIdentifier($userIdentifier);
        }

        return $token;
    }

    /**
     * @param \sonrac\Auth\Entity\AccessToken|AccessTokenEntityInterface $accessTokenEntity
     *                                                                                      {@inheritdoc}
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        if (!$accessTokenEntity->getCreatedAt()) {
            $accessTokenEntity->setCreatedAt(\time());
        }

        $this->_em->persist($accessTokenEntity);
        $this->_em->flush();
    }

    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException If token does not find.
     */
    public function revokeAccessToken($tokenId): void
    {
        $token = $this->find($tokenId);
        if (!$token) {
            throw new \InvalidArgumentException('Token does not find');
        }

        $token->setIsRevoked(true);
        $this->_em->persist($token);
        $this->_em->flush();
    }

    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException
     */
    public function isAccessTokenRevoked($tokenId): bool
    {
        /** @var \sonrac\Auth\Entity\AccessToken $entity */
        $entity = $this->find($tokenId);

        if (!$entity) {
            throw new \InvalidArgumentException('Token not found');
        }

        return (bool)$entity->isRevoked();
    }
}
