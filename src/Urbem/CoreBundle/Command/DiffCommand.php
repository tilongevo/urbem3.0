<?php

namespace Urbem\CoreBundle\Command;

use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Version as DbalVersion;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

class DiffCommand extends \Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand
{
    protected function getIgnoredEntitiesMetadata($metadatas)
    {
        $ignoredEntities = IgnoredEntities::entitiesList();

        /** @var $metadata \Doctrine\ORM\Mapping\ClassMetadata */
        $newMetadatas = array();
        foreach ($metadatas as $metadata) {
            if (!in_array($metadata->getName(), $ignoredEntities)) {
                array_push($newMetadatas, $metadata);
            }
        }

        return $newMetadatas;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $isDbalOld = (DbalVersion::compare('2.2.0') > 0);
        $configuration = $this->getMigrationConfiguration($input, $output);

        $em = $this->getHelper('em')->getEntityManager();
        $conn = $em->getConnection();
        $platform = $conn->getDatabasePlatform();
        $metadata = $this->getIgnoredEntitiesMetadata($em->getMetadataFactory()->getAllMetadata());

        if (empty($metadata)) {
            $output->writeln('No mapping information to process.', 'ERROR');

            return;
        }

        if ($filterExpr = $input->getOption('filter-expression')) {
            if ($isDbalOld) {
                throw new \InvalidArgumentException('The "--filter-expression" option can only be used as of Doctrine DBAL 2.2');
            }

            $conn->getConfiguration()
                ->setFilterSchemaAssetsExpression($filterExpr);
        }

        $tool = new SchemaTool($em);

        $fromSchema = $conn->getSchemaManager()->createSchema();
        $toSchema = $tool->getSchemaFromMetadata($metadata);

        //Not using value from options, because filters can be set from config.yml
        if (! $isDbalOld && $filterExpr = $conn->getConfiguration()->getFilterSchemaAssetsExpression()) {
            $tableNames = $toSchema->getTableNames();
            foreach ($tableNames as $tableName) {
                $tableName = substr($tableName, strpos($tableName, '.') + 1);
                if (! preg_match($filterExpr, $tableName)) {
                    $toSchema->dropTable($tableName);
                }
            }
        }

        $up = $this->buildCodeFromSql($configuration, $fromSchema->getMigrateToSql($toSchema, $platform));
        $down = $this->buildCodeFromSql($configuration, $fromSchema->getMigrateFromSql($toSchema, $platform));

        if (! $up && ! $down) {
            $output->writeln('No changes detected in your mapping information.', 'ERROR');

            return;
        }

        $version = date('YmdHis');
        $path = $this->generateMigration($configuration, $input, $version, $up, $down);

        $output->writeln(sprintf('Generated new migration class to "<info>%s</info>" from schema differences.', $path));
    }

    private function buildCodeFromSql(Configuration $configuration, array $sql)
    {
        $currentPlatform = $configuration->getConnection()->getDatabasePlatform()->getName();
        $code = array();
        foreach ($sql as $query) {
            if (stripos($query, $configuration->getMigrationsTableName()) !== false) {
                continue;
            }
            $code[] = sprintf("\$this->addSql(%s);", var_export($query, true));
        }

        if ($code) {
            array_unshift(
                $code,
                sprintf(
                    "\$this->abortIf(\$this->connection->getDatabasePlatform()->getName() != %s, %s);",
                    var_export($currentPlatform, true),
                    var_export(sprintf("Migration can only be executed safely on '%s'.", $currentPlatform), true)
                ),
                ""
            );
        }

        return implode("\n", $code);
    }
}
