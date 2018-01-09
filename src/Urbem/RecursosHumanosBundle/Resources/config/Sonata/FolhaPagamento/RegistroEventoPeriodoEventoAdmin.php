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
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal\GeneralFilterAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class RegistroEventoPeriodoEventoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_registro_evento_periodo_evento';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/registro-evento-periodo-evento';

    /**
     * @var array
     */
    protected $includeJs = array(
        '/recursoshumanos/javascripts/folhapagamento/registroEventoPeriodoEvento.js'
    );

    /**
     * @param RouteCollection $collection
     */
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

        $formOptions['evento'] = [
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

        $fieldOptions['proporcional'] = [
            'choices' => [
                'Não' => false,
                'Sim' => true
            ],
            'mapped' => false,
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.proporcional'
        ];

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
        $fieldOptions['proporcional'] = [
            'choices' => [
                'Não' => false,
                'Sim' => true
            ],
            'mapped' => false,
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.proporcional'
        ];

        $formMapper
            ->with('Dados do Evento')
            ->add('evento', 'entity', $formOptions['evento'])
            ->add('codPeriodoMovimentacao', 'hidden', ['mapped' => false, 'data' => $codPeriodoMovimentacao])
            ->add('valor', 'text', $formOptions['valor'])
            ->add('quantidade', 'text', $formOptions['quantidade'])
            ->add('parcela', 'text', $formOptions['parcela'])
            ->add('qtdeParcela', 'text', $formOptions['qtdeParcela'])
            ->add('textoComplementar', 'textarea', ['mapped' => false, 'label' => 'Texto Complementar', 'required' => false, 'attr' => ['readonly' => 'readonly']])
            ->add('proporcional', 'choice', $fieldOptions['proporcional'])
            ->end();
        parent::configureFormFields($formMapper);

        $formMapper
            ->add('eventos', 'customField', $fieldOptions['eventos_lista']);
    }

    /**
     * @param mixed $registroEventoPeriodo
     *
     * @throws Exception
     */
    public function prePersist($registroEventoPeriodo)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        /** @var RegistroEventoPeriodoModel $registroEventoPeriodoModel */
        $registroEventoPeriodoModel = new RegistroEventoPeriodoModel($em);
        /** @var RegistroEventoModel $registroEventoModel */
        $registroEventoModel = new RegistroEventoModel($em);
        /** @var UltimoRegistroEventoModel $ultimoRegistroEventoModel */
        $ultimoRegistroEventoModel = new UltimoRegistroEventoModel($em);
        /** @var ContratoModel $contratoModel */
        $contratoModel = new ContratoModel($em);
        $container = $this->getContainer();

        $form = $this->getForm();
        $tipo = $form->get('tipo')->getData();
        $campo = ($tipo == 'cgm_contrato') ? $form->get('codContrato')->getData() : $form->get($tipo)->getData();
        $codPeriodoMovimentacao = $form->get('codPeriodoMovimentacao')->getData();

        $filtro = [];
        $filtro['cod_periodo_movimentacao'] = $codPeriodoMovimentacao;

        switch ($tipo) {
            case 'lotacao':
                $filtro['lotacoes'] = implode(',', $campo);
                $registros = $contratoModel->recuperaContratosDeLotacao($filtro);
                break;
            case 'local':
                $filtro['local'] = implode(',', $campo);
                $registros = $contratoModel->recuperaContratosDeLocal($filtro);
                break;
            case 'evento':
                $filtro['evento'] = implode(',', $campo);
                $registros = $contratoModel->recuperaContratosCalculados($filtro);
                break;
            case 'geral':
                $registros = $contratoModel->recuperaContratoGeral();
                break;
            case 'cgm_contrato':
                $registros = $campo;
                break;
        }

        $request = $this->request->request;
        $eventos = $request->get('eventos');
        $ev = array_shift($eventos);

        try {
            foreach ($eventos as $evento) {
                foreach ($registros as $registro) {
                    $codContrato = ($tipo == 'cgm_contrato') ? $registro->getCodContrato() : $registro->cod_contrato;
                    $filtro = " AND registro_evento_periodo.cod_contrato = " . $codContrato;
                    $filtro .= " AND cod_periodo_movimentacao = " . $codPeriodoMovimentacao;
                    $filtro .= " AND registro_evento.cod_evento = " . $evento;
                    $stProporcional = ($form->get("proporcional") == "Sim") ? "TRUE" : "FALSE";
                    $filtro .= " AND proporcional IS " . $stProporcional;

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

                    /** @var ContratoServidorPeriodo $contratoServidorPeriodo */
                    $contratoServidorPeriodo = $em->getRepository(ContratoServidorPeriodo::class)->findOneBy(
                        [
                            'codPeriodoMovimentacao' => $codPeriodoMovimentacao,
                            'codContrato' => $codContrato
                        ]
                    );

                    if (!is_null($contratoServidorPeriodo)) {
                        /** @var RegistroEventoPeriodo $registroEventoPeriodoObject */
                        $registroEventoPeriodoObject = $registroEventoPeriodoModel->buildOne($contratoServidorPeriodo);

                        /** @var Evento $eventoObject */
                        $eventoObject = $em->getRepository(Evento::class)->findOneBy(['codEvento' => $evento]);

                        /** @var RegistroEvento $registroEventoObject */
                        $registroEventoObject = $registroEventoModel->buildOneBasedEvento($eventoObject, $registroEventoPeriodoObject);

                        /** @var UltimoRegistroEvento $ultimoRegistroEvento */
                        $ultimoRegistroEvento = $ultimoRegistroEventoModel->buildOneBasedRegistroEvento($registroEventoObject);

                        $registroEventoObject->setFkFolhapagamentoUltimoRegistroEvento($ultimoRegistroEvento);
                        $registroEventoPeriodoObject->addFkFolhapagamentoRegistroEventos($registroEventoObject);

                        $em->persist($registroEventoObject);
                        $em->flush();
                    } else {
                        $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('flash_create_error'));
                        $this->redirectByRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_periodo_evento_create');
                    }
                }
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

        $this->redirectByRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_periodo_evento_create');
    }
}
