<?php

declare(strict_types=1);

namespace Factotum\SearchBackendReindexBundle\Service;

use Factotum\SearchBackendReindexBundle\Message\SearchBackendReindexMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class SearchBackendReindexService
{
    /**
     * @param MessageBusInterface $messageBus
     */
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    ) {}

    /**
     * @param int $ownerId
     * @return void
     */
    public function dispatch(int $ownerId): void
    {
        $this->messageBus->dispatch(
            new SearchBackendReindexMessage($ownerId)
        );
    }
}
