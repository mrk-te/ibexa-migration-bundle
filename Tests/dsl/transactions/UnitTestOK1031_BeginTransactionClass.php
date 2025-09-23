<?php

use Kaliop\IbexaMigrationBundle\API\MigrationInterface;

use Symfony\Component\DependencyInjection\ContainerInterface;

class BeginTransactionClass implements MigrationInterface
{
    public static function execute(ContainerInterface $container)
    {
        /** @var \Doctrine\DBAL\Connection $conn */
        $conn = $container->get('ibexa.persistence.connection');
        $conn->beginTransaction();
        $stmt = $conn->executeQuery('SELECT SYSDATE();');
        $rows = $stmt->fetchAllAssociative();
        // we omit voluntarily committing the transaction

        // we return non-null to make sure that the listener tests pass
        return 1;
    }
}
