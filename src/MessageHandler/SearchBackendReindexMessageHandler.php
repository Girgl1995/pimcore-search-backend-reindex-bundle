<?php

declare(strict_types=1);

namespace Factotum\SearchBackendReindexBundle\MessageHandler;

use Factotum\SearchBackendReindexBundle\Message\SearchBackendReindexMessage;
use Factotum\SearchBackendReindexBundle\Service\Command\CommandRunner;
use Factotum\SearchBackendReindexBundle\Service\Notification\NotificationSender;
use Factotum\SearchBackendReindexBundle\Service\SearchBackendReindexEntityService;
use Psr\Log\LoggerInterface;
use Throwable;

class SearchBackendReindexMessageHandler
{
    /**
     * @param CommandRunner $commandRunner
     * @param NotificationSender $notificationSender
     * @param SearchBackendReindexEntityService $entityService
     */
    public function __construct(
        private readonly CommandRunner $commandRunner,
        private readonly NotificationSender $notificationSender,
        private readonly LoggerInterface $logger,
        private readonly SearchBackendReindexEntityService $entityService,
    ) {}

    /**
     * @param SearchBackendReindexMessage $message
     * @return void
     */
    public function __invoke(SearchBackendReindexMessage $message): void
    {
        $ownerId = $message->ownerId;

        try {
            $this->commandRunner->run();

            $this->notificationSender->notifyAllUsersAboutReindexSuccess($ownerId);
        } catch (Throwable $e) {
            $this->logger->error($e->getMessage());
            $this->notificationSender->notifyAllUsersAboutReindexFailure($ownerId, $e->getMessage());
        }

        $this->entityService->deleteByUserOwner($ownerId);
    }
}
