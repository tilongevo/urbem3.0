<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Cargo;

use Urbem\CoreBundle\Entity\Pessoal\Regime;
use Urbem\CoreBundle\Entity\Pessoal\SubDivisao;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model;

class RegimeAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_regime';

    protected $baseRoutePattern = 'recursos-humanos/regime';

    protected $model = Model\Cargo\RegimeModel::class;

    protected $exibirBotaoIncluir = false;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codRegime', null, ['label' => 'label.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codRegime', null, ['label' => 'label.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $idRequest = $this->getAdminRequestId();
        $this->setBreadCrumb($idRequest ? ['id' => $idRequest] : []);

        $formMapper
            ->with('label.regime.dados')
            ->add('descricao', null, ['label' => 'label.descricao',])
            ->end()
            ->with('label.subdivisao.subdivisao')
            ->add(
                'fkPessoalSubDivisoes',
                'sonata_type_collection',
                [
                    'label' => false,
                ],
                [
                    'edit' => 'inline',
                    'inline' => 'table',
                    'delete' => true,
                ]
            )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->with('label.regime.dados')
                ->add('descricao', null, ['label' => 'label.descricao'])
                ->add('fkPessoalSubDivisoes', null, ['label' => 'label.subdivisao.subdivisao'])
            ->end()
        ;
    }

    /**
     * @param Regime $regime
     */
    public function prePersist($regime)
    {
        $this->saveRelationships($regime);
    }

    /**
     * @param Regime $regime
     */
    public function preUpdate($regime)
    {
        $this->saveRelationships($regime);
    }

    /**
     * @param Regime $regime
     */
    public function saveRelationships($regime)
    {
        $subDividao = $regime->getFkPessoalSubDivisoes();
        foreach($subDividao as $divisao) {
            /** @var SubDivisao $divisao */
            $divisao->setFkPessoalRegime($regime);
        }
    }
}
