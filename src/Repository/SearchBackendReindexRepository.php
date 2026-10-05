<?php

declare(strict_types=1);

namespace Factotum\SearchBackendReindexBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Factotum\SearchBackendReindexBundle\Entity\SearchBackendReindexEntity;

class SearchBackendReindexRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SearchBackendReindexEntity::class);
    }
}
