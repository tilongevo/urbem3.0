<?php

namespace Urbem\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCredencialsBirtCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        parent::configure();
        $this
            ->setName('server:birt:update-credentials')
            ->setDescription('Atualiza permissao do BIRT em possiveis schemas novos')
            ->setHelp('');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $em = $container->get('doctrine.orm.entity_manager');

        try {
            $stmt = "SELECT distinct grantee FROM information_schema.role_table_grants where grantee not in ('PUBLIC');";
            $sth = $em->getConnection()->prepare($stmt);
            $sth->execute();
            $result = $sth->fetchAll(\PDO::FETCH_CLASS);

            foreach ($result as $permission) {
                $sql = sprintf("grant \"%s\" to birt;", $permission->grantee);
                $em->getConnection()->prepare($sql);
                $sth->execute();
            }

            $output->writeln("Credenciais atualizadas com sucesso!!!");
        } catch (\Exception $e) {
            $output->writeln("Falha ao atualizar as credenciais do BIRT");
        }
    }
}