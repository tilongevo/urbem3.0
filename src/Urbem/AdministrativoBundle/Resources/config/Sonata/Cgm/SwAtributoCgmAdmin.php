<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Cgm;

use Urbem\CoreBundle\Entity\SwAtributoCgm;
use Urbem\CoreBundle\Model\SwAtributoCgmModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class SwAtributoCgmAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao
 */
class SwAtributoCgmAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_atributo';
    protected $baseRoutePattern = 'administrativo/atributo';

    protected $model = SwAtributoCgmModel::class;

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nomAtributo', null, array('label' => 'Descrição'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codAtributo', null, ['label' => 'label.codigo'])
            ->add('nomAtributo', null, ['label'    => 'label.descricao']);

        $this->addActionsGrid($listMapper);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->label = 'label.dadosAtributo';

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];
        $fieldOptions['nomAtributo'] = [
            'label' => 'label.descricao'
        ];

        $fieldOptions['tipo'] = [
            'attr'     => ['class' => 'select2-parameters '],
            'choices'  => [
                'label.texto'  => 't',
                'label.numero' => 'n',
                'label.lista'  => 'l'
            ],
            'label'    => 'label.tipo',
            'required' => true
        ];

        $fieldOptions['valorPadrao'] = [
            'label'    => 'label.atributoDinamico.valorPadrao.padrao',
            'required' => false
        ];

        $formMapper
            ->add('nomAtributo', null, $fieldOptions['nomAtributo'])
            ->add('tipo', 'choice', $fieldOptions['tipo'])
            ->add('valorPadrao', null, $fieldOptions['valorPadrao']);
    }

    /**
     * @param SwAtributoCgm $swAtributoCgm
     */
    public function prePersist($swAtributoCgm)
    {
        $valorPadrao = $this->getForm()->get('valorPadrao')->getData();

        if (is_null($valorPadrao)) {
            $swAtributoCgm->setValorPadrao('');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb(['id' => $id]);

        $showMapper
            ->add('nomAtributo', null, ['label' => 'label.descricao'])
            ->add('getValorFormatado', null, ['label' => 'label.tipo'])
            ->add('valorPadrao', null, ['label' => 'label.atributoDinamico.valorPadrao.padrao'])
        ;
    }
}
