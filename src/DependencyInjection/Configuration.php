<?php

declare(strict_types=1);

/*
 * This file is part of the broadway/broadway-bundle package.
 *
 * (c) 2020 Broadway project
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Broadway\Bundle\BroadwayBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration definition.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('broadway');

        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('event_store')
                    ->info('a service definition id implementing Broadway\EventStore\EventStore')
                ->end()
                ->arrayNode('serializer')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('payload')->defaultValue('broadway.simple_interface_serializer')->end()
                        ->scalarNode('readmodel')->defaultValue('broadway.simple_interface_serializer')->end()
                        ->scalarNode('metadata')->defaultValue('broadway.simple_interface_serializer')->end()
                    ->end()
                ->end()
                ->scalarNode('read_model')
                    ->info('a service definition id implementing Broadway\ReadModel\RepositoryFactory')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
