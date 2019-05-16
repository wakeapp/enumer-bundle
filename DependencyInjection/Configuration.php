<?php

declare(strict_types=1);

/*
 * This file is part of the EnumerBundle package.
 *
 * (c) Wakeapp <https://wakeapp.ru>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Wakeapp\Bundle\EnumerBundle\DependencyInjection;

use Closure;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use function class_exists;
use function is_dir;
use function method_exists;
use function sprintf;

class Configuration implements ConfigurationInterface
{
    /**
     * @var string
     */
    private $projectDir;

    /**
     * @param string $projectDir
     */
    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('wakeapp_enumer');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('wakeapp_enumer');
        }

        $rootNode
            ->children()
                ->arrayNode('source_directories')
                    ->defaultValue(['src'])
                    ->prototype('scalar')->end()
                    ->validate()
                        ->always($this->validationForSourceDirectories())
                    ->end()
                ->end()
                ->arrayNode('source_classes')
                    ->prototype('scalar')->end()
                    ->validate()
                        ->always($this->validationForSourceClasses())
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

    /**
     * @return Closure
     */
    private function validationForSourceDirectories(): Closure
    {
        $projectDir = $this->projectDir;

        return function (?array $directories) use ($projectDir) {
            foreach ($directories as $directory) {
                if (!is_dir($projectDir . DIRECTORY_SEPARATOR . $directory)) {
                    throw new InvalidConfigurationException(sprintf(
                        'Received directory "%s" under "source_directories" does not exists',
                        $directory
                    ));
                }
            }

            return $directories;
        };
    }

    /**
     * @return Closure
     */
    private function validationForSourceClasses(): Closure
    {
        return function (?array $classes) {
            foreach ($classes as $class) {
                if (!class_exists($class)) {
                    throw new InvalidConfigurationException(sprintf(
                        'Received class "%s" under "source_classes" does not exists',
                        $class
                    ));
                }
            }

            return $classes;
        };
    }
}
