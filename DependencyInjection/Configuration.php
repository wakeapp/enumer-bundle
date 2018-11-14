<?php

declare(strict_types=1);

namespace Wakeapp\Bundle\EnumerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('wakeapp_enumer');

        $rootNode
            ->children()
                ->arrayNode('enum_class')
                    ->prototype('scalar')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
