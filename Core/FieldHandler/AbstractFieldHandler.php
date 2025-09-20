<?php

namespace Kaliop\IbexaMigrationBundle\Core\FieldHandler;

use Kaliop\IbexaMigrationBundle\API\ReferenceResolverInterface;

abstract class AbstractFieldHandler
{
    /** @var ReferenceResolverInterface $referenceResolver */
    protected $referenceResolver;

    public function setReferenceResolver(ReferenceResolverInterface $referenceResolver)
    {
        $this->referenceResolver = $referenceResolver;
    }
}
