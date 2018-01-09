<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Licitacao;

use Doctrine\ORM;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Licitacao\Contrato;
use Urbem\CoreBundle\Entity\Licitacao\ContratoLicitacao;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Repository\Patrimonio\Licitacao\LicitacaoRepository;

/**
 * Class LicitacaoModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Licitacao
 */
class ContratoModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var ContratoRepository|null */
    protected $repository = null;

    /**
     * LicitacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Licitacao\\Contrato");
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return mixed
     */
    public function getProximoNumContrato($exercicio, $codEntidade)
    {
        return $this->repository->getProximoNumContrato($exercicio, $codEntidade);
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $numContrato
     * @return null|object
     */
    public function getOneContrato($exercicio, $codEntidade, $numContrato)
    {
        return $this->repository->findOneBy(['exercicio' => $exercicio, 'codEntidade' => $codEntidade, 'numContrato' => $numContrato]);
    }
}
