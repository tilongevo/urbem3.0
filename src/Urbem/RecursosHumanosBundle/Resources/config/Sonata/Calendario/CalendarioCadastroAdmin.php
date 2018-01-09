<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Calendario;

use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Calendario\CalendarioCadastro;
use Urbem\CoreBundle\Entity\Calendario\CalendarioDiaCompensado;
use Urbem\CoreBundle\Entity\Calendario\CalendarioFeriadoVariavel;
use Urbem\CoreBundle\Entity\Calendario\CalendarioPontoFacultativo;
use Urbem\CoreBundle\Entity\Calendario\DiaCompensado;
use Urbem\CoreBundle\Entity\Calendario\Feriado;
use Urbem\CoreBundle\Entity\Calendario\FeriadoVariavel;
use Urbem\CoreBundle\Entity\Calendario\PontoFacultativo;
use Urbem\CoreBundle\Model\Calendario\FeriadoModel;
use Urbem\CoreBundle\Repository\RecursosHumanos\Calendario\FeriadoRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Doctrine\ORM;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;

class CalendarioCadastroAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_calendario_calendario_cadastro';
    protected $baseRoutePattern = 'recursos-humanos/calendario/calendario-cadastro';

    protected $includeJs = [
        '/recursoshumanos/javascripts/calendario/calendarioFeriado.js',
    ];

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('listar_feriados', 'listar-feriados/' . $this->getRouterIdParameter());
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->setBreadCrumb();
        $datagridMapper
            ->add('descricao', null, ['label' => 'label.descricao']);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add('descricao', null, ['label' => 'label.descricao']);
        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $this->setBreadCrumb();
        $em = $this->modelManager->getEntityManager($this->getClass());

        $feriadosSelecionaveis = [];

        $date = new \Datetime();

        $feriadosCalendario = new FeriadoModel($em);
        $feriadosSet = $feriadosCalendario->getFeriadoPorAno(0, $date, FeriadoRepository::FREE_DATES);

        foreach ($feriadosSet as $feriadosFiltro) {
            $feriadosSelecionaveis[$feriadosFiltro->cod_feriado] = $feriadosFiltro->cod_feriado;
        }

        $nextExercicio = [];
        for ($addAno = 0; $addAno<=4; $addAno++) {
            $add  = $this->getExercicio() + $addAno;
            $nextExercicio[$add] = $add;
        }

        $fieldOptions['codFeriado'] = array(
                'label' => 'label.configuracaoEmpenho.eventos',
                'class' => 'CoreBundle:Calendario\Feriado',
                'choice_label' => function ($feriado) {
                    return $feriado->getDtFeriado()->format('d/m/Y') . " - " . $feriado->getDescricao();
                },
                'query_builder' => function (ORM\EntityRepository $em) use ($feriadosSelecionaveis) {
                    $queryBuilder = $em->createQueryBuilder('c');
                    
                    if (count($feriadosSelecionaveis)) {
                        $queryBuilder
                            ->where('c.codFeriado = :codFeriado')
                            ->setParameter('codFeriado', [$feriadosSelecionaveis])
                        ;
                    } else {
                        $queryBuilder
                        ->where('1 = 0');
                    }
                    
                    return $queryBuilder;
                },
                'multiple' => true,
                'mapped' => false,
                'attr' => [
                    'class' => 'select2-parameters '
                ]
            );

        if ($this->id($this->getSubject())) {
            $feriadosCalendario = new FeriadoModel($em);
            $feriadosSet = $feriadosCalendario->getFeriadoPorAno($id, null, null);

            $arrFeriadosSelecionados = [];

            $calendarioDiaCompensado =  $this->getDoctrine()
                ->getRepository('CoreBundle:Calendario\CalendarioDiaCompensado')
                ->findBy([
                    'codCalendar' => $id
                ]);

            $calendarioFeriadoVariavel =  $this->getDoctrine()
                ->getRepository('CoreBundle:Calendario\CalendarioFeriadoVariavel')
                ->findBy([
                    'codCalendar' => $id
                ]);

            $calendarioPontoFacultativo =  $this->getDoctrine()
                ->getRepository('CoreBundle:Calendario\CalendarioPontoFacultativo')
                ->findBy([
                    'codCalendar' => $id
                ]);

            foreach ($calendarioDiaCompensado as $diaCompensado) {
                $arrFeriadosSelecionados[] = $diaCompensado->getCodFeriado();
            }

            foreach ($calendarioFeriadoVariavel as $feriadoVariavel) {
                $arrFeriadosSelecionados[] = $feriadoVariavel->getCodFeriado();
            }

            foreach ($calendarioPontoFacultativo as $pontoFacultativo) {
                $arrFeriadosSelecionados[] = $pontoFacultativo->getCodFeriado();
            }

            $dadosFeriado = array_merge($feriadosSelecionaveis, $arrFeriadosSelecionados);

            $fieldOptions['codFeriado']['query_builder'] = function (ORM\EntityRepository $repository) use ($dadosFeriado) {
                $queryBuilder = $repository->createQueryBuilder('c');

                    $queryBuilder
                        ->andWhere(
                            $queryBuilder->expr()->in('c.codFeriado', $dadosFeriado)
                        )
                    ;
                    return $queryBuilder;
            };
            
            $fieldOptions['codFeriado']['choice_attr'] = function ($codFeriado, $key, $index) use ($feriadosSet) {
                foreach ($feriadosSet as $codFeriados) {
                    if ($codFeriados->cod_feriado == $codFeriado->getCodFeriado()) {
                        return ['selected' => 'selected'];
                    }
                }
                return ['selected' => false];
            };
        }

        $formMapper
            ->with('Calendário cadastro')
                ->add('descricao', null, ['label' => 'label.descricao'])
                ->add(
                    'exercicio',
                    'choice',
                    [
                        'choices' => $nextExercicio,
                        'mapped' => false,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                        'label' => 'label.exercicio',
                        'data' =>  $this->getExercicio()
                    ]
                )
                ->add(
                    'codFeriado',
                    'entity',
                    $fieldOptions['codFeriado']
                )
            ->end();
            
        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $em, $fieldOptions) {
                $form = $event->getForm();
                $data = $event->getData();
                $subject = $admin->getSubject($data);

                if ($form->has('codFeriado')) {
                    $form->remove('codFeriado');
                }

                if (isset($data['exercicio']) && $data['exercicio'] != "") {
                    $fieldOptions['codFeriado']['auto_initialize'] = false;
                    $fieldOptions['codFeriado']['query_builder'] = function (ORM\EntityRepository $em) use ($fieldOptions) {
                        $queryBuilder = $em->createQueryBuilder('c');
                        $queryBuilder->select('c, substring(c.dtFeriado, 0, 4) as HIDDEN ano');
                        $queryBuilder
                            ->where('ano = '.$this->getExercicio());
                    };

                    $codFeriado = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'codFeriado',
                        'entity',
                        null,
                        $fieldOptions['codFeriado']
                    );

                    $form->add($codFeriado);
                }
            }
        );
    }

    /**
     * @param CalendarioCadastro $object
     */
    public function postPersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $feriados = [];

        foreach ($formData['codFeriado'] as $codFeriado) {
            $feriados[$codFeriado] = $codFeriado;
        }

        $codFeriadoObj = $em->getRepository('CoreBundle:Calendario\Feriado')->findByCodFeriado($feriados);

        foreach ($codFeriadoObj as $feriadoItem) {
            $this->setFeriados($object, $feriadoItem, $em);
        }
        $em->flush();
    }

    /**
     * @param CalendarioCadastro $object
     */
    public function preUpdate($object)
    {
        $em = $this->getDoctrine();
        $id = $this->getSubject()->getCodCalendar();

        $getFeriadosCalendario = new FeriadoModel($em);
        $feriadosDoCalendario = $getFeriadosCalendario->getFeriadoPorAno($id, null, null);

        foreach ($feriadosDoCalendario as $dataFeriados) {
            switch ($dataFeriados->tipoferiado) {
                case 'F':
                    $calendarioItem = 'CalendarioFeriadoVariavel';
                    $item = 'FeriadoVariavel';
                    break;
                case 'P':
                    $calendarioItem = 'CalendarioPontoFacultativo';
                    $item = 'PontoFacultativo';
                    break;
                case 'V':
                    $calendarioItem = 'CalendarioFeriadoVariavel';
                    $item = 'FeriadoVariavel';
                    break;
                case 'D':
                    $calendarioItem = 'CalendarioDiaCompensado';
                    $item = 'DiaCompensado';
                    break;
            }
            $this->removeFeriados($object, $calendarioItem, $item, $em);
        }
        $em->flush();
    }

    /**
     *
     * @param $object
     * @param $calendarioItem
     * @param $item
     * @param $em
     * @return bool
     *
     */
    private function removeFeriados($object, $calendarioItem, $item, $em)
    {
        $exec = false;

        $deleteItem = $em->getRepository("CoreBundle:Calendario\\{$calendarioItem}")->findByCodCalendar($object->getCodCalendar());

        foreach ($deleteItem as $codFeriado) {
            $itemBanco = $em->getRepository("CoreBundle:Calendario\\{$item}")->findOneByCodFeriado($codFeriado->getCodFeriado());

            if ($itemBanco !== null) {
                try {
                    $em->remove($itemBanco);
                    $exec =  true;
                } catch (\Exception $e) {
                }
            }
        }
        return $exec;
    }

    /**
     * @param CalendarioCadastro $object
     */
    public function postUpdate($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $em = $this->getDoctrine();

        foreach ($formData['codFeriado'] as $codFeriado) {
            $feriados[$codFeriado] = $codFeriado;
        }

        $codFeriadoObj = $em->getRepository('CoreBundle:Calendario\Feriado')->findByCodFeriado($feriados);

        foreach ($codFeriadoObj as $feriadoItem) {
            switch ($feriadoItem->getTipoFeriado()) {
                case 'F':
                    $setFeriado = $em->getRepository(FeriadoVariavel::class)->find($feriadoItem->getCodFeriado());
                    if ($setFeriado === null) {
                        $this->setFeriados($object, $feriadoItem, $em);
                    }
                    break;

                case 'P':
                    $setFeriadoPontoFacultativo = $em->getRepository(PontoFacultativo::class)->find($feriadoItem->getCodFeriado());
                    if ($setFeriadoPontoFacultativo === null) {
                        $this->setFeriados($object, $feriadoItem, $em);
                    }
                    break;

                case 'D':
                    $setFeriado = $em->getRepository(DiaCompensado::class)->find($feriadoItem->getCodFeriado());
                    if ($setFeriado === null) {
                        $this->setFeriados($object, $feriadoItem, $em);
                    }
                    break;

                case 'V':
                    $setFeriado = $em->getRepository(FeriadoVariavel::class)->find($feriadoItem->getCodFeriado());
                    if ($setFeriado === null) {
                        $this->setFeriados($object, $feriadoItem, $em);
                    }
                    break;
            }
        }
        $em->flush();
    }

    /**
     * @param $object
     * @param $feriadoItem
     * @param $em
     */
    private function setFeriados($object, $feriadoItem, $em)
    {

        switch ($feriadoItem->getTipoFeriado()) {
            case 'F':
                $setFeriado = (new FeriadoVariavel())
                    ->setFkCalendarioFeriado($feriadoItem);
                $em->persist($setFeriado);

                $calendarioFeriadoVariavel = (new CalendarioFeriadoVariavel())
                    ->setFkCalendarioCalendarioCadastro($object)
                    ->setFkCalendarioFeriadoVariavel($setFeriado);

                $em->persist($calendarioFeriadoVariavel);
                break;

            case 'V':
                $setFeriado = (new FeriadoVariavel())
                    ->setFkCalendarioFeriado($feriadoItem);
                $em->persist($setFeriado);

                $calendarioFeriadoVariavel = (new CalendarioFeriadoVariavel())
                    ->setFkCalendarioCalendarioCadastro($object)
                    ->setFkCalendarioFeriadoVariavel($setFeriado);

                $em->persist($calendarioFeriadoVariavel);
                break;

            case 'D':
                $setFeriado = (new DiaCompensado())
                    ->setFkCalendarioFeriado($feriadoItem);
                $em->persist($setFeriado);

                $calendarioFeriadoVariavel = (new CalendarioDiaCompensado())
                    ->setFkCalendarioCalendarioCadastro($object)
                    ->setFkCalendarioDiaCompensado($setFeriado);

                $em->persist($calendarioFeriadoVariavel);
                break;

            case 'P':
                $setFeriadoPontoFacultativo = (new PontoFacultativo())
                    ->setFkCalendarioFeriado($feriadoItem);
                $em->persist($setFeriadoPontoFacultativo);

                $calendarioPontoFacultativo = (new CalendarioPontoFacultativo())
                    ->setFkCalendarioCalendarioCadastro($object)
                    ->setFkCalendarioPontoFacultativo($setFeriadoPontoFacultativo);
                $em->persist($calendarioPontoFacultativo);
                break;
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $this->setBreadCrumb();
        $showMapper
            ->add(
                'descricao',
                null,
                [
                'label' =>
                    'label.descricao',
                ]
            );
    }

    public function preRemove($object)
    {
        $em = $this->getDoctrine();

        if (!$object->getFkCalendarioCalendarioDiaCompensados()->isEmpty()) {
            foreach ($object->getFkCalendarioCalendarioDiaCompensados() as $calendarioDiaCompensado) {
                $em->remove($calendarioDiaCompensado->getFkCalendarioDiaCompensado());
            }
        }

        if (!$object->getFkCalendarioCalendarioFeriadoVariaveis()->isEmpty()) {
            foreach ($object->getFkCalendarioCalendarioFeriadoVariaveis() as $feriadoVariavel) {
                $em->remove($feriadoVariavel->getFkCalendarioFeriadoVariavel());
            }
        }

        if (!$object->getFkCalendarioCalendarioPontoFacultativos()->isEmpty()) {
            foreach ($object->getFkCalendarioCalendarioPontoFacultativos() as $pontoFacultativo) {
                $em->remove($pontoFacultativo->getFkCalendarioPontoFacultativo());
            }
        }
        $em->flush();
    }
}
