<?php

declare(strict_types=1);

namespace Factotum\SearchBackendReindexBundle\Controller;

use Factotum\SearchBackendReindexBundle\Service\SearchBackendReindexEntityService;
use Factotum\SearchBackendReindexBundle\Service\SearchBackendReindexService;
use Pimcore\Controller\UserAwareController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class SearchBackendReindexController extends UserAwareController
{
    private const RESPONSE_SUCCESS_KEY              = 'success';
    private const SEARCH_BACKEND_REINDEX_PERMISSION = 'search_backend_reindex';
    
    /**
     * @param SearchBackendReindexEntityService $searchBackendReindexEntityService
     * @param SearchBackendReindexService $searchBackendReindexService
     * @return JsonResponse
     */
    #[Route('/admin/searchbackendreindex/reindex', name: 'search_backend_reindex', options: ['expose' => true], methods: ['GET'])]
    public function reindexAction(
        SearchBackendReindexEntityService $searchBackendReindexEntityService,
        SearchBackendReindexService $searchBackendReindexService,
    ): JsonResponse {
        $user = $this->getUser()->getUser();

        if (!$user->isAllowed(self::SEARCH_BACKEND_REINDEX_PERMISSION)) {
            return new JsonResponse([]);
        }

        if ($searchBackendReindexEntityService->reindexRequestExists()) {
            return new JsonResponse([self::RESPONSE_SUCCESS_KEY => false]);
        }

        $userId = $user->getId();

        $searchBackendReindexEntityService->create(time(), $userId);

        $searchBackendReindexService->dispatch($userId);

        return new JsonResponse([self::RESPONSE_SUCCESS_KEY => true]);
    }
}
