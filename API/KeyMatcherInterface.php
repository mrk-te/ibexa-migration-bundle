<?php

namespace Kaliop\IbexaMigrationBundle\API;

interface KeyMatcherInterface extends MatcherInterface
{
    /**
     * Matches *one* item based on a unique key (id, identifier, etc... as long as it is a scalar value)
     * @see MatcherInterface
     *
     * @param string|int $key
     * @return mixed
     * @throws \Kaliop\IbexaMigrationBundle\API\Exception\InvalidMatchConditionsException
     * @throws \Kaliop\IbexaMigrationBundle\API\Exception\InvalidMatchResultsNumberException
     */
    public function matchOneByKey($key);
}
