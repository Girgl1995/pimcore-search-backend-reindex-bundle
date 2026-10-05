<?php

declare(strict_types=1);

namespace Factotum\SearchBackendReindexBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Factotum\SearchBackendReindexBundle\Entity\SearchBackendReindexEntity;
use Factotum\SearchBackendReindexBundle\Repository\SearchBackendReindexRepository;

class SearchBackendReindexEntityService
{
    private const USER_OWNER_PROPERTY = 'userOwner';

    /**
     * @param SearchBackendReindexRepository $repository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private readonly SearchBackendReindexRepository $repository,
        private readonly EntityManagerInterface $entityManager,
    ) {}

    /**
     * @param int|null $timestamp
     * @param int $userOwner
     * @return SearchBackendReindexEntity
     */
    public function create(
        ?int $timestamp,
        int $userOwner,
    ): SearchBackendReindexEntity {
        $state = new SearchBackendReindexEntity();

        $state
            ->setTimestamp($timestamp)
            ->setUserOwner($userOwner);

        $this->entityManager->persist($state);
        $this->entityManager->flush();

        return $state;
    }

    /**
     * @param int $userOwner
     * @return void
     */
    public function deleteByUserOwner(int $userOwner): void
    {
        $entity = $this->repository->findOneBy([
            self::USER_OWNER_PROPERTY => $userOwner,
        ]);

        if ($entity === null) {
            return;
        }

        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    /**
     * @return bool
     */
    public function reindexRequestExists(): bool
    {
        if ($this->repository->findAll()) {
            return true;
        }

        return false;
    }
}
