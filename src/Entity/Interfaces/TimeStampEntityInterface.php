<?php

declare(strict_types=1);

namespace sonrac\Auth\Entity\Interfaces;

/**
 * Interface TimeStampEntityInterface.
 *
 * @package sonrac\Auth\Entity\Interfaces
 */
interface TimeStampEntityInterface
{
    /**
     * Get created at.
     *
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime;

    /**
     * Set created at.
     *
     * @param string|\DateTime|int $time
     *
     * @return mixed
     */
    public function setCreatedAt($time);

    /**
     * Set updated at.
     *
     * @param string|\DateTime|int $time
     *
     * @return mixed
     */
    public function setUpdatedAt($time);

    /**
     * Set updated at.
     *
     * @param string|\DateTime|int $time
     *
     * @return mixed
     */
    public function getUpdatedAt($time): \DateTime;
}
