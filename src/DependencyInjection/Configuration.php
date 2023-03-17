<?php declare(strict_types=1);
namespace Fingo\Bundle\PipedriveBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('fingo_pipedrive');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('providers')
                ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('client_id')->defaultNull()->end()
                            ->scalarNode('client_secret')->defaultNull()->end()
                            ->scalarNode('redirect_uri')->defaultNull()->end()
                            ->scalarNode('secret')->defaultNull()->end()
                            ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}