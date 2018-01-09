<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Urbem\CoreBundle\Model\Contabilidade;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class GrupoPlanoAnaliticaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_patrimonio_grupo_plano_analitica';

    protected $baseRoutePattern = 'patrimonial/patrimonio/grupo-plano-analitica';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codGrupoPlano')
            ->add('exercicio')
            ->add('codPlano')
            ->add('codPlanoDoacao')
            ->add('codPlanoPerdaInvoluntaria')
            ->add('codPlanoTransferencia');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codGrupoPlano')
            ->add('exercicio')
            ->add('codPlano')
            ->add('codPlanoDoacao')
            ->add('codPlanoPerdaInvoluntaria')
            ->add('codPlanoTransferencia');

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        /**
         * @TODO Adicionar mascara e date('Y')
         */
        $planoAnaliticaQueryBuilder = function ($entityManager) {
            return $entityManager->createQueryBuilder('pa')
                ->where('pa.codConta IS NOT NULL')
                ->andWhere('pa.exercicio = :exercicio')
                ->setParameter('exercicio', $this->getExercicio());
        };

        $formMapper
            ->add('fkContabilidadePlanoAnalitica', 'entity', [
                'class' => 'CoreBundle:Contabilidade\PlanoAnalitica',
                'choice_label' => 'codPlano',
                'label' => 'Plano de Conta',
                'query_builder' => $planoAnaliticaQueryBuilder,
                'placeholder' => 'label.selecione',
                'attr' => [
                    'class' => 'select2-parameters'
                ],
                'data' => $this->getSubject()->getFkContabilidadePlanoAnalitica()
            ])
            ->add('fkContabilidadePlanoAnalitica1', 'entity', [
                'class' => 'CoreBundle:Contabilidade\PlanoAnalitica',
                'choice_label' => 'codPlano',
                'label' => 'label.patrimonial.grupo.codPlanoDoacao',
                'query_builder' => $planoAnaliticaQueryBuilder,
                'placeholder' => 'label.selecione',
                'attr' => [
                    'class' => 'select2-parameters'
                ],
                'data' => $this->getSubject()->getFkContabilidadePlanoAnalitica1()
            ])
            ->add('fkContabilidadePlanoAnalitica2', 'entity', [
                'class' => 'CoreBundle:Contabilidade\PlanoAnalitica',
                'choice_label' => 'codPlano',
                'label' => 'label.patrimonial.grupo.codPlanoPerdaInvoluntaria',
                'query_builder' => $planoAnaliticaQueryBuilder,
                'placeholder' => 'label.selecione',
                'attr' => [
                    'class' => 'select2-parameters'
                ],
                'data' => $this->getSubject()->getFkContabilidadePlanoAnalitica2()
            ])
            ->add('fkContabilidadePlanoAnalitica3', 'entity', [
                'class' => 'CoreBundle:Contabilidade\PlanoAnalitica',
                'choice_label' => 'codPlano',
                'label' => 'label.patrimonial.grupo.codPlanoTransferencia',
                'query_builder' => $planoAnaliticaQueryBuilder,
                'placeholder' => 'label.selecione',
                'attr' => [
                    'class' => 'select2-parameters'
                ],
                'data' => $this->getSubject()->getFkContabilidadePlanoAnalitica3()
            ])
            ->add('fkContabilidadePlanoAnalitica4', 'entity', [
                'class' => 'CoreBundle:Contabilidade\PlanoAnalitica',
                'choice_label' => 'codPlano',
                'label' => 'label.patrimonial.grupo.codPlanoAlienacaoGanho',
                'query_builder' => $planoAnaliticaQueryBuilder,
                'placeholder' => 'label.selecione',
                'attr' => [
                    'class' => 'select2-parameters'
                ],
                'data' => $this->getSubject()->getFkContabilidadePlanoAnalitica4()
            ])
            ->add('fkContabilidadePlanoAnalitica5', 'entity', [
                'class' => 'CoreBundle:Contabilidade\PlanoAnalitica',
                'choice_label' => 'codPlano',
                'label' => 'label.patrimonial.grupo.codPlanoAlienacaoPerda',
                'query_builder' => $planoAnaliticaQueryBuilder,
                'placeholder' => 'label.selecione',
                'attr' => [
                    'class' => 'select2-parameters'
                ],
                'data' => $this->getSubject()->getFkContabilidadePlanoAnalitica5()
            ]);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codGrupoPlano')
            ->add('codGrupo')
            ->add('exercicio')
            ->add('codPlano')
            ->add('codPlanoDoacao')
            ->add('codPlanoPerdaInvoluntaria')
            ->add('codPlanoTransferencia');
    }
}
