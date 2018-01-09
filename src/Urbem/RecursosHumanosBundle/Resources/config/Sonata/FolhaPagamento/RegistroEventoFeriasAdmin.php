<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFeriasParcela;
use Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEventoFerias;
use Urbem\CoreBundle\Entity\Pessoal\Cargo;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Entity\Pessoal\Especialidade;
use Urbem\CoreBundle\Entity\Pessoal\SubDivisao;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoFeriasModel;
use Urbem\CoreBundle\Model\Folhapagamento\UltimoRegistroEventoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class RegistroEventoFeriasAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_registro_evento_ferias';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/registro-evento-ferias';

    protected $includeJs = [
        '/recursoshumanos/javascripts/folhapagamento/registroEventoFerias.js'
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
                /** @var RegistroEventoFerias $registroEventoFerias */
                $registroEventoFerias = $this->getSubject($this->getAdminRequestId());

                $codPeriodoMovimentacao = $registroEventoFerias->getCodPeriodoMovimentacao();
                $codContrato = $registroEventoFerias->getCodContrato();
            } else {
                list($codPeriodoMovimentacao, $codContrato) = explode("~", $id);
            }
        }

        $tipo = (isset($tipo)) ? $tipo : 'F';
        /** @var RegistroEventoFerias $registroEventoFerias */
        $registroEventoFerias = $this->getSubject();

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
                'codContrato' => $codContrato,
            ]
        );

        /** @var RegistroEventoFeriasModel $registroEventoFeriasModel */
        $registroEventoFeriasModel = new RegistroEventoFeriasModel($em);
        $eventosCadastrados = $registroEventoFeriasModel->recuperaRegistrosEventosDoContrato(
            $codContrato
        );

        foreach ($eventosCadastrados as $eventos) {
            $eventosCadastradosArray[] = str_pad($eventos['cod_evento'], 5, '0', STR_PAD_LEFT);
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
            'choices' => [
                "Abono" => 'A',
                "Férias" => "F",
                "Adiantamento" => "D",
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
                'data' => $registroEventoFerias->getFkFolhapagamentoEvento()
            ];

            $formOptions['quantidade']['data'] = $registroEventoFerias->getQuantidade();
            $formOptions['valor']['data'] = $registroEventoFerias->getValor();
            $eventoParcela = $registroEventoFerias->getFkFolhapagamentoUltimoRegistroEventoFerias()->getFkFolhapagamentoRegistroEventoFeriasParcela();
            if ($eventoParcela) {
                $formOptions['qtdeParcela']['data'] = $registroEventoFerias->getFkFolhapagamentoUltimoRegistroEventoFerias()->getFkFolhapagamentoRegistroEventoFeriasParcela()->getParcela();
                $formOptions['mesCarencia']['data'] = $registroEventoFerias->getFkFolhapagamentoUltimoRegistroEventoFerias()->getFkFolhapagamentoRegistroEventoFeriasParcela()->getMesCarencia();
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
     * @param RegistroEventoFerias $registroEventoFerias
     */
    public function prePersist($registroEventoFerias)
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

        /** @var RegistroEventoFeriasModel $registroEventoFeriasModel */
        $registroEventoFeriasModel = new RegistroEventoFeriasModel($em);
        $registroEventoFerias->setCodRegistro($registroEventoFeriasModel->getNextCodRegistro($registroEventoFerias->getCodEvento()));
        $registroEventoFerias->setFkFolhapagamentoContratoServidorPeriodo($contratoServidorPeriodo);
    }

    /**
     * @param RegistroEventoFerias $registroEventoFerias
     */
    public function postPersist($registroEventoFerias)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();
        $parcela = $form->get('parcela')->getData();
        $registroEventoFeriasModel = new RegistroEventoFeriasModel($em);

        /** @var UltimoRegistroEventoFerias $ultimoRegistroEventoFerias */
        $ultimoRegistroEventoFerias = new UltimoRegistroEventoFerias();
        $ultimoRegistroEventoFerias->setFkFolhapagamentoRegistroEventoFerias($registroEventoFerias);
        $registroEventoFeriasModel->save($ultimoRegistroEventoFerias);

        if ($parcela) {
            /** @var RegistroEventoFeriasParcela $registroEventoFeriasParcela */
            $registroEventoFeriasParcela = new RegistroEventoFeriasParcela($ultimoRegistroEventoFerias);
            $registroEventoFeriasParcela->setFkFolhapagamentoUltimoRegistroEventoFerias($ultimoRegistroEventoFerias);
            $registroEventoFeriasParcela->setParcela($parcela);
            $registroEventoFeriasModel->save($registroEventoFeriasParcela);
        }

        $registroEventoFerias->setFkFolhapagamentoUltimoRegistroEventoFerias($ultimoRegistroEventoFerias);
        $this->forceRedirect("/recursos-humanos/folha-pagamento/contrato-servidor-periodo-ferias/{$this->getObjectKey($registroEventoFerias->getFkFolhapagamentoContratoServidorPeriodo())}/show");
    }

    /**
     * @param RegistroEventoFerias $registroEventoFerias
     */
    public function preRemove($registroEventoFerias)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        /** @var UltimoRegistroEventoFerias $ultimoRegistroEventoFerias */
        $ultimoRegistroEventoFerias = $registroEventoFerias->getFkFolhapagamentoUltimoRegistroEventoFerias();
        $ultimoRegistroEventoFeriasModel = new UltimoRegistroEventoModel($em);
        $ultimoRegistroEventoFeriasModel->montaDeletarUltimoRegistro(
            $ultimoRegistroEventoFerias->getCodRegistro(),
            $ultimoRegistroEventoFerias->getCodEvento(),
            $ultimoRegistroEventoFerias->getDesdobramento(),
            $ultimoRegistroEventoFerias->getTimestamp()->format('Y-m-d H:i:s'),
            'F'
        );
    }

    /**
     * @param RegistroEventoFerias $registroEventoFerias
     */
    public function postRemove($registroEventoFerias)
    {
        $this->forceRedirect("/recursos-humanos/folha-pagamento/contrato-servidor-periodo-ferias/{$this->getObjectKey($registroEventoFerias->getFkFolhapagamentoContratoServidorPeriodo())}/show");
    }

    /**
     * @param RegistroEventoFerias $registroEventoFerias
     */
    public function postUpdate($registroEventoFerias)
    {
        $this->forceRedirect("/recursos-humanos/folha-pagamento/contrato-servidor-periodo-ferias/{$this->getObjectKey($registroEventoFerias->getFkFolhapagamentoContratoServidorPeriodo())}/show");
    }
}
