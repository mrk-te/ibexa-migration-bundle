<?php

namespace Kaliop\IbexaMigrationBundle\Tests\helper;

use Kaliop\IbexaMigrationBundle\API\Event\BeforeStepExecutionEvent;

class BeforeStepExecutionListener
{
    static $executions = 0;

    public function onBeforeStepExecution(BeforeStepExecutionEvent $event)
    {
        self::$executions++;
    }

    public static function getExecutions()
    {
        return self::$executions;
    }
}
