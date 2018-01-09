<?php
namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Urbem\CoreBundle\Entity\Folhapagamento\ConcessaoDecimo;
use Urbem\CoreBundle\Entity\Folhapagamento\ConfiguracaoAdiantamento;
use Urbem\CoreBundle\Model\Folhapagamento\UltimoRegistroEventoDecimoModel;
use Urbem\CoreBundle\Model;

class Folha13SalarioController extends ControllerCore\BaseController
{
    public function indexAction()
    {
        $this->setBreadCrumb();

        return $this->render(
            'RecursosHumanosBundle:FolhaPagamento/Folha13Salario/index.html.twig'
        );
    }

    public function conceder13SalarioAction(Request $request)
    {
        $this->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();

        $regimeModel = $em->getRepository('CoreBundle:Pessoal\Regime');
        $regimeEntity = $regimeModel->getListaRegimeSubdivisaoFuncaoEspecialidade();

        $form = $this->createFormBuilder(array())
            ->add(
                'matricula',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:SwCgmPessoaFisica',
                    'choice_label' => 'numcgm.nomCgm',
                    'label' => 'Matrícula',
                    'multiple' => true,
                    'required' => false,
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                )
            )
            ->add(
                'lotacao',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Organograma\Orgao',
                    'choice_label' => 'siglaOrgao',
                    'label' => 'Lotação',
                    'multiple' => true,
                    'expanded' => false,
                    'required' => false,
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                )
            )
            ->add(
                'local',
                EntityType::class,
                array(
                    'class' => 'CoreBundle:Organograma\Local',
                    'choice_label' => 'descricao',
                    'label' => 'Locais',
                    'multiple' => true,
                    'required' => false,
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                )
            )
            ->add(
                'regime',
                ChoiceType::class,
                array(
                    'label' => 'Regime/Subdivisão/Função/Especialidade',
                    'multiple' => true,
                    'required' => false,
                    'choices' => $regimeEntity,
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                )
            )
            ->add('percentual_pagamento', 'percent', [
                'label' => 'Percentual para Pagamento',
                'attr' => array(
                    'class' => 'money ',
                    'maxlength' => 5
                )
                ])
            ->setAction($this->generateUrl('folhapagamento_folha_13_salario_conceder_registros_13_salario'))
            ->getForm();

        $form->handleRequest($request);
        return $this->render(
            'RecursosHumanosBundle:FolhaPagamento/Folha13Salario/conceder_13_salario.html.twig',
            array('form' => $form->createView())
        );
    }

    public function concederRegistros13SalarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $data = $request->request->get('form');

        $ureModel = $em->getRepository('CoreBundle:Folhapagamento\UltimoRegistroEventoDecimo');
        try{
            $umModel = $em->getRepository('Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao');
            $ultimaMovimentacao = $umModel->montaRecuperaUltimaMovimentacao('');
            $pmModel =  new Model\Folhapagamento\PeriodoMovimentacaoModel($em);
            $configAdiantamentoModel = new Model\Folhapagamento\ConfiguracaoAdiantamentoModel($em);
            $conDecimoModel = new Model\Folhapagamento\ConcessaoDecimoModel($em);
            $matriculas = "";
            if(isset($data['matricula'])){
                $matriculas = implode(",", $data['matricula']);
            }

            $lotacoes = "";
            if(isset($data['locatacao'])){
                $lotacoes = implode(",", $data['locatacao']);
            }

            $locais = "";
            if(isset($data['local'])){
                $locais = implode(",", $data['local']);
            }

            $cargos = "";
            if(isset($data['regime'])){
                $cargos = implode(",", $data['regime']);
            }

            $cdModel = new Model\Folhapagamento\ConcessaoDecimoModel($em);
            $rsContratos = $cdModel->montaRecuperaContratosConcessaoDecimo($ultimaMovimentacao["cod_periodo_movimentacao"], $lotacoes, $locais, $cargos);

            //ARRAY FAKE PARA PODER VISUALISAR OS DADOS
            /*$rsContratos = array(
                array(
                'cod_contrato' => 100,
                'registro' => 1073,
                'numcgm' => 315,
                'nom_cgm' => 'DANIELA SZYMCZAK',
                )
            );*/
            //Recupera os Contratos de Concessão de Décimo
            //recuperaContratosConcessaoDecimo

            $boContinuar = "true";
            $data['stDesdobramento'] = "A";
            $data['boPagEmFolhaSalario'] = "F"; // verificar
            $data['somente_vantagens'] = true; // verificar
            if($data['stDesdobramento'] == "C"){
                $stFiltro  = " AND ultimo_registro_evento_decimo.desdobramento = 'D'";
                $stFiltro .= " AND registro_evento_decimo.cod_periodo_movimentacao = ".$ultimaMovimentacao["cod_periodo_movimentacao"];
                $rsRegistros = $ureModel->recuperaRegistrosDeEventoSemCalculo($stFiltro);
            }

            $arDtFinal = explode("/", $ultimaMovimentacao["dt_final"]);
            $stFiltro  = " WHERE to_char(dt_final,'yyyy') = '".$arDtFinal[2]."'";
            $stOrdem  = " ORDER BY cod_periodo_movimentacao LIMIT 1";

            $rsTodosPeriodos = $pmModel->montaPeriodoMovimentacaoWhitParamns($stFiltro, $stOrdem);

            $arContratos = array();
            $arContratosErro = array();
            $concessaoDescimo = new ConcessaoDecimo();

            if(count($rsContratos) == 0){
                $request->getSession()
                    ->getFlashBag()
                    ->add('error', "Nenhum contrato foi encontrado com os parametros de busca selecionados!");
                return $this->redirectToRoute('folhapagamento_folha_13_salario_index');
            }
            foreach($rsContratos as $contratos){
                $contrato = $em->getRepository('Urbem\CoreBundle\Entity\Pessoal\Contrato')->findOneBy(array('codContrato' => $contratos["cod_contrato"]));
                $concessaoDescimo->setCodContrato($contrato);
                $concessaoDescimo->setDesdobramento($data['stDesdobramento']);
                $pMovimentacao = $pmModel->findOneByCodPeriodoMovimentacao($ultimaMovimentacao["cod_periodo_movimentacao"]);
                $concessaoDescimo->setCodPeriodoMovimentacao($pMovimentacao);
                $concessaoDescimo->setFolhaSalario($data['boPagEmFolhaSalario']);

                $stFiltro  = " WHERE cod_contrato = " . $contratos["cod_contrato"];
                $stFiltro .= "   AND cod_periodo_movimentacao <= ".$ultimaMovimentacao["cod_periodo_movimentacao"];
                $stFiltro .= "   AND cod_periodo_movimentacao >=".$rsTodosPeriodos[0]["cod_periodo_movimentacao"];
                $stFiltro .= "   AND desdobramento = '".$data['stDesdobramento']."'";
                $rsConcessao = $conDecimoModel->montaGeraConcessaoDecimoWithParanms($stFiltro, false);

                if($data['stDesdobramento'] == "A") {
                    if (count($rsConcessao) == 0) {
                        $conDecimoModel->save($concessaoDescimo);

                        $obTFolhaPagamentoConfiguracaoAdiantamento = new ConfiguracaoAdiantamento();
                        $nuPercentualPagamento = str_replace(".", "", $data['percentual_pagamento']);
                        $nuPercentualPagamento = (float)str_replace(",", ".", $nuPercentualPagamento);
                        $obTFolhaPagamentoConfiguracaoAdiantamento->setPercentual($nuPercentualPagamento);
                        $obTFolhaPagamentoConfiguracaoAdiantamento->setVantagensFixas($data['somente_vantagens']);
                        $obTFolhaPagamentoConfiguracaoAdiantamento->setCodContrato($contrato->getCodContrato());
                        $obTFolhaPagamentoConfiguracaoAdiantamento->setCodPeriodoMovimentacao($pMovimentacao->getCodPeriodomovimentacao());
                        $obTFolhaPagamentoConfiguracaoAdiantamento->setDesdobramento($data['stDesdobramento']);

                        $configAdiantamentoModel->save($obTFolhaPagamentoConfiguracaoAdiantamento);

                        //Array para mostrar os contratos que deram certo
                        $inIndex = count($arContratos);
                        $arContratos[$inIndex]['registro']     = $contratos["registro"];
                        $arContratos[$inIndex]['numcgm']       = $contratos["numcgm"];
                        $arContratos[$inIndex]['nom_cgm']      = $contratos["nom_cgm"];
                        $entidade = "";
                        //Incluindo os registros
                        $obErro = $conDecimoModel->montaGeraRegistroDecimo($contrato->getCodContrato(), $ultimaMovimentacao['cod_periodo_movimentacao'], $data['stDesdobramento'], $entidade);
                    }else{
                        $inIndex = count($arContratosErro);
                        $arContratosErro[$inIndex]['registro']     = $contratos["registro"];
                        $arContratosErro[$inIndex]['numcgm']       = $contratos["numcgm"];
                        $arContratosErro[$inIndex]['nom_cgm']      = $contratos["nom_cgm"];
                        $arContratosErro[$inIndex]['motivo']       = "A matrícula já possui concessão de adiantamento de 13º, no exercício";
                    }
                } else {
                    if (count($rsConcessao) == 0) {
                        $conDecimoModel->save($concessaoDescimo);
                        $entidade = "";
                        //Incluindo os registros
                        $obErro = $conDecimoModel->montaGeraRegistroDecimo($contrato->getCodContrato(), $ultimaMovimentacao['cod_periodo_movimentacao'], $data['stDesdobramento'], $entidade);

                        $inIndex = count($arContratos);
                        $arContratos[$inIndex]['registro']     = $contratos["registro"];
                        $arContratos[$inIndex]['numcgm']       = $contratos["numcgm"];
                        $arContratos[$inIndex]['nom_cgm']      = $contratos["nom_cgm"];
                    }else{
                        $inIndex = count($arContratosErro);
                        $arContratosErro[$inIndex]['registro']     = $contratos["registro"];
                        $arContratosErro[$inIndex]['numcgm']       = $contratos["numcgm"];
                        $arContratosErro[$inIndex]['nom_cgm']      = $contratos["nom_cgm"];
                        $arContratosErro[$inIndex]['motivo']       = "A matrícula já possui concessão de Saldo de 13º Salário, no exercício";
                    }
                }
            }

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Sucesso ao emitir o 13 salário!');

            return $this->redirectToRoute('folha_13_salario_finalizada', array('contratosErro' => $arContratosErro,
                'arContratos' => $arContratos
                ));
        }catch (Exception $e){
            $request->getSession()
                ->getFlashBag()
                ->add('error', "Erro ao abrir a folha complementar!");
            throw $e;
        }
        return $this->redirectToRoute('folhapagamento_folha_13_salario_index');
    }

    public function folhaSalario13finalizadaAction(Request $request)
    {
        $this->setBreadCrumb();

        $all = $request->query->all();
        $arContratosErro = "";
        $arContratos = "";

        if(isset($all['contratosErro'])){
            $arContratosErro = $all['contratosErro'];
        }
        if(isset($all['arContratos'])){
            $arContratos = $all['arContratos'];
        }

        return $this->render(
            'RecursosHumanosBundle:FolhaPagamento/Folha13Salario/folha_13_salario_finalizada.html.twig',
            array(
                'contratosErro' => $arContratosErro,
                'arContratos' => $arContratos
            )
        );
    }

    public function cancelar13SalarioAction()
    {
        $this->setBreadCrumb();

        return $this->render(
            'RecursosHumanosBundle:FolhaPagamento/Folha13Salario/cancelar_13_salario.html.twig'
        );
    }

    public function calcular13SalarioAction()
    {
        $this->setBreadCrumb();

        return $this->render(
            'RecursosHumanosBundle:FolhaPagamento/Folha13Salario/calcular_13_salario.html.twig'
        );
    }

    public function consultarFichaFinanceiraAction(Request $request)
    {
        $this->setBreadCrumb();

        $form = $this->createFormBuilder(array())
        ->add(
            'stOpcao',
            ChoiceType::class,
            array(
                'choices' => array(
                    'Matrícula' => 'contrato',
                    'Contrato' => 'cgm_contrato',
                    'Evento' => 'evento'
                ),
                'expanded' => true,
            )
        )
        ->add(
            'inContrato',
            ChoiceType::class,
            array(
                'choices' => array(),
                'placeholder' => 'Selecione'
            )
        )
        ->add(
            'inAno',
            NumberType::class,
            array(
                'data' => date("Y"),
            )
        )
        ->add(
            'inCodMes',
            EntityType::class,
            array (
                'class' => 'CoreBundle:Administracao\Mes',
                'choice_label' => 'descricao',
                'choice_value' => 'codMes',
            )
        )
        ->add(
            'boFiltrarFolhaComplementar',
            CheckboxType::class
        )
        ->add(
            'stConfiguracao',
            EntityType::class,
            array(
                'class' => 'CoreBundle:Folhapagamento\ConfiguracaoEvento',
                'choice_label' => 'descricao',
                'choice_value' => 'codConfiguracao',
            )
        )
        ->add(
            'stOrdenacao',
            ChoiceType::class,
            array(
                'choices' => array(
                    'Código do Evento' => 'codigo',
                    'Sequência de Cálculo' => 'sequencia',
                ),
                'expanded' => true,
            )
        )
        ->add(
            'stDesdobramento',
            ChoiceType::class,
            array(
                'choices' => array(
                    'Adiantamento 13º Salário' => 'A',
                    'Complemento' => 'D',
                    '13º Salário' => 'C'
                ),
                'expanded' => true,
            )
        )
        ->add(
            'btnVisualizar',
            ButtonType::class
        )
        ->add(
            'btnLimpar',
            ResetType::class
        )
        ->add(
            'btnImprimir',
            ButtonType::class
        )
        ->setAction($this->generateUrl('folhapagamento_folha_13_salario_consultar_ficha_financeira'))
        ->getForm();
        ;

        $form->handleRequest($request);

        return $this->render(
            'RecursosHumanosBundle:FolhaPagamento/Folha13Salario/consultar_ficha_financeira.html.twig',
            array('form' => $form->createView())
        );
    }

    public function registrarEvento13SalarioContratoAction(Request $request)
    {
        $this->setBreadCrumb();

        $form = $this->createFormBuilder(array())
        ->add(
            'stTipoFiltro',
            ChoiceType::class,
            array(
                'choices' => array(
                    'Matrícula' => 'contrato',
                    'CGM/Matrícula' => 'cgm_contrato',
                    'Cargo' => 'cargo',
                    'Função' => 'funcao',
                    'Padrão' => 'padrao',
                    'Lotação' => 'lotacao',
                    'Local' => 'local',
                ),
                'placeholder' => 'Selecione'
            )
        )
        ->add('inContrato')
        ->add(
            'btnOk',
            ButtonType::class
        )
        ->add(
            'btnLimpar',
            ResetType::class
        )
        ->setAction($this->generateUrl('folhapagamento_folha_13_salario_registrar_evento_13_salario_contrato'))
        ->getForm();

        $form->handleRequest($request);

        return $this->render(
            'RecursosHumanosBundle:FolhaPagamento/Folha13Salario/registrar_evento_13_salario_contrato.html.twig',
            array('form' => $form->createView())
        );
    }

    public function consultarRegistrosEvento13SalarioAction(Request $request)
    {
        $this->setBreadCrumb();

        $form = $this->createFormBuilder(array())
        ->add(
            'stOpcao',
            ChoiceType::class,
            array(
                'choices' => array(
                    'Matrícula' => 'contrato',
                    'Contrato' => 'cgm_contrato',
                    'Evento' => 'evento'
                ),
                'expanded' => true,
            )
        )
        ->add('inContrato')
        ->add(
            'inAno',
            NumberType::class,
            array(
                'data' => date("Y"),
            )
        )
        ->add(
            'inCodMes',
            EntityType::class,
            array (
                'class' => 'CoreBundle:Administracao\Mes',
                'choice_label' => 'descricao',
                'choice_value' => 'codMes',
            )
        )
        ->add(
            'Ok',
            ButtonType::class
        )
        ->add(
            'btnLimpar',
            ResetType::class
        )
        ->setAction($this->generateUrl('folhapagamento_folha_13_salario_consultar_registros_evento_13_salario'))
        ->getForm();

        $form->handleRequest($request);

        return $this->render(
            'RecursosHumanosBundle:FolhaPagamento/Folha13Salario/consultar_registros_evento_13_salario.html.twig',
            array('form' => $form->createView())
        );
    }
}
