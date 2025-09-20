<?php

namespace Kaliop\IbexaMigrationBundle\Tests\helper;

use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Core\QueryType\QueryType;

class MigrationTestQueryType implements QueryType
{
    public static function getName()
    {
        return 'kezmbtest_query';
    }

    public function getQuery(array $parameters = [])
    {
        $query = new LocationQuery();
        return $query;
    }

    public function getSupportedParameters()
    {
        return array();
    }
}
