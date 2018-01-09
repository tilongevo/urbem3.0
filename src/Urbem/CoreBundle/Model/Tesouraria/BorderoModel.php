<?php

namespace Urbem\CoreBundle\Model\Tesouraria;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel as Model;
use Urbem\CoreBundle\Entity\Contabilidade\PlanoRecurso;
use Urbem\CoreBundle\Entity\Empenho;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Entity\Tesouraria;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Urbem\CoreBundle\Repository\Empenho\PagamentoLiquidacaoRepository;
use Urbem\CoreBundle\Repository\Financeiro\Tesouraria\BorderoRepository;

/**
 * Class BorderoModel
 * @package Urbem\CoreBundle\Model\Tesouraria
 */
class BorderoModel extends Model
{
    protected $entityManager = null;

    /** @var BorderoRepository|null */
    protected $repository = null;

    const NAO_INFORMADO = "1";
    const TRANSFERENCIA_CC = "2";
    const TRANSFERENCIA_PO = "3";
    const DOC = "4";
    const TED = "5";


    /**
     * BorderoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Tesouraria\Bordero::class);
    }

    /**
     * @param array $params
     * @return int
     */
    public function getUltimoCodBordero(array $params)
    {
        $repositoryRes = $this->repository->ultimoCodigo($params);

        return $repositoryRes['codigo'] + 1;
    }

    /**
     * @param Tesouraria\Bordero $bordero
     * @return Tesouraria\Bordero
     */
    public function buildBordero(Tesouraria\Bordero $bordero)
    {
        $autenticacaoModel = new AutenticacaoModel($this->entityManager);
        $autenticacao = $autenticacaoModel->buildOneBasedBordero($bordero);
        $bordero->setFkTesourariaAutenticacao($autenticacao);

        $codBordero = $this->getUltimoCodBordero([
            'exercicio' => $bordero->getExercicio(),
            'cod_entidade' => $bordero->getCodEntidade()
        ]);

        $bordero->setCodBordero($codBordero);

        $usuarioTerminal = $bordero->getFkTesourariaBoletim()->getFkTesourariaUsuarioTerminal();
        $bordero->setFkTesourariaUsuarioTerminal($usuarioTerminal);

        return $bordero;
    }

    /**
     * @param $codPlano
     * @param $exercicio
     * @return null|object
     */
    public function getPlanoRecursoPorCodPlanoAndExercicio($codPlano, $exercicio)
    {
        return $this->entityManager->getRepository(PlanoRecurso::class)->findOneBy(['codPlano' => $codPlano, 'exercicio' => $exercicio]);
    }

    /**
     * @param $entidade
     * @param $exercicio
     * @param $codRecurso
     * @return array
     */
    public function getOrdemPagamentoPorEntidadeAndExercicioAndCodRecurso($entidade, $exercicio, $codRecurso, $codOrdemPagamento)
    {
        $ordemPagamento = $this->repository->findAllOrdemPagamento($entidade, $exercicio, $codRecurso, $codOrdemPagamento);
        if (empty($codOrdemPagamento)) {
            $ordemPagamento = $this->parseArrayToChoice($ordemPagamento, 'cod_ordem', ['cod_ordem', 'beneficiario']);
        }

        return $ordemPagamento;
    }

    /**
     * @param $ordemPagamento
     * @param $codEntidade
     * @param $exercicio
     */
    public function clearOrdemPagamentoJaEfetuado($ordemPagamento, $codEntidade, $exercicio)
    {
        $ordemPagamentoJaEfetuados = $this->repository->findAllOrdemPagamentoJaEfetuado($codEntidade, $exercicio);
        if (!empty($ordemPagamentoJaEfetuados) || !empty($ordemPagamento)) {
            $formatArray = array_column($ordemPagamentoJaEfetuados, 'codOrdem');
            foreach ($formatArray as $value) {
                if (array_key_exists($value, $ordemPagamento)) {
                    unset($ordemPagamento[$value]);
                }
            }
        }
        return $ordemPagamento;
    }

    /**
     * @param $entidade
     * @param $exercicio
     * @return array
     */
    public function getContaPorEntidadeAndExercicio($entidade, $exercicio)
    {
        return $this->parseArrayToChoice($this->repository->findByContaPorEntidadeAndExercicio($entidade, $exercicio), 'cod_plano', ['cod_estrutural', 'nom_conta']);
    }

    /**
     * @param $codOrdem
     * @param $exercicio
     * @param $codEntidade
     * @return array
     */
    public function getCodNota($codOrdem, $exercicio, $codEntidade)
    {
        return $this->repository->findCodNota($codOrdem, $exercicio, $codEntidade);
    }

    /**
     * @param $codEntidade
     * @param $exercicio
     * @param $codOrdem
     * @param $codNota
     * @return array
     */
    public function getValoresPorOrdemDePagamento($codEntidade, $exercicio, $codOrdem, $codNota)
    {
        return $this->repository->findValoresPorOrdemDePagamento($codEntidade, $exercicio, $codOrdem, $codNota);
    }

    /**
     * @param $codBanco
     * @return array
     */
    public function getAgenciasPorBanco($codBanco)
    {
        return $this->parseArrayToChoice($this->repository->findAllAgenciasPorBanco($codBanco), 'codAgencia', ['numAgencia', 'nomAgencia']);
    }

    /**
     * Helper para retornar values 'concatenados'
     *
     * @param $array
     * @param $campoChave
     * @param $camposValor
     * @return array
     */
    public static function parseArrayToChoice($array, $campoChave, $camposValor)
    {
        if (empty($array)) {
            return $array;
        }

        function retornaCampos($camposValor, $keyValor)
        {
            $valor = "";
            foreach ($camposValor as $key => $value) {
                $valor .=  ($key != 0 ? " - " : "")  . $keyValor[$value];
            }
            return $valor;
        }

        $result = [];
        foreach ($array as $key) {
            $result[$key[$campoChave]] = retornaCampos($camposValor, $key);
        }

        return $result;
    }
}
