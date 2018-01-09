<?php
namespace Urbem\CoreBundle\Model\Patrimonial\Compras;

use Doctrine\ORM;
use Faker\Provider\tr_TR\DateTime;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoAnulacao;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoItem;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoItemAnulacao;
use Urbem\CoreBundle\Model;

class SolicitacaoItemAnulacaoModel implements Model\InterfaceModel
{
    private $entityManager = null;
    protected $repository = null;

    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:Compras\\SolicitacaoItemAnulacao");
    }

    public function canRemove($object)
    {
        // TODO: Implement canRemove() method.
    }

    public function anularItensSolicitacaoLote(SolicitacaoItem $item, SolicitacaoAnulacao $solicitacaoAnulacao)
    {
        $itemAnulacao = $this->repository
            ->findOneBy([
                'exercicio' => $item->getExercicio(),
                'codSolicitacao' => $item->getCodSolicitacao(),
                'codEntidade' => $item->getCodEntidade(),
                'codCentro' => $item->getCodCentro(),
                'codItem' => $item->getCodItem()
            ]);

        if (is_null($itemAnulacao)) {
            $itemAnulacao = new SolicitacaoItemAnulacao();
            $itemAnulacao->setCodItem($item->getCodItem());
            $itemAnulacao->setQuantidade($item->getQuantidade());
            $itemAnulacao->setVlTotal($item->getVlTotal());
            $itemAnulacao->setCodCentro($item->getCodCentro());
            $itemAnulacao->setFkComprasSolicitacaoItem($item);
            $itemAnulacao->setTimestamp($solicitacaoAnulacao->getTimestamp());
            $this->entityManager->persist($itemAnulacao);
            $this->entityManager->flush();
        }
    }

    /**
     * @param SolicitacaoAnulacao $solicitacaoAnulacao
     * @param SolicitacaoItem $objItem
     * @param $codSolicitacao
     * @param $codEntidade
     * @param $exercicio
     * @param $codItem
     * @param $itensArray
     */
    public function anularItemSolicitacao(SolicitacaoAnulacao $solicitacaoAnulacao, SolicitacaoItem $objItem, $codSolicitacao, $codEntidade, $exercicio, $codItem, $itensArray)
    {
        $codCentro = $itensArray['codCentro'][$codItem];
        $quantidadeAnular = $itensArray['quantidadeAnular'][$codItem];
        $valorAnular = $itensArray['valorAnular'][$codItem];

        $itemAnulacao = $this->repository
            ->findOneBy([
                'exercicio' => $exercicio,
                'codSolicitacao' => $codSolicitacao,
                'codEntidade' => $codEntidade,
                'codCentro' => $itensArray['codCentro'][$codItem],
                'codItem' => $codItem
            ]);

        $valorAnular = str_replace(',', ".", str_replace('.', "", $valorAnular));

        if (!is_null($itemAnulacao)) {
            $quantidadeAnular = $itemAnulacao->getQuantidade() + $quantidadeAnular;
            $valorAnular = (float) $itemAnulacao->getVlTotal() + $valorAnular;
            $itemAnulacao->setQuantidade($quantidadeAnular);
            $itemAnulacao->setVlTotal($valorAnular);
        } else {
            $itemAnulacao = new SolicitacaoItemAnulacao();
            $itemAnulacao->setCodItem($codItem);
            $itemAnulacao->setQuantidade($quantidadeAnular);
            $itemAnulacao->setVlTotal($valorAnular);
            $itemAnulacao->setCodCentro($codCentro);
            $itemAnulacao->setFkComprasSolicitacaoItem($objItem);
            $itemAnulacao->setTimestamp($solicitacaoAnulacao->getTimestamp());
        }
        $this->entityManager->persist($itemAnulacao);
        $this->entityManager->flush();

        return $itemAnulacao;
    }


    public function alteraMotivoAnulacao(SolicitacaoAnulacao $solicitacaoAnulacao, $motivo)
    {
        if (!is_null($solicitacaoAnulacao)) {
            $solicitacaoAnulacao->setMotivo($motivo);
            $this->entityManager->persist($solicitacaoAnulacao);
            $this->entityManager->flush();
        }
    }
}
