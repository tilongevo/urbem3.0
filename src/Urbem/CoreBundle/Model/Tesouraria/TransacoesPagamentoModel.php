<?php

namespace Urbem\CoreBundle\Model\Tesouraria;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel as Model;
use Urbem\CoreBundle\Entity\Empenho;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Tesouraria;
use Urbem\CoreBundle\Model\Empenho\NotaLiquidacaoPagaModel;
use Urbem\CoreBundle\Repository\Empenho\PagamentoLiquidacaoRepository;

/**
 * Class TransacoesPagamentoModel
 * @package Urbem\CoreBundle\Model\Tesouraria
 */
class TransacoesPagamentoModel extends Model
{
    protected $entityManager = null;

    /** @var ORM\EntityRepository|null */
    protected $repository = null;

    /**
     * BorderoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Tesouraria\TransacoesPagamento::class);
    }

    /**
     * @param $dados
     * @param $bordero
     */
    public function populaTransacoesPagamento($dados, $bordero)
    {
        foreach ($dados as $key => $value) {
            $codOrdem = $this->entityManager->getRepository(Empenho\OrdemPagamento::class)->findOneBy(['codOrdem' => $value['codOrdemPag'], 'exercicio' => $bordero->getExercicio(), 'codEntidade' => $value['entidade']]);
            $agencia = $this->entityManager->getRepository(Agencia::class)->findOneBy(['codBanco' => $value['banco'], 'codAgencia' => $value['agencia']]);
            $transacoesPagamento = new Tesouraria\TransacoesPagamento();
            $transacoesPagamento->setFkEmpenhoOrdemPagamento($codOrdem);
            $transacoesPagamento->setFkMonetarioAgencia($agencia);
            $transacoesPagamento->setFkTesourariaBordero($bordero);
            $transacoesPagamento->setContaCorrente($value['contaCorrente']);
            $transacoesPagamento->setCodTipo($value['codTipo']);
            $transacoesPagamento->setDescricao(
                sprintf(
                    'Pagamento de empenho(s) conforme Borderô nr. %s/%s',
                    $bordero->getCodBordero(),
                    $bordero->getExercicio()
                )
            );

            $notaLiquidacaoPagaModel = new NotaLiquidacaoPagaModel($this->entityManager);
            $notaLiquidacaoPagaModel->buildOneBasedTransacoesPagamento($transacoesPagamento, $bordero);

            $bordero->addFkTesourariaTransacoesPagamentos($transacoesPagamento);
        }
    }
}
