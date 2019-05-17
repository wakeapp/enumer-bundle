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

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class WakeappEnumerExtension extends Extension
{
    public const PARAMETER_SOURCES = 'wakeapp_enumer.source_directories';
    public const PARAMETER_SOURCE_CLASSES = 'wakeapp_enumer.source_classes';

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $projectDir = $container->getParameter('kernel.project_dir');

        $configuration = new Configuration($projectDir);
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(self::PARAMETER_SOURCES, $config['source_directories'] ?? []);
        $container->setParameter(self::PARAMETER_SOURCE_CLASSES, $config['source_classes'] ?? []);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }
}
