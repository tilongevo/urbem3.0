<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoItem;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacao;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;
use Urbem\CoreBundle\Entity\Orcamento\Despesa;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoItemDotacaoAnulacao;

class SolicitacaoItemDotacaoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Compras\\SolicitacaoItemDotacao");
    }

    /**
     * @param SolicitacaoItem $item
     * @return SolicitacaoItemDotacao
     */
    public function saveSolicitacaoItemDotacao(SolicitacaoItem $item)
    {
        $solItemDotacao = new SolicitacaoItemDotacao();

        $despesa = $item->getFkComprasSolicitacaoItemDotacoes()->last()->getFkOrcamentoDespesa();
        $solItemDotacao->setFkOrcamentoDespesa($despesa);
        $contaDespesa = $item->getFkComprasSolicitacaoItemDotacoes()->last()->getFkOrcamentoContaDespesa();
        $solItemDotacao->setFkOrcamentoContaDespesa($contaDespesa);
        $solItemDotacao->setFkComprasSolicitacaoItem($item);
        $solItemDotacao->setQuantidade($item->getQuantidade());
        $solItemDotacao->setVlReserva($item->getVlTotal());

        $this->save($solItemDotacao);
        return $solItemDotacao;
    }

    /**
     * @param SolicitacaoItem $solicitacaoItem
     * @param ContaDespesa $contaDespesa
     * @param Despesa $despesa
     * @return SolicitacaoItemDotacao
     * @internal param $codConta
     */
    public function salvaSolicitacaoItemDotacao(SolicitacaoItem $solicitacaoItem, ContaDespesa $contaDespesa, Despesa $despesa)
    {

        $exercicio = $solicitacaoItem->getExercicio();
        $codEntidade = $solicitacaoItem->getCodEntidade();
        $codSolicitacao = $solicitacaoItem->getCodSolicitacao();
        $codCentro = $solicitacaoItem->getCodCentro();
        $codItem = $solicitacaoItem->getCodItem();

        $solItemDotacao = $this->getOneSolicitacaoItemDotacao($exercicio, $codEntidade, $codSolicitacao, $codCentro, $codItem, $contaDespesa->getCodConta(), $despesa->getCodDespesa());
        if (!is_null($solItemDotacao)) {
            $this->removeSolicitacaoItemDotacao($exercicio, $codEntidade, $codSolicitacao, $codCentro, $codItem, $contaDespesa->getCodConta(), $despesa->getCodDespesa());
        }
        /** @var SolicitacaoItemDotacao $solItemDotacao */
        $solItemDotacao = new SolicitacaoItemDotacao();
        $solItemDotacao->setVlReserva($solicitacaoItem->getVlTotal());
        $solItemDotacao->setQuantidade($solicitacaoItem->getQuantidade());
        $solItemDotacao->setFkOrcamentoDespesa($despesa);
        $solItemDotacao->setFkOrcamentoContaDespesa($contaDespesa);
        $solItemDotacao->setFkComprasSolicitacaoItem($solicitacaoItem);

        $this->entityManager->persist($solItemDotacao);

        return $solItemDotacao;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $codSolicitacao
     * @param $codCentro
     * @param $codItem
     * @param $codConta
     * @param $codDespesa
     * @return null|object
     */
    public function getOneSolicitacaoItemDotacao($exercicio, $codEntidade, $codSolicitacao, $codCentro, $codItem, $codConta, $codDespesa)
    {
        $solicitacaoItemDotacao = $this->repository->findOneBy([
            'exercicio' => $exercicio,
            'codEntidade' => $codEntidade,
            'codSolicitacao' => $codSolicitacao,
            'codCentro' => $codCentro,
            'codItem' => $codItem,
            'codConta' => $codConta,
            'codDespesa' => $codDespesa
        ]);

        return $solicitacaoItemDotacao;
    }

    /**
     * @param $exercicio
     * @param $codEntidade
     * @param $codSolicitacao
     * @param $codItem
     */
    public function removeSolicitacaoItemDotacao($exercicio, $codEntidade, $codSolicitacao, $codCentro, $codItem, $codConta, $codDespesa)
    {
        $registroSolicitacaoItemDotacao = $this->entityManager->getRepository('CoreBundle:Compras\SolicitacaoItemDotacao')
            ->findBy([
                'exercicio' => $exercicio,
                'codEntidade' => $codEntidade,
                'codSolicitacao' => $codSolicitacao,
                'codCentro' => $codCentro,
                'codItem' => $codItem,
                'codConta' => $codConta,
                'codDespesa' => $codDespesa
            ]);

        if (!is_null($registroSolicitacaoItemDotacao)) {
            foreach ($registroSolicitacaoItemDotacao as $acaoSolicitacaoItemDotacao) {
                $this->remove($acaoSolicitacaoItemDotacao);
            }
        }
    }


    /**
     * @param $exercicio
     * @param $itensDotacaoArray
     * @param $codItem
     * @param $itensArray
     */
    public function anulaSolicitacaoItemDotacao($exercicio, $itensDotacaoArray, $codItem, $itensArray)
    {
        $timestamp = $itensDotacaoArray['timestamp'];
        $codEntidade = $itensDotacaoArray['cod_entidade'];
        $codSolicitacao = $itensDotacaoArray['cod_solicitacao'];
        $codCentro = $itensDotacaoArray['cod_centro'];
        $codConta = $itensDotacaoArray['cod_conta'];
        $codDespesa = $itensDotacaoArray['cod_despesa'];
        $quantidadeAnular = $itensArray['quantidadeAnular'][$codItem];
        $valorAnular = $itensArray['valorAnular'][$codItem];


        $registroSolicitacaoItemDotacao = $this->entityManager->getRepository('CoreBundle:Compras\SolicitacaoItemDotacao')
            ->findOneBy([
                'exercicio' => $exercicio,
                'codEntidade' => $codEntidade,
                'codSolicitacao' => $codSolicitacao,
                'codCentro' => $codCentro,
                'codItem' => $codItem,
                'codConta' => $codConta,
                'codDespesa' => $codDespesa
            ]);

        if (!is_null($registroSolicitacaoItemDotacao)) {
            $registroSolicitacaoItemDotacaoAnulacao = $this->entityManager->getRepository('CoreBundle:Compras\SolicitacaoItemDotacaoAnulacao')
                ->findOneBy([
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'codSolicitacao' => $codSolicitacao,
                    'timestamp' => $timestamp,
                    'codCentro' => $codCentro,
                    'codItem' => $codItem,
                    'codConta' => $codConta,
                    'codDespesa' => $codDespesa
                ]);

            $valorAnular = str_replace(',', ".", str_replace('.', "", $valorAnular));

            if (!is_null($registroSolicitacaoItemDotacaoAnulacao)) {
                $quantidadeAnular = $registroSolicitacaoItemDotacaoAnulacao->getQuantidade() + $quantidadeAnular;
                $valorAnular = (float) $registroSolicitacaoItemDotacaoAnulacao->getVlAnulacao() + $valorAnular;
                $registroSolicitacaoItemDotacaoAnulacao->setQuantidade($quantidadeAnular);
                $registroSolicitacaoItemDotacaoAnulacao->setVlAnulacao($valorAnular);
            } else {
                $registroSolicitacaoItemDotacaoAnulacao = new SolicitacaoItemDotacaoAnulacao();
                $registroSolicitacaoItemDotacaoAnulacao->setExercicio($exercicio);
                $registroSolicitacaoItemDotacaoAnulacao->setCodEntidade($codEntidade);
                $registroSolicitacaoItemDotacaoAnulacao->setCodSolicitacao($codSolicitacao);
                $registroSolicitacaoItemDotacaoAnulacao->setTimestamp($timestamp);
                $registroSolicitacaoItemDotacaoAnulacao->setCodCentro($codCentro);
                $registroSolicitacaoItemDotacaoAnulacao->setCodItem($codItem);
                $registroSolicitacaoItemDotacaoAnulacao->setCodConta($codConta);
                $registroSolicitacaoItemDotacaoAnulacao->setCodDespesa($codDespesa);
                $registroSolicitacaoItemDotacaoAnulacao->setQuantidade($quantidadeAnular);
                $registroSolicitacaoItemDotacaoAnulacao->setVlAnulacao($valorAnular);
            }
            $this->entityManager->persist($registroSolicitacaoItemDotacaoAnulacao);
            $this->entityManager->flush();
        }
    }

    /**
     * @param SolicitacaoItem $solicitacaoItem
     * @param Despesa         $despesa
     * @param                 $vlReserva
     * @param                 $quantidade
     * @param bool            $save
     *
     * @return SolicitacaoItemDotacao
     */
    public function buildOneSolicitacaoItemDotacao(SolicitacaoItem $solicitacaoItem, Despesa $despesa, $vlReserva, $quantidade, $save = false)
    {
        /** @var SolicitacaoItemDotacao $solicitacaoItemDotacao */
        $solicitacaoItemDotacao = new SolicitacaoItemDotacao();
        $solicitacaoItemDotacao->setFkComprasSolicitacaoItem($solicitacaoItem);
        $solicitacaoItemDotacao->setFkOrcamentoDespesa($despesa);
        $solicitacaoItemDotacao->setFkOrcamentoContaDespesa($despesa->getFkOrcamentoContaDespesa());
        $solicitacaoItemDotacao->setVlReserva($vlReserva);
        $solicitacaoItemDotacao->setQuantidade($quantidade);

        if ($save == true) {
            $this->save($solicitacaoItemDotacao);
        }

        return $solicitacaoItemDotacao;
    }
}
