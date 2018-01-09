<?php

namespace Urbem\RedeSimplesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\FormBuilder;

class FormCacheCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('rede_simples:form_cache');
        $this->setDescription('Create or delete a FORM cache');
        $this->setHelp(<<<EOT
    The <info>%command.name%</info> command manage the FORM cache

    <comment>Create the FORM cache</comment>
    <info>%command.full_name% --create</info>

    <comment>Delete the FORM cache</comment>
    <info>%command.full_name% --delete</info>

    <comment>Delete and Create the FORM cache</comment>
    <info>%command.full_name% --delete --create</info>
EOT
        );

        #$this->addArgument('cache-key', InputArgument::REQUIRED, 'The cache key');
        $this->addOption('delete', null, InputOption::VALUE_NONE, 'Delete the FORM cache');
        $this->addOption('create', null, InputOption::VALUE_NONE, 'Crate the FORM cache');

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * 
     * @return integer
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /* src/Urbem/RedeSimplesBundle/DependencyInjection/RedeSimplesExtension.php */
        /** @var $service FormBuilder */
        $service = $this->getContainer()->get('rede_simples.form_create');

        if (true === $input->getOption('delete')) {
            $service->removeCachedResult();

            $output->writeln('<info>FORM cache deleted</info>');
        }

        if (true === $input->getOption('create')) {
            $service->getCachedResult();

            $output->writeln('<info>FORM cache created</info>');
        }

        return 1;
    }
}
