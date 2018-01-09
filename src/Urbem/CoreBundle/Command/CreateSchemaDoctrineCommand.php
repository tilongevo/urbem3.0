<?php

namespace Urbem\CoreBundle\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand;
use Doctrine\Bundle\DoctrineBundle\Command\Proxy;
use Doctrine\ORM\Tools\SchemaTool;

class CreateSchemaDoctrineCommand extends \Doctrine\Bundle\DoctrineBundle\Command\Proxy\CreateSchemaDoctrineCommand
{
    protected function executeSchemaCommand(InputInterface $input, OutputInterface $output, SchemaTool $schemaTool, array $metadatas)
    {
        $ignoredEntities = IgnoredEntities::entitiesList();

        /** @var $metadata \Doctrine\ORM\Mapping\ClassMetadata */
        $newMetadatas = array();
        foreach ($metadatas as $metadata) {
            if (!in_array($metadata->getName(), $ignoredEntities)) {
                array_push($newMetadatas, $metadata);
            }
        }

        parent::executeSchemaCommand($input, $output, $schemaTool, $newMetadatas);
    }
}
