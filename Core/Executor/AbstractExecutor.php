<?php

namespace Kaliop\IbexaMigrationBundle\Core\Executor;

use Kaliop\IbexaMigrationBundle\API\Exception\InvalidStepDefinitionException;
use Kaliop\IbexaMigrationBundle\API\Value\MigrationStep;
use Kaliop\IbexaMigrationBundle\API\ExecutorInterface;

abstract class AbstractExecutor implements ExecutorInterface
{
    /// @todo check if all child classes do use this
    use ReferenceResolverTrait;

    protected $supportedStepTypes = array();

    public function supportedTypes()
    {
        return $this->supportedStepTypes;
    }

    /**
     * IT IS MANDATORY TO OVERRIDE THIS IN SUBCLASSES
     * @param MigrationStep $step
     * @return mixed
     * @throws InvalidStepDefinitionException
     */
    public function execute(MigrationStep $step)
    {
        if (!in_array($step->type, $this->supportedStepTypes)) {
            throw new InvalidStepDefinitionException("Something is wrong! Executor can not work on step of type '{$step->type}'");
        }
    }
}
