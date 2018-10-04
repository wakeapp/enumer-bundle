<?php

declare(strict_types=1);

namespace Wakeapp\EnumerBundle\Factory;

use ReflectionException;
use Wakeapp\Component\Enumer\Enumer;
use Wakeapp\Component\Enumer\EnumRegistry;

/**
 * Class EnumerFactory
 */
class EnumerFactory
{
    /**
     * @param array $enumClassList
     *
     * @return Enumer
     * @throws ReflectionException
     */
    public function create(array $enumClassList)
    {
        $registry = new EnumRegistry();

        foreach ($enumClassList as $enumClass) {
            $registry->addEnum($enumClass);
        }

        $enumer = new Enumer($registry);

        return $enumer;
    }
}
