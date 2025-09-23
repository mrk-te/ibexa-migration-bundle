<?php

namespace Kaliop\IbexaMigrationBundle\Core\Helper;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Ibexa\Contracts\Core\SiteAccess\ConfigResolverInterface;
use Kaliop\IbexaMigrationBundle\API\ConfigResolverInterface as KMBConfigResolverInterface;
use Kaliop\IbexaMigrationBundle\API\Exception\MigrationBundleException;

/**
 * Helps with BC: allows a parameter to be defined either as dynamic (siteaccess-aware) or as simple Sf parameter
 */
class ConfigResolver implements KMBConfigResolverInterface
{
    /** @var ConfigResolverInterface $ezConfigResolver */
    protected $ezConfigResolver;

    protected $container;

    public function __construct(ConfigResolverInterface $ezConfigResolver, ContainerInterface $container)
    {
        $this->ezConfigResolver = $ezConfigResolver;
        $this->container = $container;
    }

    /**
     * @param string $paramName
     * @param string $scope
     * @return mixed
     * @throws \Exception
     */
    public function getParameter($paramName, $scope = null)
    {
        $parsed = explode('.', $paramName, 2);
        if (count($parsed) === 1) {
            throw new MigrationBundleException("Parameter '$paramName' is not in the good format for flexible configuration resolving");
        }

        if ($this->ezConfigResolver->hasParameter($parsed[1], $parsed[0], $scope)) {
            return $this->ezConfigResolver->getParameter($parsed[1], $parsed[0], $scope);
        }

        return $this->container->getParameter($paramName);
    }
}
