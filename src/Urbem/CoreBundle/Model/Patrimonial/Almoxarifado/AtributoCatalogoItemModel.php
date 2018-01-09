<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM;

use Urbem\CoreBundle\AbstractModel as Model;
use Urbem\CoreBundle\Entity\Administracao;
use Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * Class AtributoCatalogoItemModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado]
 */
class AtributoCatalogoItemModel extends Model
{
    protected $entityManager = null;

    /** @var null|ORM\EntityRepository $repository */
    protected $repository = null;

    /**
     * ControleEstoqueModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Almoxarifado\AtributoCatalogoItem::class);
    }

    /**
     * @param Almoxarifado\CatalogoItem $catalogoItem
     * @param Administracao\AtributoDinamico $atributoDinamico
     * @return Almoxarifado\AtributoCatalogoItem
     */
    public function buildWithCatalogoItem(
        Almoxarifado\CatalogoItem $catalogoItem,
        Administracao\AtributoDinamico $atributoDinamico
    ) {
        $atributoCatalogoItem = new Almoxarifado\AtributoCatalogoItem();
        $atributoCatalogoItem->setAtivo(true);
        $atributoCatalogoItem->setFkAlmoxarifadoCatalogoItem($catalogoItem);
        $atributoCatalogoItem->setFkAdministracaoAtributoDinamico($atributoDinamico);

        $catalogoItem->addFkAlmoxarifadoAtributoCatalogoItens($atributoCatalogoItem);

        $this->save($atributoCatalogoItem);

        return $atributoCatalogoItem;
    }

    /**
     * @param Almoxarifado\CatalogoItem $catalogoItem
     * @param array $atributosDinamicos
     * @return \Doctrine\Common\Collections\Collection|Almoxarifado\AtributoCatalogoItem
     */
    public function clearAllExcept(
        Almoxarifado\CatalogoItem $catalogoItem,
        $atributosDinamicos
    ) {
        $atributoCatalogoItens = $catalogoItem->getFkAlmoxarifadoAtributoCatalogoItens();

        /** @var Almoxarifado\AtributoCatalogoItem $atributoCatalogoItem */
        foreach ($atributoCatalogoItens as $atributoCatalogoItem) {
            /** @var Administracao\AtributoDinamico $atributoDinamico */
            foreach ($atributosDinamicos as $atributoDinamico) {
                if ($atributoDinamico->getCodAtributo() != $atributoCatalogoItem->getCodAtributo()) {
                    $atributoCatalogoItens->removeElement($atributoCatalogoItem);
                }
            }
        }


        if (empty($atributosDinamicos)) {
            foreach ($atributoCatalogoItens as $atributoCatalogoItem) {
                $this->remove($atributoCatalogoItem);
            }
        }

        return $atributoCatalogoItens;
    }
}
