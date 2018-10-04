<?php

declare(strict_types=1);

namespace Wakeapp\EnumerBundle\Traits;

use Wakeapp\Component\Enumer\Enumer;

/**
 * Trait EnumerAwareTrait
 */
trait EnumerAwareTrait
{
    /**
     * @var Enumer
     */
    protected $enumer;

    /**
     * @require
     *
     * @param Enumer $enumer
     */
    public function setEnumer(Enumer $enumer)
    {
        $this->enumer = $enumer;
    }
}
