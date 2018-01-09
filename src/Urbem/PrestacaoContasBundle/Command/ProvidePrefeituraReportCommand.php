<?php

namespace Urbem\PrestacaoContasBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Class ProvidePrefeituraReportCommand
 *
 * @package Urbem\PrestacaoContasBundle\Command
 */
class ProvidePrefeituraReportCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('transparencia:provide:report')
            ->setDescription('Gera um arquivo .zip para o projeto Portal Transparencia');

        parent::configure();
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return bool
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $reportGenerator = $this->getContainer()->get('transparencia.export_transparencia');

        $output->write('Gerando relatório.' . PHP_EOL);
        try {
            $reportGenerator->execute($output);
            $output->write(sprintf('Arquivo de relatório gerado: %s.', $reportGenerator->getFileName()) . PHP_EOL);
        } catch (\Exception $exception) {
            $reportGenerator->removeOldFiles(true);
            $output->write(sprintf('Um erro ocorreu durante a execução do relatório: %s', $exception->getMessage()) . PHP_EOL);
        }

        return true;
    }
}
