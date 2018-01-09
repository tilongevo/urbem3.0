<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\Fgts;
use Urbem\CoreBundle\Entity\Folhapagamento\FgtsCategoria;
use Urbem\CoreBundle\Entity\Folhapagamento\FgtsEvento;
use Urbem\CoreBundle\Model\Folhapagamento\FgtsCategoriaModel;
use Urbem\CoreBundle\Model\Folhapagamento\FgtsEventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\FgtsModel;
use Urbem\CoreBundle\Model\Folhapagamento\TipoEventoFgtsModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class FgtsAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_fgts';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/fgts';


    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoExcluir = false;

    /**
     * @param ErrorElement $errorElement
     * @param Fgts $fgts
     */
    public function validate(ErrorElement $errorElement, $fgts)
    {

        $arrayCategorias = [];
        $categoriasDuplicadas = [];
        /** @var FgtsCategoria $fgtsCategoria */
        foreach ($fgts->getFkFolhapagamentoFgtsCategorias() as $fgtsCategoria) {
            $arrayCategorias[] = $fgtsCategoria->getFkPessoalCategoria()->getCodCategoria() .
                ' - ' . $fgtsCategoria->getFkPessoalCategoria()->getDescricao();
        }
        $categoriasDuplicadas = array_unique(array_diff_assoc($arrayCategorias, array_unique($arrayCategorias)));

        if (!empty($categoriasDuplicadas)) {
            $message = $this->trans('rh.fgts.errors.categoriaSefipDuplicado', ['%categoria%' => implode(", ", $categoriasDuplicadas)], 'validators');
            $errorElement->addViolation($message)->end();
        }
    }

    /**
     * @param Fgts $fgts
     */
    public function prePersist($fgts)
    {
        $this->checkSelectedDeleteInListCollecion(
            $fgts,
            'fkFolhapagamentoFgtsCategorias',
            'setFkFolhapagamentoFgts'
        );

        $em = $this->modelManager->getEntityManager($this->getClass());
        $fgtsModel = new FgtsModel($em);
        $codFgts = $fgtsModel->getNextCodFgts();
        $fgts->setCodFgts($codFgts);

        /** @var FgtsCategoria $fgtsCategoria */
        foreach ($fgts->getFkFolhapagamentoFgtsCategorias() as $fgtsCategoria) {
            $fgtsCategoria->setFkFolhapagamentoFgts($fgts);
        }
    }

    /**
     * @param Fgts $fgts
     */
    public function postPersist($fgts)
    {
        $form = $this->getForm();
        $evento1 = $form->get('evento1')->getData();
        $evento2 = $form->get('evento2')->getData();
        $evento3 = $form->get('evento3')->getData();

        $em = $this->modelManager->getEntityManager($this->getClass());
        $tipoEventoFgtsModel = new TipoEventoFgtsModel($em);
        $fgtsEventoModel = new FgtsEventoModel($em);

        $tipo1 = $tipoEventoFgtsModel->gettipoEventoFgtsByCodTipo(1);
        $tipo2 = $tipoEventoFgtsModel->gettipoEventoFgtsByCodTipo(2);
        $tipo3 = $tipoEventoFgtsModel->gettipoEventoFgtsByCodTipo(3);

        $fgtsEventoModel->saveFgtsEvento($fgts, $evento1, $tipo1);
        $fgtsEventoModel->saveFgtsEvento($fgts, $evento2, $tipo2);
        $fgtsEventoModel->saveFgtsEvento($fgts, $evento3, $tipo3);
    }

    /**
     * @param Fgts $fgts
     */
    public function preUpdate($fgts)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $fgtsCategoriaModel = new FgtsCategoriaModel($em);
        $categorias = $fgtsCategoriaModel->getFgtsByCodFgts($fgts->getCodFgts());

        /** @var FgtsCategoria $categoria */
        foreach ($categorias as $categoria) {
            $em->remove($categoria);
        }

        /** @var FgtsCategoria $fgtsCategoria */
        foreach ($fgts->getFkFolhapagamentoFgtsCategorias() as $fgtsCategoria) {
            $fgtsCategoria->setFkFolhapagamentoFgts($fgts);
        }

        $this->checkSelectedDeleteInListCollecion(
            $fgts,
            'fkFolhapagamentoFgtsCategorias',
            'setFkFolhapagamentoFgts'
        );

        /** @var FgtsEvento $fgtsEvento */
        foreach ($fgts->getFkFolhapagamentoFgtsEventos() as $fgtsEvento) {
            $fgts->removeFkFolhapagamentoFgtsEventos($fgtsEvento);
        }

        $em->flush();
    }

    /**
     * @param Fgts $fgts
     */
    public function postUpdate($fgts)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $fgtsModel = new FgtsModel($em);

        $form = $this->getForm();
        $fgtsCategorias = $form->get('fkFolhapagamentoFgtsCategorias')->getData();
        /** @var FgtsCategoria $fgtsCategoria */
        foreach ($fgtsCategorias as $fgtsCategoria) {
            $fgtsCategoria->setFkFolhapagamentoFgts($fgts);
            $fgtsModel->save($fgtsCategoria);
        }

        $this->postPersist($fgts);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'vigencia',
                'doctrine_orm_callback',
                [
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.fgts.vigencia'
                ],
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                ]
            );
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        if ($filter['vigencia']['value'] != '') {
            $queryBuilder->andWhere("{$alias}.vigencia = :vigencia");
            $queryBuilder->setParameter("vigencia", $filter['vigencia']['value']);
        }

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $fieldOptions['codFgts'] = [
            'label' => 'label.fgts.codFgts'
        ];
        $fieldOptions['vigencia'] = [
            'label' => 'label.fgts.vigencia'
        ];
        $listMapper
            ->add('codFgts', null, $fieldOptions['codFgts'])
            ->add('vigencia', null, $fieldOptions['vigencia'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                )
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $informativo = 'I';
        $base = 'B';

        /** @var Fgts $fgts */
        $fgts = $this->getSubject();
        $eventoArray = [];

        if ($fgts->getFkFolhapagamentoFgtsEventos()) {
            $eventos = $fgts->getFkFolhapagamentoFgtsEventos();

            /** @var Evento $evento */
            foreach ($eventos as $evento) {
                $eventoArray[$evento->getCodTipo()] = $evento;
            }
        }

        $fieldOptions['evento1'] = [
            'class' => Evento::class,
            'label' => 'label.fgts.eventoInformativoRecolhido',
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'choice_value' => 'codEvento',
            'query_builder' => function (EntityRepository $entityManager) use ($informativo) {
                $qb = $entityManager->createQueryBuilder('e');
                $qb->innerJoin('e.fkFolhapagamentoEventoEventos', 'ee');
                $qb->leftJoin('e.fkFolhapagamentoSequenciaCalculoEventos', 'sce');
                $qb->where('e.natureza = :natureza');
                $qb->andWhere('e.eventoSistema = true')
                    ->setParameter(':natureza', $informativo);

                return $qb;
            },
            'placeholder' => 'label.selecione',
            'data' => !empty($eventoArray) ? $eventoArray[1] : null,
            'mapped' => false
        ];

        $fieldOptions['evento2'] = [
            'class' => Evento::class,
            'label' => 'label.fgts.eventoInformativoContribuicao',
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'choice_value' => 'codEvento',
            'query_builder' => function (EntityRepository $entityManager) use ($informativo) {
                $qb = $entityManager->createQueryBuilder('e');
                $qb->innerJoin('e.fkFolhapagamentoEventoEventos', 'ee');
                $qb->leftJoin('e.fkFolhapagamentoSequenciaCalculoEventos', 'sce');
                $qb->where('e.natureza = :natureza');
                $qb->andWhere('e.eventoSistema = true')
                    ->setParameter(':natureza', $informativo);

                return $qb;
            },
            'placeholder' => 'label.selecione',
            'data' => !empty($eventoArray) ? $eventoArray[2] : null,
            'mapped' => false
        ];

        $fieldOptions['evento3'] = [
            'class' => Evento::class,
            'label' => 'label.fgts.eventoBase',
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'choice_value' => 'codEvento',
            'query_builder' => function (EntityRepository $entityManager) use ($base) {
                $qb = $entityManager->createQueryBuilder('e');
                $qb->innerJoin('e.fkFolhapagamentoEventoEventos', 'ee');
                $qb->leftJoin('e.fkFolhapagamentoSequenciaCalculoEventos', 'sce');
                $qb->where('e.natureza = :natureza');
                $qb->andWhere('e.eventoSistema = true')
                    ->setParameter(':natureza', $base);

                return $qb;
            },
            'placeholder' => 'label.selecione',
            'data' => !empty($eventoArray) ? $eventoArray[3] : null,
            'mapped' => false
        ];

        $fieldOptions['vigencia'] = [
            'label' => 'label.fgts.vigencia',
            'format' => 'dd/MM/yyyy',
            'data' => ($fgts->getVigencia()) ? $fgts->getVigencia() : new \DateTime()
        ];

        $formMapper
            ->with('label.fgts.dadosFgts')
            ->add('evento1', 'entity', $fieldOptions['evento1'])
            ->add('evento2', 'entity', $fieldOptions['evento2'])
            ->add('evento3', 'entity', $fieldOptions['evento3'])
            ->add('vigencia', 'sonata_type_date_picker', $fieldOptions['vigencia'])
            ->end()
            ->with('label.fgts.dadosSefip')
            ->add('fkFolhapagamentoFgtsCategorias', 'sonata_type_collection', [
                'by_reference' => false,
                'label' => false,
            ], [
                'edit' => 'inline',
                'inline' => 'table'
            ])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['codFgts'] = [
            'label' => 'label.fgts.codFgts'
        ];
        $fieldOptions['vigencia'] = [
            'label' => 'label.fgts.vigencia'
        ];
        $fieldOptions['fkFolhapagamentoFgtsEventos'] = [
            'label' => 'Eventos',
            'class' => FgtsEvento::class,
            'associated_property' => function (FgtsEvento $evento) {
                return $evento->getFkFolhapagamentoEvento();
            }
        ];
        $fieldOptions['fkFolhapagamentoFgtsCategorias'] = [
            'label' => 'Categorias',
            'class' => FgtsCategoria::class,
            'associated_property' => function (FgtsCategoria $categoria) {
                return $categoria->getFkPessoalCategoria() . ' - ' . $categoria->getAliquotaContribuicao() . ' - ' . $categoria->getAliquotaDeposito();
            }
        ];

        $showMapper
            ->with('label.fgts.dadosFgts')
            ->add('codFgts', null, $fieldOptions['codFgts'])
            ->add('fkFolhapagamentoFgtsEventos', null, $fieldOptions['fkFolhapagamentoFgtsEventos'])
            ->add('fkFolhapagamentoFgtsCategorias', null, $fieldOptions['fkFolhapagamentoFgtsCategorias'])
            ->add('vigencia', null, $fieldOptions['vigencia'])
            ->end();
    }
}
