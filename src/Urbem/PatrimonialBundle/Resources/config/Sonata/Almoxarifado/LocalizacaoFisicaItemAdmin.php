<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM;

use Sonata\AdminBundle\Form\FormMapper;

use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\MarcaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class LocalizacaoFisicaItemAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class LocalizacaoFisicaItemAdmin extends AbstractSonataAdmin
{


    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $localizacaoFisicaItem = null;
        $catalogoItem = null;
        $marca = null;

        /** @var Almoxarifado\LocalizacaoFisicaItem|null $localizacaoFisicaItem */
        try {
            $localizacaoFisicaItem = $this->getSubject();
        } catch (\Exception $e) {
            $localizacaoFisicaItem = null;
        }



        if (isset($localizacaoFisicaItem)) {
            /** @var ORM\EntityManager $entityManager */
            $entityManager = $this->modelManager->getEntityManager($this->getClass());

            $catalogoItemModel = new CatalogoItemModel($entityManager);
            $catalogoItem = $catalogoItemModel->getOneByCodItem($localizacaoFisicaItem->getCodItem());

            $marcaModel = new MarcaModel($entityManager);
            $marca = $marcaModel->getOneByCodMarca($localizacaoFisicaItem->getCodMarca());
        }

        $fieldOptions = [];
        $fieldOptions['codItem'] = [
            'attr' => ['class' => 'select2-parameters '],
            'label' => 'label.almoxarifado.item',
            'multiple' => false,
            'class' => Almoxarifado\CatalogoItem::class,
            'route' => ['name' => 'urbem_patrimonial_almoxarifado_catalogo_item_autocomplete'],
            'data' => $catalogoItem,
        ];

        $fieldOptions['codMarca'] = [
            'attr' => ['class' => 'select2-parameters '],
            'label' => 'label.almoxarifado.marca',
            'multiple' => false,
            'class' => Almoxarifado\Marca::class,
            'route' => ['name' => 'urbem_patrimonial_almoxarifado_marca_autocomplete'],
            'data' => $marca
        ];

        $fieldOptions['unidadeMedida'] = [
            'mapped' => false,
            'label' => 'label.almoxarifado.unidadeMedida',
            'data' => 'Indefinido',
            'required' => false,
            'attr' => [
                'readonly' => 'readonly'
            ]
        ];

        $formMapper
            ->add('codItem', 'autocomplete', $fieldOptions['codItem'])
            ->add('unidadeMedida', 'text', $fieldOptions['unidadeMedida'])
            ->add('codMarca', 'autocomplete', $fieldOptions['codMarca'])
        ;
    }
}
