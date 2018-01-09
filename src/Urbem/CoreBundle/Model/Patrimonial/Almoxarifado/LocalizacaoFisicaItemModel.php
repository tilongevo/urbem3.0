<?php

namespace Urbem\CoreBundle\Model\Patrimonial\Almoxarifado;

use Doctrine\ORM;

use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Almoxarifado;

/**
 * Class LocalizacaoFisicaItemModel
 * @package Urbem\CoreBundle\Model\Patrimonial\Almoxarifado
 */
class LocalizacaoFisicaItemModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var ORM\EntityManager|null $repository */
    protected $repository = null;

    /**
     * LocalizacaoFisicaItemModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Almoxarifado\LocalizacaoFisicaItem::class);
    }

    /**
     * @param Almoxarifado\CatalogoItemMarca $catalogoItemMarca
     * @param Almoxarifado\LocalizacaoFisica $localizacaoFisica
     * @return Almoxarifado\LocalizacaoFisicaItem
     */
    public function findOrCreate(
        Almoxarifado\CatalogoItemMarca $catalogoItemMarca,
        Almoxarifado\LocalizacaoFisica $localizacaoFisica
    ) {
        /** @var Almoxarifado\LocalizacaoFisicaItem $localizacaoFisicaItem */
        $localizacaoFisicaItem = $this->repository->find([
            'codAlmoxarifado' => $localizacaoFisica->getCodAlmoxarifado(),
            'codItem' => $catalogoItemMarca->getCodItem(),
            'codMarca' => $catalogoItemMarca->getCodMarca()
        ]);

        if (is_null($localizacaoFisicaItem)) {
            $localizacaoFisicaItem = new Almoxarifado\LocalizacaoFisicaItem();
            $localizacaoFisicaItem->setFkAlmoxarifadoCatalogoItemMarca($catalogoItemMarca);
            $localizacaoFisicaItem->setFkAlmoxarifadoLocalizacaoFisica($localizacaoFisica);

            $this->save($localizacaoFisicaItem);
        }

        $localizacaoFisica->addFkAlmoxarifadoLocalizacaoFisicaItens($localizacaoFisicaItem);

        return $localizacaoFisicaItem;
    }

    /**
     * @param Almoxarifado\CatalogoItemMarca $catalogoItemMarca
     * @param Almoxarifado\LocalizacaoFisica $localizacaoFisica
     * @param Almoxarifado\LocalizacaoFisicaItem $localizacaoFisicaItem
     * @return Almoxarifado\LocalizacaoFisicaItem
     */
    public function updateOrCreate(
        Almoxarifado\CatalogoItemMarca $catalogoItemMarca,
        Almoxarifado\LocalizacaoFisica $localizacaoFisica,
        Almoxarifado\LocalizacaoFisicaItem $localizacaoFisicaItem = null
    ) {
        if (is_null($localizacaoFisicaItem)) {
            $localizacaoFisicaItem = new Almoxarifado\LocalizacaoFisicaItem();
        }

        $localizacaoFisicaItem->setFkAlmoxarifadoCatalogoItemMarca($catalogoItemMarca);
        $localizacaoFisicaItem->setFkAlmoxarifadoLocalizacaoFisica($localizacaoFisica);

        return $localizacaoFisicaItem;
    }
}
