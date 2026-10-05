<?php

declare(strict_types=1);

namespace Factotum\SearchBackendReindexBundle\Service\Notification;

use Pimcore\Model\Notification\Service\NotificationService;
use Pimcore\Model\User;
use Symfony\Contracts\Translation\TranslatorInterface;

class NotificationSender
{
    private const ADMIN_DOMAIN                  = 'admin';
    private const REINDEX_COMPLETED_TITLE_KEY   = 'reindex_completed_title';
    private const REINDEX_COMPLETED_MESSAGE_KEY = 'reindex_completed_message';
    private const REINDEX_FAILED_TITLE_KEY      = 'reindex_failed_title';
    private const REINDEX_FAILED_MESSAGE_KEY    = 'reindex_failed_message';

    /**
     * @param TranslatorInterface $translator
     * @param NotificationService $notification
     */
    public function __construct(
        private readonly TranslatorInterface $translator,
        private readonly NotificationService $notification,
    ) {}

    /**
     * @param int $ownerId
     * @return void
     */
    public function notifyAllUsersAboutReindexSuccess(int $ownerId): void
    {
        $title = $this->translator->trans(
            self::REINDEX_COMPLETED_TITLE_KEY,
            domain: self::ADMIN_DOMAIN,
        );

        $message = $this->translator->trans(
            self::REINDEX_COMPLETED_MESSAGE_KEY,
            domain: self::ADMIN_DOMAIN,
        );

        $this->notifyAllUsers($ownerId, $title, $message);
    }

    /**
     * @param int $ownerId
     * @param string $errorMessage
     * @return void
     */
    public function notifyAllUsersAboutReindexFailure(int $ownerId, string $errorMessage): void
    {
        $title = $this->translator->trans(
            self::REINDEX_FAILED_TITLE_KEY,
            domain: self::ADMIN_DOMAIN,
        );

        $message = sprintf($this->translator->trans(
            self::REINDEX_FAILED_MESSAGE_KEY,
            domain: self::ADMIN_DOMAIN,
        ), $errorMessage);

        $this->notifyAllUsers($ownerId, $title, $message);
    }

    /**
     * @param int $ownerId
     * @param string $title
     * @param string $message
     * @return void
     */
    private function notifyAllUsers(int $ownerId, string $title, string $message): void
    {
        $listing = new User\Listing();
        $users   = $listing->getUsers();

        foreach ($users as $user) {
            $this->notification->sendToUser(
                $user->getId(),
                $ownerId,
                $title,
                $message,
            );
        }
    }
}
