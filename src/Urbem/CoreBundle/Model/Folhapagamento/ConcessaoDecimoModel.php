<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Doctrine\ORM\Query;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\ConcessaoDecimoRepository;

class ConcessaoDecimoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var ConcessaoDecimoRepository|null  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\ConcessaoDecimo");
    }

    /**
     * @param      $codPeriodoMovimentacao
     * @param bool $orgao
     * @param bool $local
     * @param bool $params
     *
     * @return array
     */
    public function montaRecuperaContratosConcessaoDecimo($codPeriodoMovimentacao, $orgao = false, $local = false, $params = false)
    {
        return $this->repository->montaRecuperaContratosConcessaoDecimo($codPeriodoMovimentacao, $orgao, $local, $params);
    }

    /**
     * @param        $codContrato
     * @param        $codPeriodoMovimentacao
     * @param        $desdobramento
     * @param string $entidade
     *
     * @return mixed
     */
    public function montaGeraRegistroDecimo($codContrato, $codPeriodoMovimentacao, $desdobramento, $entidade = '')
    {
        return $this->repository->montaGeraRegistroDecimo($codContrato, $codPeriodoMovimentacao, $desdobramento, $entidade);
    }

    public function montaGeraConcessaoDecimoWithParanms($filtro, $order)
    {
        return $this->repository->montaGeraConcessaoDecimoWithParanms($filtro, $order);
    }

    /**
     * @param $mesAniversario
     * @param $entidade
     * @param $codPeriodoMovimentacao
     * @return mixed
     */
    public function montaRecuperaContratosAdiantamentoDecidoMesAniversario($mesAniversario, $entidade, $codPeriodoMovimentacao)
    {
        return $this->repository->montaRecuperaContratosAdiantamentoDecidoMesAniversario($mesAniversario, $entidade, $codPeriodoMovimentacao);
    }

    /**
     * @param bool $filtro
     *
     * @return array
     */
    public function montaRecuperaTodos($filtro = false)
    {
        return $this->repository->montaRecuperaTodos($filtro);
    }

    /**
     * @param array $params
     * @param bool|string $filtro
     *
     * @return array
     */
    public function recuperaContratosParaCancelar($params, $filtro = false)
    {
        return $this->repository->recuperaContratosParaCancelar($params, $filtro);
    }

    /**
     * @param      $params
     * @param bool $filtro
     *
     * @return array
     */
    public function recuperaContratosParaCancelarPensionista($params, $filtro = false)
    {
        return $this->repository->recuperaContratosParaCancelarPensionista($params, $filtro);
    }
}
