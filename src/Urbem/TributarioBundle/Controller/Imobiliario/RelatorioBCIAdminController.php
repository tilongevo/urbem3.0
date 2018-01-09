<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Imobiliario\ImovelModel;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Model\Imobiliario\ConstrucaoModel;
use Urbem\CoreBundle\Model\Imobiliario\LoteModel;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoImovelValor;

class RelatorioBCIAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function relatorioAction(Request $request)
    {
        $container = $this->container;
        
        $params = $request->query->all();
        $queryParams = [];
        
        $where = $this->_getWhere($params, $queryParams);
        
        $em = $this->getDoctrine()->getManager();
        $imovel = new ImovelModel($em);
        
        $bcis = $imovel->getBoletimCadastroImobiliario($where, $queryParams);
        $report = $this->_prepareReport($bcis);
        
        $html = $this->render(
            'TributarioBundle:Imobiliario/Relatorios:bci.html.twig',
            [
                'bcis' => $report,
                'filtros' => $params,
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'modulo' => 'Cadastro Imobiliário',
                'subModulo' => 'Relatórios',
                'funcao' => 'BCI',
                'logoTipo' => $this->container->get('urbem.configuracao')->getLogoTipo(),
                'nomRelatorio' => 'Relatório de BCI',
                'dtEmissao' => new \DateTime(),
                'usuario' => $container->get('security.token_storage')->getToken()->getUser(),
                'versao' => $container->getParameter('version'),
                'admin' => $this->admin
            ]
        );
        
        $filename = sprintf('RelatorioBCI_%s.pdf', date('Y-m-d-His'));
        
        return new Response(
            $this->get('knp_snappy.pdf')->getOutputFromHtml(
                $html,
                [
                    'encoding' => 'utf-8',
                    'enable-javascript' => true,
                    'footer-line' => true,
                    'footer-left' => 'URBEM - CNM',
                    'footer-right' => '[page]',
                    'footer-center' => 'www.cnm.org.br',
                    'orientation'=>'Portrait'
                ]
            ),
            200,
            [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            ]
        );
    }

    /**
     * @param $params
     * @return array
     */
    private function _getWhere($params, Array &$queryParams)
    {
        $where = [];
        
        if ((isset($params['inscricaoDe']) && !isset($params['inscricaoAte'])) || !isset($params['inscricaoDe']) && isset($params['inscricaoAte'])) {
            $where[] =  " ii.inscricao_municipal = :inscricao";
            $queryParams[':inscricao'] = isset($params['inscricaoDe'])?$params['inscricaoDe']:$params['inscricaoAte'];
        } else if (isset($params['inscricaoDe']) && isset($params['inscricaoAte'])) {
            $where[] = " ii.inscricao_municipal BETWEEN :inscricaoDe AND :inscricaoAte";
            $queryParams['inscricaoDe'] = $params['inscricaoDe'];
            $queryParams['inscricaoAte'] = $params['inscricaoAte'];
        }
        
        if ((isset($params['localizacaoDe']) && !isset($params['localizacaoAte'])) || !isset($params['localizacaoDe']) && isset($params['localizacaoAte'])) {
            $where[] =  " il.codigo_composto = :localizacao";
            $queryParams[':localizacao'] = isset($params['localizacaoDe'])?$params['localizacaoDe']:$params['localizacaoAte'];
        } else if (isset($params['localizacaoDe']) && isset($params['localizacaoAte'])) {
            $where[] = " il.codigo_composto BETWEEN :localizacaoDe AND :localizacaoAte";
            $queryParams[':localizacaoDe'] = $params['localizacaoDe'];
            $queryParams[':localizacaoAte'] = $params['localizacaoAte'];
        }
        
        if ((isset($params['logradouroDe']) && !isset($params['logradouroAte'])) || !isset($params['logradouroDe']) && isset($params['logradouroAte'])) {
            $where[] =  " iconftre.cod_logradouro = :logradouro";
            $queryParams[':logradouro'] = isset($params['logradouroDe'])?$params['logradouroDe']:$params['logradouroAte'];
        } else if (isset($params['logradouroDe']) && isset($params['logradouroAte'])) {
            $where[] = " iconftre.cod_logradouro BETWEEN :logradouroDe AND :logradouroAte";
            $queryParams[':logradouroDe'] = $params['logradouroDe'];
            $queryParams[':logradouroAte'] = $params['logradouroAte'];
        }
        
        if ((isset($params['bairroDe']) && !isset($params['bairroAte'])) || !isset($params['bairroDe']) && isset($params['bairroAte'])) {
            $where[] =  " bairro.cod_bairro = :bairro";
            $queryParams[':bairro'] = isset($params['bairroDe'])?$params['bairroDe']:$params['bairroAte'];
        } else if (isset($params['bairroDe']) && isset($params['bairroAte'])) {
            $where[] = " bairro.cod_bairro BETWEEN :bairroDe AND :bairroAte";
            $queryParams[':bairroDe'] = $params['bairroDe'];
            $queryParams[':bairroAte'] = $params['bairroAte'];
        }
        
        return $where;
    }
    
    /**
     * @param array $data
     * @return array
     */
    private function _prepareReport(Array $data)
    {
        $em = $this->getDoctrine()->getManager();
        $atributoModel = new AtributoDinamicoModel($em);
        $loteModel = new LoteModel($em);
        $construcaoModel = new ConstrucaoModel($em);
        
        $atributosImovel = $atributoModel->getAtributosDinamicosPessoal(
            ['cod_modulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO, 'cod_cadastro' =>  Cadastro::CADASTRO_TRIBUTARIO_IMOVEL]
        );
        
        $atributosLote = $atributoModel->getAtributosDinamicosPessoal(
            ['cod_modulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO, 'cod_cadastro' =>  Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO]
        );
        
        $atributosConstrucao = $atributoModel->getAtributosDinamicosPessoal(
            ['cod_modulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO, 'cod_cadastro' => Cadastro::CADASTRO_TRIBUTARIO_TIPO_EDIFICACAO]
        );
        
        $inTotalDados = count( $data );
        $arDados = [];
        $arConfrontacoes = [];
        $inPosLivre = 0;
        
        for ($inX=0; $inX<$inTotalDados; $inX++) {
            $boIncluir = true;
            for ($inY=0; $inY<$inPosLivre; $inY++) {
                if ($arDados[$inY]["inscricao_municipal"] == $data[$inX]["inscricao_municipal"]) {
                    if ($arDados[$inY]["numcgm_proprietario"] == $data[$inX]["numcgm_proprietario"]) { //podem existir mais de uma confrontacao
                        //armazenando dados das demais confrontacoes
                        $inInscricao = $arDados[$inY]["inscricao_municipal"];
                        $inPosicaoLivre = $arConfrontacoes[$inInscricao]["total_conf"];
                        $arConfrontacoes[$inInscricao]['confrontacao'][$inPosicaoLivre]["conf_lot_ponto_cardeal"] = $data[$inX]["conf_lot_ponto_cardeal"];
                        $arConfrontacoes[$inInscricao]['confrontacao'][$inPosicaoLivre]["conf_lot_metragem"] = $data[$inX]["conf_lot_metragem"];
                        $arConfrontacoes[$inInscricao]['confrontacao'][$inPosicaoLivre]["conf_lot_especificar"] = $data[$inX]["conf_lot_especificar"];
                        $arConfrontacoes[$inInscricao]['confrontacao'][$inPosicaoLivre]["conf_principal"] = $data[$inX]["conf_principal"];
                        $arConfrontacoes[$inInscricao]['confrontacao'][$inPosicaoLivre]["conf_ativa"] = "[  ]";
                        $arConfrontacoes[$inInscricao]["total_conf"]++;
                    }
                    
                    $boIncluir = false;
                    break;
                }
            }
            
            if ($boIncluir) {
                $inInscricao = $data[$inX]["inscricao_municipal"];
                $arConfrontacoes[$inInscricao]["total_conf"] = 1;
                $arConfrontacoes[$inInscricao]['numcgm_proprietario'] = $data[$inX]['numcgm_proprietario'];
                $arConfrontacoes[$inInscricao]['nom_cgm_proprietario'] = $data[$inX]['nom_cgm_proprietario'];
                $arConfrontacoes[$inInscricao]['cota_proprietario'] = $data[$inX]['cota_proprietario'];
                $arConfrontacoes[$inInscricao]['cpf_cnpj_proprietario'] = $data[$inX]['cpf_cnpj_proprietario'];
                $arConfrontacoes[$inInscricao]['confrontacao'][0]["conf_lot_ponto_cardeal"] = $data[$inX]["conf_lot_ponto_cardeal"];
                $arConfrontacoes[$inInscricao]['confrontacao'][0]["conf_lot_metragem"] = $data[$inX]["conf_lot_metragem"];
                $arConfrontacoes[$inInscricao]['confrontacao'][0]["conf_lot_especificar"] = $data[$inX]["conf_lot_especificar"];
                $arConfrontacoes[$inInscricao]['confrontacao'][0]["conf_principal"] = $data[$inX]["conf_principal"];
                $arConfrontacoes[$inInscricao]['confrontacao'][0]["conf_ativa"] = "[  ]";
                
                $arDados[$inPosLivre] = $data[$inX];
                
                // Atributo Imovel
                $atributosImovelValor = $em->getRepository(AtributoImovelValor::class)
                ->findBy(['inscricaoMunicipal' => $inInscricao]);
                
                $attrImovelValor = [];
                foreach ($atributosImovelValor as $attr) {
                    $attrImovelValor[$attr->getCodAtributo()] = [$attr->getValor()];
                }
                $arConfrontacoes[$inInscricao]['atributosImovel'] = $this->_getAtributosValores($inInscricao, $atributosImovel, $attrImovelValor);
                
                // Atributo Lote
                $lotes = [];
                foreach ($loteModel->getLoteByCod($data[$inX]['cod_lote']) as $lote) {
                    $lotes[$lote['cod_atr_din_lote']] = explode(',', $lote['valor_atr_din_lote']);
                }
                $arConfrontacoes[$inInscricao]['atributosLote'] = $this->_getAtributosValores($inInscricao, $atributosLote, $lotes);
                
                // Atributo Construção
                $arConfrontacoes[$inInscricao]['construcoes'] = $construcoes = [];
                $construcoes = $this->_getCaracteristicasEdificacao(
                    $construcaoModel,
                    $data[$inX]['cod_construcao'],
                    $data[$inX]['cod_tipo']
                );
                
                $construcoesValores = [];
                foreach ($construcoes as $contrucao) {
                    $construcoesValores[$contrucao['cod_atributo']] = explode(',', $contrucao['valor']);
                }

                $arConfrontacoes[$inInscricao]['atributosConstrucao'] = $this->_getAtributosValores($inInscricao, $atributosConstrucao, $construcoesValores, true);
                
                $inPosLivre++;
            }
        }
        return $arConfrontacoes;
    }
    
    /**
     * @param $indice
     * @param $atributos
     * @return array
     */
    private function _getAtributosValores($indice, $atributos, $attrSelecionado, $skipUndefined = false)
    {
        $atributosValores = array();
        foreach ($atributos as $atributo) {
            if ($atributo->ativo) {
                $valorPadraoDesc = $atributo->valor_padrao_desc;
                $cod_atributo = $atributo->cod_atributo;
                
                if (!isset($attrSelecionado[$cod_atributo]) && $skipUndefined) {
                    continue;
                }
                
                if ($valorPadraoDesc) {
                    $valorSelecionado = explode(",", $atributo->valor_padrao);
                    
                    $atributos = [];
                    $aux = 0;
                    foreach (explode("[][][]", $valorPadraoDesc) as $padrao) {
                        $atributos[$valorSelecionado[$aux]] = $padrao;
                        $aux++;
                    }
                    foreach ($atributos as $key => $val) {
                        $aux = false;
                        if (isset($attrSelecionado[$cod_atributo])) {
                            $aux = array_search($key, $attrSelecionado[$cod_atributo]) !== false;
                        }
                        $atributos[$key] = "[ ".($aux?"*":"&nbsp;")." ] " . $val;
                    }
                    $atributosValores['atributos'][$cod_atributo] = $atributos;
                }
                $atributosValores['titulos'][$cod_atributo] = $atributo->nom_atributo;
            }
        }
        return $atributosValores;
    }
    
    /**
     * @param ConstrucaoModel $costrucao
     * @param int $codContrucao
     * @param int $codTipo
     * @return array
     */
    private function _getCaracteristicasEdificacao($costrucao, $codContrucao, $codTipo)
    {
        if (is_null($codContrucao) && is_null($codTipo)) {
            return [];
        }
        
        $where = $param = [];
        if (intval($codContrucao)) {
            $where[] = "ic.cod_construcao = :codCostrucao";
            $param[":codCostrucao"] = $codContrucao;
        }
        
        if (intval($codTipo)) {
            $where[] = "ice.cod_tipo = :codTipo";
            $param[":codTipo"] = $codTipo;
        }
        
        return $costrucao->getCaracteristicasEdificacao($where, $param);
    }
}
