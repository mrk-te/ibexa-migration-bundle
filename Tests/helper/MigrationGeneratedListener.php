<?php

namespace Kaliop\IbexaMigrationBundle\Tests\helper;

use Kaliop\IbexaMigrationBundle\API\Event\MigrationGeneratedEvent;

class MigrationGeneratedListener
{
    static $event;

    public function onMigrationGenerated(MigrationGeneratedEvent $event)
    {
        self::$event = $event;
    }

    public static function getLastEvent()
    {
        return self::$executions;
    }
}
