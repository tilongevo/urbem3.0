<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Urbem\CoreBundle\Model\Contabilidade\PlanoContaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

class GrupoPlanoDepreciacaoAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codNatureza')
            ->add('codGrupo')
            ->add('exercicio')
            ->add('codPlano')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codNatureza')
            ->add('codGrupo')
            ->add('exercicio')
            ->add('codPlano')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $exercicio = $this->getExercicio();

        $formMapper
            ->add('fkContabilidadePlanoAnalitica', 'entity', [
                'class' => 'CoreBundle:Contabilidade\PlanoAnalitica',
                'choice_label' => 'codPlano',
                'label' => 'label.patrimonio.grupo.grupoPlanoDepreciacao.codPlano',
                'query_builder' => function ($entityManager) use ($exercicio) {
                    return $entityManager->createQueryBuilder('pa')
                        ->where('pa.codConta IS NOT NULL')
                        ->andWhere('pa.exercicio = :exercicio')
                        ->setParameter('exercicio', $exercicio);
                },
                'placeholder' => 'label.selecione',
                'attr' => [
                    'class' => 'select2-parameters'
                ],
                'data' => $this->getSubject()->getFkContabilidadePlanoAnalitica()
            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codNatureza')
            ->add('codGrupo')
            ->add('exercicio')
            ->add('codPlano')
        ;
    }
}
