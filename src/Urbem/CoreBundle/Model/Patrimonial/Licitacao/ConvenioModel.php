<?php
/**
 * Created by PhpStorm.
 * User: longevo
 * Date: 27/07/16
 * Time: 15:40
 */

namespace Urbem\CoreBundle\Model\Patrimonial\Licitacao;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Licitacao;
use Urbem\CoreBundle\Helper\DatePK;

class ConvenioModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Licitacao\Convenio::class);
    }

    public function findOneById($convenioId)
    {
        return $this->repository->findOneById($convenioId);
    }

    /**
     * Retorna Convenio com base no exercicio e numconvenio
     *
     * @param string|int $numConvenio
     * @param string|int $exercicio
     *
     * @return Licitacao\Convenio
     */
    public function getOneByExercicioAndNumConvenio($numConvenio, $exercicio)
    {
        return $this->repository->findOneBy([
            'exercicio' => $exercicio,
            'numConvenio' => $numConvenio
        ]);
    }

    public function getParticipanteConvenio(Licitacao\Convenio $convenio)
    {
        $participantes = $this->entityManager
            ->getRepository(Licitacao\ParticipanteConvenio::class)
            ->findBy(['numConvenio' => $convenio])
        ;

        return $participantes;
    }

    /**
     * @param Licitacao\Convenio $convenio
     * @param Licitacao\VeiculosPublicidade $veiculosPublicidade
     * @param DatePK $dtPublicacao
     * @return bool
     */
    public function veiculoPublicidadeExiste(Licitacao\Convenio $convenio, Licitacao\VeiculosPublicidade $veiculosPublicidade, DatePK $dtPublicacao)
    {
        $result = $this->repository->veiculoPublicidadeExiste($convenio, $veiculosPublicidade, $dtPublicacao);
        if (count($result) > 0) {
            return true;
        }
        return false;
    }

    /**
     * @param Licitacao\Convenio $convenio
     * @return mixed
     */
    public function getValorEPercentualConvenioDisponivel(Licitacao\Convenio $convenio)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder
            ->select([
                'SUM(participanteConvenio.percentualParticipacao) as percentualUsado',
                'SUM(participanteConvenio.valorParticipacao) as valorUsado'
            ])
            ->from(Licitacao\ParticipanteConvenio::class, 'participanteConvenio')
            ->where('participanteConvenio.numConvenio = :numConvenio')
            ->setParameter('numConvenio', $convenio->getNumConvenio())
        ;

        $result = $queryBuilder->getQuery()->getSingleResult();

        $result['percentualDisponivel'] = 100 - $result['percentualUsado'];
        $result['valorDisponivel'] = $convenio->getValor() - $result['valorUsado'];
        $result['valorTotal'] = $convenio->getValor();

        return $result;
    }
}
