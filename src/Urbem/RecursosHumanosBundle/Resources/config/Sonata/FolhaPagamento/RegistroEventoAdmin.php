<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoParcela;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento;
use Urbem\CoreBundle\Entity\Pessoal\Cargo;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Entity\Pessoal\Especialidade;
use Urbem\CoreBundle\Entity\Pessoal\ServidorContratoServidor;
use Urbem\CoreBundle\Entity\Pessoal\SubDivisao;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoPeriodoModel;
use Urbem\CoreBundle\Model\Folhapagamento\UltimoRegistroEventoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class RegistroEventoAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_registro_evento';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/registro-evento';

    protected $includeJs = [
        '/recursoshumanos/javascripts/folhapagamento/registroEvento.js'
    ];

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('recupera_relacionamento_configuracao', 'recupera-relacionamento-configuracao', array(), array(), array(), '', array(), array('POST','GET'))
        ;
    }

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
            $tipo = $formData['tipo'];
        } else {
            $tipo = $this->request->get('tipo');

            if (strpos($route, 'edit')) {
                /** @var RegistroEvento $registroEvento */
                $registroEvento = $this->getSubject($this->getAdminRequestId());

                $codPeriodoMovimentacao = $registroEvento->getFkFolhapagamentoRegistroEventoPeriodo()->getCodPeriodoMovimentacao();
                $codContrato = $registroEvento->getFkFolhapagamentoRegistroEventoPeriodo()->getCodContrato();
            } else {
                list($codPeriodoMovimentacao, $codContrato) = explode("~", $id);
            }
        }

        $tipo = (isset($tipo)) ? $tipo : 'F';
        /** @var RegistroEvento $registroEvento */
        $registroEvento = $this->getSubject();

        $em = $this->modelManager->getEntityManager($this->getClass());
        $eventoModel = new EventoModel($em);
        $eventoArray = $eventoModel->getEventoByParams(['P', 'D'], false, $tipo);
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
                'codContrato' => $codContrato
            ]
        );

        $ultimoRegistroEventoModel = new UltimoRegistroEventoModel($em);
        $eventosCadastrados = $ultimoRegistroEventoModel->montaRecuperaRegistrosEventoDoContrato(
            $contratoServidorPeriodo->getFkPessoalContrato()->getRegistro(),
            $periodoFinal->getCodPeriodoMovimentacao()
        );

        foreach ($eventosCadastrados as $eventos) {
            $eventosCadastradosArray[] = $eventos['codigo'];
        }

        $codEventos = array_diff($codEventos, $eventosCadastradosArray);

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

        /*if ( is_object($this->obRFolhaPagamentoEvento->roUltimoConfiguracaoEvento) ) {
            if ( $this->obRFolhaPagamentoEvento->roUltimoConfiguracaoEvento->getCodConfiguracao() ) {
                $stFiltro .= " AND configuracao_evento_caso.cod_configuracao = ".$this->obRFolhaPagamentoEvento->roUltimoConfiguracaoEvento->getCodConfiguracao();
            }
        }
        */

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

        $formOptions['mesCarencia'] = [
            'attr' => [
                'class' => 'numeric ',
                'readonly' => 'readonly',
            ],
            'mapped' => false,
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.mesCarencia',
        ];

        $formOptions['previsao'] = [
            'attr' => [
                'readonly' => 'readonly',
            ],
            'mapped' => false,
            'label' => 'label.recursosHumanos.contratoServidorPeriodo.previsao',
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
            $eventoParcela = $registroEvento->getFkFolhapagamentoUltimoRegistroEvento()->getFkFolhapagamentoRegistroEventoParcela();
            if ($eventoParcela) {
                $formOptions['qtdeParcela']['data'] = $registroEvento->getFkFolhapagamentoUltimoRegistroEvento()->getFkFolhapagamentoRegistroEventoParcela()->getParcela();
                $formOptions['mesCarencia']['data'] = $registroEvento->getFkFolhapagamentoUltimoRegistroEvento()->getFkFolhapagamentoRegistroEventoParcela()->getMesCarencia();
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

        /**
         * Se aba = 3 e aba = 2 então libera valor e quantidade
         */

        $label = 'label.recursosHumanos.contratoServidorPeriodo.dadosEventoFixo';

        if ($tipo == "V") {
            $label = 'label.recursosHumanos.contratoServidorPeriodo.eventosVariaveisCadastrados';
        } elseif ($tipo == "P") {
            $label = 'label.recursosHumanos.contratoServidorPeriodo.eventosProporcionaisCadastrados';
        }

        $formMapper
            ->with($label)
            ->add('codPeriodoMovimentacao', 'hidden', ['mapped' => false, 'data' => $codPeriodoMovimentacao])
            ->add('codContrato', 'hidden', ['mapped' => false, 'data' => $codContrato])
            ->add('codCargo', 'hidden', ['mapped' => false, 'data' => $codCargo])
            ->add('codSubDivisao', 'hidden', ['mapped' => false, 'data' => $codSubDivisao])
            ->add('codEspecialidade', 'hidden', ['mapped' => false, 'data' => $codEspecialidade])
            ->add('tipo', 'hidden', ['mapped' => false, 'data' => $tipo])
            ->add('fkFolhapagamentoEvento', null, $formOptions['fkFolhapagamentoEvento'])
            ->add('valor', null, $formOptions['valor'])
            ->add('quantidade', null, $formOptions['quantidade'])
            ->add('parcela', 'text', $formOptions['parcela'])
            ->add('qtdeParcela', 'text', $formOptions['qtdeParcela'])
            ->add('mesCarencia', 'text', $formOptions['mesCarencia'])
            ->add('previsao', 'text', $formOptions['previsao'])
            ->add('textoComplementar', 'textarea', ['mapped' => false, 'label' => 'Texto Complementar', 'attr' => ['readonly' => 'readonly']])
            ->end();
    }

    /**
     * @param RegistroEvento $registroEvento
     */
    public function prePersist($registroEvento)
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

        /** @var RegistroEventoPeriodoModel $registroEventoPeriodoModel */
        $registroEventoPeriodoModel = new RegistroEventoPeriodoModel($em);
        $registroEventoPeriodo = $registroEventoPeriodoModel->buildOne($contratoServidorPeriodo);
        $registroEvento->setFkFolhapagamentoRegistroEventoPeriodo($registroEventoPeriodo);
    }

    /**
     * @param RegistroEvento $registroEvento
     */
    public function postPersist($registroEvento)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();
        $parcela = $form->get('parcela')->getData();
        $mesCarencia = $form->get('mesCarencia')->getData();
        $registroEventoPeriodoModel = new RegistroEventoPeriodoModel($em);

        /** @var UltimoRegistroEvento $ultimoRegistroEvento */
        $ultimoRegistroEvento = new UltimoRegistroEvento();
        $ultimoRegistroEvento->setFkFolhapagamentoRegistroEvento($registroEvento);

        $registroEventoPeriodoModel->save($ultimoRegistroEvento);

        if (($parcela) && ($mesCarencia)) {
            /** @var RegistroEventoParcela $registroEventoParcela */
            $registroEventoParcela = new RegistroEventoParcela();
            $registroEventoParcela->setFkFolhapagamentoUltimoRegistroEvento($ultimoRegistroEvento);
            $registroEventoParcela->setMesCarencia($mesCarencia);
            $registroEventoParcela->setParcela($parcela);
            $registroEventoPeriodoModel->save($registroEventoParcela);
        }

        $registroEvento->setFkFolhapagamentoUltimoRegistroEvento($ultimoRegistroEvento);
        $this->forceRedirect("/recursos-humanos/folha-pagamento/contrato-servidor-periodo/{$this->getObjectKey($registroEvento->getFkFolhapagamentoRegistroEventoPeriodo()->getFkFolhapagamentoContratoServidorPeriodo())}/show");
    }

    /**
     * @param RegistroEvento $registroEvento
     */
    public function preRemove($registroEvento)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        /** @var UltimoRegistroEvento $ultimoRegistroEvento */
        $ultimoRegistroEvento = $registroEvento->getFkFolhapagamentoUltimoRegistroEvento();
        $ultimoRegistroEventoModel = new UltimoRegistroEventoModel($em);
        $ultimoRegistroEventoModel->montaDeletarUltimoRegistro(
            $ultimoRegistroEvento->getCodRegistro(),
            $ultimoRegistroEvento->getCodEvento(),
            '',
            $ultimoRegistroEvento->getTimestamp()
        );
    }

    /**
     * @param RegistroEvento $registroEvento
     */
    public function postRemove($registroEvento)
    {
        $this->forceRedirect("/recursos-humanos/folha-pagamento/contrato-servidor-periodo/{$this->getObjectKey($registroEvento->getFkFolhapagamentoRegistroEventoPeriodo()->getFkFolhapagamentoContratoServidorPeriodo())}/show");
    }

    /**
     * @param RegistroEvento $registroEvento
     */
    public function postUpdate($registroEvento)
    {
        $this->forceRedirect("/recursos-humanos/folha-pagamento/contrato-servidor-periodo/{$this->getObjectKey($registroEvento->getFkFolhapagamentoRegistroEventoPeriodo()->getFkFolhapagamentoContratoServidorPeriodo())}/show");
    }
}
