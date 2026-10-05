<?php

declare(strict_types=1);

namespace Factotum\SearchBackendReindexBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    private const MEMORY_LIMIT_KEY = 'memory_limit';

    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(Extension::BUNDLE_ALIAS);

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode(self::MEMORY_LIMIT_KEY)
                    ->defaultValue(ini_get(self::MEMORY_LIMIT_KEY))
                ->end()
            ->end();

        return $treeBuilder;
    }
}
