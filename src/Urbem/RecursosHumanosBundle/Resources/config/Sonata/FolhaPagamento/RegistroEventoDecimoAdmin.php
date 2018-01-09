<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimo;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoDecimoParcela;
use Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoDecimo;
use Urbem\CoreBundle\Entity\Pessoal\Cargo;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Entity\Pessoal\Especialidade;
use Urbem\CoreBundle\Entity\Pessoal\SubDivisao;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoDecimoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\UltimoRegistroEventoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class RegistroEventoDecimoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_registro_evento_decimo';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/registro-evento-decimo';

    protected $includeJs = [
        '/recursoshumanos/javascripts/folhapagamento/registroEventoDecimo.js'
    ];

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb(['id' => $id]);
        $route = $this->getRequest()->get('_sonata_name');

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codPeriodoMovimentacao = $formData['codPeriodoMovimentacao'];
            $codContrato = $formData['codContrato'];
            /** @var RegistroEventoDecimo $registroEvento */
            $registroEvento = $this->getSubject();
            $tipo = $formData['tipo'];
        } else {
            $tipo = $this->request->get('tipo');
            if (strpos($route, 'edit')) {
                /** @var RegistroEventoDecimo $registroEvento */
                $registroEvento = $this->getSubject($this->getAdminRequestId());

                $codPeriodoMovimentacao = $registroEvento->getCodPeriodoMovimentacao();
                $codContrato = $registroEvento->getCodContrato();
            } else {
                list($codPeriodoMovimentacao, $codContrato) = explode("~", $id);
            }
        }

        $tipo = (isset($tipo)) ? $tipo : 'F';

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var EventoModel $eventoModel */
        $eventoModel = new EventoModel($em);
        $eventoArray = $eventoModel->getEventoByParams(['P', 'D', 'B', 'I'], false, $tipo);
        $codEventos = $eventosCadastradosArray = [];
        foreach ($eventoArray as $evento) {
            $codEventos[] = $evento;
        }

        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $codPeriodoMovimentacao = $periodoFinal->getCodPeriodoMovimentacao();

        $codSubDivisao = $codCargo = $codEspecialidade = null;

        /** @var ContratoServidorPeriodo $contratoServidorPeriodo */
        $contratoServidorPeriodo = $em->getRepository(ContratoServidorPeriodo::class)->findOneBy(
            [
                'codPeriodoMovimentacao' => $codPeriodoMovimentacao,
                'codContrato' => $codContrato,
            ]
        );

        if (empty($codEventos)) {
            $codEventos[] = '00000';
        }

        /** @var ContratoServidor $contratoServidor */
        $contratoServidor = $contratoServidorPeriodo->getFkPessoalContrato()->getFkPessoalContratoServidor();

        /** @var Cargo $cargo */
        $cargo = ($contratoServidor->getFkPessoalContratoServidorFuncoes()->last()) ? $contratoServidor->getFkPessoalContratoServidorFuncoes()->last()->getFkPessoalCargo() : null;
        $codCargo = (is_object($cargo)) ? $cargo->getCodCargo() : $codCargo;

        /** @var SubDivisao $subDivisao */
        $subDivisao = ($cargo) ? $cargo->getFkPessoalCargoSubDivisoes()->last()->getFkPessoalSubDivisao() : null;
        $codSubDivisao = (is_object($subDivisao)) ? $subDivisao->getCodSubDivisao() : $codSubDivisao;

        /** @var Especialidade $especialidade */
        $especialidade = ($cargo) ? $cargo->getFkPessoalEspecialidades()->last() : null;
        $codEspecialidade = (is_object($especialidade)) ? $especialidade->getCodEspecialidade() : $codEspecialidade;

        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($em);
        $inMesCalculoDecimo = (int) $configuracaoModel->getConfiguracao(
            'mes_calculo_decimo',
            Modulo::MODULO_FOLHAPAGAMENTO,
            true
        );

        $inMesCompetencia = (int) $periodoFinal->getDtFinal()->format('m');

        $desdobramentoArray = [];

        if ($inMesCompetencia == 12) {
            $desdobramentoArray = ['13º Salário' => 'D' , 'Complemento 13º Salario' => 'C'];
        }
        if ($inMesCompetencia < $inMesCalculoDecimo) {
            $desdobramentoArray = ['Adiantamento' => "A"];
        }
        if (($inMesCompetencia == $inMesCalculoDecimo) && ($inMesCalculoDecimo != 12)) {
            $desdobramentoArray = ['13º Salário' => 'D'];
        }

        $formOptions['quantidade'] = [
            'attr' => [
                'class' => 'money '
            ],
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.quantidade',
            'data' => 0
        ];

        $formOptions['parcela'] = [
            'attr' => [
                'class' => 'money ',
                'readonly' => 'readonly'
            ],
            'mapped' => false,
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.parcela',
        ];

        $formOptions['valor'] = [
            'attr' => [
                'class' => 'money ',
                'readonly' => 'readonly',
            ],
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.valor',
            'data' => 0
        ];

        $formOptions['qtdeParcela'] = [
            'attr' => [
                'class' => 'numeric ',
                'readonly' => 'readonly',
            ],
            'mapped' => false,
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.qtdeParcela',
        ];

        $formOptions['desdobramento'] = [
            'choices' => $desdobramentoArray,
            'expanded' => false,
            'multiple' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'placeholder' => 'label.selecione',
            'required' => true
        ];

        if (strpos($route, 'edit')) {
            $formOptions['fkFolhapagamentoEvento'] = [
                'class' => Evento::class,
                'label' => 'label.recursosHumanos.contratoServidorPeriodo.evento',
                'attr' => [
                    'class' => 'select2-parameters '
                ],
                'placeholder' => 'label.selecione',
                'data' => $registroEvento->getFkFolhapagamentoEvento()
            ];

            $formOptions['quantidade']['data'] = $registroEvento->getQuantidade();
            $formOptions['valor']['data'] = $registroEvento->getValor();
            $eventoParcela = $registroEvento->getFkFolhapagamentoUltimoRegistroEventoDecimo()->getFkFolhapagamentoRegistroEventoDecimoParcela();
            if ($eventoParcela) {
                $formOptions['qtdeParcela']['data'] = $registroEvento->getFkFolhapagamentoUltimoRegistroEventoDecimo()->getFkFolhapagamentoUltimoRegistroEventoDecimo()->getParcela();
                $formOptions['mesCarencia']['data'] = $registroEvento->getFkFolhapagamentoUltimoRegistroEventoDecimo()->getFkFolhapagamentoUltimoRegistroEventoDecimo()->getMesCarencia();
            }
        } else {
            $formOptions['fkFolhapagamentoEvento'] = [
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
                'required' => true
            ];
        }

        $formMapper
            ->with('label.recursosHumanos.contratoServidorPeriodo.dadosEvento')
            ->add('codPeriodoMovimentacao', 'hidden', ['mapped' => false, 'data' => $codPeriodoMovimentacao])
            ->add('codContrato', 'hidden', ['mapped' => false, 'data' => $codContrato])
            ->add('codCargo', 'hidden', ['mapped' => false, 'data' => $codCargo])
            ->add('codSubDivisao', 'hidden', ['mapped' => false, 'data' => $codSubDivisao])
            ->add('codEspecialidade', 'hidden', ['mapped' => false, 'data' => $codEspecialidade])
            ->add('tipo', 'hidden', ['mapped' => false, 'data' => $tipo])
            ->add('codEvento', 'entity', $formOptions['fkFolhapagamentoEvento'])
            ->add('valor', null, $formOptions['valor'])
            ->add('quantidade', null, $formOptions['quantidade'])
            ->add('desdobramento', 'choice', $formOptions['desdobramento'])
            ->add('parcela', 'text', $formOptions['parcela'])
            ->add('qtdeParcela', 'text', $formOptions['qtdeParcela'])
            ->add('textoComplementar', 'textarea', ['mapped' => false, 'label' => 'Texto Complementar', 'attr' => ['readonly' => 'readonly']])
            ->end();
    }

    /**
     * @param RegistroEventoDecimo $registroEventoDecimo
     */
    public function prePersist($registroEventoDecimo)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();
        $codPeriodoMovimentacao = $form->get('codPeriodoMovimentacao')->getData();
        $codContrato = $form->get('codContrato')->getData();

        /** @var ContratoServidorPeriodo $contratoServidorPeriodo */
        $contratoServidorPeriodo = $em->getRepository(ContratoServidorPeriodo::class)->findOneBy(
            [
                'codPeriodoMovimentacao' => $codPeriodoMovimentacao,
                'codContrato' => $codContrato
            ]
        );

        $codEvento = is_object($registroEventoDecimo->getCodEvento()) ? $registroEventoDecimo->getCodEvento()->getCodEvento() : $registroEventoDecimo->getCodEvento();
        $registroEventoDecimo->setCodEvento($codEvento);
        /** @var RegistroEventoDecimoModel $registroEventoDecimoModel */
        $registroEventoDecimoModel = new RegistroEventoDecimoModel($em);
        $registroEventoDecimo->setCodRegistro($registroEventoDecimoModel->getNextCodRegistro($codEvento));
        $registroEventoDecimo->setFkFolhapagamentoContratoServidorPeriodo($contratoServidorPeriodo);
    }

    /**
     * @param RegistroEventoDecimo $registroEventoDecimo
     */
    public function postPersist($registroEventoDecimo)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();
        $parcela = $form->get('parcela')->getData();
        /** @var RegistroEventoDecimoModel $registroEventoDecimoModel */
        $registroEventoDecimoModel = new RegistroEventoDecimoModel($em);

        /** @var UltimoRegistroEventoDecimo $ultimoRegistroEventoDecimo */
        $ultimoRegistroEventoDecimo = new UltimoRegistroEventoDecimo();
        $ultimoRegistroEventoDecimo->setFkFolhapagamentoRegistroEventoDecimo($registroEventoDecimo);
        $registroEventoDecimoModel->save($ultimoRegistroEventoDecimo);

        if ($parcela) {
            /** @var RegistroEventoDecimoParcela $registroEventoDecimoParcela */
            $registroEventoDecimoParcela = new RegistroEventoDecimoParcela($ultimoRegistroEventoDecimo);
            $registroEventoDecimoParcela->setFkFolhapagamentoUltimoRegistroEventoDecimo($ultimoRegistroEventoDecimo);
            $registroEventoDecimoParcela->setParcela($parcela);
            $registroEventoDecimoModel->save($registroEventoDecimoParcela);
        }

        $registroEventoDecimo->setFkFolhapagamentoUltimoRegistroEventoDecimo($ultimoRegistroEventoDecimo);
        $this->forceRedirect("/recursos-humanos/folha-pagamento/contrato-servidor-periodo-decimo/{$this->getObjectKey($registroEventoDecimo->getFkFolhapagamentoContratoServidorPeriodo())}/show");
    }

    /**
     * @param RegistroEventoDecimo $registroEventoDecimo
     */
    public function preUpdate($registroEventoDecimo)
    {
        $codEvento = is_object($registroEventoDecimo->getCodEvento()) ? $registroEventoDecimo->getCodEvento()->getCodEvento() : $registroEventoDecimo->getCodEvento();
        $registroEventoDecimo->setCodEvento($codEvento);
    }

    /**
     * @param RegistroEventoDecimo $registroEventoDecimo
     */
    public function preRemove($registroEventoDecimo)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        /** @var UltimoRegistroEventoDecimo $ultimoRegistroEventoDecimo */
        $ultimoRegistroEventoDecimo = $registroEventoDecimo->getFkFolhapagamentoUltimoRegistroEventoDecimo();
        $ultimoRegistroEventoDecimoModel = new UltimoRegistroEventoModel($em);
        $ultimoRegistroEventoDecimoModel->montaDeletarUltimoRegistro(
            $ultimoRegistroEventoDecimo->getCodRegistro(),
            $ultimoRegistroEventoDecimo->getCodEvento(),
            $ultimoRegistroEventoDecimo->getDesdobramento(),
            $ultimoRegistroEventoDecimo->getTimestamp()->format('Y-m-d H:i:s'),
            'D'
        );
    }

    /**
     * @param RegistroEventoDecimo $registroEventoDecimo
     */
    public function postRemove($registroEventoDecimo)
    {
        $this->forceRedirect("/recursos-humanos/folha-pagamento/contrato-servidor-periodo-decimo/{$this->getObjectKey($registroEventoDecimo->getFkFolhapagamentoContratoServidorPeriodo())}/show");
    }

    /**
     * @param RegistroEventoDecimo $registroEventoDecimo
     */
    public function postUpdate($registroEventoDecimo)
    {
        $this->forceRedirect("/recursos-humanos/folha-pagamento/contrato-servidor-periodo-decimo/{$this->getObjectKey($registroEventoDecimo->getFkFolhapagamentoContratoServidorPeriodo())}/show");
    }

    /**
     * @param ErrorElement $errorElement
     * @param RegistroEventoDecimo        $registroEventoDecimo
     */
    public function validate(ErrorElement $errorElement, $registroEventoDecimo)
    {
        $route = $this->getRequest()->get('_sonata_name');
        if (strpos($route, 'create')) {
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());
            $form = $this->getForm();
            $codContrato = $form->get('codContrato')->getData();
            $codEvento = is_object($form->get('codEvento')->getData()) ? $form->get('codEvento')->getData()->getCodEvento() : $form->get('codEvento')->getData();
            $desdobramento = $registroEventoDecimo->getDesdobramento();
            $codPeriodoMovimentacao = $form->get('codPeriodoMovimentacao')->getData();
            $inCodSubDivisao = $form->get('codSubDivisao')->getData();
            $inCodCargo = $form->get('codCargo')->getData();
            $inCodEspecialidade = $form->get('codEspecialidade')->getData();

            $stFiltro  = " AND evento.cod_evento = '".$codEvento."'";
            $stFiltro .= " AND sub_divisao.cod_sub_divisao = ".$inCodSubDivisao;
            $stFiltro .= " AND cargo.cod_cargo = ".$inCodCargo;
            $stFiltro .= ($inCodEspecialidade ) ? " AND especialidade.cod_especialidade = ".$inCodEspecialidade : "";

            $mensagem = '';
            /** @var RegistroEventoModel $registroEventoModel */
            $registroEventoModel = new RegistroEventoModel($em);

            $registros = $registroEventoModel->recuperaRelacionamentoConfiguracao($stFiltro);

            if (!empty($registros)) {
                $mensagem = $this->getTranslator()->trans(
                    'rh.folhas.registroEvento.errors.eventoSemConfiguracao',
                    [],
                    'validators'
                );

                $errorElement->with('codEvento')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
            }

            /** @var RegistroEventoDecimoModel $registroEventoDecimoModel */
            $registroEventoDecimoModel = new RegistroEventoDecimoModel($em);
            $params = [
                'codContrato' => $codContrato,
                'codPeriodoMovimentacao' => $codPeriodoMovimentacao,
                'codEvento' => $codEvento,
                'desdobramento' => $desdobramento,
                'natureza' => 'B'
            ];

            $eventosCadastrados = $registroEventoDecimoModel->montaParametrosRecuperaRelacionamento($params);

            if (!empty($eventosCadastrados)) {
                $mensagem = $this->getTranslator()->trans(
                    'rh.folhas.registroEventoDecimo.errors.registroJaExiste',
                    [
                        '%evento%' => $eventosCadastrados[0]['codigo'] . "-" . $eventosCadastrados[0]['descricao'],
                        '%desdobramento%' => $eventosCadastrados[0]['desdobramento_texto']
                    ],
                    'validators'
                );
                $errorElement->with('codEvento')->addViolation($mensagem)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $mensagem);
            }
        }
    }
}
