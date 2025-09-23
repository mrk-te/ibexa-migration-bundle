<?php

namespace Kaliop\IbexaMigrationBundle\API\Exception;

class MigrationStepExecutionException extends MigrationBundleException
{
    public function __construct($message = "", $step = 0, \Throwable $previous = null)
    {
        $message = "Error in execution of step $step: " . $message;

        parent::__construct($message, $step, $previous);
    }
}
