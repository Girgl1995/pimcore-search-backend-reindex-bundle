<?php

declare(strict_types=1);

namespace Factotum\SearchBackendReindexBundle\Service\Command;

use Pimcore\Console\Application;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\HttpKernel\KernelInterface;
use Throwable;

class CommandRunner
{
    private const REINDEX_COMMAND      = 'pimcore:search-backend-reindex';
    private const COMMAND_KEY          = 'command';
    private const MEMORY_LIMIT_KEY     = 'memory_limit';
    private const INVALID_MEMORY_LIMIT = 'Invalid memory_limit configuration "%s"; falling back to default value "%s".';

    /**
     * @param LoggerInterface $logger
     * @param KernelInterface $kernel
     * @param string $memoryLimit
     */
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly KernelInterface $kernel,
        private readonly string $memoryLimit
    ) {}

    /**
     * @return void
     *
     * @throws Throwable
     */
    public function run(): void
    {
        $defaultLimit = ini_get(self::MEMORY_LIMIT_KEY);

        try {
            ini_set(self::MEMORY_LIMIT_KEY, $this->memoryLimit);
        } catch (Throwable $exception) {
            ini_set(self::MEMORY_LIMIT_KEY, $defaultLimit);

            $this->logger->error(
                sprintf(
                    self::INVALID_MEMORY_LIMIT,
                    $this->memoryLimit,
                    $defaultLimit
                ) . $exception->getMessage()
            );
        }

        $application = new Application($this->kernel);
        $application->setAutoExit(false);
        $application->setCatchExceptions(false);
        $application->setCatchErrors(false);

        $application->run(
            new ArrayInput([
                self::COMMAND_KEY => self::REINDEX_COMMAND,
            ]),
            new ConsoleOutput()
        );
    }
}
