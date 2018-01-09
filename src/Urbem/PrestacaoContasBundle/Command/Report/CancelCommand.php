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

class CancelCommand extends ContainerAwareCommand
{
    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('prestacaocontas:report:cancel')
            ->setDescription('Cancela um relatorio em processamento');

        $this->addOption('id', null, InputOption::VALUE_REQUIRED);

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

        if (false === $model->canCancel($fila)) {
            $output->write(
                sprintf('Fila (%s) não pode ser cancelada.', $fila->getId()),
                true
            );

            return 0;
        }

        try {
            $model->updateToCanceling($fila);

//            $ch = curl_init($this->getContainer()->getParameter('prestacao_contas_pentaho_endpoint'));
//
//            $headers = [
//                sprintf('Authorization:Basic %s', $this->getContainer()->getParameter('prestacao_contas_pentaho_authorization')),
//                'Content-Type:application/x-www-form-urlencoded',
//            ];
//
//            $extra = [
//                'database_host' => (new ServerModel($this->getContainer()))->executeEc2("--public-ipv4"),
//                'client_name' => $this->getContainer()->get('prefeitura.info')->getNomePrefeitura(),
//                'client_id' => $this->getContainer()->get('prefeitura.info')->getUf(),
//                'level' => $this->getContainer()->getParameter('prestacao_contas_pentaho_level'),
//                'rep' => $this->getContainer()->getParameter('prestacao_contas_pentaho_rep'),
//            ];
//
//            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//            curl_setopt($ch, CURLOPT_POST, true);
//            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($model->prepareParametersToSend($fila, $extra)));
//            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//            $response = curl_exec($ch);

//            $model->updateToCanceled($fila, $response);

            $output->write(
                sprintf('A fila %s foi cancelad', $fila->getId()),
                true
            );

            return 1;

        } catch (\Exception $e) {
            $model->updateStatusToError($fila, $e->getMessage());

            $output->write(
                sprintf(
                    'A fila (%s) não pode ser cancelada. (%s)',
                    $fila->getId(),
                    $e->getMessage()
                ),
                true
            );

            return 0;
        }
    }
}
