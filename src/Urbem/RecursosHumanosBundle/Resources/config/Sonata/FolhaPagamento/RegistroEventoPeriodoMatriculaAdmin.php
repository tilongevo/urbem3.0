<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Exception;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculado;
use Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculo;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoParcela;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoPeriodoModel;
use Urbem\CoreBundle\Model\Folhapagamento\UltimoRegistroEventoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class RegistroEventoPeriodoMatriculaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_registro_evento_periodo_matricula';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/registro-evento-periodo-matricula';

    protected $includeJs = array(
        '/recursoshumanos/javascripts/folhapagamento/registroEventoPeriodoMatricula.js'
    );

    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept('create');
    }


    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb(['id' => $id]);

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $codPeriodoMovimentacao = $periodoFinal->getCodPeriodoMovimentacao();

        $eventoModel = new EventoModel($em);
        $eventoArray = $eventoModel->getEventoByParams(['P', 'D', 'I'], false);
        $codEventos = $eventosCadastradosArray = [];
        foreach ($eventoArray as $evento) {
            $codEventos[] = $evento;
        }

        if (empty($codEventos)) {
            $codEventos[] = '00000';
        }

        $fieldOptions['eventos_lista'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'RecursosHumanosBundle::FolhaPagamento/FolhaSalario/eventos.html.twig',
            'attr' => array(
                'style' => 'display:none;'
            ),
            'data' => array(
                'eventos' => array()
            )
        );

        $fieldOptions['evento'] = [
            'class' => Evento::class,
            'choice_label' => function ($evento) {
                return $evento->getCodigo() . ' - ' . $evento->getDescricao();
            },
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.evento',
            'query_builder' => function (EntityRepository $repo) use ($codEventos) {
                $qb = $repo->createQueryBuilder('e');
                $qb->where(
                    $qb->expr()->In('e.codigo', $codEventos)
                );

                return $qb;
            },
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione',
            'required' => false,
            'mapped' => false
        ];

        $formOptions['quantidade'] = [
            'attr' => [
                'class' => 'quantity '
            ],
            'required' => false,
            'mapped' => false,
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.quantidade',
            'data' => 0
        ];

        $formOptions['parcela'] = [
            'attr' => [
                'class' => 'money ',
                'readonly' => 'readonly'
            ],
            'required' => false,
            'mapped' => false,
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.parcela',
        ];

        $formOptions['valor'] = [
            'attr' => [
                'class' => 'money ',
                'readonly' => 'readonly',
            ],
            'required' => false,
            'mapped' => false,
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.valor',
            'data' => 0
        ];

        $formOptions['qtdeParcela'] = [
            'attr' => [
                'class' => 'numeric ',
                'readonly' => 'readonly',
            ],
            'required' => false,
            'mapped' => false,
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.qtdeParcela',
        ];

        $formOptions['contratoServidor'] = [
            'class' => ContratoServidorPeriodo::class,
            'route' => [
                'name' => 'carrega_contrato_servidor_periodo'
            ],
            'json_choice_label' => function ($contratoServidor) use ($em) {

                if (!is_null($contratoServidor->getFkPessoalContrato())) {
                    $nomcgm = $contratoServidor->getFkPessoalContrato()
                        ->getFkPessoalContratoServidor()
                        ->getFkPessoalServidorContratoServidores()->last()
                        ->getFkPessoalServidor()
                        ->getFkSwCgmPessoaFisica()
                        ->getFkSwCgm()
                        ->getNomcgm();
                } else {
                    $nomcgm = "Não localizado";
                }

                return $nomcgm;
            },
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'req_params' => [
                'codPeriodoMovimentacao' => 'varJsCodPeriodoMovimentacao'
            ],
            'label' => 'label.cgm'
        ];

        $fieldOptions['proporcional'] = [
            'choices' => [
                'Não' => false,
                'Sim' => true
            ],
            'mapped' => false,
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.proporcional'
        ];

        $formMapper
            ->with('Dados da Matrícula')
            ->add('fkFolhapagamentoContratoServidorPeriodo', 'autocomplete', $formOptions['contratoServidor'], ['admin_code' => 'recursos_humanos.admin.contrato_servidor_periodo'])
            ->add('codPeriodoMovimentacao', 'hidden', ['mapped' => false, 'data' => $codPeriodoMovimentacao])
            ->add('proporcional', 'choice', $fieldOptions['proporcional'])
            ->end()
            ->with('Dados do Evento')
            ->add('evento', 'entity', $fieldOptions['evento'])
            ->add('valor', 'text', $formOptions['valor'])
            ->add('quantidade', 'text', $formOptions['quantidade'])
            ->add('parcela', 'text', $formOptions['parcela'])
            ->add('qtdeParcela', 'text', $formOptions['qtdeParcela'])
            ->add('textoComplementar', 'textarea', ['mapped' => false, 'label' => 'Texto Complementar', 'required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('eventos', 'customField', $fieldOptions['eventos_lista'])
            ->end();
    }

    /**
     * @param mixed $registroEventoPeriodo
     *
     * @throws Exception
     */
    public function prePersist($registroEventoPeriodo)
    {

        $request = $this->request->request;
        $eventos = $request->get('eventos');
        $ev = array_shift($eventos);
        $form = $this->getForm();
        $container = $this->getContainer();

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        /** @var RegistroEventoPeriodoModel $registroEventoPeriodoModel */
        $registroEventoPeriodoModel = new RegistroEventoPeriodoModel($em);
        /** @var RegistroEventoModel $registroEventoModel */
        $registroEventoModel = new RegistroEventoModel($em);
        /** @var UltimoRegistroEventoModel $ultimoRegistroEventoModel */
        $ultimoRegistroEventoModel = new UltimoRegistroEventoModel($em);
        try {
            foreach ($eventos as $evento) {
                $filtro = " AND registro_evento_periodo.cod_contrato = " . $registroEventoPeriodo->getCodContrato();
                $filtro .= " AND cod_periodo_movimentacao = " . $registroEventoPeriodo->getCodPeriodoMovimentacao();
                $filtro .= " AND registro_evento.cod_evento = ".$evento;
                $stProporcional = ($form->get("proporcional") == "Sim") ? "TRUE" : "FALSE";
                $filtro .= " AND proporcional IS ".$stProporcional;

                $rsEventos = $registroEventoPeriodoModel->montaRecuperaRegistrosDeEventos($filtro);

                if (!empty($rsEventos)) {
                    foreach ($rsEventos as $eventos) {
                        /** @var RegistroEvento $registroEvento */
                        $registroEvento = $em->getRepository(RegistroEvento::class)->findOneBy(
                            [
                                'codEvento' => $eventos['cod_evento'],
                                'timestamp' => $eventos['timestamp'],
                                'codRegistro' => $eventos['cod_registro'],
                            ]
                        );
                        /** @var EventoCalculado $eventoCalculado */
                        $eventoCalculado = $registroEvento->getFkFolhapagamentoUltimoRegistroEvento()->getFkFolhapagamentoEventoCalculado();
                        if (!is_null($eventoCalculado)) {
                            $registroEventoPeriodoModel->remove($eventoCalculado);
                        }

                        /** @var LogErroCalculo $logErroCalculo */
                        $logErroCalculo = $registroEvento->getFkFolhapagamentoUltimoRegistroEvento()->getFkFolhapagamentoLogErroCalculo();
                        if (!is_null($logErroCalculo)) {
                            $registroEventoPeriodoModel->remove($logErroCalculo);
                        }

                        /** @var RegistroEventoParcela $registroEventoParcela */
                        $registroEventoParcela = $registroEvento->getFkFolhapagamentoUltimoRegistroEvento()->getFkFolhapagamentoRegistroEventoParcela();
                        if (!is_null($registroEventoParcela)) {
                            $registroEventoPeriodoModel->remove($registroEventoParcela);
                        }

                        $registroEventoPeriodoModel->remove($registroEvento->getFkFolhapagamentoUltimoRegistroEvento());
                    }
                }
                /** @var RegistroEventoPeriodo $registroEventoPeriodoObject */
                $registroEventoPeriodoObject = $registroEventoPeriodoModel->buildOne(
                    $registroEventoPeriodo->getFkFolhapagamentoContratoServidorPeriodo()
                );

                /** @var Evento $eventoObject */
                $eventoObject = $em->getRepository(Evento::class)->findOneBy(['codEvento' => $evento]);

                /** @var RegistroEvento $registroEventoObject */
                $registroEventoObject = $registroEventoModel->buildOneBasedEvento($eventoObject, $registroEventoPeriodoObject);

                /** @var UltimoRegistroEvento $ultimoRegistroEvento */
                $ultimoRegistroEvento = $ultimoRegistroEventoModel->buildOneBasedRegistroEvento($registroEventoObject);

                $registroEventoObject->setFkFolhapagamentoUltimoRegistroEvento($ultimoRegistroEvento);
                $registroEventoPeriodoObject->addFkFolhapagamentoRegistroEventos($registroEventoObject);

                $em->persist($registroEventoPeriodoObject);
                $em->flush();
            }
            $container->get('session')
                ->getFlashBag()
                ->add(
                    'success',
                    $this->getTranslator()->trans('flash_create_success')
                );
        } catch (Exception $e) {
            throw $e;
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('flash_create_error'));
        }

        $this->redirectByRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_periodo_matricula_create');
    }
}
