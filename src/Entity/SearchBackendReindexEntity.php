<?php

declare(strict_types=1);

namespace Factotum\SearchBackendReindexBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Factotum\SearchBackendReindexBundle\Repository\BackendReindexRepository;

#[ORM\Entity(repositoryClass: BackendReindexRepository::class)]
#[ORM\Table(name: 'search_backend_reindex')]
class SearchBackendReindexEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'bigint', nullable: true)]
    private ?int $timestamp = null;

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private int $userOwner;

    /**
     * @return int|null
     */
    public function getTimestamp(): ?int
    {
        return $this->timestamp;
    }

    /**
     * @param int|null $timestamp
     * @return self
     */
    public function setTimestamp(?int $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserOwner(): int
    {
        return $this->userOwner;
    }

    /**
     * @param int $userOwner
     * @return self
     */
    public function setUserOwner(int $userOwner): self
    {
        $this->userOwner = $userOwner;

        return $this;
    }
}
