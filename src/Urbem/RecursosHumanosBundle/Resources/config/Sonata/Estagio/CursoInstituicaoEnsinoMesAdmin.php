<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Estagio;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Estagio;
use Urbem\CoreBundle\Entity\Administracao;

class CursoInstituicaoEnsinoMesAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_estagio_curso_instituicao_ensino_mes';

    protected $baseRoutePattern = 'recursos-humanos/estagio/curso-instituicao-ensino-mes';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numcgm', null, [
                'label' => 'label.estagio.instituicao_ensino'
            ], 'entity', [
                'class' => Entity\SwCgmPessoaJuridica::class,
                'choice_label' => function ($numcgm) {
                    return $numcgm->getNumcgm()->getNomCgm();
                }
            ])
            ->add('codCurso', null, [
                'label' => 'label.estagio.curso'
            ], 'entity', [
                'class' => Estagio\Curso::class,
                'query_builder' => function ($curso) {
                    return $curso->createQueryBuilder('c')
                        ->leftJoin('c.codGrau', 'cg')
                        ->orderBy('cg.descricao, c.nomCurso', 'ASC');
                },
                'choice_label' => function ($codCurso) {
                    return $codCurso->getCodGrau()->getDescricao() . ' - ' . $codCurso->getNomCurso();
                }
            ])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('id')
            ->add('numcgm', null, array(
                'label' => 'label.estagio.instituicao_ensino',
                'associated_property' => function ($numcgm) {
                    return $numcgm->getNumcgm()->getNomCgm();
                }
            ))
            ->add('codCurso', null, array(
                'label' => 'label.estagio.curso',
                'associated_property' => function ($codCurso) {
                    return $codCurso->getCodGrau()->getDescricao() . ' - ' . $codCurso->getNomCurso();
                }
            ))
            ->add('codMes', null, array(
                'label' => 'label.periodoAvaliacao',
                'associated_property' => function ($codMes) {
                    return $codMes->getDescricao();
                }
            ))
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
            ->add('numcgm', 'entity', [
                'class' => Entity\SwCgmPessoaJuridica::class,
                'choice_label' => function ($numcgm) {
                    return $numcgm->getNumcgm()->getNomCgm();
                },
                'label' => 'label.estagio.instituicao_ensino'
            ])
            ->add('codCurso', 'entity', array(
                'class' => Estagio\Curso::class,
                'query_builder' => function ($curso) {
                    return $curso->createQueryBuilder('c')
                        ->leftJoin('c.codGrau', 'cg')
                        ->orderBy('cg.descricao, c.nomCurso', 'ASC');
                },
                'choice_label' => function ($codCurso) {
                    return $codCurso->getCodGrau()->getDescricao() . ' - ' . $codCurso->getNomCurso();
                },
                'label' => 'label.estagio.curso'
            ))
            ->add('codMes', 'entity', array(
                'class' => Administracao\Mes::class,
                'choice_label' => function ($codMes) {
                    return $codMes->getDescricao();
                },
                'label' => 'label.periodoAvaliacao',
                'mapped' => false
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('id')
            ->add('numcgm', null, array(
                'label' => 'label.estagio.instituicao_ensino',
                'associated_property' => function ($numcgm) {
                    return $numcgm->getNumcgm()->getNomCgm();
                }
            ))
            ->add('codCurso', null, array(
                'label' => 'label.estagio.curso',
                'associated_property' => function ($codCurso) {
                    return $codCurso->getCodGrau()->getDescricao() . ' - ' . $codCurso->getNomCurso();
                }
            ))
            ->add('codMes', null, array(
                'label' => 'label.periodoAvaliacao',
                'associated_property' => function ($codMes) {
                    return $codMes->getDescricao();
                }
            ))
        ;
    }
}
