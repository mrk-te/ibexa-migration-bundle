<?php

namespace Kaliop\IbexaMigrationBundle\API\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Kaliop\IbexaMigrationBundle\API\Value\MigrationStep;

class StepExecutedEvent extends Event
{
    protected $step;
    protected $result;

    public function __construct(MigrationStep $step, $result)
    {
        $this->step = $step;
        $this->result = $result;
    }

    /**
     * @return MigrationStep
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }
}
