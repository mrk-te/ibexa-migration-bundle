<?php

namespace Kaliop\IbexaMigrationBundle\API\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Kaliop\IbexaMigrationBundle\API\Value\MigrationStep;
use Kaliop\IbexaMigrationBundle\API\Exception\MigrationAbortedException;

class MigrationAbortedEvent extends Event
{
    protected $step;
    protected $exception;

    public function __construct(MigrationStep $step, MigrationAbortedException $exception)
    {
        $this->step = $step;
        $this->exception = $exception;
    }

    /**
     * @return MigrationStep
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @return MigrationAbortedException
     */
    public function getException()
    {
        return $this->exception;
    }
}
