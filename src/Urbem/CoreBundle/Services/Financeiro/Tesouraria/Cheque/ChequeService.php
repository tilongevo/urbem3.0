<?php

namespace Urbem\CoreBundle\Services\Financeiro\Tesouraria\Cheque;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Urbem\CoreBundle\Entity\Empenho\OrdemPagamento;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrente;
use Urbem\CoreBundle\Entity\Tesouraria\Transferencia;

class ChequeService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Soma todos os valores de chequeEmitidoOrdemPagamento e subtrai pelo total da ordemPagamento
     * @param $codOrdem
     * @param $exercicio
     * @param $codEntidade
     * @return mixed
     */
    public function getValorChequeEmissao($codOrdem, $exercicio, $codEntidade)
    {
        $ordemPagamento = $this->em->getRepository(OrdemPagamento::class)->findOneBy(['codOrdem' => $codOrdem, 'exercicio' => $exercicio, 'codEntidade' => $codEntidade]);
        $valoresCheques = new ArrayCollection();
        foreach ($ordemPagamento->getFkTesourariaChequeEmissaoOrdemPagamentos() as $key => $chequeEmissaoOrdemPagamento) {
            $statusCheque = $this->statusCheque($chequeEmissaoOrdemPagamento);
            if ($statusCheque['emitido'] == "Não" || $statusCheque['emitido'] == "Anulado") {
                $ordemPagamento->getFkTesourariaChequeEmissaoOrdemPagamentos()->remove($key);
            } else {
                $valoresCheques->add($chequeEmissaoOrdemPagamento->getFkTesourariaChequeEmissao()->getValor());
            }
        }

        return ($ordemPagamento->getValor() - array_sum($valoresCheques->toArray()));
    }

    /**
     * Soma todos os valores de chequeEmissaoTransferencia e subtrai pelo total da transferencia
     * @param $codLote
     * @param $exercicio
     * @param $codEntidade
     * @param $tipo
     * @return mixed
     */
    public function getValorChequeEmissaoTransferencia($codLote, $exercicio, $codEntidade, $tipo)
    {
        $transferencia = $this->em->getRepository(Transferencia::class)->findOneBy(['codLote' => $codLote, 'exercicio' => $exercicio, 'codEntidade' => $codEntidade, 'tipo' => $tipo]);
        $valoresCheques = new ArrayCollection();
        foreach ($transferencia->getFkTesourariaChequeEmissaoTransferencias() as $key => $fkChequeEmissaoTransferencia) {
            $statusCheque = $this->statusCheque($fkChequeEmissaoTransferencia);
            if ($statusCheque['emitido'] == "Não" || $statusCheque['emitido'] == "Anulado") {
                $transferencia->getFkTesourariaChequeEmissaoTransferencias()->remove($key);
            } else {
                $valoresCheques->add($fkChequeEmissaoTransferencia->getFkTesourariaChequeEmissao()->getValor());
            }
        }

        return ($transferencia->getValor() - array_sum($valoresCheques->toArray()));
    }

    /**
     * Retorna o status do cheque
     * @param $chequeEmissao
     * @return mixed
     */
    private function statusCheque($chequeEmissao)
    {
        $repositoryCheque = $this->em->getRepository('CoreBundle:Tesouraria\Cheque');
        $repositoryContaCorrente = $this->em->getRepository(ContaCorrente::class);

        $dadosBusca =  ['codBanco' => $chequeEmissao->getCodBanco(), 'codAgencia' => $chequeEmissao->getCodAgencia(), 'codContaCorrente' => $chequeEmissao->getCodContaCorrente()];
        $contaCorrente = $repositoryContaCorrente->findOneBy($dadosBusca);
        $statusCheque =  $repositoryCheque->statusCheque(
            $contaCorrente->getFkMonetarioAgencia()->getFkMonetarioBanco()->getNumBanco(),
            $contaCorrente->getFkMonetarioAgencia()->getNumAgencia(),
            $contaCorrente->getNumContaCorrente(),
            $chequeEmissao->getNumCheque()
        );

        return $statusCheque;
    }
}
