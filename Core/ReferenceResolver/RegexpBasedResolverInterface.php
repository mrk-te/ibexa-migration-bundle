<?php

namespace Kaliop\IbexaMigrationBundle\Core\ReferenceResolver;

use Kaliop\IbexaMigrationBundle\API\ReferenceResolverInterface;

interface RegexpBasedResolverInterface extends ReferenceResolverInterface
{
    /**
     * Returns the regexp used to identify if a string is a reference
     * @return string
     */
    public function getRegexp();
}
