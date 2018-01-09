<?php

namespace Urbem\CoreBundle\Model\Empenho;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel as Model;
use Urbem\CoreBundle\Entity\Empenho;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Entity\Tesouraria\TransacoesPagamento;
use Urbem\CoreBundle\Repository\Empenho\OrdemPagamentoRepository;

/**
 * Class OrdemPagamentoModel
 * @package Urbem\CoreBundle\Model\Empenho
 */
class OrdemPagamentoModel extends Model
{
    protected $entityManager = null;

    /** @var OrdemPagamentoRepository|null */
    protected $repository = null;

    const COD_MODULO = 9;
    const PARAMETRO = 'utilizar_encerramento_mes';
    const SITUACAO = 'F';

    /**
     * OrdemPagamentoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Empenho\OrdemPagamento::class);
    }

    /**
     * @param array $params
     * @return null|object
     */
    public function find(array $params)
    {
        return $this->repository->find($params);
    }

    /**
     * @param string|integer $codEntidade
     * @param string $exercicio
     * @return ORM\QueryBuilder|null
     */
    public function recuperaOrdensPorEntidadeQueryBuilder($codEntidade, $exercicio)
    {
        $repositoryRes = $this->repository->getOrdemPagamentoParaBordero([
            'cod_entidade' => $codEntidade,
            'exercicio' => $exercicio
        ]);

        if (empty($repositoryRes)) {
            return null;
        }

        $codOrdens = [];
        foreach ($repositoryRes as $singleResult) {
            $codOrdens[] = $singleResult['cod_ordem'];
        }

        $queryBuilder = $this->repository->createQueryBuilder('o');
        $rootAlias = $queryBuilder->getRootAliases()[0];

        $queryBuilder
            ->where($queryBuilder->expr()->in(sprintf('%s.codOrdem', $rootAlias), $codOrdens))
            ->andWhere(sprintf('%s.exercicio = :exercicio', $rootAlias))
            ->setParameter('exercicio', $exercicio);

        return $queryBuilder;
    }

    /**
     * @param string|array|Orcamento\Entidade $entidade
     * @return array|null
     * @throws \Exception
     */
    public function recuperaOrdensPorEntidade($entidade)
    {
        $queryBuilder = null;
        $codEntidade = null;
        $exercicio = null;

        switch (gettype($entidade)) {
            case 'string':
                if (preg_match('/([0-9]{4}\~[0-9]+)/', $entidade)) {
                    $exercicio = explode('~', $entidade)[0];
                    $codEntidade = explode('~', $entidade)[1];
                } else {
                    throw new \Exception('Invalid composite key.');
                }

                break;
            case 'array':
                $exercicio = $entidade['exercicio'];
                $codEntidade = $entidade['cod_entidade'];

                break;
            case 'object':
                if ($entidade instanceof Orcamento\Entidade) {
                    $exercicio = $entidade->getExercicio();
                    $codEntidade = $entidade->getCodEntidade();
                } else {
                    throw new \Exception('Invalid Entidade object.');
                }

                break;
        }

        $queryBuilder = $this->recuperaOrdensPorEntidadeQueryBuilder($codEntidade, $exercicio);

        if ($queryBuilder instanceof ORM\QueryBuilder) {
            return $queryBuilder->getQuery()->getResult();
        }

        return null;
    }

    /**
     * @param TransacoesPagamento $transacoesPagamento
     * @return array
     */
    public function recuperaDadosParaEmissaoBordero(TransacoesPagamento $transacoesPagamento)
    {
        $res = $this->repository->recuperaOrdemPagamentoRelatorio([
            'cod_ordem' => $transacoesPagamento->getCodOrdem(),
            'exercicio' => $transacoesPagamento->getExercicio(),
            'cod_entidade' => $transacoesPagamento->getCodEntidade()
        ]);

        /** @var SwCgmPessoaJuridica $swCgmBeneficiario */
        $swCgmBeneficiario =
            $this->entityManager->getRepository(SwCgmPessoaJuridica::class)->find($res['cgm_beneficiario']);

        if (is_null($swCgmBeneficiario)) {

            /** @var SwCgmPessoaFisica $swCgmBeneficiario */
            $swCgmBeneficiario =
                $this->entityManager->getRepository(SwCgmPessoaFisica::class)->find($res['cgm_beneficiario']);
        }

        $res['cgm_beneficiario'] = $swCgmBeneficiario;
        $res['observacoes'] = $transacoesPagamento->getDescricao();
        $res['banco_agencia_conta'] = sprintf(
            '%s / %s / %s',
            $transacoesPagamento->getFkMonetarioAgencia()->getCodBanco()->getNumBanco(),
            $transacoesPagamento->getFkMonetarioAgencia()->getNumAgencia(),
            $transacoesPagamento->getContaCorrente()
        );

        return $res;
    }

    public function recuperaFornecedor($ordemPagamento)
    {
        $fornecedor = array();
        $pagamentoLiquidacoes = $ordemPagamento->getFkEmpenhoPagamentoLiquidacoes();
        if (count($pagamentoLiquidacoes)) {
            $repository = $this->repository;

            $pagamentoLiquidacao = $pagamentoLiquidacoes->last();
            $empenho = $pagamentoLiquidacao->getFkEmpenhoNotaLiquidacao()->getFkEmpenhoEmpenho();

            $info = $repository->getOrdemPagamentoItem(
                $empenho->getExercicio(),
                $empenho->getCodEntidade(),
                $empenho->getCodEmpenho(),
                false
            );

            $fornecedor = array(
                $info['cgm_beneficiario'] . ' - ' . $info['beneficiario'] =>
                $info['cgm_beneficiario']
            );
        }
        return $fornecedor;
    }

    public function recuperaTotal($ordemPagamento)
    {
        $total = 0.00;
        $pagamentoLiquidacoes = $ordemPagamento->getFkEmpenhoPagamentoLiquidacoes();
        foreach ($pagamentoLiquidacoes as $pagamentoLiquidacao) {
            $total += $pagamentoLiquidacao->getVlPagamento();
        }
        return $total;
    }

    public function recuperaTotalRetencoes($ordemPagamento)
    {
        $total = 0.00;
        $retencoes = $ordemPagamento->getFkEmpenhoOrdemPagamentoRetencoes();
        foreach ($retencoes as $retencao) {
            $total += $retencao->getVlRetencao();
        }
        return $total;
    }

    public function verificaMesEncerramento($exercicio)
    {
        $em = $this->entityManager;
        $utilizarEncerramentoMes = $em->getRepository('CoreBundle:Administracao\Configuracao')
            ->findOneBy([
                'codModulo' => $this::COD_MODULO,
                'parametro' => $this::PARAMETRO,
                'exercicio' => $exercicio,
            ]);
        if ($utilizarEncerramentoMes) {
            $utilizarEncerramentoMes = $utilizarEncerramentoMes->getValor();

            if ($utilizarEncerramentoMes == "true") {
                $encerramentoMes = $em->getRepository('CoreBundle:Contabilidade\EncerramentoMes')
                    ->findOneBy([
                        'exercicio' => $exercicio,
                        'situacao' => $this::SITUACAO
                    ], ['timestamp' => 'DESC']);
                if ($encerramentoMes) {
                    return $encerramentoMes->getMes();
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return int
     */
    public function getProximoCodOrdem($exercicio, $codEntidade)
    {
        return $this->repository->getProximoCodOrdem($exercicio, $codEntidade);
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @return \DateTime|null
     */
    public function getDtOrdemPagamento($exercicio, $codEntidade)
    {
        return $this->repository->getDtOrdemPagamento($exercicio, $codEntidade);
    }
}
