<?php

declare(strict_types=1);

namespace sonrac\Auth\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
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
     * Token entity.
     *
     * @var \League\OAuth2\Server\Entities\AccessTokenEntityInterface|null
     */
    protected $token;

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
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AccessToken::class);
    }

    /**
     * Set access token entity.
     *
     * @param \League\OAuth2\Server\Entities\AccessTokenEntityInterface $token
     */
    public function setToken(AccessTokenEntityInterface $token)
    {
        $this->token = $token;
    }

    /**
     * Get access token entity.
     *
     * @return \League\OAuth2\Server\Entities\AccessTokenEntityInterface|null
     */
    public function getToken(): ?AccessTokenEntityInterface
    {
        return $this->token;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $this->getToken()->setClient($clientEntity);

        if ($userIdentifier) {
            $this->setUserIdentifier($userIdentifier);
        }

        return $this->getToken();
    }

    /**
     *{@inheritdoc}
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

        return (bool) $entity->isRevoked();
    }
}
