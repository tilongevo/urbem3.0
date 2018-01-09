<?php

namespace Urbem\CoreBundle\Model\Folhapagamento;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity;
use Doctrine\ORM\Query;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Repository\RecursosHumanos\FolhaPagamento\UltimoRegistroEventoRepository;

class UltimoRegistroEventoModel extends AbstractModel
{
    protected $entityManager = null;
    /** @var UltimoRegistroEventoRepository|null */
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Folhapagamento\\UltimoRegistroEvento");
    }

    /**
     * @param $codContrato
     * @param bool $codPeriodoMovimentacao
     * @param bool $desdobramento
     * @return array
     */
    public function montaRecuperaRegistrosEventoDoContrato($registro, $codPeriodoMovimentacao = false, $desdobramento = false)
    {
        return $this->repository->montaRecuperaRegistrosEventoDoContrato($registro, $codPeriodoMovimentacao, $desdobramento);
    }

    /**
     * @param $codRegistro
     * @param $codEvento
     * @param $desdobramento
     * @param $timestamp
     * @param string $tipo
     * @return array
     */
    public function montaDeletarUltimoRegistro($codRegistro, $codEvento, $desdobramento, $timestamp, $tipo = 'S')
    {
        return $this->repository->montaDeletarUltimoRegistro($codRegistro, $codEvento, $desdobramento, $timestamp, $tipo);
    }

    /**
     * @param Entity\Folhapagamento\RegistroEvento $registroEvento
     *
     * @return Entity\Folhapagamento\UltimoRegistroEvento
     */
    public function buildOneBasedRegistroEvento(Entity\Folhapagamento\RegistroEvento $registroEvento)
    {
        $ultimoRegistroEvento = new Entity\Folhapagamento\UltimoRegistroEvento();
        $ultimoRegistroEvento->setFkFolhapagamentoRegistroEvento($registroEvento);

        return $ultimoRegistroEvento;
    }

    /**
     * @param $filtro
     * @param $ordem
     * @return array
     */
    public function montaRecuperaRelacionamento($filtro = null, $ordem = null)
    {
        return $this->repository->montaRecuperaRelacionamento($filtro, $ordem);
    }
}
