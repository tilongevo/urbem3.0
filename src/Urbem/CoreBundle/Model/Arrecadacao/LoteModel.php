<?php

namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Arrecadacao\Lote;
use Urbem\CoreBundle\Repository\Arrecadacao\LoteRepository;

/**
 * Class LoteModel
 * @package Urbem\CoreBundle\Model\Arrecadacao
 */
class LoteModel extends AbstractModel
{
    protected $entityManager = null;
    /**
     * @var \Doctrine\ORM\EntityRepository|null|LoteRepository
     */
    protected $repository = null;

    /**
     * LoteModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Lote::class);
    }

    /**
     * @param $filter
     * @return array
     */
    public function getListaLotes($filter)
    {
        $res = $this->entityManager->getRepository(Lote::class)
            ->getListaLotes($filter);

        return $res;
    }

    /**
     * @param $lotes
     * @return mixed
     */
    public function getListaResumoLotesOrigem($lotes)
    {
        $res = $this->entityManager->getRepository(Lote::class)
            ->getListaResumoLotesOrigem($lotes);

        return $res;
    }

    /**
     * @param $lotes
     * @return array
     */
    public function getListaCreditoOrigem($lotes)
    {
        $resumoLotesListaOrigem = $this->entityManager->getRepository(Lote::class)
            ->getListaResumoLotesOrigem($lotes);

        $listaOrigem = array();
        for ($inX = 0; $inX < count($resumoLotesListaOrigem); $inX++) {
            if ($this->validaInconsistencia($resumoLotesListaOrigem[$inX]['tipo_numeracao'])) {
                continue;
            }

            if ($this->validaDA($resumoLotesListaOrigem[$inX]['descricao'])) {
                continue;
            }

            for ($inY = 0; $inY < count($listaOrigem); $inY++) {
                if (($resumoLotesListaOrigem[$inX]["origem"] == $listaOrigem[$inY]["origem"]) && ($resumoLotesListaOrigem[$inX]["origem_exercicio"] == $listaOrigem[$inY]["origem_exercicio"])) {
                    break;
                }
            }
            $listaOrigem[] = $resumoLotesListaOrigem[$inX];
        }

        return $listaOrigem;
    }

    /**
     * @param $tipo_numeracao
     * @return int
     */
    public function validaInconsistencia($tipo_numeracao)
    {
        return preg_match("/INCONSISTENCIA/", $tipo_numeracao);
    }

    /**
     * @param $descricao
     * @return int
     */
    public function validaDA($descricao)
    {
        return preg_match("/(D.A.)/", $descricao);
    }

    /**
     * @param $lotes
     * @param $listaOrigens
     * @return array
     */
    public function getSomatoriosNormais($lotes, $listaOrigens)
    {
        return ($listaOrigens['tipo'] == 'divida')
            ? $listaOrigens
            : $this->entityManager->getRepository(Lote::class)
                ->getListaPagamentosLote($lotes, $listaOrigens);
    }

    /**
     * @param $lotes
     * @param $listaOrigens
     * @return array
     */
    public function getSomatoriosNormaisAnalitico($lotes, $listaOrigens)
    {
        return ($listaOrigens['tipo'] == 'divida')
            ? $listaOrigens
            : $this->entityManager->getRepository(Lote::class)
                ->getListaPagamentosLoteAnalitico($lotes, $listaOrigens);
    }

    /**
     * @param $listaNormais
     * @return array
     */
    public function getTotalNormais($listaNormais)
    {
        return [
            "stNormal" => "Normais",
            "somaNormal" => array_sum(array_column($listaNormais, 'valor_pago_calculo')),
            "somaJuros" => array_sum(array_column($listaNormais, 'juros')),
            "somaMulta" => array_sum(array_column($listaNormais, 'multa')),
            "somaDiff" => array_sum(array_column($listaNormais, 'diferenca')),
            "somaCorrecao" => array_sum(array_column($listaNormais, 'correcao')),
            "somaTotal" => array_sum(array_column($listaNormais, 'valor_pago_normal'))
        ];
    }

    /**
     * @param $listaNormais
     * @return mixed
     */
    public function getSomatoriosNormaisOrigem($listaNormais)
    {
        $listaOrigem = array_unique(array_column($listaNormais, 'origem'));
        foreach ($listaOrigem as $origem) {
            $result[$origem] = array_filter($listaNormais, function ($lista) use ($origem) {
                return $lista['origem'] == $origem;
            });
        }

        foreach ($listaOrigem as $origem) {
            $somatorioNormaisOrigem[$origem] = [
                "descricao" => current($result[$origem])['descricao_credito'],
                "somaTotal" => array_sum(array_column($result[$origem], 'valor_pago_normal')),
                "somaJuros" => array_sum(array_column($result[$origem], 'juros')),
                "somaMulta" => array_sum(array_column($result[$origem], 'multa')),
                "somaNormal" => array_sum(array_column($result[$origem], 'valor_pago_calculo')),
                "somaDiff" => array_sum(array_column($result[$origem], 'diferenca')),
                "somaCorrecao" => array_sum(array_column($result[$origem], 'correcao')),
            ];
        }

        return $somatorioNormaisOrigem;
    }

    /**
     * @param $lotes
     * @param $origem
     * @return array
     */
    public function getListaPagamentosLote($lotes, $origem)
    {
        $res = $this->entityManager->getRepository(Lote::class)
            ->getListaPagamentosLote($lotes, $origem);

        return $res;
    }

    /**
     * @param $lotes
     * @param $origem
     * @return mixed
     */
    public function getListaPagamentosLoteAnalitico($lotes, $origem)
    {
        $res = $this->entityManager->getRepository(Lote::class)
            ->getListaPagamentosLoteAnalitico($lotes, $origem);

        return $res;
    }

    /**
     * @param $somatoriosNormais
     * @return array
     */
    public function getTotaisRelatorio($somatoriosNormais)
    {
        return [
            "stNormal" => "Totais do Relatório",
            "somaNormal" => array_sum(array_column($somatoriosNormais, 'somaNormal')),
            "somaJuros" => array_sum(array_column($somatoriosNormais, 'somaJuros')),
            "somaMulta" => array_sum(array_column($somatoriosNormais, 'somaMulta')),
            "somaDiff" => array_sum(array_column($somatoriosNormais, 'somaDiff')),
            "somaCorrecao" => array_sum(array_column($somatoriosNormais, 'somaCorrecao')),
            "somaTotal" => array_sum(array_column($somatoriosNormais, 'somaTotal'))
        ];
    }

    /**
     * @param $lotes
     * @param $origem
     * @return array
     */
    public function getResumoLoteListaInconsistenteAgrupado($lotes, $origem)
    {
        $res = $this->entityManager->getRepository(Lote::class)
            ->getResumoLoteListaInconsistenteAgrupado($lotes, $origem);

        return $res;
    }

    /**
     * @param $somaInconsistente
     * @return array
     */
    public function getTotalInconsistenteAgrupado($somaInconsistente)
    {
        return [
            "stInconsistente" => "Total Inconsistente",
            "valorInconsistente" => array_sum(array_column($somaInconsistente, 'valor'))
        ];
    }

    /**
     * @param $lotes
     * @return mixed
     */
    public function getResumoLoteListaInconsistenteDividaAtiva($lotes)
    {
        $res = $this->entityManager->getRepository(Lote::class)
            ->getResumoLoteListaInconsistenteDividaAtiva($lotes);

        return $res;
    }

    /**
     * @param $listaInconsistente
     * @return array
     */
    public function getTotalInconsistente($listaInconsistente)
    {
        return [
            "stInconsistente" => "Total Inconsistente",
            "total" => array_sum(array_column($listaInconsistente, 'valor'))
        ];
    }

    /**
     * @param $lotes
     * @return mixed
     */
    public function getResumoLoteListaInconsistenteSemVinculo($lotes)
    {
        $res = $this->entityManager->getRepository(Lote::class)
            ->getResumoLoteListaInconsistenteSemVinculo($lotes);

        return $res;
    }
}
