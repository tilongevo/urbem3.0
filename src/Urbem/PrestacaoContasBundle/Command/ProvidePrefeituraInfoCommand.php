<?php

namespace Urbem\PrestacaoContasBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ProvideMunicipioInfoCommand
 * @package Urbem\PrestacaoContasBundle\Command
 */
class ProvidePrefeituraInfoCommand extends ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this
            ->setName('transparencia:provide:info')
            ->setDescription('Informa o municipio e a Sigla para o projeto Portal Transparencia');

        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return bool|int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Escrevendo informações no projeto: ' . $this->getContainer()->getParameter('portal_transparencia_rootpath'), true);

        $info = $this->getContainer()->get('prefeitura.info');

        $writer = $this->getContainer()->get('transparencia.write_prefeitura_info');

        $writer
            ->write('uf', $info->getUf())
            ->write('nome', $info->getNomePrefeitura())
            ->write('email', $info->getEmail())
        ;

        return true;
    }
}
