<?php

declare(strict_types=1);

namespace Wakeapp\Bundle\EnumerBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Wakeapp\Bundle\EnumerBundle\DependencyInjection\Compiler\EnumRegistryCompilerPass;

class WakeappEnumerBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new EnumRegistryCompilerPass());
    }
}
