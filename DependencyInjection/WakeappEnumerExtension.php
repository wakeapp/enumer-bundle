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
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use function class_exists;

class WakeappEnumerExtension extends Extension implements PrependExtensionInterface
{
    public const PARAMETER_SOURCES = 'wakeapp_enumer.source_directories';

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(self::PARAMETER_SOURCES, $config['source_directories'] ?? []);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        if (!$this->isNeedIntegrationWithDbalEnumType($container)) {
            $container->removeDefinition('Wakeapp\Bundle\EnumerBundle\Doctrine\Connection\ConnectionFactoryDecorator');
            $container->removeDefinition('Wakeapp\Component\DbalEnumType\EventSubscriber\EnumEventSubscriber');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container): void
    {
        if (!$this->isNeedIntegrationWithDbalEnumType($container)) {
            return;
        }

        $container->prependExtensionConfig('doctrine', [
            'dbal' => [
                'driver_class' => 'Wakeapp\Component\DbalEnumType\Driver\PDOMySql\EnumAwareDriver'
            ]
        ]);
    }

    /**
     * @param ContainerBuilder $container
     *
     * @return bool
     */
    private function isNeedIntegrationWithDbalEnumType(ContainerBuilder $container): bool
    {
        $bundleList = $container->getParameter('kernel.bundles');
        $doctrineBundleInstalled = isset($bundleList['DoctrineBundle']);

        if (!$doctrineBundleInstalled) {
            return false;
        }

        $dbalEnumTypeInstalled = class_exists('Wakeapp\Component\DbalEnumType\Driver\PDOMySql\EnumAwareDriver');

        if (!$dbalEnumTypeInstalled) {
            return false;
        }

        return true;
    }
}
