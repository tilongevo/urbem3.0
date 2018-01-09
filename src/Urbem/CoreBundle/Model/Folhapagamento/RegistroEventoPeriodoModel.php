<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\RegistroEventoPeriodoRepository;

class RegistroEventoPeriodoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var RegistroEventoPeriodoRepository|null  */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\RegistroEventoPeriodo");
    }

    public function montaRecuperaRegistrosDeEventos($stFiltro)
    {
        return $this->repository->montaRecuperaRegistrosDeEventos($stFiltro);
    }

    /**
     * @param      $codPeriodoMovimentacao
     * @param bool $numcgm
     *
     * @return array
     */
    public function montaRecuperaContratosAutomaticos($codPeriodoMovimentacao, $numcgm = false)
    {
        return $this->repository->montaRecuperaContratosAutomaticos($codPeriodoMovimentacao, $numcgm);
    }

    /**
     * @param $stCodContratos
     * @param $stTipoFolha
     * @param $inCodComplementar
     * @param $entidade
     * @return mixed
     */
    public function deletarInformacoesCalculo($stCodContratos, $stTipoFolha, $inCodComplementar, $entidade)
    {
        return $this->repository->deletarInformacoesCalculo($stCodContratos, $stTipoFolha, $inCodComplementar, $entidade);
    }

    /**
     * @param $cod_contrato
     * @param $tipo
     * @param $erro
     * @param $entidade
     * @param $exercicio
     * @return mixed
     */
    public function calculaFolha($cod_contrato, $tipo, $erro, $entidade, $exercicio)
    {
        return $this->repository->calculaFolha($cod_contrato, $tipo, $erro, $entidade, $exercicio);
    }

    /**
     * @param ContratoServidorPeriodo $contratoServidorPeriodo
     * @return RegistroEventoPeriodo
     */
    public function buildOne(ContratoServidorPeriodo $contratoServidorPeriodo)
    {
        $codRegistro = $this->repository->getNextCodRegistro();
        $registroEventoPeriodo = new RegistroEventoPeriodo();
        $registroEventoPeriodo->setFkFolhapagamentoContratoServidorPeriodo($contratoServidorPeriodo);
        $registroEventoPeriodo->setCodRegistro($codRegistro);

//        $this->save($registroEventoPeriodo);
        return $registroEventoPeriodo;
    }
}
