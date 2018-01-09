<?php

namespace Urbem\CoreBundle\Model\Empenho;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel as Model;
use Urbem\CoreBundle\Entity\Empenho;
use Urbem\CoreBundle\Entity\Tesouraria;
use Urbem\CoreBundle\Repository\Empenho\PagamentoLiquidacaoRepository;

/**
 * Class BorderoModel
 * @package Urbem\CoreBundle\Model\Tesouraria
 */
class NotaLiquidacaoPagaModel extends Model
{
    protected $entityManager = null;
    protected $repository = null;

    /**
     * BorderoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Empenho\NotaLiquidacaoPaga::class);
    }

    /**
     * @param Tesouraria\TransacoesPagamento $transacoesPagamento
     * @param Tesouraria\Bordero $bordero
     * @return Empenho\NotaLiquidacaoPaga
     */
    public function buildOneBasedTransacoesPagamento(
        Tesouraria\TransacoesPagamento $transacoesPagamento,
        Tesouraria\Bordero $bordero
    ) {
        /** @var PagamentoLiquidacaoRepository $pagamentoLiquidacaoRepository */
        $pagamentoLiquidacaoRepository = $this->entityManager->getRepository(Empenho\PagamentoLiquidacao::class);
        $repositoryRes = $pagamentoLiquidacaoRepository->recuperaPagamentoLiquidacao([
            'cod_ordem' => $transacoesPagamento->getCodOrdem(),
            'cod_entidade' => $transacoesPagamento->getCodEntidade(),
            'exercicio' => $transacoesPagamento->getExercicio()
        ]);

        $notaLiquidacao = $this->entityManager
            ->getRepository(Empenho\NotaLiquidacao::class)
            ->find([
                'codNota' => $repositoryRes['cod_nota'],
                'exercicio' => $repositoryRes['ex_empenho'],
                'codEntidade' => $repositoryRes['cod_entidade']
            ]);

        $notaLiquidacaoPaga = new Empenho\NotaLiquidacaoPaga();
        $notaLiquidacaoPaga->setFkEmpenhoNotaLiquidacao($notaLiquidacao);
        $notaLiquidacaoPaga->setVlPago($repositoryRes['vl_pago']);
        $notaLiquidacaoPaga->setObservacao(
            sprintf(
                'Pagamento de empenho(s) conforme Borderô nr. %s/%s',
                $bordero->getCodBordero(),
                $bordero->getExercicio()
            )
        );

        $this->entityManager->persist($notaLiquidacaoPaga);
        $this->entityManager->flush();

        return $notaLiquidacaoPaga;
    }

    /**
     * @param array $params
     * @return Empenho\NotaLiquidacaoPaga|null
     */
    public function find(array $params)
    {
        /** @var Empenho\NotaLiquidacaoPaga $notaLiquidacaoPaga */
        $notaLiquidacaoPaga = $this->repository->find($params);

        return $notaLiquidacaoPaga;
    }
}
