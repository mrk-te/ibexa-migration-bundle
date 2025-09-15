<?php

include_once(__DIR__.'/MigrationExecutingTest.php');

/**
 * Tests the `status` command
 */
class StatusTest extends MigrationExecutingTest
{
    public function testSummary()
    {
        $output = $this->runCommand('kaliop:migration:status', array('--summary' => true));
        $this->assertMatchesRegularExpression('?\| Invalid +\| \d+ +\|?', $output);
        $this->assertMatchesRegularExpression('?\| To do +\| \d+ +\|?', $output);
        $this->assertMatchesRegularExpression('?\| Started +\| \d+ +\|?', $output);
        $this->assertMatchesRegularExpression('?\| Started +\| \d+ +\|?', $output);
        $this->assertMatchesRegularExpression('?\| Done +\| \d+ +\|?', $output);
        $this->assertMatchesRegularExpression('?\| Suspended +\| \d+ +\|?', $output);
        $this->assertMatchesRegularExpression('?\| Failed +\| \d+ +\|?', $output);
        $this->assertMatchesRegularExpression('?\| Skipped +\| \d+ +\|?', $output);
    }

    // Tests issue #190
    public function testSorting()
    {
        $filePath1 = $this->dslDir.'/misc/UnitTestOK701_harmless.yml';
        $filePath2 = $this->dslDir.'/misc/UnitTestOK702_harmless.yml';

        $this->prepareMigration($filePath1);
        $this->prepareMigration($filePath2);

        $output = $this->runCommand('kaliop:migration:migrate', array('--path' => array($filePath2), '-n' => true, '-u' => true));
        // check that there are no notes related to adding the migration before execution
        $this->assertMatchesRegularExpression('?\| ' . basename($filePath2) . ' +\| +\|?', $output);
        sleep(1);
        $output = $this->runCommand('kaliop:migration:migrate', array('--path' => array($filePath1), '-n' => true, '-u' => true));
        // check that there are no notes related to adding the migration before execution
        $this->assertMatchesRegularExpression('?\| ' . basename($filePath1) . ' +\| +\|?', $output);

        $output = $this->runCommand('kaliop:migration:status');
        $this->assertMatchesRegularExpression('?\| ' . basename($filePath1) . ' +\| executed +\|.+\| ' . basename($filePath2) . ' +\| executed +\|?s', $output);

        $output = $this->runCommand('kaliop:migration:status', array('--sort-by' => 'execution'));
        $this->assertMatchesRegularExpression('?\| ' . basename($filePath2) . ' +\| executed +\|.+\| ' . basename($filePath1) . ' +\| executed +\|?s', $output);

        $this->deleteMigration($filePath1);
        $this->deleteMigration($filePath2);
    }

    public function testTodo()
    {
        $filePath = realpath($this->dslDir.'/misc/UnitTestOK701_harmless.yml');
        $this->prepareMigration($filePath);
        $output = $this->runCommand('kaliop:migration:status', array('--todo' => true));
        $this->assertMatchesRegularExpression('?^'.$filePath.'$?m', $output);

        $this->deleteMigration($filePath);
    }

    public function testPath()
    {
        $filePath = $this->dslDir.'/misc/UnitTestOK701_harmless.yml';
        $this->deleteMigration($filePath, false);

        $output = $this->runCommand('kaliop:migration:status');
        $this->assertStringNotContainsString(basename($filePath), $output);

        $output = $this->runCommand('kaliop:migration:status', array('--path' => array($filePath)));
        $this->assertStringContainsString(basename($filePath), $output);
        $this->assertStringNotContainsString('20100101000200_MigrateV1ToV2.php', $output);

        $this->addMigration($filePath);
        $output = $this->runCommand('kaliop:migration:status');
        $this->assertStringContainsString(basename($filePath), $output);

        $this->deleteMigration($filePath);
    }

    public function testShowPath()
    {
        $filePath = $this->dslDir.'/misc/UnitTestOK701_harmless.yml';
        $this->deleteMigration($filePath, false);

        $output = $this->runCommand('kaliop:migration:status', array('--show-path' => true, '--path' => array($filePath)));
        $this->assertStringContainsString(realpath($filePath), $output);

        $this->addMigration($filePath);
        $output = $this->runCommand('kaliop:migration:status', array('--show-path' => true));
        $this->assertStringContainsString(realpath($filePath), $output);

        $this->deleteMigration($filePath);
    }
}
