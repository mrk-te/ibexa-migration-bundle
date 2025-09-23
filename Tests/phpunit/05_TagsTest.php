<?php

include_once(__DIR__.'/MigrationExecutingTest.php');

use Kaliop\IbexaMigrationBundle\Tests\helper\BeforeStepExecutionListener;
use Kaliop\IbexaMigrationBundle\Tests\helper\StepExecutedListener;

/**
 * Tests the 'kaliop:migration:migrate' and (partially) 'kaliop:migration:migration' command for eZTags
 */
class TagsTest extends MigrationExecutingTest
{
    /**
     * @param string $filePath
     * @dataProvider goodDSLProvider
     */
    public function testExecuteGoodDSL($filePath = '')
    {
        $bundles = $this->getBootedContainer()->getParameter('kernel.bundles');

        if ($filePath == '' || !isset($bundles['NetgenTagsBundle'])) {
            $this->markTestSkipped();
            return;
        }

        $this->prepareMigration($filePath);

        $count1 = BeforeStepExecutionListener::getExecutions();
        $count2 = StepExecutedListener::getExecutions();

        $output = $this->runCommand('kaliop:migration:migrate', array('--path' => array($filePath), '-n' => true, '-u' => true));
        // check that there are no notes after adding the migration
        $this->assertMatchesRegularExpression('?\| ' . basename($filePath) . ' +\| +\|?', $output);

        // simplistic check on the event listeners having fired off correctly
        $this->assertGreaterThanOrEqual($count1 + 1, BeforeStepExecutionListener::getExecutions(), "Migration 'before step' listener did not fire");
        $this->assertGreaterThanOrEqual($count2 + 1, StepExecutedListener::getExecutions(), "Migration 'step executed' listener did not fire");

        $this->deleteMigration($filePath);
    }

    public function goodDSLProvider()
    {
        $dslDir = $this->dslDir.'/eztags';

        if (!is_dir($dslDir)) {
            return array();
        }

        $out = array();
        foreach (scandir($dslDir) as $fileName) {
            $filePath = $dslDir . '/' . $fileName;
            if (is_file($filePath)) {
                $out[] = array($filePath);
            }
        }
        return $out;
    }
}
