<?php

declare(strict_types=1);

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
