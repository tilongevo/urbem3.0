<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Organograma;

use Urbem\CoreBundle\Entity\Organograma\Local;
use Urbem\CoreBundle\Helper\StringHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class LocalAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Organograma
 */
class LocalAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_organograma_local';
    protected $baseRoutePattern = 'administrativo/organograma/local';

    protected $includeJs = [
        '/administrativo/javascripts/organograma/local.js'
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('descricao', null, ['label' => 'label.organigramaLocal.descricao']);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper->add('descricao', null, ['label' => 'label.organigramaLocal.descricao']);

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $this->label = 'label.organigramaLocal.dados_local';

        $fieldOptions = [];
        $fieldOptions['descricao'] = [
            'label' => 'label.organigramaLocal.descricao'
        ];

        $fieldOptions['fkSwLogradouro'] = [
            'attr'                => ['class' => 'select2-parameters '],
            'container_css_class' => 'select2-v4-parameters ',
            'data_class'          => null,
            'label'               => 'label.logradouro',
            'property'            => 'fkSwNomeLogradouros.nomLogradouro',
        ];

        $fieldOptions['numero'] = [
            'label'    => 'label.organigramaLocal.numero',
            'required' => false
        ];

        $fieldOptions['fone'] = [
            'attr'     => ['maxlength' => 14],
            'label'    => 'label.organigramaLocal.fone',
            'required' => false
        ];

        $fieldOptions['ramal'] = [
            'label'    => 'label.organigramaLocal.ramal',
            'required' => false
        ];

        $fieldOptions['dificilAcesso'] = [
            'label' => 'label.organigramaLocal.dificilAcesso'
        ];

        $fieldOptions['insalubre'] = [
            'label' => 'label.organigramaLocal.insalubre'
        ];

        $formMapper
            ->add('descricao', null, $fieldOptions['descricao'])
            ->add('fkSwLogradouro', 'sonata_type_model_autocomplete', $fieldOptions['fkSwLogradouro'])
            ->add('numero', 'number', $fieldOptions['numero'])
            ->add('fone', null, $fieldOptions['fone'])
            ->add('ramal', null, $fieldOptions['ramal'])
            ->add('dificilAcesso', null, $fieldOptions['dificilAcesso'])
            ->add('insalubre', null, $fieldOptions['insalubre']);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add('descricao', null, ['label' => 'label.organigramaLocal.descricao'])
            ->add('fkSwLogradouro', 'text', ['label' => 'label.logradouro'])
            ->add('numero', null, ['label' => 'label.organigramaLocal.numero'])
            ->add('fone', null, ['label' => 'label.organigramaLocal.fone'])
            ->add('ramal', null, ['label' => 'label.organigramaLocal.ramal'])
            ->add('dificilAcesso', null, ['label' => 'label.organigramaLocal.dificilAcesso'])
            ->add('insalubre', null, ['label' => 'label.organigramaLocal.insalubre']);
    }

    /**
     * @param Local $local
     */
    public function prePersist($local)
    {
        $fone = $local->getFone();
        $local->setFone(StringHelper::removeAllSpace(StringHelper::clearString($fone)));
    }

    /**
     * @param Local $local
     */
    public function preUpdate($local)
    {
        $fone = $local->getFone();
        $local->setFone(StringHelper::removeAllSpace(StringHelper::clearString($fone)));
    }
}
