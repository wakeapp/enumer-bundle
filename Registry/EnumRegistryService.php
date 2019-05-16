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

namespace Wakeapp\Bundle\EnumerBundle\Registry;

use Wakeapp\Component\Enumer\EnumRegistry;
use function is_string;
use function mb_strtolower;

class EnumRegistryService
{
    /**
     * @var array
     */
    private $enumList;

    /**
     * @param array $enumList
     */
    public function __construct(array $enumList)
    {
        $this->enumList = $enumList;
    }

    /**
     * @param string $enumClass
     *
     * @return bool
     */
    public function hasEnum(string $enumClass): bool
    {
        return isset($this->enumList[$enumClass]);
    }

    /**
     * @param string $enumClass
     *
     * @return array
     */
    public function getOriginalList(string $enumClass): array
    {
        return $this->enumList[$enumClass][EnumRegistry::TYPE_ORIGINAL];
    }

    /**
     * @param string $enumClass
     * @param string|int|float|null $value
     *
     * @return string|null
     */
    public function getOriginalValue(string $enumClass, $value): ?string
    {
        if (null === $value) {
            return null;
        }

        $enumValueList = $this->getCombinedList($enumClass);

        if (isset($enumValueList[$value])) {
            return $enumValueList[$value];
        }

        if (!is_string($value)) {
            return null;
        }

        $enumValueList = $this->getNormalizedList($enumClass);
        $value = mb_strtolower($value);

        return $enumValueList[$value] ?? null;
    }

    /**
     * @param string $enumClass
     *
     * @return array
     */
    public function getCombinedList(string $enumClass): array
    {
        return $this->enumList[$enumClass][EnumRegistry::TYPE_COMBINE];
    }

    /**
     * @param string $enumClass
     *
     * @return array
     */
    public function getNormalizedList(string $enumClass): array
    {
        return $this->enumList[$enumClass][EnumRegistry::TYPE_COMBINE_NORMALIZE];
    }
}
