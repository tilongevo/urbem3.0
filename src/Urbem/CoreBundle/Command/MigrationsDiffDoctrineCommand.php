<?php

namespace Urbem\CoreBundle\Command;

use Doctrine\Bundle\DoctrineBundle\Command\Proxy\DoctrineCommandHelper;
use Doctrine\DBAL\Sharding\PoolingShardConnection;
use Doctrine\Bundle\MigrationsBundle\Command\DoctrineCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationsDiffDoctrineCommand extends DiffCommand
{
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('doctrine:migrations:diff')
            ->addOption('em', null, InputOption::VALUE_OPTIONAL, 'The entity manager to use for this command.')
            ->addOption('shard', null, InputOption::VALUE_REQUIRED, 'The shard connection to use for this command.')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        DoctrineCommandHelper::setApplicationEntityManager($this->getApplication(), $input->getOption('em'));

        if ($input->getOption('shard')) {
            $connection = $this->getApplication()->getHelperSet()->get('db')->getConnection();
            if (!$connection instanceof PoolingShardConnection) {
                throw new \LogicException(sprintf("Connection of EntityManager '%s' must implements shards configuration.", $input->getOption('em')));
            }

            $connection->connect($input->getOption('shard'));
        }

        $configuration = $this->getMigrationConfiguration($input, $output);
        DoctrineCommand::configureMigrations($this->getApplication()->getKernel()->getContainer(), $configuration);

        parent::execute($input, $output);
    }
}
