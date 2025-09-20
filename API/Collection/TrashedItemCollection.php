<?php

namespace Kaliop\IbexaMigrationBundle\API\Collection;

/**
 * @todo add phpdoc to suggest typehinting
 */
class TrashedItemCollection extends AbstractCollection
{
    protected $allowedClass = 'Ibexa\Contracts\Core\Repository\Values\Content\TrashItem';
}
