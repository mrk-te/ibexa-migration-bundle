<?php

declare(strict_types=1);

namespace Kaliop\IbexaMigrationBundle\Core;

use Doctrine\DBAL\Connection;
use Ibexa\Contracts\Core\Repository\Repository;

/**
 * Functionality related to managing transactions - both "repo transactions" and "db transactions"
 *
 * Implemented as a trait to avoid breaking BC as much as possible.
 * @todo transform this into an interface + a service, when bumping a major version
 */
trait TransactionManagerTrait
{
    /** @var Repository $repository */
    protected $repository;

    /** @var Connection $connection */
    protected $connection;

    public function setRepository(Repository $repository): void
    {
        // NB: ideally we should retrieve the DB connection from the Repository. But that means going through
        // multiple steps of access to protected/private members (persistenceHandler / transactionHandler / ...) which
        // are not guaranteed to be stable, or even present. So we inject th connection separately...

        $this->repository = $repository;
    }

    public function setConnection(Connection $connection): void
    {
        $this->connection = $connection;
    }

    /**
     * Repo transaction
     * @return void
     */
    protected function beginTransaction(): void
    {
        $this->repository->beginTransaction();
    }

    /**
     * Repo transaction
     * @return void
     */
    protected function commit(): void
    {
        $this->repository->commit();
    }

    /**
     * Repo transaction
     * @return void
     */
    protected function rollback(): void
    {
        $this->repository->rollback();
    }

    /**
     * Resets the transaction counter and all other transaction-related info for the current db connection.
     * To be used only when we know for sure the db has no active transactions, and the DBAL object is out of sync
     * @internal
     * @return void
     */
    protected function resetDBTransaction()
    {
        $connection = $this->connection;
        if (interface_exists('ProxyManager\Proxy\ValueHolderInterface') && $connection instanceof \ProxyManager\Proxy\ValueHolderInterface) {
            $connection = $connection->getWrappedValueHolderValue();
        } elseif (interface_exists('Symfony\Component\VarExporter\LazyObjectInterface') && $connection instanceof \Symfony\Component\VarExporter\LazyObjectInterface) {
            $connection = $connection->initializeLazyObject();
        }

        $cl = \Closure::bind(function () {
                $this->transactionNestingLevel = 0;
                $this->isRollbackOnly = false;
            },
            $connection,
            $connection
        );
        $cl();
    }

    /**
     * Returns the current db transaction nesting level.
     *
     * @return int The nesting level. A value of 0 means there's no active transaction.
     */
    public function getDBTransactionNestingLevel()
    {
        return $this->connection->getTransactionNestingLevel();
    }

    public function rollbackDBTransaction()
    {
        return $this->connection->rollBack();
    }
}
