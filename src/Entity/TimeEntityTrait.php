<?php

declare(strict_types=1);

namespace sonrac\Auth\Entity;

/**
 * Class TimeEntityTrait.
 *
 * Class property created_at and updated_at must be exists.
 */
trait TimeEntityTrait
{
    /**
     * Get created time.
     *
     * @return int
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->{$this->getCreatedAtFieldName()};
    }

    /**
     * Get created at field name.
     *
     * @return string
     */
    protected function getCreatedAtFieldName(): string
    {
        return 'created_at';
    }

    /**
     * Set created time.
     *
     * @param int|string $created_at
     */
    public function setCreatedAt($created_at): void
    {
        $this->setTimeField($created_at, $this->getCreatedAtFieldName());
    }

    /**
     * Get updated time.
     *
     * @return int|null
     */
    public function getUpdatedAt(): ?int
    {
        return $this->{$this->getUpdatedAtFieldName()};
    }

    /**
     * Get updated at field name.
     *
     * @return string
     */
    protected function getUpdatedAtFieldName(): string
    {
        return 'updated_at';
    }

    /**
     * Set updated time.
     *
     * @param int|string $updated_at
     */
    public function setUpdatedAt($updated_at): void
    {
        $this->setTimeField($updated_at, $this->getUpdatedAtFieldName());
    }

    /**
     * Set time in object field.
     *
     * @param int|string|\DateTime|null $time
     * @param string                    $fieldName
     */
    private function setTimeField($time, string $fieldName): void
    {
        if ($time instanceof \DateTime) {
            $this->{$fieldName} = $time;

            return;
        }

        $this->{$fieldName} = new \DateTime();

        if (\is_numeric($time)) {
            $this->{$fieldName}->setTimestamp($time);
        }

        if (\is_string($time)) {
            $this->{$fieldName}->setTimestamp(\strtotime($time));
        }
    }
}
