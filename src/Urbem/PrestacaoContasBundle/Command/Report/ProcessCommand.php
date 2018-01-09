<?php

namespace Urbem\PrestacaoContasBundle\Command\Report;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio;
use Urbem\CoreBundle\Model\PrestacaoContas\FilaRelatorioModel;

class ProcessCommand extends ContainerAwareCommand
{
    const NAME = 'prestacaocontas:report:process';
    const OPTION_ID = '--id';

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName(self::NAME)
            ->setDescription('Processa um relatório pronto');

        $this->addOption('id', 'id', InputOption::VALUE_REQUIRED);

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
        $id = $input->getOption('id');

        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        /** @var FilaRelatorio $fila */
        $fila = $em->getRepository(FilaRelatorio::class)->find((int) $id);

        if (null === $fila) {
            $output->write('Fila não encontrada', true);

            return 0;
        }

        $model = new FilaRelatorioModel($em);

        if (false === $model->canProcess($fila)) {
            $output->write(
                sprintf('Fila (%s) não pode ser processada.', $fila->getId()),
                true
            );

            return 0;
        }

        try {
            $model->updateToTransforming($fila);

            /** @var $class \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\AbstractReport */
            $class = $fila->getClasseProcessamento();
            $class = new $class;

            $model->updateToFinalized(
                $fila,
                $class->build($this->getContainer()->getParameter('prestacao_contas_file_path'), $fila)
            );

            $output->write(
                sprintf('A fila %s foi processada', $fila->getId()),
                true
            );

            return 1;

        } catch (\Exception $e) {
            $model->updateStatusToError($fila, $e->getMessage());

            $output->write(
                sprintf(
                    'A fila (%s) não pode ser processada. (%s)',
                    $fila->getId(),
                    $e->getMessage()
                ),
                true
            );

            return 0;
        }
    }
}
