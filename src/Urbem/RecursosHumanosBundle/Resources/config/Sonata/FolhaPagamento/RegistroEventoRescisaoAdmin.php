<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculado;
use Urbem\CoreBundle\Entity\Folhapagamento\EventoRescisaoCalculadoDependente;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisao;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoRescisaoParcela;
use Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoRescisao;
use Urbem\CoreBundle\Entity\Pessoal\Cargo;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Entity\Pessoal\Especialidade;
use Urbem\CoreBundle\Entity\Pessoal\SubDivisao;
use Urbem\CoreBundle\Model\Folhapagamento\ContratoServidorPeriodoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoRescisaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\UltimoRegistroEventoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class RegistroEventoRescisaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_registro_evento_rescisao';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/registro-evento-rescisao';

    protected $includeJs = [
        '/recursoshumanos/javascripts/folhapagamento/registroEventoRescisao.js'
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
            $tipo = $formData['tipo'];
        } else {
            $tipo = $this->request->get('tipo');
            if (strpos($route, 'edit')) {
                /** @var RegistroEventoRescisao $registroEvento */
                $registroEvento = $this->getSubject($this->getAdminRequestId());
                $codPeriodoMovimentacao = $registroEvento->getFkFolhapagamentoContratoServidorPeriodo()->getCodPeriodoMovimentacao();
                $codContrato = $registroEvento->getCodContrato();
            } else {
                list($codPeriodoMovimentacao, $codContrato) = explode("~", $id);
            }
        }

        $tipo = (isset($tipo)) ? $tipo : 'F';
        /** @var RegistroEventoRescisao $registroEvento */
        $registroEvento = $this->getSubject();

        $em = $this->modelManager->getEntityManager($this->getClass());
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

        $exercicio = $this->getExercicio();
        $anoMesCompetencia = $periodoFinal->getDtFinal()->format('Ym');

        $filtro = "AND  contrato.cod_contrato =" . $codContrato;

        /** @var RegistroEventoRescisaoModel $registroEventoRescisaoModel */
        $registroEventoRescisaoModel = new RegistroEventoRescisaoModel($em);
        $contratoRescindido = $registroEventoRescisaoModel->recuperaRescisaoContrato($exercicio, $filtro);

        if (empty($contratoRescindido)) {
            $contratoRescindido = $registroEventoRescisaoModel->recuperaRescisaoContratoPensionista($exercicio, '', $anoMesCompetencia, $filtro);
        }

        /** @var ContratoServidorPeriodo $contratoServidorPeriodo */
        $contratoServidor = $em->getRepository(ContratoServidor::class)->findOneBy(
            [
                'codContrato' => $codContrato,
            ]
        );

        /** @var RegistroEventoRescisaoModel $registroEventoRescisaoModel */
        $registroEventoRescisaoModel = new RegistroEventoRescisaoModel($em);
        $eventosCadastrados = $registroEventoRescisaoModel->recuperaRegistrosEventosDoContrato(
            $codContrato
        );

        foreach ($eventosCadastrados as $eventos) {
            $eventosCadastradosArray[] = str_pad($eventos['cod_evento'], 5, '0', STR_PAD_LEFT);
        }

        $codEventos = array_diff($codEventos, $eventosCadastradosArray);

        if (empty($codEventos)) {
            $codEventos[] = '00000';
        }


        /** @var Cargo $cargo */
        $cargo = ($contratoServidor->getFkPessoalContratoServidorFuncoes()->last()) ? $contratoServidor->getFkPessoalContratoServidorFuncoes()->last()->getFkPessoalCargo() : null;
        $codCargo = (is_object($cargo)) ? $cargo->getCodCargo() : $codCargo;

        /** @var SubDivisao $subDivisao */
        $subDivisao = ($cargo) ? $cargo->getFkPessoalCargoSubDivisoes()->last()->getFkPessoalSubDivisao() : null;
        $codSubDivisao = (is_object($subDivisao)) ? $subDivisao->getCodSubDivisao() : $codSubDivisao;

        /** @var Especialidade $especialidade */
        $especialidade = ($cargo) ? $cargo->getFkPessoalEspecialidades()->last() : null;
        $codEspecialidade = (is_object($especialidade)) ? $especialidade->getCodEspecialidade() : $codEspecialidade;

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
            'choices' => [
                "Saldo Salário" => "S",
                "Aviso Prévio Indenizado" => "A",
                "Férias Vencidas" => "V",
                "Férias Proporcionais" => "P",
                "13º Salário" => "D",
            ],
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
            $eventoParcela = $registroEvento->getFkFolhapagamentoUltimoRegistroEventoRescisao()->getFkFolhapagamentoRegistroEventoRescisaoParcela();
            if ($eventoParcela) {
                $formOptions['qtdeParcela']['data'] = $registroEvento->getFkFolhapagamentoUltimoRegistroEventoRescisao()->getFkFolhapagamentoRegistroEventoParcela()->getParcela();
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
            ->add('fkFolhapagamentoEvento', null, $formOptions['fkFolhapagamentoEvento'])
            ->add('valor', null, $formOptions['valor'])
            ->add('quantidade', null, $formOptions['quantidade'])
            ->add('desdobramento', 'choice', $formOptions['desdobramento'])
            ->add('parcela', 'text', $formOptions['parcela'])
            ->add('qtdeParcela', 'text', $formOptions['qtdeParcela'])
            ->add('textoComplementar', 'textarea', ['mapped' => false, 'label' => 'Texto Complementar', 'attr' => ['readonly' => 'readonly']])
            ->end();
    }

    /**
     * @param RegistroEventoRescisao $registroEventoRescisao
     */
    public function prePersist($registroEventoRescisao)
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

        /** @var Contrato $contrato */
        $contrato = $em->getRepository(Contrato::class)->findOneBy(
            [
                'codContrato' => $codContrato
            ]
        );

        /** @var PeriodoMovimentacaoModel $periodoMovimentacaoModel */
        $periodoMovimentacaoModel = new PeriodoMovimentacaoModel($em);
        $periodoMovimentacao = $periodoMovimentacaoModel->findOneByCodPeriodoMovimentacao($codPeriodoMovimentacao);


        /** @var ContratoServidorPeriodoModel $contratoServidorPeriodoModel */
        $contratoServidorPeriodoModel = new ContratoServidorPeriodoModel($em);
        $contratoServidorPeriodo = $contratoServidorPeriodoModel->findOrCreateContratoServidorPeriodo($periodoMovimentacao, $contrato);


        /** @var RegistroEventoRescisaoModel $registroEventoRescisaoModel */
        $registroEventoRescisaoModel = new RegistroEventoRescisaoModel($em);
        $registroEventoRescisao->setCodRegistro($registroEventoRescisaoModel->getNextCodRegistro($registroEventoRescisao->getCodEvento()));
        $registroEventoRescisao->setFkFolhapagamentoContratoServidorPeriodo($contratoServidorPeriodo);
    }

    /**
     * @param RegistroEventoRescisao $registroEventoRescisao
     */
    public function postPersist($registroEventoRescisao)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();
        $parcela = $form->get('parcela')->getData();
        /** @var RegistroEventoRescisaoModel $registroEventoRescisaoModel */
        $registroEventoRescisaoModel = new RegistroEventoRescisaoModel($em);

        /** @var UltimoRegistroEventoRescisao $ultimoRegistroEventoRescisao */
        $ultimoRegistroEventoRescisao = new UltimoRegistroEventoRescisao();
        $ultimoRegistroEventoRescisao->setFkFolhapagamentoRegistroEventoRescisao($registroEventoRescisao);
        $registroEventoRescisaoModel->save($ultimoRegistroEventoRescisao);

        /** @var EventoRescisaoCalculado $eventoRescisaoCalculado */
        $eventoRescisaoCalculado = new EventoRescisaoCalculado();
        $eventoRescisaoCalculado->setFkFolhapagamentoUltimoRegistroEventoRescisao($ultimoRegistroEventoRescisao);
        $eventoRescisaoCalculado->setQuantidade($registroEventoRescisao->getQuantidade());
        $eventoRescisaoCalculado->setValor($registroEventoRescisao->getValor());

        /** @var EventoRescisaoCalculadoDependente $eventoRescisaoCalculadoDependente */
        $eventoRescisaoCalculadoDependente = new EventoRescisaoCalculadoDependente();
        $eventoRescisaoCalculadoDependente->setFkFolhapagamentoEventoRescisaoCalculado($eventoRescisaoCalculado);
        $registroEventoRescisaoModel->save($eventoRescisaoCalculado);

        if ($parcela) {
            /** @var RegistroEventoRescisaoParcela $registroEventoRescisaoParcela */
            $registroEventoRescisaoParcela = new RegistroEventoRescisaoParcela($ultimoRegistroEventoRescisao);
            $registroEventoRescisaoParcela->setFkFolhapagamentoUltimoRegistroEventoRescisao($ultimoRegistroEventoRescisao);
            $registroEventoRescisaoParcela->setParcela($parcela);
            $registroEventoRescisaoModel->save($registroEventoRescisaoParcela);
        }

        $registroEventoRescisao->setFkFolhapagamentoUltimoRegistroEventoRescisao($ultimoRegistroEventoRescisao);
        $this->forceRedirect("/recursos-humanos/folha-pagamento/contrato-servidor-periodo-rescisao/{$this->getObjectKey($registroEventoRescisao->getFkFolhapagamentoContratoServidorPeriodo()->getFkPessoalContrato())}/detalhes-rescisao");
    }

    /**
     * @param RegistroEventoRescisao $registroEventoRescisao
     */
    public function preRemove($registroEventoRescisao)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        /** @var UltimoRegistroEventoRescisao $ultimoRegistroEventoRescisao */
        $ultimoRegistroEventoRescisao = $registroEventoRescisao->getFkFolhapagamentoUltimoRegistroEventoRescisao();
        $ultimoRegistroEventoRescisaoModel = new UltimoRegistroEventoModel($em);
        $ultimoRegistroEventoRescisaoModel->montaDeletarUltimoRegistro(
            $ultimoRegistroEventoRescisao->getCodRegistro(),
            $ultimoRegistroEventoRescisao->getCodEvento(),
            $ultimoRegistroEventoRescisao->getDesdobramento(),
            $ultimoRegistroEventoRescisao->getTimestamp()->format('Y-m-d H:i:s'),
            'R'
        );
    }

    /**
     * @param RegistroEventoRescisao $registroEventoRescisao
     */
    public function postRemove($registroEventoRescisao)
    {
        $this->forceRedirect("/recursos-humanos/folha-pagamento/contrato-servidor-periodo-rescisao/{$this->getObjectKey($registroEventoRescisao->getFkFolhapagamentoContratoServidorPeriodo()->getFkPessoalContrato())}/detalhes-rescisao");
    }

    /**
     * @param RegistroEventoRescisao $registroEventoRescisao
     */
    public function postUpdate($registroEventoRescisao)
    {
        $this->forceRedirect("/recursos-humanos/folha-pagamento/contrato-servidor-periodo-rescisao/{$this->getObjectKey($registroEventoRescisao->getFkFolhapagamentoContratoServidorPeriodo()->getFkPessoalContrato())}/detalhes-rescisao");
    }
}
