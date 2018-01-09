<?php

namespace Urbem\CoreBundle\Model\Empenho;

use Doctrine\ORM;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\UnidadeMedida;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Entity\Empenho\ItemPreEmpenho;
use Urbem\CoreBundle\Entity\Empenho\PreEmpenho;
use Urbem\CoreBundle\Repository\Empenho\ItemPreEmpenhoRepository;

/**
 * Class ItemPreEmpenhoModel
 * @package Urbem\CoreBundle\Model\Empenho
 */
class ItemPreEmpenhoModel extends AbstractModel
{
    /** @var ORM\EntityManager|null  */
    protected $entityManager = null;

    /** @var ItemPreEmpenhoRepository|null  */
    protected $repository = null;

    /**
     * ItemPreEmpenhoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(ItemPreEmpenho::class);
    }

    /**
     * @param int $codPreEmpenho
     * @param string $exercicio
     * @return int
     */
    public function getProximoNumItem($codPreEmpenho, $exercicio)
    {
        return $this->repository->getProximoNumItem($codPreEmpenho, $exercicio);
    }
    
    /**
     * Ações adicionais após inserir um item de pre empenho
     * @param  object $object
     */
    public function afterEmpenhoDiversos($object)
    {
        $preEmpenhoDespesa = $this->entityManager->getRepository("CoreBundle:Empenho\PreEmpenhoDespesa")
        ->findOneBy(
            array(
                'exercicio' => $object->getExercicio(),
                'codPreEmpenho' => $object->getCodPreEmpenho(),
            )
        );

        $contaDespesa = $this->entityManager->getRepository("CoreBundle:Orcamento\ContaDespesa")
        ->findOneBy(
            array(
                'exercicio' => $preEmpenhoDespesa->getExercicio(),
                'codConta' => $preEmpenhoDespesa->getCodConta(),
            )
        );

        $codDespesa = $this->entityManager->getRepository("CoreBundle:Orcamento\Despesa")
        ->findOneByCodDespesa($preEmpenhoDespesa->getCodDespesa());

        $empenho = $this->entityManager->getRepository("CoreBundle:Empenho\Empenho")
        ->findOneByCodPreEmpenho($object->getCodPreEmpenho());
        
        $lote = $this->entityManager->getRepository("CoreBundle:Contabilidade\Lote")
        ->findOneBy(
            array(
                'codEntidade' => $empenho->getCodEntidade(),
                'exercicio' => $object->getExercicio(),
                'tipo' => 'E'
            )
        );
        
        if ($lote) {
            $codLote = $lote->getCodLote();
        } else {
            $stNomeLote = "Emissão de Empenho n° " . $empenho->getCodEmpenho() . "/" . $object->getExercicio();
            $codLote = $this->entityManager->getRepository("CoreBundle:Empenho\Empenho")
            ->fnInsereLote(
                $object->getExercicio(),
                $empenho->getCodEntidade(),
                'E',
                $stNomeLote,
                $empenho->getDtEmpenho()->format("d/m/Y")
            );
        }
        
        $vlTotal = $this->getVlTotal($object->getExercicio(), $object->getCodPreEmpenho());

        $sequencia = $this->entityManager->getRepository("CoreBundle:Empenho\Empenho")
        ->empenhoEmissao(
            $object->getExercicio(),
            $vlTotal,
            $empenho->getCodEmpenho() . "/" . $object->getExercicio(),
            $codLote,
            "E",
            $empenho->getCodEntidade(),
            $object->getCodPreEmpenho(),
            $codDespesa->getCodDespesa(),
            $contaDespesa->getCodEstrutural()
        );

        $lancamento = $this->entityManager->getRepository("CoreBundle:Contabilidade\Lancamento")
        ->findOneBy(
            array(
                'codLote' => $codLote,
                'exercicio' => $object->getExercicio(),
                'codEntidade' => $empenho->getCodEntidade(),
                'sequencia' => $sequencia,
                'tipo' => 'E'
            )
        );
        
        $lancamentoEmpenho = $this->entityManager->getRepository("CoreBundle:Contabilidade\LancamentoEmpenho")
        ->findOneBy(
            array(
                'exercicio' => $object->getExercicio(),
                'codEntidade' => $empenho->getCodEntidade(),
                'tipo' => 'E',
                'codLote' => $codLote,
                'sequencia' => $sequencia,
            )
        );

        if (! $lancamentoEmpenho) {
            $lancamentoEmpenho = new \Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho();
        }
        
        $lancamentoEmpenho->setFkContabilidadeLancamento($lancamento);
        $this->entityManager->persist($lancamentoEmpenho);
        
        $empenhamento = $this->entityManager->getRepository("CoreBundle:Contabilidade\Empenhamento")
        ->findOneBy(
            array(
                'exercicio' => $object->getExercicio(),
                'sequencia' => $sequencia,
                'tipo' => 'E',
                'codLote' => $codLote,
                'codEntidade' => $empenho->getCodEntidade(),
            )
        );
        
        if (! $empenhamento) {
            $empenhamento = new \Urbem\CoreBundle\Entity\Contabilidade\Empenhamento();
        }
        
        $empenhamento->setFkContabilidadeLancamentoEmpenho($lancamentoEmpenho);
        $empenhamento->setFkEmpenhoEmpenho($empenho);
        $this->entityManager->persist($empenhamento);

        $this->entityManager->flush();
    }
    
    /**
     * Ações adicionais após atualizar um item de pre empenho
     * @param  object $object
     */
    public function updateEmpenhoDiversos($object)
    {
        $preEmpenhoDespesa = $this->entityManager->getRepository("CoreBundle:Empenho\PreEmpenhoDespesa")
        ->findOneBy(
            array(
              'exercicio' => $object->getExercicio(),
              'codPreEmpenho' => $object->getCodPreEmpenho(),
            )
        );

        $contaDespesa = $this->entityManager->getRepository("CoreBundle:Orcamento\ContaDespesa")
        ->findOneBy(
            array(
              'exercicio' => $preEmpenhoDespesa->getExercicio(),
              'codConta' => $preEmpenhoDespesa->getCodConta(),
            )
        );

        $codDespesa = $this->entityManager->getRepository("CoreBundle:Orcamento\Despesa")
        ->findOneByCodDespesa($preEmpenhoDespesa->getCodDespesa());

        $empenho = $this->entityManager->getRepository("CoreBundle:Empenho\Empenho")
        ->findOneByCodPreEmpenho($object->getCodPreEmpenho());
      
        $lote = $this->entityManager->getRepository("CoreBundle:Contabilidade\Lote")
        ->findOneBy(
            array(
              'codEntidade' => $empenho->getCodEntidade(),
              'exercicio' => $object->getExercicio(),
              'tipo' => 'E'
            )
        );
        
        $vlTotal = $this->getVlTotal($object->getExercicio(), $object->getCodPreEmpenho());
        
        $sequencia = $this->entityManager->getRepository("CoreBundle:Empenho\Empenho")
        ->empenhoEmissao(
            $object->getExercicio(),
            $vlTotal,
            $empenho->getCodEmpenho() . "/" . $object->getExercicio(),
            $lote->getCodLote(),
            "E",
            $empenho->getCodEntidade(),
            $object->getCodPreEmpenho(),
            $codDespesa->getCodDespesa(),
            $contaDespesa->getCodEstrutural()
        );

        $lancamento = $this->entityManager->getRepository("CoreBundle:Contabilidade\Lancamento")
        ->findOneBy(
            array(
              'codLote' => $lote->getCodLote(),
              'exercicio' => $object->getExercicio(),
              'codEntidade' => $empenho->getCodEntidade(),
              'sequencia' => $sequencia,
              'tipo' => 'E'
            )
        );
        
        $lancamentoEmpenho = $this->entityManager->getRepository("CoreBundle:Contabilidade\LancamentoEmpenho")
        ->findOneBy(
            array(
              'exercicio' => $object->getExercicio(),
              'codEntidade' => $empenho->getCodEntidade(),
              'tipo' => 'E',
              'codLote' => $lote->getCodLote(),
              'sequencia' => $sequencia,
            )
        );

        if (! $lancamentoEmpenho) {
            $lancamentoEmpenho = new \Urbem\CoreBundle\Entity\Contabilidade\LancamentoEmpenho();
        }
      
        $lancamentoEmpenho->setFkContabilidadeLancamento($lancamento);
        $this->entityManager->persist($lancamentoEmpenho);
      
        $empenhamento = $this->entityManager->getRepository("CoreBundle:Contabilidade\Empenhamento")
        ->findOneBy(
            array(
              'exercicio' => $object->getExercicio(),
              'sequencia' => $sequencia,
              'tipo' => 'E',
              'codLote' => $lote->getCodLote(),
              'codEntidade' => $empenho->getCodEntidade(),
            )
        );
      
        if (! $empenhamento) {
            $empenhamento = new \Urbem\CoreBundle\Entity\Contabilidade\Empenhamento();
        }
      
        $empenhamento->setFkContabilidadeLancamentoEmpenho($lancamentoEmpenho);
        $empenhamento->setFkEmpenhoEmpenho($empenho);
        $this->entityManager->persist($empenhamento);

        $this->entityManager->flush();
    }

    /**
     * @param $inNumItemCont
     * @param PreEmpenho $preEmpenho
     * @param $rsItensSolicitacao
     * @param CentroCusto $centroCusto
     * @param CatalogoItem $item
     * @param UnidadeMedida $unidade
     */
    public function saveItemPreEmpenho(
        $inNumItemCont,
        PreEmpenho $preEmpenho,
        $rsItensSolicitacao,
        CentroCusto $centroCusto,
        CatalogoItem $item,
        UnidadeMedida $unidade
    ) {
        if (is_array($rsItensSolicitacao)) {
            $rsItensSolicitacao = $rsItensSolicitacao[0];
        }

        $itemPreEmpenho = new ItemPreEmpenho();
        $itemPreEmpenho->setNumItem($inNumItemCont);
        $itemPreEmpenho->setFkEmpenhoPreEmpenho($preEmpenho);
        $itemPreEmpenho->setQuantidade($rsItensSolicitacao->qtd_cotacao);
        $itemPreEmpenho->setNomUnidade($rsItensSolicitacao->nom_unidade);
        $itemPreEmpenho->setVlTotal($rsItensSolicitacao->vl_cotacao);
        $itemPreEmpenho->setNomItem($rsItensSolicitacao->descricao_completa);

        $complemento = trim($rsItensSolicitacao->descricao_completa).trim($rsItensSolicitacao->complemento);
        $itemPreEmpenho->setComplemento($complemento);
        $itemPreEmpenho->setSiglaUnidade($rsItensSolicitacao->simbolo);
        $itemPreEmpenho->setFkAlmoxarifadoCentroCusto($centroCusto);
        $itemPreEmpenho->setFkAlmoxarifadoCatalogoItem($item);
        $itemPreEmpenho->setFkAdministracaoUnidadeMedida($unidade);
        $this->save($itemPreEmpenho);
    }
    
    /**
     * Retorna o valor total do empenho
     * @param  string $exercicio
     * @param  integer $codPreEmpenho
     * @return float
     */
    public function getVlTotal($exercicio, $codPreEmpenho)
    {
        $itensPreEmpenho = $this->entityManager->getRepository("CoreBundle:Empenho\ItemPreEmpenho")
        ->findBy(
            array(
                'exercicio' => $exercicio,
                'codPreEmpenho' => $codPreEmpenho
            )
        );
        
        $vlTotal = 0;
        foreach ($itensPreEmpenho as $itemPreEmpenho) {
            $vlTotal += (float) $itemPreEmpenho->getVlTotal();
        }
        
        return $vlTotal;
    }

    /**
     * @param PreEmpenho $preEmpenho
     * @param CatalogoItem $catalogoItem
     * @return null|ItemPreEmpenho
     */
    public function findByPreEmpenhoAndItemDescricao(PreEmpenho $preEmpenho, CatalogoItem $catalogoItem)
    {
        return $this->repository->findOneBy([
            'codPreEmpenho' => $preEmpenho->getCodPreEmpenho(),
            'exercicio' => $preEmpenho->getExercicio(),
            'nomItem' => $catalogoItem->getDescricao()
        ]);
    }

    /**
     * @param ItemPreEmpenho $itemPreEmpenho
     * @param CentroCusto $centroCusto
     * @return void
     */
    public function checkAndUpdateItemPreEmpenhoWithCentroCusto(
        ItemPreEmpenho $itemPreEmpenho,
        CentroCusto $centroCusto
    ) {
        if (true == is_null($itemPreEmpenho->getCodCentro())) {
            $itemPreEmpenho->setFkAlmoxarifadoCentroCusto($centroCusto);
            $this->save($itemPreEmpenho);
        }
    }

    /**
     * @param ItemPreEmpenho $itemPreEmpenho
     * @param CatalogoItem $catalogoItem
     * @return void
     */
    public function checkAndUpdateItemPreEmpenhoWithCatalogoItem(
        ItemPreEmpenho $itemPreEmpenho,
        CatalogoItem $catalogoItem
    ) {
        if (true == is_null($itemPreEmpenho->getCodItem())) {
            $itemPreEmpenho->setFkAlmoxarifadoCatalogoItem($catalogoItem);
            $this->save($itemPreEmpenho);
        }
    }

    /**
     * @param ItemPreEmpenho $itemPreEmpenho
     * @param Marca $marca
     * @return void
     */
    public function checkAndUpdateItemPreEmpenhoWithMarca(ItemPreEmpenho $itemPreEmpenho, Marca $marca)
    {
        if (true == is_null($itemPreEmpenho->getCodMarca())) {
            $itemPreEmpenho->setFkAlmoxarifadoMarca($marca);
            $this->save($itemPreEmpenho);
        }
    }
}
