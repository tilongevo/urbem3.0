<?php

namespace Urbem\CoreBundle\Model\Contabilidade;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Empenho\NotaLiquidacao;
use Urbem\CoreBundle\Model\Empenho\EmpenhoModel;

class LiquidacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Contabilidade\\Liquidacao");
    }

    public function executaRestosAPagar($object, $exercicio, NotaLiquidacao $codNota, $valor)
    {
        $complemento = $object->getCodEmpenho() . '/' . $object->getExercicio();

        $descricaoLote = 'Liquidação Empenho RP n° ' . $complemento;

        $empenhoModel = new EmpenhoModel($this->entityManager);
        $codLote = $empenhoModel->fnInsereLote(
            $exercicio,
            $object->getCodEntidade(),
            'L',
            $descricaoLote,
            date('d/m/Y')
        );

        $sequencia = $this->empenhoLiquidacaoRestosAPagarTCEMS(
            $exercicio,
            $valor,
            $complemento,
            $codLote,
            'L',
            $object->getCodEntidade(),
            $codNota->getCodNota(),
            $object->getExercicio()
        );

        if ($codLote && $sequencia) {
            return [
                'codLote' => $codLote,
                'sequencia' => $sequencia
            ];
        }

        return [];
    }

    public function empenhoLiquidacaoRestosAPagarTCEMS($exercicio, $valor, $complemento, $codLote, $tipoLote, $codEntidade, $codNota, $exercicioEmpenho)
    {
        return $this->repository->empenhoLiquidacaoRestosAPagarTCEMS($exercicio, $valor, $complemento, $codLote, $tipoLote, $codEntidade, $codNota, $exercicioEmpenho);
    }

    public function executaAnulacaoLiquidacao($object, $exercicio, NotaLiquidacao $codNota, $valor)
    {
        $complemento = $object->getCodEmpenho() . '/' . $object->getExercicio();

        $descricaoLote = 'Anulação Liquidação Empenho RP n° ' . $complemento;
        $empenhoModel = new EmpenhoModel($this->entityManager);
        $codLote = $empenhoModel->fnInsereLote(
            $exercicio,
            $object->getCodEntidade(),
            'L',
            $descricaoLote,
            date('d/m/Y')
        );

        $sequencia = $this->empenhoAnulacaoLiquidacaoRestosAPagarTCEMS(
            $exercicio,
            $valor,
            $complemento,
            $codLote,
            'L',
            $object->getCodEntidade(),
            $codNota->getCodNota(),
            $object->getExercicio()
        );

        if ($codLote && $sequencia) {
            return [
                'codLote' => $codLote,
                'sequencia' => $sequencia
            ];
        }

        return [];
    }

    public function empenhoAnulacaoLiquidacaoRestosAPagarTCEMS($exercicio, $valor, $complemento, $codLote, $tipoLote, $codEntidade, $codNota, $exercicioEmpenho)
    {
        return $this->repository->empenhoAnulacaoLiquidacaoRestosAPagarTCEMS($exercicio, $valor, $complemento, $codLote, $tipoLote, $codEntidade, $codNota, $exercicioEmpenho);
    }
}
