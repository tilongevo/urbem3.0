<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorComplementar;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementarParcela;
use Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoComplementar;
use Urbem\CoreBundle\Entity\Pessoal\Cargo;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\Especialidade;
use Urbem\CoreBundle\Entity\Pessoal\SubDivisao;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoComplementarModel;
use Urbem\CoreBundle\Model\Folhapagamento\UltimoRegistroEventoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class RegistroEventoComplementarAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_registro_evento_complementar';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/registro-evento-complementar';
    protected $exibirBotaoIncluir = false;

    protected $includeJs = [
        '/recursoshumanos/javascripts/folhapagamento/registroEventoComplementar.js'
    ];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('imprimir_registro_evento_complementar', '{id}/imprimir-registro-evento-complementar');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $codigos = (new EventoModel($em))->getEventoByParams(['P', 'D'], null);
        $codigos = array_flip($codigos);

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();

        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);
        $codPeriodoMovimentacao = $periodoFinal->getCodPeriodoMovimentacao();

        $codSubDivisao = $codCargo = $codEspecialidade = $codComplementar = null;

        $codContrato = $this->request->get('codContrato');

        if ($codContrato) {
            /** @var Contrato $contrato */
            $contrato = $em->getRepository(Contrato::class)->find($codContrato);

            /** @var ContratoServidorComplementar $contratoServidorComplementar */
            $contratoServidorComplementar = $contrato->getFkFolhapagamentoContratoServidorComplementares()->filter(
                function ($entry) use ($periodoFinal) {
                    if ($entry->getCodPeriodoMovimentacao() == $periodoFinal->getCodPeriodoMovimentacao()) {
                        return $entry;
                    }
                }
            )->first();

            if ($contratoServidorComplementar) {
                $codComplementar = $contratoServidorComplementar->getCodComplementar();
                $eventosCadastrados = (new RegistroEventoComplementarModel($em))->montaRecuperaRegistrosEventoDoContrato(
                    $periodoFinal->getCodPeriodoMovimentacao(),
                    $contratoServidorComplementar->getCodComplementar(),
                    $codContrato
                );

                foreach ($eventosCadastrados as $evento) {
                    unset($codigos[$evento['codigo']]);
                }
            }

            /** @var Cargo $cargo */
            $cargo = ($contrato->getFkPessoalContratoServidor())
                ? $contrato->getFkPessoalContratoServidor()->getFkPessoalContratoServidorFuncoes()->last()->getFkPessoalCargo()
                : null;

            $codCargo = (is_object($cargo)) ? $cargo->getCodCargo() : $codCargo;

            /** @var SubDivisao $subDivisao */
            $subDivisao = ($cargo) ? $cargo->getFkPessoalCargoSubDivisoes()->last()->getFkPessoalSubDivisao() : null;
            $codSubDivisao = (is_object($subDivisao)) ? $subDivisao->getCodSubDivisao() : $codSubDivisao;

            /** @var Especialidade $especialidade */
            $especialidade = ($cargo) ? $cargo->getFkPessoalEspecialidades()->last() : null;
            $codEspecialidade = (is_object($especialidade)) ? $especialidade->getCodEspecialidade() : $codEspecialidade;
        }

        $fieldOptions = array();

        $fieldOptions['fkFolhapagamentoEvento'] = [
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.evento',
            'class' => Evento::class,
            'placeholder' => 'label.selecione',
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $fieldOptions['valor'] = [
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.valor',
            'attr' => [
                'class' => 'money '
            ],
            'required' => true
        ];

        $fieldOptions['quantidade'] = [
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.quantidade',
            'attr' => [
                'class' => 'money '
            ],
            'required' => true
        ];

        $fieldOptions['parcela'] = [
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.qtdeParcela',
            'attr' => [
                'class' => 'numeric '
            ],
            'required' => true,
            'mapped' => false
        ];

        $fieldOptions['limiteCalculo'] = [
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.previsao',
            'mapped' => false,
            'required' => false,
            'attr' => ['readonly' => 'readonly']
        ];

        $fieldOptions['fkFolhapagamentoConfiguracaoEvento'] = [
            'label' => 'label.recursosHumanos.contratoServidorComplementar.caracteristica',
            'class' => ConfiguracaoEvento::class,
            'choice_label' => function ($configuracaoEvento) {
                return $configuracaoEvento->getCodConfiguracao() . ' - ' . $configuracaoEvento->getDescricao();
            },
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione',
            'required' => true
        ];

        $fieldOptions['textoComplementar'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.recursosHumanos.contratoServidorComplementar.textoComplementar',
            'attr' => ['readonly' => 'readonly']
        ];

        if ($this->id($this->getSubject())) {
            /** @var RegistroEventoComplementar $registroEventoComplementar */
            $registroEventoComplementar = $this->getSubject();

            $fieldOptions['fkFolhapagamentoEvento']['mapped'] = false;
            $fieldOptions['fkFolhapagamentoEvento']['disabled'] = true;
            $fieldOptions['fkFolhapagamentoEvento']['data'] = $registroEventoComplementar->getFkFolhapagamentoEvento();

            $fieldOptions['valor']['mapped'] = false;
            $fieldOptions['valor']['data'] = $registroEventoComplementar->getValor();

            $fieldOptions['quantidade']['mapped'] = false;
            $fieldOptions['quantidade']['data'] = $registroEventoComplementar->getQuantidade();

            $eventoInfo = (new EventoModel($em))->listarEvento($registroEventoComplementar->getCodEvento());

            if ($eventoInfo[0]['fixado'] == 'V' || $eventoInfo[0]['fixado'] == '1') {
                $fieldOptions['quantidade']['required'] = false;
            } elseif ($eventoInfo[0]['fixado'] == 'Q') {
                $fieldOptions['valor']['attr'] = ['class' => 'money ', 'readonly' => 'readonly'];
            }

            if (!$eventoInfo[0]['apresenta_parcela']) {
                $fieldOptions['parcela']['attr'] = ['class' => 'numeric ', 'readonly' => 'readonly'];
            }

            $fieldOptions['textoComplementar']['data'] = $eventoInfo[0]['observacao'];

            if ($registroEventoComplementar->getFkFolhapagamentoUltimoRegistroEventoComplementar()->getFkFolhapagamentoRegistroEventoComplementarParcela()) {
                $fieldOptions['parcela']['data'] = $registroEventoComplementar->getFkFolhapagamentoUltimoRegistroEventoComplementar()->getFkFolhapagamentoRegistroEventoComplementarParcela()->getParcela();
            }
        } else {
            $fieldOptions['fkFolhapagamentoEvento']['query_builder'] = function (EntityRepository $er) use ($codigos) {
                $qb = $er->createQueryBuilder('e');
                $qb->where(
                    $qb->expr()->In('e.codigo', array_flip($codigos))
                );
                return $qb;
            };

            $fieldOptions['valor']['data'] = 0.0;
            $fieldOptions['valor']['attr'] = ['class' => 'money ', 'readonly' => 'readonly'];

            $fieldOptions['quantidade']['data'] = 0.0;

            $fieldOptions['parcela']['attr'] = ['class' => 'numeric ', 'readonly' => 'readonly'];
        }

        $formMapper
            ->with('label.recursosHumanos.contratoServidorPeriodo.dadosEvento')
            ->add('exercicio', 'hidden', ['mapped' => false, 'data' => $this->getExercicio()])
            ->add('codContrato', 'hidden', ['mapped' => false, 'data' => $codContrato])
            ->add('codCargo', 'hidden', ['mapped' => false, 'data' => $codCargo])
            ->add('codSubDivisao', 'hidden', ['mapped' => false, 'data' => $codSubDivisao])
            ->add('codEspecialidade', 'hidden', ['mapped' => false, 'data' => $codEspecialidade])
            ->add('codPeriodoMovimentacao', 'hidden', ['mapped' => false, 'data' => $codPeriodoMovimentacao])
            ->add('codComplementar', 'hidden', ['mapped' => false, 'data' => $codComplementar])
            ->add('fkFolhapagamentoEvento', null, $fieldOptions['fkFolhapagamentoEvento'])
            ->add('valor', null, $fieldOptions['valor'])
            ->add('quantidade', null, $fieldOptions['quantidade'])
            ->add('parcela', 'text', $fieldOptions['parcela'])
            ->add('limiteCalculo', 'text', $fieldOptions['limiteCalculo'])
            ->add('textoComplementar', 'textarea', $fieldOptions['textoComplementar'])
            ->add('fkFolhapagamentoConfiguracaoEvento', null, $fieldOptions['fkFolhapagamentoConfiguracaoEvento'])
            ->end();
    }

    /**
     * @param RegistroEventoComplementar $registroEventoComplementar
     */
    public function prePersist($registroEventoComplementar)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $registroEventoComplementarModel = new RegistroEventoComplementarModel($em);

        $codRegistro = $registroEventoComplementarModel->getNextCodRegistro(
            $registroEventoComplementar->getCodEvento(),
            $registroEventoComplementar->getCodConfiguracao()
        );

        $registroEventoComplementar->setCodRegistro($codRegistro);

        $form = $this->getForm();

        /** @var ContratoServidorComplementar $contratoServidorComplementar */
        $contratoServidorComplementar = $registroEventoComplementarModel->recuperarContratoServidorComplementar(
            $form->get('codPeriodoMovimentacao')->getData(),
            $form->get('codComplementar')->getData(),
            $form->get('codContrato')->getData()
        );

        $registroEventoComplementar->setFkFolhapagamentoContratoServidorComplementar($contratoServidorComplementar);

        $registroEventoComplementarModel->manterUltimoRegistroEventoComplementar($registroEventoComplementar, $form->get('parcela')->getData());
        $registroEventoComplementarModel->manterRegistrosEventoComplementarAnteriores($registroEventoComplementar);
    }

    /**
     * @param RegistroEventoComplementar $registroEventoComplementar
     */
    public function postPersist($registroEventoComplementar)
    {
        $this->forceRedirect("/recursos-humanos/folha-pagamento/contrato-servidor-complementar/{$this->getObjectKey($registroEventoComplementar->getFkFolhapagamentoContratoServidorComplementar()->getFkPessoalContrato())}/show");
    }

    /**
     * @param RegistroEventoComplementar $registroEventoComplementar
     */
    public function preUpdate($registroEventoComplementar)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $registroEventoComplementarModel = new RegistroEventoComplementarModel($em);

        $codRegistro = $registroEventoComplementarModel->getNextCodRegistro(
            $registroEventoComplementar->getCodEvento(),
            $registroEventoComplementar->getCodConfiguracao()
        );

        $registrosEventoComplementarNovo = new RegistroEventoComplementar();
        $registrosEventoComplementarNovo->setCodRegistro($codRegistro);
        $registrosEventoComplementarNovo->setValor($this->getForm()->get('valor')->getData());
        $registrosEventoComplementarNovo->setQuantidade($this->getForm()->get('quantidade')->getData());
        $registrosEventoComplementarNovo->setFkFolhapagamentoEvento($registroEventoComplementar->getFkFolhapagamentoEvento());
        $registrosEventoComplementarNovo->setFkFolhapagamentoContratoServidorComplementar($registroEventoComplementar->getFkFolhapagamentoContratoServidorComplementar());
        $registrosEventoComplementarNovo->setFkFolhapagamentoConfiguracaoEvento($registroEventoComplementar->getFkFolhapagamentoConfiguracaoEvento());

        $registroEventoComplementarModel->manterUltimoRegistroEventoComplementar($registrosEventoComplementarNovo, $this->getForm()->get('parcela')->getData());
        $registroEventoComplementarModel->manterRegistrosEventoComplementarAnteriores($registrosEventoComplementarNovo);

        $em->persist($registrosEventoComplementarNovo);
    }

    /**
     * @param RegistroEventoComplementar $registroEventoComplementar
     */
    public function postUpdate($registroEventoComplementar)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        if ($registroEventoComplementar->getFkFolhapagamentoUltimoRegistroEventoComplementar()->getFkFolhapagamentoRegistroEventoComplementarParcela()) {
            $em->remove($registroEventoComplementar->getFkFolhapagamentoUltimoRegistroEventoComplementar()->getFkFolhapagamentoRegistroEventoComplementarParcela());
        }
        $em->remove($registroEventoComplementar->getFkFolhapagamentoUltimoRegistroEventoComplementar());
        $em->flush();
        $this->forceRedirect("/recursos-humanos/folha-pagamento/contrato-servidor-complementar/{$this->getObjectKey($registroEventoComplementar->getFkFolhapagamentoContratoServidorComplementar()->getFkPessoalContrato())}/show");
    }

    /**
     * @param RegistroEventoComplementar $registroEventoComplementar
     */
    public function preRemove($registroEventoComplementar)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        (new RegistroEventoComplementarModel($em))->manterRegistrosEventoComplementarAnteriores($registroEventoComplementar, new DateTimeMicrosecondPK());
        $em->flush();
        $em->clear();
        $this->forceRedirect("/recursos-humanos/folha-pagamento/contrato-servidor-complementar/{$this->getObjectKey($registroEventoComplementar->getFkFolhapagamentoContratoServidorComplementar()->getFkPessoalContrato())}/show");
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $codPeriodoMovimentacao = $periodoFinal->getCodPeriodoMovimentacao();

        $query->innerJoin('o.fkFolhapagamentoContratoServidorComplementar', 'csp');
        $query->andWhere("{$query->getRootAliases()[0]}.codPeriodoMovimentacao = :codPeriodoMovimentacao");
        if (!$this->getRequest()->query->get('filter')) {
            $query->andWhere("YEAR({$query->getRootAliases()[0]}.timestamp) = :ano");
        }
        $query->setParameters(
            [
                'codPeriodoMovimentacao' => $codPeriodoMovimentacao,
                'ano' => $this->getExercicio()
            ]
        );


        return $query;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('codContrato')
            ->add('codRegistro');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'fkFolhapagamentoContratoServidorComplementar.fkPessoalContrato',
                null,
                [
                    'label' => 'label.recursosHumanos.folhas.folhaComplementar.cgm',
                    'associated_property' => function ($fkPessoalContrato) {
                        return is_null($fkPessoalContrato->getFkPessoalContratoServidor()) ? "Servidor não informado" : $fkPessoalContrato->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()->getFkPessoalServidor()->getFkSwCgmPessoaFisica();
                    },
                    'admin_code' => 'core.admin.contrato'
                ]
            )
            ->add('fkFolhapagamentoEvento', null, ['label' => 'label.recursosHumanos.folhas.folhaComplementar.evento'])
            ->add(
                'codRegistro',
                null,
                [
                    'label' => 'label.matricula',
                ]
            )
            ->add('codComplementar', null, ['label' => 'label.recursosHumanos.folhas.folhaComplementar.codComplementar'])
            ->add(
                'fkFolhapagamentoContratoServidorComplementar.fkFolhapagamentoComplementar.fkFolhapagamentoPeriodoMovimentacao.dtFinal',
                'date',
                [
                    'label' => 'label.recursosHumanos.folhas.folhaComplementar.exercicio',
                    'format' => 'Y'
                ]
            );

        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'RecursosHumanosBundle::Sonata/FolhaPagamento/RegistroEventoComplementar/CRUD/list__action_print.html.twig'),
                )
            ));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $exercicio = $this->getExercicio();
        $datagridMapper
            ->add(
                'exercicio',
                'doctrine_orm_callback',
                array(
                    'callback' => array($this, 'getSearchFilter'),
                    'label' => 'label.recursosHumanos.folhas.folhaComplementar.exercicio',
                ),
                null,
                array(
                    'attr' => array(
                        'required' => true,
                    )
                )
            )
            ->add('codComplementar', null, ['label' => 'label.recursosHumanos.folhas.folhaComplementar.codComplementar']);
        ;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $codPeriodoMovimentacao = $periodoFinal->getCodPeriodoMovimentacao();

        $filter = $this->getDataGrid()->getValues();

        $joinItensAtivo = false;

        $queryBuilder->resetDQLPart('join');

        if (isset($filter['exercicio']['value']) and $filter['exercicio']['value'] != '') {
            $queryBuilder->join('o.fkFolhapagamentoContratoServidorComplementar', 'csc')
                ->join('csc.fkFolhapagamentoComplementar', 'fc')
                ->join('fc.fkFolhapagamentoPeriodoMovimentacao', 'pm');
            $queryBuilder->andWhere("YEAR(o.timestamp) = :exercicio");
            $queryBuilder->setParameters(
                [
                    "exercicio" => $filter['exercicio']['value'],
                    'codPeriodoMovimentacao' => $codPeriodoMovimentacao
                ]
            );
        }

        return true;
    }
}
