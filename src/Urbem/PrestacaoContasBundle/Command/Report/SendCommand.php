<?php

namespace Urbem\PrestacaoContasBundle\Command\Report;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Model\PrestacaoContas\FilaRelatorioModel;
use Urbem\CoreBundle\Model\ServerModel;

class SendCommand extends ContainerAwareCommand
{
    const NAME = 'prestacaocontas:report:send';
    const OPTION_ID = '--id';

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName(self::NAME)
            ->setDescription('Envia um relatório para ser gerado em um software externo');

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

        $container = $this->getContainer();

        /** @var EntityManager $em */
        $em = $container->get('doctrine.orm.entity_manager');

        /** @var FilaRelatorio $fila */
        $fila = $em->getRepository(FilaRelatorio::class)->find((int) $id);

        if (null === $fila) {
            $output->write('Fila não encontrada', true);

            return 0;
        }

        $model = new FilaRelatorioModel($em);

        if (false === $model->canSend($fila)) {
            $output->write(
                sprintf('Fila (%s) não pode ser enviada.', $fila->getId()),
                true
            );

            return 0;
        }

        try {
            $model->updateStatusToSending($fila);

            $ch = curl_init($this->getContainer()->getParameter('prestacao_contas_pentaho_endpoint'));

            $headers = [
                sprintf('Authorization:Basic %s', $this->getContainer()->getParameter('prestacao_contas_pentaho_authorization')),
                'Content-Type:application/x-www-form-urlencoded',
            ];

            $databaseHost = $container->hasParameter("server_database_bi_nat_host") && !empty($container->getParameter("server_database_bi_nat_host")) ?
                $container->getParameter("server_database_bi_nat_host") : (new ServerModel($this->getContainer()))->executeEc2("--public-ipv4");

            $extra = [
                'database_host' => $databaseHost,
                'client_name' => $this->getContainer()->get('prefeitura.info')->getNomePrefeitura(),
                'client_id' => $this->getContainer()->get('prefeitura.info')->getUf(),
                'level' => $this->getContainer()->getParameter('prestacao_contas_pentaho_level'),
                'rep' => $this->getContainer()->getParameter('prestacao_contas_pentaho_rep'),
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($model->prepareParametersToSend($fila, $container, $extra)));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($ch);
            $responseXml = simplexml_load_string($response);

            $this->checkResultStatus($response, $responseXml);
            $fila->setIdentificadorExterno($this->getResponseId($responseXml));

            $model->updateStatusToSent(
                $fila,
                $response,
                $this->getContainer()->get('zechim_queue.default_command_producer')
            );

            $output->write(
                sprintf('A fila %s foi enviada', $fila->getId()),
                true
            );

            return 1;

        } catch (\Exception $e) {
            $model->updateStatusToError($fila, $e->getMessage());

            $output->write(
                sprintf(
                    'A fila (%s) não pode ser enviada. (%s)',
                    $fila->getId(),
                    $e->getMessage()
                ),
                true
            );

            return 0;
        }
    }

    /**
     * @param $response
     * @param $responseXml
     * @return bool
     * @throws \Exception
     */
    private function checkResultStatus($response, $responseXml)
    {
        if (!$responseXml || $response === false) {
            throw new \Exception(Error::ERROR_COMMUNICATION_SERVER_REPORT);
        }

        if (!property_exists($responseXml, 'result') || $responseXml->result === 'ERROR') {
            throw new \Exception($responseXml->message);
        }

        return true;
    }

    /**
     * @param $responseXml
     * @return string
     * @throws \Exception
     */
    private function getResponseId($responseXml)
    {
        if (!property_exists($responseXml, 'result') && $responseXml->result !== 'OK') {
            throw new \Exception(Error::ERROR_WITHOUT_ID_SERVER_REPORT);
        }

        return (string)$responseXml->id;
    }
}
