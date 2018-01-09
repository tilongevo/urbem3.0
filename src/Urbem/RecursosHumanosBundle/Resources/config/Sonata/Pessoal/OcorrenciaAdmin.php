<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Folhapagamento;

class OcorrenciaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_classificacao_agentes_nocivos';

    protected $baseRoutePattern = 'recursos-humanos/pessoal/classificacao-agentes-nocivos';

    protected $model = null;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
//            ->add('codOcorrencia', null, ['label' => 'label.codOcorrencia'])
            ->add('numOcorrencia', null, ['label' => 'label.numOcorrencia'])
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
//            ->add('codOcorrencia', null, ['label' => 'label.codOcorrencia'])
            ->add('numOcorrencia', null, ['label' => 'label.numOcorrencia'])
            ->add('descricao', null, ['label' => 'label.descricao'])
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

        $formMapper
            ->add('numOcorrencia', null, ['label' => 'label.numOcorrencia'])
            ->add(
                'fkFolhapagamentoRegimePrevidencia',
                'entity',
                [
                    'class' => Folhapagamento\RegimePrevidencia::class,
                    'choice_label' => 'descricao',
                    'label' => 'RegimePrevidencia',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->add('descricao', null, ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
//            ->add('codOcorrencia', null, ['label' => 'label.codOcorrencia'])
            ->add('numOcorrencia', null, ['label' => 'label.numOcorrencia'])
            ->add('codRegimePrevidencia', null, [
                'label' => 'RegimePrevidencia'
            ])
            ->add('descricao', null, ['label' => 'label.descricao'])
        ;
    }

    public function toString($object)
    {
        return $object->getDescricao();
    }
}
