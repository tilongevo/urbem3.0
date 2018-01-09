<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Exception;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Folhapagamento\ContratoServidorPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\Evento;
use Urbem\CoreBundle\Entity\Folhapagamento\EventoCalculado;
use Urbem\CoreBundle\Entity\Folhapagamento\LogErroCalculo;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEvento;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoParcela;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoPeriodo;
use Urbem\CoreBundle\Entity\Folhapagamento\UltimoRegistroEvento;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\EventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoPeriodoModel;
use Urbem\CoreBundle\Model\Folhapagamento\UltimoRegistroEventoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoModel;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class RegistroEventoPeriodoImportarAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_registro_evento_periodo_importar';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/registro-evento-periodo-importar';
    protected $arEventosCadastrados = [];

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

        $fieldOptions['arquivo'] = [
            'mapped' => false
        ];

        $fieldOptions['delimitadorCasa'] = [
            'label' => 'label.recursosHumanos.folhas.folhaSalario.delimitadorCasa',
            'mapped' => false,
            'choices' => [
                'Últimos dois algarismos' => ' ',
                'Vírgula' => ',',
                'Ponto' => '.',
            ],
            'expanded' => false,
            'multiple' => false,
            'attr' => [
                'required' => true,
                'class' => 'select2-parameters '
            ],
        ];

        $fieldOptions['delimitadorColuna'] = [
            'label' => 'label.recursosHumanos.folhas.folhaSalario.delimitadorColuna',
            'mapped' => false,
            'attr' => [
                'required' => true,
                'maxlength' => 1
            ],
            'data' => ';'
        ];

        $arColunas = [
            "Matrícula" => "contrato", "Evento" => "evento", "Valor" => "valor", "Quantidade" => "quantidade",
            "Quantidade Parcelas" => "quantidadeParcelas", "Meses de Carência" => "mesesCarencia"
        ];

        $fieldOptions['coluna1'] = [
            'label' => 'label.recursosHumanos.folhas.folhaSalario.coluna1',
            'mapped' => false,
            'choices' => $arColunas,
            'expanded' => false,
            'multiple' => false,
            'attr' => [
                'required' => true,
                'class' => 'select2-parameters '
            ],
        ];

        $fieldOptions['coluna2'] = $fieldOptions['coluna1'];
        $fieldOptions['coluna2']['data'] = 'evento';
        $fieldOptions['coluna2']['label'] = 'label.recursosHumanos.folhas.folhaSalario.coluna2';

        $fieldOptions['coluna3'] = $fieldOptions['coluna1'];
        $fieldOptions['coluna3']['data'] = 'valor';
        $fieldOptions['coluna3']['label'] = 'label.recursosHumanos.folhas.folhaSalario.coluna3';

        $fieldOptions['coluna4'] = $fieldOptions['coluna1'];
        $fieldOptions['coluna4']['data'] = 'quantidade';
        $fieldOptions['coluna4']['label'] = 'label.recursosHumanos.folhas.folhaSalario.coluna4';

        $fieldOptions['coluna5'] = $fieldOptions['coluna1'];
        $fieldOptions['coluna5']['data'] = 'quantidadeParcelas';
        $fieldOptions['coluna5']['label'] = 'label.recursosHumanos.folhas.folhaSalario.coluna5';

        $fieldOptions['coluna6'] = $fieldOptions['coluna1'];
        $fieldOptions['coluna6']['data'] = 'mesesCarencia';
        $fieldOptions['coluna6']['label'] = 'label.recursosHumanos.folhas.folhaSalario.coluna6';

        $formMapper
            ->with('Folha/Importação')
            ->add('codPeriodoMovimentacao', 'hidden', ['mapped' => false, 'data' => $codPeriodoMovimentacao])
            ->add('arquivo', 'file', $fieldOptions['arquivo'])
            ->add('delimitadorCasa', 'choice', $fieldOptions['delimitadorCasa'])
            ->add('delimitadorColuna', 'text', $fieldOptions['delimitadorColuna'])
            ->add('coluna1', 'choice', $fieldOptions['coluna1'])
            ->add('coluna2', 'choice', $fieldOptions['coluna2'])
            ->add('coluna3', 'choice', $fieldOptions['coluna3'])
            ->add('coluna4', 'choice', $fieldOptions['coluna4'])
            ->add('coluna5', 'choice', $fieldOptions['coluna5'])
            ->add('coluna6', 'choice', $fieldOptions['coluna6'])
            ->end();
    }

    /**
     * @param ErrorElement          $errorElement
     * @param RegistroEventoPeriodo $registroEventoPeriodo
     *
     * @throws Exception
     */
    public function validate(ErrorElement $errorElement, $registroEventoPeriodo)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var RegistroEventoModel $registroEventoModel */
        $registroEventoModel = new RegistroEventoModel($em);

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $codPeriodoMovimentacao = $periodoFinal->getCodPeriodoMovimentacao();

        /** @var ConfiguracaoModel $configuracaoModel */
        $configuracaoModel = new ConfiguracaoModel($em);
        $stMascara = $configuracaoModel->getConfiguracao('mascara_evento', $configuracaoModel::MODULO_RH_FOLHAPAGAMENTO, true);

        $form = $this->getForm();
        $delimitadorCasa = $form->get('delimitadorCasa')->getData();
        $delimitadorColuna = $form->get('delimitadorColuna')->getData();
        $erro = [];
        $file = $this->getForm()->get('arquivo')->getViewData();
        $handle = @fopen($file, 'r');
        $stErroArquivo = [];

        for ($i = 1; $i <= 6; $i++) {
            for ($j = $i + 1; $j <= 6; $j++) {
                if ($form->get("coluna" . $i)->getData() == $form->get("coluna" . $j)->getData()) {
                    $stErroArquivo[] = "Coluna $i é igual a coluna $j.";
                }
            }
        }
        if (!empty($stErroArquivo)) {
            $errorElement->addViolation($stErroArquivo)->end();
        } else {
            try {
                if ($handle) {
                    //Monta colunas do arquivo
                    for ($i = 1; $i <= 6; $i++) {
                        $inColuna = $i - 1;
                        switch ($form->get("coluna" . $i)->getData()) {
                            case "contrato":
                                $inColContrato = $inColuna;
                                break;
                            case "evento":
                                $inColEvento = $inColuna;
                                break;
                            case "valor":
                                $inColValor = $inColuna;
                                break;
                            case "quantidade":
                                $inColQuantidade = $inColuna;
                                break;
                            case "quantidadeParcelas":
                                $inColQuantidadeParcelas = $inColuna;
                                break;
                            case "mesesCarencia":
                                $inColMesesCarencia = $inColuna;
                                break;
                        }
                    }

                    $inId = 0;
                    while (!feof($handle)) {
                        $stErroLinha = "Erro";
                        $arLinhas = fgetcsv($handle, 8096, $delimitadorColuna, "\"");
                        if ($arLinhas != '') {
                            /** @var EventoModel $eventoModel */
                            $eventoModel = new EventoModel($em);
                            /** @var Evento $rsEvento */
                            $rsEvento = $eventoModel->getEventoByCodEvento($arLinhas[$inColEvento]);
                            $stErroLinha .= $registroEventoModel->validaRegistroContrato($arLinhas[$inColContrato]);
                            $stErroLinha .= $registroEventoModel->validaCodigoEvento($arLinhas[$inColEvento], $stMascara);
                            $stErroLinha .= $registroEventoModel->validaValor($arLinhas[$inColValor], $delimitadorCasa);
                            $stErroLinha .= $registroEventoModel->validaValor($arLinhas[$inColQuantidade], $delimitadorCasa, 'quantidade informada inválida');
                            $stErroLinha .= $registroEventoModel->validaInteiro($arLinhas[$inColQuantidadeParcelas]);
                            $stErroLinha .= $registroEventoModel->validaEventoImportacao(
                                $arLinhas[$inColContrato],
                                $arLinhas[$inColEvento],
                                $arLinhas[$inColValor],
                                $arLinhas[$inColQuantidade],
                                $arLinhas[$inColQuantidadeParcelas],
                                $arLinhas[$inColMesesCarencia],
                                $rsEvento->getFixado(),
                                $rsEvento->getApresentaParcela(),
                                $codPeriodoMovimentacao,
                                $stMascara
                            );

                            $inId = $inId + 1;
                            if ($stErroLinha == "Erro") {
                                $stErroLinha = "Ok";

                                $arEvento['inId'] = $inId;
                                $arEvento['registro'] = $arLinhas[$inColContrato] ? $arLinhas[$inColContrato] : "&nbsp;";
                                $arEvento['inCodigoEvento'] = $registroEventoModel->formataEvento($arLinhas[$inColEvento], $stMascara);
                                $arEvento['cod_evento'] = $rsEvento->getCodEvento();
                                $arEvento['valor'] = $registroEventoModel->formataValor($arLinhas[$inColValor], $delimitadorCasa);
                                $arEvento['quantidade'] = $registroEventoModel->formataValor($arLinhas[$inColQuantidade], $delimitadorCasa);
                                $arEvento['parcelas'] = $arLinhas[$inColQuantidadeParcelas] ? $arLinhas[$inColQuantidadeParcelas] : "&nbsp;";
                                $arEvento['stHdnFixado'] = $rsEvento->getFixado() ? $rsEvento->getFixado() : "&nbsp;";
                                $arEvento['stHdnApresentaParcela'] = $rsEvento->getApresentaParcela() ? $rsEvento->getApresentaParcela() : "&nbsp;";
                                $arEvento['stSituacao'] = $stErroLinha;
                                $arEvento['boExcluirDisabled'] = "true";
                                $arEvento['mes_carencia'] = $arLinhas[$inColMesesCarencia] ? $arLinhas[$inColMesesCarencia] : "0";

                                $this->arEventosCadastrados[] = $arEvento;
                            } else {
                                $erro[$inId]['mensagem'] = ['Linha ' . $inId . ' está com ' . $stErroLinha];
                            }
                        }
                    }
                }

                if (!empty($erro)) {
                    foreach ($erro as $er) {
                        $errorElement->with('arquivo')->addViolation($er['mensagem'])->end();
                    }
                }
            } catch (Exception $e) {
                throw $e;
                $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('flash_create_error'));
            }
        }
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

        /** @var ContratoModel $contratoModel */
        $contratoModel = new ContratoModel($em);
        $container = $this->getContainer();

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        /** @var RegistroEventoPeriodoModel $registroEventoPeriodoModel */
        $registroEventoPeriodoModel = new RegistroEventoPeriodoModel($em);
        /** @var RegistroEventoModel $registroEventoModel */
        $registroEventoModel = new RegistroEventoModel($em);
        /** @var UltimoRegistroEventoModel $ultimoRegistroEventoModel */
        $ultimoRegistroEventoModel = new UltimoRegistroEventoModel($em);

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $codPeriodoMovimentacao = $periodoFinal->getCodPeriodoMovimentacao();


        try {
            foreach ($this->arEventosCadastrados as $eventosCadastrado) {
                $filtro = " AND registro_evento_periodo.cod_contrato = " . $eventosCadastrado['registro'];
                $filtro = " AND registro_evento_periodo.cod_contrato = " . $eventosCadastrado['registro'];
                $filtro .= " AND cod_periodo_movimentacao = " . $codPeriodoMovimentacao;
                $filtro .= " AND registro_evento.cod_evento = " . $eventosCadastrado['cod_evento'];
                $filtro .= " AND proporcional IS FALSE";

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
                        'codContrato' => $eventosCadastrado['registro']
                    ]
                );

                if (!is_null($contratoServidorPeriodo)) {
                    /** @var RegistroEventoPeriodo $registroEventoPeriodoObject */
                    $registroEventoPeriodoObject = $registroEventoPeriodoModel->buildOne($contratoServidorPeriodo);

                    /** @var Evento $eventoObject */
                    $eventoObject = $em->getRepository(Evento::class)->findOneBy(['codEvento' => $eventosCadastrado['cod_evento']]);

                    /** @var RegistroEvento $registroEventoObject */
                    $registroEventoObject = $registroEventoModel->buildOneBasedEvento($eventoObject, $registroEventoPeriodoObject);

                    /** @var UltimoRegistroEvento $ultimoRegistroEvento */
                    $ultimoRegistroEvento = $ultimoRegistroEventoModel->buildOneBasedRegistroEvento($registroEventoObject);

                    $registroEventoPeriodoObject->addFkFolhapagamentoRegistroEventos($registroEventoObject);

                    $em->persist($registroEventoObject);
                    $em->flush();
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
        $this->redirectByRoute('urbem_recursos_humanos_folha_pagamento_registro_evento_periodo_importar_create');
    }

    /**
     * @param mixed $object
     *
     * @return string
     */
    public function toString($object)
    {
        return (string) 'Importação de Arquivo de Eventos';
    }
}
