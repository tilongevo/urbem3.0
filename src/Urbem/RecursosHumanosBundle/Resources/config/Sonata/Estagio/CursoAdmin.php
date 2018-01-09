<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Estagio;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Estagio;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class CursoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_estagio_curso';

    protected $baseRoutePattern = 'recursos-humanos/estagio/curso';

    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'codCurso'
    ];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nomCurso', null, ['label' => 'label.nomeCurso'])
            //->add('fkEstagioGrau.descricao', null, ['label' => 'label.estagio.grauInstrucao'])
            ->add(
                'fkEstagioGrau',
                null,
                ['label' => 'label.estagio.grauInstrucao'],
                'entity',
                [
                    'class' => 'CoreBundle:Estagio\Grau',
                    'choice_label' => 'descricao',
                    'query_builder' => function ($em) {
                        $qb = $em->createQueryBuilder('m');
                        $qb->orderBy('m.descricao', 'ASC');
                        return $qb;
                    }
                ]
            )
            //->add('fkEstagioAreaConhecimento.descricao', null, ['label' => 'label.estagio.areaConhecimento'])
            ->add(
                'fkEstagioAreaConhecimento',
                null,
                ['label' => 'label.estagio.areaConhecimento'],
                'entity',
                [
                    'class' => 'CoreBundle:Estagio\AreaConhecimento',
                    'choice_label' => 'descricao',
                    'query_builder' => function ($em) {
                        $qb = $em->createQueryBuilder('m');
                        $qb->orderBy('m.descricao', 'ASC');
                        return $qb;
                    }
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('nomCurso', null, ['label' => 'label.nomeCurso', 'sortable' => false])
            ->add('fkEstagioGrau.descricao', null, ['label' => 'label.estagio.grauInstrucao'])
            ->add('fkEstagioAreaConhecimento.descricao', null, ['label' => 'label.estagio.areaConhecimento'])

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
            ->add('nomCurso', null, ['label' => 'label.nomeCurso'])
            ->add('fkEstagioAreaConhecimento', 'entity', [

                'class' => Estagio\AreaConhecimento::class,
                'choice_label' => function ($codAreaConhecimento) {
                    return $codAreaConhecimento->getDescricao();
                },
                'label' => 'label.estagio.areaConhecimento',
                'attr' => [
                    'class' => 'select2-parameters '
                ],
                'placeholder' => 'label.selecione'
            ])
            ->add('fkEstagioGrau', 'entity', [
                'class' => Estagio\Grau::class,
                'choice_label' => function ($codGrau) {
                    return $codGrau->getDescricao();
                },
                   'label' => 'label.estagio.grauInstrucao',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'placeholder' => 'label.selecione'
            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('nomCurso', null, ['label' => 'label.nomeCurso'])
            ->add('fkEstagioGrau', "text", ['label' => 'label.estagio.grauInstrucao'])
            ->add('fkEstagioAreaConhecimento', "text", ['label' => 'label.estagio.areaConhecimento'])
        ;
    }
}
