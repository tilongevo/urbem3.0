<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Almoxarifado\Catalogo;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoNiveis;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class CatalogoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class CatalogoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_catalogo';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/catalogo';

    protected $fkAlmoxarifadoCatalogoNiveis = [];

    /**
     * @param Catalogo $catalogo
     */
    protected function createFkAlmoxarifadoCatalogoNiveis(Catalogo $catalogo)
    {
        /** @var $catalogoNivel CatalogoNiveis */
        foreach ($catalogo->getFkAlmoxarifadoCatalogoNiveis() as $catalogoNivel) {
            if (null == $catalogoNivel->getCodCatalogo()) {
                $this->fkAlmoxarifadoCatalogoNiveis[] = clone $catalogoNivel;

                $catalogo->removeFkAlmoxarifadoCatalogoNiveis($catalogoNivel);
            } else {
                $this->fkAlmoxarifadoCatalogoNiveis[] = clone $catalogoNivel;

                $catalogo->removeFkAlmoxarifadoCatalogoNiveis($catalogoNivel);
            }
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('descricao', null, [
                'label' => 'label.descricao'
            ]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $fieldOptions['permiteManutencao'] = [
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr' => ['class' => 'checkbox-sonata '],
            'label' => 'label.catalogo.permiteManutencao'
        ];

        $listMapper
            ->add('codCatalogo', null, [
                'label' => 'label.codigo'
            ])
            ->add('descricao', null, [
                'label' => 'label.descricao'
            ])
            ->add('fkAlmoxarifadoCatalogoNiveis', null, [
                'label' => 'label.catalogo.mascara',
                'mapped' => false,
                'template' => 'CoreBundle:Sonata/CRUD:list_custom_join_mascara.html.twig'
            ])
            ->add(
                'permiteManutencao',
                null,
                $fieldOptions['permiteManutencao']
            )
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['permiteManutencao'] = [
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr' => ['class' => 'checkbox-sonata '],
            'label' => 'label.catalogo.permiteManutencao'
        ];

        $formMapper
            ->with('label.catalogo.dadoscatalogo')
            ->add(
                'descricao',
                null,
                array(
                    'label' => 'label.descricao'
                )
            )
            ->add(
                'permiteManutencao',
                null,
                $fieldOptions['permiteManutencao']
            )
            ->end()
            ->with('label.catalogo.dadosdonivel')
            ->add(
                'fkAlmoxarifadoCatalogoNiveis',
                'sonata_type_collection',
                array(
                    'label' => false,
                ),
                array(
                    'edit' => 'inline',
                    'inline' => 'table',
                    'sortable' => 'position',
                )
            )
            ->end();
    }

    /**
     * @param Catalogo $catalogo
     */
    public function prePersist($catalogo)
    {
        $this->createFkAlmoxarifadoCatalogoNiveis($catalogo);
    }

    /**
     * @param Catalogo $catalogo
     */
    public function postPersist($catalogo)
    {
        $em = $this->configurationPool->getContainer()->get('doctrine.orm.default_entity_manager');

        $nivel = 1;
        foreach ($this->fkAlmoxarifadoCatalogoNiveis as $catalogoNivel) {
            $catalogoNivel->setFkAlmoxarifadoCatalogo($catalogo);
            $catalogoNivel->setNivel($nivel);
            $nivel++;
            $em->persist($catalogoNivel);
        }

        $em->flush();
    }

    /**
     * @param Catalogo $catalogo
     */
    public function preUpdate($catalogo)
    {
        $this->createFkAlmoxarifadoCatalogoNiveis($catalogo);
    }

    /**
     * @param Catalogo $catalogo
     */
    public function postUpdate($catalogo)
    {
        $this->postPersist($catalogo);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $this->data['fkAlmoxarifadoCatalogoNiveis'] = $this->getSubject()->getFkAlmoxarifadoCatalogoNiveis();
        $fieldOptions['permiteManutencao'] = [
            'label_attr' => ['class' => 'checkbox-sonata '],
            'attr' => ['class' => 'checkbox-sonata '],
            'label' => 'label.catalogo.permiteManutencao'
        ];

        $showMapper
            ->add('codCatalogo', null, ['label' => 'label.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->add(
                'fkAlmoxarifadoCatalogoNiveis',
                'entity',
                [
                    'label' => 'label.catalogo.dadosdonivel',
                    'template' => 'PatrimonialBundle:Almoxarifado\Catalogo:almoxarifadoCatalogoNiveis.html.twig'
                ]
            )
            ->add('permiteManutencao', null, $fieldOptions['permiteManutencao']);
    }
}
