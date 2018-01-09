<?php

namespace Urbem\CoreBundle\Model\PrestacaoContas;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio;
use Urbem\CoreBundle\Helper\DateTimePK;
use Urbem\PrestacaoContasBundle\Command\Report\ConsultCommand;
use Urbem\PrestacaoContasBundle\Command\Report\ProcessCommand;
use Urbem\PrestacaoContasBundle\Command\Report\SendCommand;
use Zechim\QueueBundle\Service\Producer\CommandProducer;

class FilaRelatorioModel extends AbstractModel
{
    const CONTROLE_EXECUCAO_JOB = "/COMPARTILHADO/BI_CONTROLE_EXECUCAO_JOB";

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(FilaRelatorio::class);
    }

    /**
     * @param $hash
     * @param $job
     * @param array $parameters
     * @param array $value
     * @param $class
     * @param Usuario $createdBy
     * @param CommandProducer $producer
     * @return FilaRelatorio
     */
    public function create($hash, $job, array $parameters, array $value, $class, Usuario $createdBy, CommandProducer $producer)
    {
        $filaRelatorio = new FilaRelatorio();
        $filaRelatorio->setDataCriacao(new DateTimePK());
        $filaRelatorio->setRelatorio($hash);
        $filaRelatorio->setNome($job);
        $filaRelatorio->setParametros($parameters);
        $filaRelatorio->setValor($value);
        $filaRelatorio->setClasseProcessamento($class);
        $filaRelatorio->setFkAdministracaoUsuario($createdBy);

        $filaRelatorio = $this->updateToStatus($filaRelatorio, FilaRelatorio::STATUS_CRIADO);

        $this->updateStatusToCreated($filaRelatorio, $producer);

        return $filaRelatorio;
    }

    /**
     * Verifica se o usuario nao tem nenhuma fila "em aberto",
     * pois e permitido somente uma fila em processamento por
     * usuario
     *
     * @param $hash
     * @param Usuario $user
     * @return bool
     */
    public function userCanCreate($hash, Usuario $user)
    {
        $qb = $this->repository->createQueryBuilder('filaRelatorio');
        $qb->select('COUNT(filaRelatorio)');
        $qb->andWhere('filaRelatorio.fkAdministracaoUsuario = :user');
        $qb->andWhere('filaRelatorio.relatorio = :hash');
        $qb->andWhere($qb->expr()->notIn('filaRelatorio.status', $this->getClosedStatus()));

        $qb->setParameters(['user' => $user, 'hash' => $hash]);

        return 0 === (int) $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * @param $hash
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $user
     * @return mixed
     */
    public function getReportByUser($hash, Usuario $user)
    {
        $qb = $this->repository->createQueryBuilder('filaRelatorio');
        $qb->andWhere('filaRelatorio.fkAdministracaoUsuario = :user');
        $qb->andWhere('filaRelatorio.relatorio = :hash');
        $qb->andWhere(
            $qb->expr()->notIn(
                'filaRelatorio.status',
                [
                    FilaRelatorio::STATUS_ENVIANDO => FilaRelatorio::STATUS_ENVIANDO,
                    FilaRelatorio::STATUS_CANCELANDO => FilaRelatorio::STATUS_CANCELANDO,
                    FilaRelatorio::STATUS_CANCELADO => FilaRelatorio::STATUS_CANCELADO,
                    FilaRelatorio::STATUS_ERRO => FilaRelatorio::STATUS_ERRO,
                    FilaRelatorio::STATUS_FINALIZADO => FilaRelatorio::STATUS_FINALIZADO
                ]
            )
        );

        $qb->setParameters(['user' => $user, 'hash' => $hash]);

        return $qb->getQuery()->execute();
    }

    /**
     * Retorna os status que sao finalizadores
     *
     * @return array
     */
    protected function getClosedStatus()
    {
        return [
            FilaRelatorio::STATUS_ERRO => FilaRelatorio::STATUS_ERRO,
            FilaRelatorio::STATUS_FINALIZADO => FilaRelatorio::STATUS_FINALIZADO
        ];
    }

    /**
     * Retorna todos os status disponveis para uma fila
     *
     * @return array
     */
    public function getAvailableStatus()
    {
        return [
            /* criado e pronto para o software externo capturar */
            FilaRelatorio::STATUS_CRIADO => FilaRelatorio::STATUS_CRIADO,

            /* enviando ao requisicao ao software externo (SendCommand) */
            FilaRelatorio::STATUS_ENVIANDO => FilaRelatorio::STATUS_ENVIANDO,
            FilaRelatorio::STATUS_ENVIADO => FilaRelatorio::STATUS_ENVIADO,

            /* alterado que o software externo faz para informar o passo atual */
            FilaRelatorio::STATUS_PROCESSANDO => FilaRelatorio::STATUS_PROCESSANDO,
            FilaRelatorio::STATUS_PRONTO => FilaRelatorio::STATUS_PRONTO,

            FilaRelatorio::STATUS_ERRO => FilaRelatorio::STATUS_ERRO,

            /* ultima parte do processo (ProcessCommand) */
            FilaRelatorio::STATUS_TRANSFORMANDO => FilaRelatorio::STATUS_TRANSFORMANDO,
            FilaRelatorio::STATUS_FINALIZADO => FilaRelatorio::STATUS_FINALIZADO
        ];
    }

    /**
     * @param FilaRelatorio $filaRelatorio
     * @return bool
     */
    public function canSend(FilaRelatorio $filaRelatorio)
    {
        return FilaRelatorio::STATUS_CRIADO === $filaRelatorio->getStatus();
    }

    /**
     * Verifica se a fila pode ser processada (depois que foi enviada e recebida)
     *
     * @param FilaRelatorio $filaRelatorio
     * @return bool
     */
    public function canProcess(FilaRelatorio $filaRelatorio)
    {
        return FilaRelatorio::STATUS_PRONTO === $filaRelatorio->getStatus();
    }

    /**
     * Verifica se a fila pode ser processada (depois que foi enviada e recebida)
     *
     * @param FilaRelatorio $filaRelatorio
     * @return bool
     */
    public function canConsult(FilaRelatorio $filaRelatorio)
    {
        return true === in_array($filaRelatorio->getStatus(), [FilaRelatorio::STATUS_PRONTO, FilaRelatorio::STATUS_ENVIADO, FilaRelatorio::STATUS_PROCESSANDO]);
    }
    /**
     * @param FilaRelatorio $filaRelatorio
     * @return bool
     */
    public function canDownload(FilaRelatorio $filaRelatorio)
    {
        return FilaRelatorio::STATUS_FINALIZADO === $filaRelatorio->getStatus();
    }

    /**
     * @param FilaRelatorio $filaRelatorio
     * @return bool
     */
    public function canCancel(FilaRelatorio $filaRelatorio)
    {
        return true === in_array($filaRelatorio->getStatus(), [FilaRelatorio::STATUS_PROCESSANDO, FilaRelatorio::STATUS_ENVIADO]);
    }

    /**
     * Atualiza o status da fila e gera o log de atualizacao
     *
     * @param FilaRelatorio $filaRelatorio
     * @param $status
     * @param null $message
     * @return FilaRelatorio
     */
    protected function updateToStatus(FilaRelatorio $filaRelatorio, $status, $message = null)
    {
        $log = $filaRelatorio->getRelatorioLog();

        $log[] = [
            'from' => $filaRelatorio->getStatus(),
            'to' => $status,
            'at' => date('y-m-d H:i:s'),
            'message' => $message
        ];

        $filaRelatorio->setRelatorioLog($log);
        $filaRelatorio->setStatus($status);

        $this->entityManager->persist($filaRelatorio);
        $this->entityManager->flush($filaRelatorio);

        return $filaRelatorio;
    }

    /**
     * Gera os parametros que serao utilizados no software externo
     *
     * @param \Urbem\CoreBundle\Entity\PrestacaoContas\FilaRelatorio $filaRelatorio
     * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param array $extra
     * @return array
     */
    public function prepareParametersToSend(FilaRelatorio $filaRelatorio, ContainerInterface $container, array $extra)
    {
        $databasePort = $container->hasParameter("server_database_bi_nat_port") && !empty($container->getParameter("server_database_bi_nat_port")) ?
            $container->getParameter("server_database_bi_nat_port") : $this->entityManager->getConnection()->getPort();

        $data = [
            'CLIENTE_NOME' => $extra['client_name'],
            'CLIENTE_UF' => $extra['client_id'],
            'DB_HOST_NAME' => $extra['database_host'],
            'DB_PORT' => $databasePort,
            'DB_NAME' => $this->entityManager->getConnection()->getDatabase(),
            'DB_USER_NAME' => $this->entityManager->getConnection()->getUsername(),
            'DB_PASSWORD' => $this->entityManager->getConnection()->getPassword(),
            'level' => $extra['level'],
            'rep' => $extra['rep'],
            'JOB_NOME' => $filaRelatorio->getNome(),
            'job' => self::CONTROLE_EXECUCAO_JOB,
        ];

        $data['ID'] = $filaRelatorio->getId();

        return $data;
    }

    /**
     * @param FilaRelatorio $filaRelatorio
     * @return FilaRelatorio
     */
    public function updateStatusToSending(FilaRelatorio $filaRelatorio)
    {
        return $this->updateToStatus($filaRelatorio, FilaRelatorio::STATUS_ENVIANDO);
    }

    /**
     * @param FilaRelatorio $filaRelatorio
     * @param $response
     * @param CommandProducer $producer
     * @return FilaRelatorio
     */
    public function updateStatusToSent(FilaRelatorio $filaRelatorio, $response, CommandProducer $producer)
    {
        $fila = $this->updateToStatus($filaRelatorio, FilaRelatorio::STATUS_ENVIADO, $response);

        $producer->publish(ConsultCommand::NAME, [ConsultCommand::OPTION_ID => $filaRelatorio->getId()], new \DateInterval('PT5S'));

        return $fila;
    }

    /**
     * @param FilaRelatorio $filaRelatorio
     * @param CommandProducer $producer
     * @return FilaRelatorio
     */
    public function updateStatusToCreated(FilaRelatorio $filaRelatorio, CommandProducer $producer)
    {
        $fila = $this->updateToStatus($filaRelatorio, FilaRelatorio::STATUS_CRIADO);

        try {
            $producer->publish(SendCommand::NAME, [ProcessCommand::OPTION_ID => $filaRelatorio->getId()]);
        } catch (\Exception $e) {}

        return $fila;
    }

    /**
     * @param FilaRelatorio $filaRelatorio
     * @param CommandProducer $producer
     * @return FilaRelatorio
     */
    public function updateStatusToReady(FilaRelatorio $filaRelatorio, CommandProducer $producer)
    {
        $fila = $this->updateToStatus($filaRelatorio, FilaRelatorio::STATUS_PRONTO);

        $producer->publish(ProcessCommand::NAME, [ProcessCommand::OPTION_ID => $filaRelatorio->getId()]);

        return $fila;
    }

    /**
     * @param FilaRelatorio $filaRelatorio
     * @return FilaRelatorio
     */
    public function updateToTransforming(FilaRelatorio $filaRelatorio)
    {
        return $this->updateToStatus($filaRelatorio, FilaRelatorio::STATUS_TRANSFORMANDO);
    }

    /**
     * @param FilaRelatorio $filaRelatorio
     * @param $downloadPath
     * @return FilaRelatorio
     */
    public function updateToFinalized(FilaRelatorio $filaRelatorio, $downloadPath)
    {
        $filaRelatorio->setCaminhoDownload($downloadPath);

        return $this->updateToStatus($filaRelatorio, FilaRelatorio::STATUS_FINALIZADO);
    }

    /**
     * @param FilaRelatorio $filaRelatorio
     * @return FilaRelatorio
     */
    public function updateToCanceling(FilaRelatorio $filaRelatorio)
    {
        $filaRelatorio->setDataResposta(new DateTimePK());
        return $this->updateToStatus($filaRelatorio, FilaRelatorio::STATUS_CANCELANDO);
    }

    /**
     * @param FilaRelatorio $filaRelatorio
     * @param $message
     * @return FilaRelatorio
     */
    public function updateToCanceled(FilaRelatorio $filaRelatorio, $message)
    {
        $filaRelatorio->setDataResposta(new DateTimePK());
        return $this->updateToStatus($filaRelatorio, FilaRelatorio::STATUS_CANCELADO, $message);
    }

    /**
     * @param FilaRelatorio $filaRelatorio
     * @param $message
     * @return FilaRelatorio
     */
    public function updateStatusToError(FilaRelatorio $filaRelatorio, $message)
    {
        $filaRelatorio->setDataResposta(new DateTimePK());
        return $this->updateToStatus($filaRelatorio, FilaRelatorio::STATUS_ERRO, $message);
    }
}
