<?php

namespace Kaliop\IbexaMigrationBundle\Core\ReferenceResolver;

use Kaliop\IbexaMigrationBundle\API\EmbeddedReferenceResolverInterface;

abstract class AbstractResolver extends PrefixBasedResolver implements EmbeddedReferenceResolverInterface
{
    use EmbeddedRegexpReferenceResolverTrait;
}
