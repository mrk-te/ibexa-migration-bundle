<?php

namespace Kaliop\IbexaMigrationBundle\Tests\helper;

use Kaliop\IbexaMigrationBundle\API\Exception\MigrationAbortedException;

class JustAService
{
    public function echoBack($string)
    {
        return $string;
    }

    public function throwMigrationAbortedException($msg)
    {
        throw  new MigrationAbortedException($msg);
    }
}
