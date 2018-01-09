<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Urbem\CoreBundle\Entity\Pessoal\FaixaTurno;
use Urbem\CoreBundle\Entity\Pessoal\GradeHorario;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Model;

class GradeHorarioAdmin extends AbstractSonataAdmin
{
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'codGrade',
    ];

    /** @var string */
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_grade_horario';
    /** @var string */
    protected $baseRoutePattern = 'recursos-humanos/pessoal/grade-horario';
    /** @var Model\Pessoal\GradeHorarioModel */
    protected $model = Model\Pessoal\GradeHorarioModel::class;
    /** @var array */
    protected $includeJs = [
        '/recursoshumanos/javascripts/pessoal/grade-horario.js'
    ];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'descricao',
                null,
                [
                    'label' => 'Descrição'
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
            ->add(
                'descricao',
                null,
                [
                    'label' => 'Descrição'
                ]
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

        $fieldOptions = [];

        $fieldOptions['descricao'] = [
            'label' => 'label.descricao'
        ];

        $fieldOptions['fkPessoalFaixaTurnos'] = [
            'by_reference' => false,
            'label' => false,
            'type_options' => [
                'delete' => false,
                'delete_options' => [
                    'type' => 'hidden'
                ],
            ],
        ];

        if ($this->id($this->getSubject())) {
            if ($this->getSubject()->getFkPessoalFaixaTurnos()->count() >= 7) {
                $fieldOptions['fkPessoalFaixaTurnos']['btn_add'] = false;
            }
        }

        $formMapper
            ->with('label.gradeHorario.dadosDaGrade')
                ->add(
                    'descricao',
                    null,
                    $fieldOptions['descricao']
                )
            ->end()
            ->with('label.gradeHorario.turno')
                ->add(
                    'fkPessoalFaixaTurnos',
                    'sonata_type_collection',
                    $fieldOptions['fkPessoalFaixaTurnos'],
                    [
                        'edit' => 'inline',
                        'inline' => 'table',
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
            ->with('label.gradeHorario.dadosDaGrade')
                ->add(
                    'descricao',
                    null,
                    [
                        'label' => 'label.descricao'
                    ]
                )
                ->add(
                    'fkPessoalFaixaTurnos',
                    'customField',
                    [
                        'label' => false,
                        'template' => 'RecursosHumanosBundle::Sonata/Pessoal/GradeHorario/fkPessoalFaixaTurnos.html.twig',
                        'data' => []
                    ]
                )
            ->end()
        ;
    }

    /**
     * @param GradeHorario $gradeHorario
     */
    public function prePersist($gradeHorario)
    {
        $em = $this->getDoctrine();
        $gradeHorario->setCodGrade(
            $em->getRepository(GradeHorario::class)->getNextCodGrade()
        );

        $codTurno = $em->getRepository(FaixaTurno::class)->getNextCodTurno();

        foreach ($gradeHorario->getFkPessoalFaixaTurnos() as $turno) {
            /** @var FaixaTurno $turno */
            $turno->setFkPessoalGradeHorario($gradeHorario)
                ->setCodTurno($codTurno)
            ;
            $codTurno++;
        }
    }

    public function preUpdate($gradeHorario)
    {
        $em = $this->getDoctrine();

        $codTurno = $em->getRepository(FaixaTurno::class)->getNextCodTurno();

        foreach ($gradeHorario->getFkPessoalFaixaTurnos() as $turno) {
            /** @var FaixaTurno $turno */
            $turno->setFkPessoalGradeHorario($gradeHorario)
                ->setCodTurno($codTurno)
            ;
            $codTurno++;
        }
    }
}
