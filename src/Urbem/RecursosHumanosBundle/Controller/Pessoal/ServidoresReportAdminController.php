<?php
namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Cse\GrauParentesco;
use Urbem\CoreBundle\Entity\Folhapagamento\SalarioFamilia;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPadrao;
use Urbem\CoreBundle\Entity\Pessoal\Servidor;
use Urbem\CoreBundle\Entity\Pessoal\ServidorCtps;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Model\Pessoal\Assentamento\AssentamentoGeradoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorContaSalarioModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorInicioProgressaoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorPrevidenciaModel;
use Urbem\CoreBundle\Model\Pessoal\FeriasModel;

/**
 * Class ServidoresReportAdminController
 *
 * @package Urbem\RecursosHumanosBundle\Controller\Pessoal
 */
class ServidoresReportAdminController extends Controller
{

    /**
     * @param Request $request
     * @return Response
     */
    public function relatorioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $q = $request->get($request->get('uniqid'));
        $filtroForm = array_merge($q, $request->request->all());

        // Define quais grupos de informações irão aparecer no relatório
        $opcoesVisualizacao = array();
        foreach ($filtroForm['opcoesVisualizacao'] as $key => $value) {
            $opcoesVisualizacao[$value] = true;
        }

        $servidores = array();
        $informacoesServidor = (new \Urbem\CoreBundle\Model\Pessoal\ServidorModel($em))->getRelatorioServidor(array('exercicio' => $filtroForm['exercicio'], 'filtro' => $this::getFiltro($filtroForm), 'situacao' => $this::getSituacao($filtroForm)));

        foreach ($informacoesServidor as $informacao) {
            // Define a visualização quando o tipo de filtro for 'local'
            switch ($filtroForm['tipoFiltro']) {
                case 'local':
                    $tipoFiltro = 'local';
                    $valor = $informacao['cod_local'];
                    $opcoesVisualizacao['local'] = true;
                    break;
                case 'lotacao':
                    $tipoFiltro = 'contrato';
                    $valor = $informacao['cod_contrato'];
                    $opcoesVisualizacao['codLotacao'] = true;
                    break;
                default:
                    $tipoFiltro = 'contrato';
                    $valor = $informacao['cod_contrato'];
            }

            $servidor = $em->getRepository(Servidor::class)->findOneBy(['codServidor' => $informacao['cod_servidor']]);
            $contratoServidor = $em->getRepository(ContratoServidor::class)->findOneBy(['codContrato' => $informacao['cod_contrato']]);

            // Informações Básicas
            $informacao['nomEstadoCivil'] = $servidor->getFkCseEstadoCivil()->getNomEstado();
            $informacao['nomRaca'] = $servidor->getFkCseRaca()->getNomRaca();
            $informacao['cargo'] = $contratoServidor->getFkPessoalCargo()->getDescricao();
            $informacao['norma'] = $contratoServidor->getFkNormasNorma()->getNomNorma();
            $informacao['portaria'] = $contratoServidor->getFkNormasNorma()->getNumNorma() . '/' . $contratoServidor->getFkNormasNorma()->getExercicio() . ' - ' . $contratoServidor->getFkNormasNorma()->getNomNorma();
            $informacao['regime'] = $contratoServidor->getFkPessoalRegime()->getDescricao();
            $informacao['subDivisao'] = $contratoServidor->getFkPessoalSubDivisao()->getDescricao();
            $informacao['tipoAdmissao'] = $contratoServidor->getFkPessoalTipoAdmissao()->getDescricao();
            $informacao['vinculoEmpregaticio'] = $contratoServidor->getFkPessoalVinculoEmpregaticio()->getDescricao();
            $informacao['categoria'] = $contratoServidor->getFkPessoalCategoria()->getDescricao();
            $informacao['contratoMedico'] = $contratoServidor->getFkPessoalContratoServidorExameMedicos()->last(); //******
            $informacao['tipoPagamento'] = $contratoServidor->getFkPessoalTipoPagamento()->getDescricao();
            $informacao['formaPagamento'] = $contratoServidor->getFkPessoalContratoServidorFormaPagamentos()->last()->getFkPessoalFormaPagamento()->getDescricao(); //***
            $informacao['nivelPadrao'] = $contratoServidor->getFkPessoalContratoServidorNivelPadroes()->last(); //****
            $contaSalario = $contratoServidor->getFkPessoalContratoServidorContaSalario();
            $informacao['contaSalario']['numeroConta'] = $contaSalario ? $contaSalario->getNrConta() : '';
            $informacao['contaSalario']['agencia'] = $contaSalario ? $contaSalario->getFkMonetarioAgencia()->getNumAgencia().' - '.$contaSalario->getFkMonetarioAgencia()->getNomAgencia() : '';
            $informacao['contaSalario']['banco'] = $contaSalario ? $contaSalario->getFkMonetarioAgencia()->getFkMonetarioBanco()->getNumBanco().' - '.$contaSalario->getFkMonetarioAgencia()->getFkMonetarioBanco()->getNomBanco() : '';
            $informacao['progressao'] = (new ContratoServidorInicioProgressaoModel($em))->consultaDataInicioProgressaoMaxTimestamp($informacao['cod_contrato']);

            if (isset($opcoesVisualizacao['documentacao'])) {
                $qb = $em->getRepository(ServidorCtps::class)->createQueryBuilder('c');
                $qb->join('c.fkPessoalServidor', 'sc');
                $qb->where('sc.codServidor = :codServidor');
                $qb->setParameter('codServidor', $informacao['cod_servidor']);
                $informacao['ctps'] = $qb->getQuery()->getOneOrNullResult();

                $informacao['documentacao'] = end((new \Urbem\CoreBundle\Model\Pessoal\ServidorModel($em))
                    ->getRelatorioServidor2(array('numcgm' => $informacao['numcgm'], 'registro' => $informacao['registro'], 'exercicio' => $filtroForm['exercicio'])));
            }

            if (isset($opcoesVisualizacao['contratuais'])) {
                $qb = $em->getRepository(ContratoServidorPadrao::class)->createQueryBuilder('pp');
                $qb->join('pp.fkFolhapagamentoPadrao', 'fp');
                $qb->where('pp.codContrato = :codContrato');
                $qb->andWhere('pp.codPadrao = :codPadrao');
                $qb->setParameter('codContrato', $informacao['cod_contrato']);
                $qb->setParameter('codPadrao', $informacao['cod_padrao']);
                $cargaHoraria = $qb->getQuery()->getResult();
                $informacao['cargaHoraria']['descricao'] = end($cargaHoraria)->getFkFolhapagamentoPadrao()->getDescricao();
                $informacao['cargaHoraria']['horasMensais'] = end($cargaHoraria)->getFkFolhapagamentoPadrao()->getHorasMensais();
                $informacao['cargaHoraria']['horasSemanais'] = end($cargaHoraria)->getFkFolhapagamentoPadrao()->getHorasSemanais();
            }

            if ($contratoServidor->getFkPessoalContratoServidorPrevidencias()->last()) {
                $codPrevidencia = $contratoServidor->getFkPessoalContratoServidorPrevidencias()->last()->getFkFolhapagamentoPrevidencia()->getCodPrevidencia();
                $informacao['previdencia'] = end((new ContratoServidorPrevidenciaModel($em))->getDadosRelatorioServidor($codPrevidencia));
            }

            if (isset($opcoesVisualizacao['salariais'])) {
                $informacao['salario'] = (new ContratoServidorContaSalarioModel($em))->consultaSalarioMaxTimestamp($informacao['cod_contrato']);
            }

            if (isset($opcoesVisualizacao['ferias'])) {
                $ferias = (new FeriasModel($em))->getDadosRelatorioServidor([
                    'cod_entidade' => '',
                    'exercicio' => $filtroForm['exercicio'],
                    'dataHoje' => (new \DateTime('now'))->format('d/m/Y'),
                    'tipo' => $tipoFiltro,
                    'codContrato' => $valor]);

                $arrayFerias = array();
                foreach ($ferias as $f) {
                    if ($f['dt_inicial_gozo'] && $f['dt_final_gozo']) {
                        array_push($arrayFerias, $f);
                    }
                }

                $informacao['ferias'] = $arrayFerias;
            }

            if (isset($opcoesVisualizacao['atributos'])) {
                $params = array();
                $params['codCadastro'] = Cadastro::CADASTRO_TRIBUTARIO_TIPO_EDIFICACAO;
                $params['codModulo'] = Modulo::MODULO_PESSOAL;
                $params['tabelaAtributo'] = "pessoal.atributo_contrato_servidor_valor";
                $params['campoAtributo'] = "cod_contrato";
                $params['codAtributo'] = $informacao['cod_contrato'];
                $informacao['atributos'] = (new AtributoDinamicoModel($em))->getValorAtributoDinamicoPorTabelaComCodigo($params);
            }

            if (isset($opcoesVisualizacao['dependentes'])) {
                $informacao['dependentes'] = (new \Urbem\CoreBundle\Model\Pessoal\ServidorModel($em))->getDependentesServidor(array('codServidor' => $servidor->getCodServidor()));

                if ($informacao['dependentes']) {
                    $index = 0;

                    $idadeLimite = null;
                    if (isset($informacao['previdencia'])) {
                        $salarioFamilia = $em->getRepository(SalarioFamilia::class)->findOneBy(['codRegimePrevidencia' => $informacao['previdencia']['cod_regime_previdencia']]);
                        $idadeLimite = $salarioFamilia->getIdadeLimite();
                    }

                    foreach ($informacao['dependentes'] as $dependente) {
                        $grauParentesco = $em->getRepository(GrauParentesco::class)->findOneBy(['codGrau' => $dependente['cod_grau']]);
                        $informacao['dependentes'][$index]['nom_grau_parentesco'] = $grauParentesco->getNomGrau();
                        $dataNascimento = explode("/", reset($informacao['dependentes'])['dt_nascimento']);

                        if ($idadeLimite) {
                            $anoLimite = $dataNascimento[2] + $idadeLimite;
                            $informacao['dependentes'][$index]['limite_salario_familia'] = $dataNascimento[0] ."/". $dataNascimento[1] ."/". $anoLimite;
                        } else {
                            $informacao['dependentes'][$index]['limite_salario_familia'] = '';
                        }
                        $index++;
                    }
                }
            }

            if (isset($opcoesVisualizacao['assentamentos'])) {
                $params2 = array();
                $params2['codContrato'] = $valor;
                $params2['exercicio'] = $filtroForm['exercicio'];
                $params2['tipo'] = $tipoFiltro;
                $informacao['assentamentos'] = (new AssentamentoGeradoModel($em))->getAssentamentoGeradoByCodContratoAndExercicio($params2);
            }
            array_push($servidores, $informacao);
        }

        $html = $this->renderView(
            'RecursosHumanosBundle:Pessoal/Relatorios/Servidores:servidores.html.twig',
            array(
                'logoTipo' => $this->container->get('urbem.configuracao')->getLogoTipo(),
                'servidores' => $servidores,
                'visualizacao' => $opcoesVisualizacao,
                'usuario' => $this->get('security.token_storage')->getToken()->getUser(),
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'modulo' => 'Pessoal',
                'subModulo' => 'Relatórios',
                'funcao' => 'Servidores',
                'dtEmissao' => new \DateTime(),
                'nomRelatorio' => 'Exercício: '.$filtroForm['exercicio'],
                'versao' => '3.0.0'
            )
        );

        $filename = "Servidores_" . (new \DateTime())->format("Ymd_His") . ".pdf";

        return new Response(
            $this->get('knp_snappy.pdf')
                ->getOutputFromHtml(
                    $html,
                    array(
                        'encoding' => 'utf-8',
                        'enable-javascript' => true,
                        'footer-line' => true,
                        'footer-left' => 'URBEM - CNM',
                        'footer-right' => '[page]',
                        'footer-center' => 'www.cnm.org.br',
                    )
                ),
            200,
            array(
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            )
        );
    }

    /**
     * @param $filtro
     * @return string
     */
    public function getSituacao($filtro)
    {
        switch ($filtro['tipoCadastro']) {
            case 'ativo':
                return " AND situacao = 'A' ";
                break;
            case 'aposentado':
                return " AND situacao = 'P' ";
                break;
            case 'pensionista':
                return " AND situacao = 'E' ";
                break;
            case 'rescindido':
                return " AND situacao = 'R' ";
                break;
            case 'todos':
                return " ";
                break;
        }
    }

    /**
     * @param $filtro
     * @return string
     */
    public function getFiltro($filtro)
    {
        switch ($filtro['tipoFiltro']) {
            case 'contrato':
                return " WHERE contrato.cod_contrato IN (".$this->getValores($filtro['cgmMatriculas']).") ";
                break;
            case 'cgm_contrato':
                return " WHERE contrato.cod_contrato IN (".$this->getValores($filtro['cgmMatriculas']).") ";
                break;
            case 'lotacao':
                return " WHERE vw_orgao_nivel.cod_orgao IN (".$this->getValores($filtro['lotacao']).") ";
                break;
            case 'local':
                return " WHERE contrato_servidor_local.cod_local IN (".$this->getValores($filtro['local']).") ";
                break;
            case 'atributo_servidor':
                $andWhere = '';
                $valorAtributo = end($filtro['atributoDinamico'][$filtro['atributoSelecao']]);

                if (!is_array($valorAtributo) && !empty($valorAtributo)) {
                    $andWhere = " AND atributo_contrato_servidor_valor.valor = '".$valorAtributo."' ";
                }

                return " WHERE atributo_dinamico.cod_atributo IN (".$filtro['atributoSelecao'].") AND atributo_dinamico.cod_cadastro IN (5) ".$andWhere;
                break;
        }
    }

    /**
     * @param $filtro
     * @return bool|string
     */
    public function getValores($filtro)
    {
        $valores = '';
        if (sizeof($filtro) <= 0 || $filtro == '') {
            return 'null';
        }

        foreach ($filtro as $filtro) {
            if ($filtro && !is_array($filtro)) {
                $valores .= $filtro.', ';
            } else {
                $valores .= $filtro['codContrato'] . ', ';
            }
        }
        $valores = substr($valores, 0, -2);

        return $valores;
    }
}
