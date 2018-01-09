<?php

namespace Urbem\PrestacaoContasBundle\Command\Report;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio;
use Urbem\CoreBundle\Model\PrestacaoContas\FilaRelatorioModel;
use Urbem\CoreBundle\Model\ServerModel;

class ConsultCommand extends ContainerAwareCommand
{
    const NAME = 'prestacaocontas:report:consult';
    const OPTION_ID = '--id';

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('prestacaocontas:report:consult')
            ->setDescription('Consulta o status de um relatório que está sendo gerado em um software externo');

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

        if (false === $model->canConsult($fila)) {
            $output->write(
                sprintf('Fila (%s) não pode ser consultada.', $fila->getId()),
                true
            );

            return 0;
        }

        if ($fila->getStatus() === FilaRelatorio::STATUS_PRONTO) {
            $model->updateStatusToReady($fila, $this->getContainer()->get('zechim_queue.default_command_producer'));

        } else {
            $this->getContainer()->get('zechim_queue.default_command_producer')->publish(self::NAME, [self::OPTION_ID => $fila->getId()], new \DateInterval('PT1M'));
        }
    }
}
