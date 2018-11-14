<?php

declare(strict_types=1);

namespace Wakeapp\Bundle\EnumerBundle\Factory;

use ReflectionException;
use Wakeapp\Component\Enumer\Enumer;
use Wakeapp\Component\Enumer\EnumRegistry;

class EnumerFactory
{
    /**
     * @param array $enumClassList
     *
     * @return Enumer
     *
     * @throws ReflectionException
     */
    public static function create(array $enumClassList): Enumer
    {
        $registry = new EnumRegistry();

        foreach ($enumClassList as $enumClass) {
            $registry->addEnum($enumClass);
        }

        $enumer = new Enumer($registry);

        return $enumer;
    }
}
