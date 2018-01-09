<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemMarcaModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LocalizacaoFisicaItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\LocalizacaoFisicaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class LocalizacaoFisicaAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class LocalizacaoFisicaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_localizacao_fisica';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/localizacao-fisica';
    protected $includeJs = [
        '/patrimonial/javascripts/almoxarifado/localizacaoFisica.js',
    ];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $fieldOptions['fkAlmoxarifadoAlmoxarifado'] = [
            'attr' => ['class' => 'select2-parameters '],
            'label' => 'label.almoxarifado.modulo'
        ];

        $fieldOptions['localizacao'] = ['label' => 'label.bem.localizacao'];
        $datagridMapper
            ->add('fkAlmoxarifadoAlmoxarifado', null, [
                'label' => 'label.almoxarifado.modulo',
            ], null, $fieldOptions['fkAlmoxarifadoAlmoxarifado'])
            ->add('localizacao', null, $fieldOptions['localizacao'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codLocalizacao', null, ['label' => 'label.codigo'])
            ->add('fkAlmoxarifadoAlmoxarifado', null, ['label' => 'label.almoxarifado.modulo'])
            ->add('localizacao', null, ['label' => 'label.almoxarifado.localizacao'])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        /** @var ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $showMapper
            ->with('Dados da Localização')
                ->add('fkAlmoxarifadoAlmoxarifado.fkSwCgm.nomCgm', null, ['label' => 'label.almoxarifado.modulo'])
                ->add('localizacao', 'text', ['label' => 'label.almoxarifado.localizacao'])
                ->add('fkAlmoxarifadoLocalizacaoFisicaItens', null, [
                    'associated_property' => function (Almoxarifado\LocalizacaoFisicaItem $localizacaoFisicaItem) use ($entityManager) {
                        $marca = $localizacaoFisicaItem
                            ->getFkAlmoxarifadoCatalogoItemMarca()
                            ->getFkAlmoxarifadoMarca();

                        /** @var Almoxarifado\CatalogoItem $catalogoItem */
                        $catalogoItem = $entityManager->getRepository(Almoxarifado\CatalogoItem::class)
                            ->find($localizacaoFisicaItem->getCodItem());

                        return sprintf("%s - %s", $catalogoItem->getDescricao(), $marca->getDescricao());
                    },
                    'label' => 'label.almoxarifado.catalogoItemMarca'
                ])
            ->end()
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];
        $fieldOptions['fkAlmoxarifadoAlmoxarifado'] = [
            'attr' => ['class' => 'select2-parameters '],
            'label' => 'label.inventario.codAlmoxarifado',
            'class' => Almoxarifado\Almoxarifado::class,
            'placeholder' => 'label.selecione'
        ];

        if ($subject = $this->getSubject()) {
            $fieldOptions['almox'] = [
                'attr' => ['readonly' => 'readonly'],
                'data' => $subject->getFkAlmoxarifadoAlmoxarifado(),
                'mapped' => false,
                'label' => 'label.almoxarifado.modulo',
            ];
        }

        $fieldOptions['localizacao'] = ['label' => 'label.bem.localizacao'];

        $formMapper->with('Dados da Localização');
        if ($this->isEdit()) {
            $formMapper->add('almox', 'text', $fieldOptions['almox']);
        } else {
            $formMapper->add('fkAlmoxarifadoAlmoxarifado', 'entity', $fieldOptions['fkAlmoxarifadoAlmoxarifado']);
        }
        $formMapper
            ->add('localizacao', 'text', $fieldOptions['localizacao'])
            ->end()
        ;


        $formMapper
            ->with('Dados do Item')
                ->add('fkAlmoxarifadoLocalizacaoFisicaItens', 'sonata_type_collection', [
                    'label' => false,
                    'required' => false,
                ], [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'delete' => true
                ])
            ->end()
        ;
    }

    /**
     * @param Almoxarifado\LocalizacaoFisica $localizacaoFisica
     */
    public function saveLocalizacaoFisicaItem(Almoxarifado\LocalizacaoFisica $localizacaoFisica, $method = 'create')
    {
        /** @var ORM\EntityManager $em */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $catalogoItemMarcaModel = new CatalogoItemMarcaModel($entityManager);

        /** @var Almoxarifado\LocalizacaoFisicaItem $item */
        foreach ($localizacaoFisica->getFkAlmoxarifadoLocalizacaoFisicaItens() as $item) {
            $item->setCodItem($item->getCodItem()->getCodItem());
            $item->setCodMarca($item->getCodMarca()->getCodMarca());
            $catalogoItemMarca = $catalogoItemMarcaModel->findOrCreateCatalogoItemMarca(
                $item->getCodItem(),
                $item->getCodMarca()
            );
            $item->setFkAlmoxarifadoLocalizacaoFisica($localizacaoFisica);
            $item->setFkAlmoxarifadoCatalogoItemMarca($catalogoItemMarca);
        }
    }

    /**
     * @param Almoxarifado\LocalizacaoFisica $localizacaoFisica
     */
    public function prePersist($localizacaoFisica)
    {
        $this->saveLocalizacaoFisicaItem($localizacaoFisica);
    }

    /**
     * @param Almoxarifado\LocalizacaoFisica $localizacaoFisica
     */
    public function preUpdate($localizacaoFisica)
    {
        $this->saveLocalizacaoFisicaItem($localizacaoFisica, 'update');
    }

    /**
     * @param ErrorElement $errorElement
     * @param Almoxarifado\LocalizacaoFisica $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        /** @var ORM\EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $localizacao = $em->getRepository(Almoxarifado\LocalizacaoFisica::class)
            ->findBy(['localizacao' => $object->getLocalizacao()]);
        if (count($localizacao) > 0 && $localizacao[0] !== $object) {
            $message = $this->trans('localizacaoFisica.errors.localizacaoDuplicada', [], 'validators');
            $errorElement->addViolation($message)->end();
        }
//        fkAlmoxarifadoLocalizacaoFisicaItens
        foreach ($this->getForm()->get('fkAlmoxarifadoLocalizacaoFisicaItens') as $item) {
            $delete = $item->get('_delete')->getData();
            $itemCodMarca = $item->get('codMarca')->getData();
            $itemCodItem = $item->get('codItem')->getData();
            if (!$delete && (!$itemCodMarca || !$itemCodItem)) {
                $message = $this->trans('localizacaoFisica.errors.addItemVazio', [], 'validators');
                $errorElement->addViolation($message)->end();
            }
        }
    }

    /**
     * Return se o form corrente está sendo vista como edit ou não
     * @TODO Mover esse codigo para abstract.
     * @return bool
     */
    public function isEdit()
    {
        $route = $this->getRequest()->get('_sonata_name');
        if ($this->baseRouteName . "_edit" == $route) {
            return true;
        }
        return false;
    }
}
