<?php

declare(strict_types=1);

namespace Factotum\SearchBackendReindexBundle\Message;

final readonly class SearchBackendReindexMessage
{
    /**
     * @param int $ownerId
     */
    public function __construct(
        public readonly int $ownerId
    ) {}
}
