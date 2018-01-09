<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\FaixaPagamentoSalarioFamilia;
use Urbem\CoreBundle\Entity\Folhapagamento\RegimePrevidencia;
use Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamilia;
use Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamiliaEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\TipoEventoSalarioFamilia;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaPagamentoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model;

class SalarioFamiliaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_salario_familia';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/salario-familia';

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'vigencia',
                null,
                [
                    'label' => 'label.dtVigencia',
                ]
            )
            ->add(
                'fkFolhapagamentoRegimePrevidencia',
                null,
                [
                    'label' => 'RegimePrevidencia',
                ]
            )
            ->add(
                'idadeLimite',
                null,
                [
                    'label' => 'label.idadeLimite'
                ]
            )
            ->add('_action',
                'actions',
                [
                    'actions' => [
                        'edit' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'],
                        'delete' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'],
                    ]
                ]
            )
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(array('timestamp'));
        $datagridMapper
            ->add(
                'vigencia',
                null,
                [
                    'label' => 'label.dtVigencia',
                ]
            )
            ->add(
                'fkFolhapagamentoRegimePrevidencia',
                null,
                [
                    'label' => 'RegimePrevidencia'
                ]
            )
            ->add(
                'idadeLimite',
                null,
                [
                    'label' => 'label.idadeLimite'
                ]
            )
        ;
    }

    /**
     * @param FormMapper $formMapper
     * @return void|\Symfony\Component\HttpFoundation\Response
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->getDoctrine();
        $eventos = (new FolhaPagamentoModel())->getAllTipoEventoSalarioFamilia($em);
        $eventoModel = new Model\Folhapagamento\EventoModel($em);

        if (count(
            $em->getRepository(SalarioFamilia::class)
                ->createQueryBuilder('sf')
                ->select('sf.codRegimePrevidencia')
                ->groupBy('sf.codRegimePrevidencia')
                ->getQuery()
                ->getResult()) >=
            count($em->getRepository(RegimePrevidencia::class)
                ->findAll()))
        {
            $this->getDoctrine()
                ->clear();

            $this->getFlashBag()
                ->add(
                    'error',
                    $this->trans('errors.rh.folhapagamento.salarioFamiliaRegimeCompleto')
                );
            return $this->redirectByRoute($this->baseRouteName . '_list');
        }

        /** @var SalarioFamilia $salarioFamilia */
        $salarioFamilia = $this->getSubject();

        // Recupera os registros da tabela SalarioFamiliaEvento
        $salarioFamiliaEventoCadastrado = [];

        $salarioFamiliaEventos = $salarioFamilia
            ? $salarioFamilia->getFkFolhapagamentoSalarioFamiliaEventos()
            : [];

        if (count($salarioFamiliaEventos)) {
            foreach ($salarioFamiliaEventos as $salarioFamiliaEvento) {
                $salarioFamiliaEventoCadastrado[$salarioFamiliaEvento->getCodTipo()]
                    = $salarioFamiliaEvento->getCodEvento();
            }
        }

        $formMapper
            ->with('label.salarioFamilia.dadosSalarioFamilia')
                ->add(
                    'fkFolhapagamentoRegimePrevidencia',
                    'entity',
                    array(
                        'class' => RegimePrevidencia::class,
                        'choice_label' => 'descricao',
                        'label' => 'label.salarioFamilia.regimePrevidenciario',
                        'attr' => [
                            'class' => 'select2-parameters '
                        ]
                    )
                );

        foreach ($eventos as $evento) {
            $codTipo = $evento->getCodTipo();
            $natureza = $codTipo == 1 ? "P" : "B";

            $data = array_key_exists($codTipo, $salarioFamiliaEventoCadastrado)
                ? $salarioFamiliaEventoCadastrado[$codTipo]
                : null;

            $formMapper->add(
                'codTipo' . $evento->getCodTipo(),
                'entity',
                [
                    'label' => $evento->getDescricao(),
                    'class' => Evento::class,
                    'choice_label' => 'descricao',
                    'query_builder' => $eventoModel->getEventoPorNatureza($natureza),
                    'mapped' => false,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'data' => $data
                ]
            );
        }

        $formMapper->add(
            'vigencia',
            'sonata_type_date_picker',
            [
                'dp_default_date' =>  (new \DateTime())->format('d/m/Y'),
                'format' => 'dd/MM/yyyy',
                'label' => 'label.vigencia'
            ]
        )
        ->add(
            'idadeLimite',
            'integer',
            [
                'label' => 'label.salarioFamilia.idadeLimite',
            ]
        )
        ->end()
        ->with('label.salarioFamilia.dadosFaixa')
        ->add(
            'fkFolhapagamentoFaixaPagamentoSalarioFamilias',
            'sonata_type_collection',
            [
            'label' => false
            ],
            [
                'edit' => 'inline',
                'inline' => 'table',
                'delete' => true,
                'required' => true,
            ]
        )
        ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->with('label.salarioFamilia.salarioFamilia')
                ->add(
                    'vigencia',
                    null,
                    [
                        'label' => 'label.dtVigencia',
                    ]
                )
                ->add(
                    'fkFolhapagamentoRegimePrevidencia',
                    null,
                    [
                        'label' => 'RegimePrevidencia',
                    ]
                )
                ->add(
                    'idadeLimite',
                    null,
                    [
                        'label' => 'label.idadeLimite',
                    ]
                )
            ->end()
        ;
    }

    /**
     * @param SalarioFamilia $salarioFamilia
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function prePersist($salarioFamilia)
    {
        $this->saveRelationships($salarioFamilia);
    }

    /**
     * @param SalarioFamilia $salarioFamilia
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function saveRelationships($salarioFamilia)
    {
        if (!!$this->getDoctrine()
            ->getRepository(SalarioFamilia::class)
            ->findBy(['codRegimePrevidencia' => $salarioFamilia->getCodRegimePrevidencia()])
        ) {
            $this->getDoctrine()
                ->clear();

            $this->getFlashBag()
                ->add(
                    'error',
                    $this->trans('errors.rh.folhapagamento.salarioFamiliaRegimeDuplicado')
                );
            return $this->redirectByRoute($this->baseRouteName . '_list');
        }

        $em = $this->getDoctrine();
        $faixas = $salarioFamilia->getFkFolhapagamentoFaixaPagamentoSalarioFamilias();
        $codFaixa = $em
            ->getRepository(FaixaPagamentoSalarioFamilia::class)
            ->getNextCodFaixa();

        if (!count($faixas)) {
            $this->getFlashBag()->add('error', $this->trans('errors.rh.folhapagamento.concessao'));
            return $this->redirectByRoute($this->baseRouteName . '_create');
        }

        foreach ($faixas as $faixa) {
            /** @var FaixaPagamentoSalarioFamilia $faixa */
            if (is_null($faixa->getCodFaixa())) {
                $faixa
                    ->setFkFolhapagamentoSalarioFamilia($salarioFamilia)
                    ->setCodFaixa($codFaixa)
                ;
                $codFaixa++;
            }
        }

        $eventos = (new FolhaPagamentoModel())->getAllTipoEventoSalarioFamilia($em);
        $salarioFamilia->getFkFolhapagamentoSalarioFamiliaEventos();

        foreach ($eventos as $tipoEvento) {
            $campo = 'codTipo' . $tipoEvento->getCodTipo();
            $evento = $this->getForm()->get($campo)->getData();

            $salarioFamiliaEvento = $this->hasEventRegistered($tipoEvento);

            if (false === $salarioFamiliaEvento) {
                $salarioFamiliaEvento = new SalarioFamiliaEvento();
            }

            $salarioFamiliaEvento
                ->setFkFolhapagamentoSalarioFamilia($salarioFamilia)
                ->setFkFolhapagamentoTipoEventoSalarioFamilia($tipoEvento)
                ->setFkFolhapagamentoEvento($evento)
            ;

            $em->persist($salarioFamiliaEvento);

            $salarioFamilia->addFkFolhapagamentoSalarioFamiliaEventos($salarioFamiliaEvento);
            $em->persist($salarioFamilia);

            $em->flush();
        }
    }

    /**
     * @param TipoEventoSalarioFamilia $tipoEventoSalarioFamilia
     * @return bool|mixed|SalarioFamiliaEvento
     */
    private function hasEventRegistered(TipoEventoSalarioFamilia $tipoEventoSalarioFamilia)
    {
        /** @var SalarioFamilia $salarioFamilia */
        $salarioFamilia = $this->getSubject();
        foreach ($salarioFamilia->getFkFolhapagamentoSalarioFamiliaEventos() as $evento) {
            /** @var SalarioFamiliaEvento $evento */
            if ($evento->getFkFolhapagamentoTipoEventoSalarioFamilia()->getCodTipo()
                == $tipoEventoSalarioFamilia->getCodTipo()) {
                return $evento;
            }
        }
        return false;
    }

    /**
     * @param SalarioFamilia $salarioFamilia
     */
    public function preUpdate($salarioFamilia)
    {
        $em = $this->getDoctrine();

        $salarioFamiliaEventos = $salarioFamilia->getFkFolhapagamentoSalarioFamiliaEventos();

        foreach ($salarioFamiliaEventos as $salarioFamiliaEvento) {
            $em->remove($salarioFamiliaEvento);
        }

        $this->saveRelationships($salarioFamilia);
        $em->flush();
    }

    /**
     * @param mixed $object
     */
    public function postUpdate($object)
    {
        $this->postPersist($object);
    }

    /**
     * @param SalarioFamilia $salarioFamilia
     * @return void
     */
    public function preRemove($salarioFamilia)
    {
        $em = $this->getDoctrine();

        $salarioFamiliaEventos = $salarioFamilia->getFkFolhapagamentoSalarioFamiliaEventos();

        foreach ($salarioFamiliaEventos as $salarioFamiliaEvento) {
            $em->remove($salarioFamiliaEvento);
        }

        $faixas = $salarioFamilia->getFkFolhapagamentoFaixaPagamentoSalarioFamilias();
        foreach ($faixas as $faixa) {
            $em->remove($faixa);
        }
        $em->flush();
    }
}
