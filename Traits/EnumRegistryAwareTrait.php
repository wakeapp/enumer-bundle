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

namespace Wakeapp\Bundle\EnumerBundle\Traits;

use Wakeapp\Bundle\EnumerBundle\Registry\EnumRegistryService;

trait EnumRegistryAwareTrait
{
    /**
     * @var EnumRegistryService
     */
    protected $enumer;

    /**
     * @require
     *
     * @param EnumRegistryService $enumer
     */
    public function setEnumer(EnumRegistryService $enumer)
    {
        $this->enumer = $enumer;
    }
}
