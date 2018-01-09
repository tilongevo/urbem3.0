<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;

class RelatorioCadastroImobiliarioAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function relatorioAction(Request $request)
    {
        $container = $this->container;

        $em = $this->getDoctrine()->getManager();

        $params = $request->query->all();
        
        $filtroLote = $filtroImovel = [];
        $situacao = $ordenacao = '';
        
        list(
            $filtroLote, 
            $filtroImovel, 
            $situacao,
            $ordenacao
        ) = $this->getWhere($params);
        
        $filtro = [
            'lote' => $filtroLote,
            'imovel' => $filtroImovel
        ];

        $imoveis = $em->getRepository(Imovel::class)->getCadastroList($filtro, $situacao, $ordenacao);
        
        $entidade = $this->get('urbem.entidade')->getEntidade();

        $tipoTemplate = 'sintetico';
        
        $data = [
            'imoveis' => $imoveis,
            'admin' => $this->admin,
            'entidade' => $entidade,
            'modulo' => 'Cadastro Imobiliário',
            'subModulo' => 'Relatórios',
            'funcao' => 'Relatório de Cadastro Imobiliário',
            'nomRelatorio' => 'Cadastro Imobiliário',
            'dtEmissao' => new \DateTime(),
            'usuario' => $container->get('security.token_storage')->getToken()->getUser(),
            'versao' => $container->getParameter('version'),
            'filtros' => $params,
            'logoTipo' => $container->get('urbem.configuracao')->getLogoTipo()
        ];
        
        $atribImovel = $atribLoteRural = $atribLoteUrbano = [];
        
        if (isset($params['atributosImovel'])) {
            $atribImovel = $this->_getAtributos($params['atributosImovel']);
        }
        if (isset($params['atributosLoteUrbano'])) {
            $atribLoteUrbano = $this->_getAtributos($params['atributosLoteUrbano']);
        }
        if (isset($params['atributosLoteRural'])) {
            $atribLoteRural = $this->_getAtributos($params['atributosLoteRural']);
        }

        if ((!empty($atribLoteUrbano) || !empty($atribLoteRural) || !empty($atribImovel)) && $params['tipoRelatorio'] == 'analitico') {
            $tipoTemplate = 'analitico';
            $data['atributosFiltroImovel'] = $atribImovel;
            $data['atributosFiltroLoteUrbano'] = $atribLoteUrbano;
            $data['atributosFiltroLoteRural'] = $atribLoteRural;
        }
        
        $html = $this->renderView(
            sprintf('TributarioBundle:Imobiliario/Relatorios:cadastroImobiliario_%s.html.twig', $tipoTemplate),
            $data
        );

        $filename = sprintf('RelatorioCadastroImobiliario_%s.pdf', date('Y-m-d-His'));

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
                    'orientation'=>'Landscape'
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
    protected function getWhere($params)
    {
        $filtro = [];
        $filtroLote = [];

        if ($params['localizacaoInicial'] || $params['localizacaoFinal']) {
            if ($params['localizacaoInicial'] && $params['localizacaoFinal']) {
                $filtroLote[] = sprintf(' LOC.codigo_composto BETWEEN \'\'%s\'\' AND \'\'%s\'\'', $params['localizacaoInicial'], $params['localizacaoFinal']);
            }
            if (!$params['localizacaoInicial'] || !$params['localizacaoFinal']) {
                $params['localizacaoInicial'] = $params['localizacaoFinal'];
                $filtroLote[] = sprintf(' LOC.codigo_composto = \'%s\'', $params['localizacaoInicial']);
            }
        }

        if ($params['loteInicial'] || $params['loteFinal']) {
            if ($params['loteInicial'] && $params['loteFinal']) {
                $filtroLote[] = sprintf(' L.cod_lote BETWEEN %d AND %d', $params['loteInicial'], $params['loteFinal']);
            }
            if (!$params['loteInicial'] || !$params['loteFinal']) {
                $params['loteInicial'] = $params['loteFinal'];
                $filtroLote[] = sprintf(' L.cod_lote = %d', $params['loteInicial']);
            }
        }

        if ($params['inscricaoImobiliariaInicial'] || $params['inscricaoImobiliariaFinal']) {
            if ($params['inscricaoImobiliariaInicial'] && $params['inscricaoImobiliariaFinal']) {
                $filtroLote[] = sprintf(' I.inscricao_municipal BETWEEN %d AND %d', $params['inscricaoImobiliariaInicial'], $params['inscricaoImobiliariaFinal']);
            }
            if (!$params['inscricaoImobiliariaInicial'] || !$params['inscricaoImobiliariaFinal']) {
                $params['inscricaoImobiliariaInicial'] = $params['inscricaoImobiliariaFinal'];
                $filtroLote[] = sprintf(' I.inscricao_municipal = %d', $params['inscricaoImobiliariaInicial']);
            }
        }

        $filtroImovel = [];

        if ($params['codigoLogradouroInicial'] || $params['codigoLogradouroFinal']) {
            if ($params['codigoLogradouroInicial'] && $params['codigoLogradouroFinal']) {
                $filtroImovel[] = sprintf(' LO.cod_logradouro BETWEEN %d AND %d', $params['codigoLogradouroInicial'], $params['codigoLogradouroFinal']);
            }
            if (!$params['codigoLogradouroInicial'] || !$params['codigoLogradouroFinal']) {
                if (!$params['codigoLogradouroInicial']) {
                    $params['codigoLogradouroInicial'] = $params['codigoLogradouroFinal'];
                }
                $filtroImovel[] = sprintf(' LO.cod_logradouro = %s', $params['codigoLogradouroInicial']);
            }
        }

        if ($params['codigoBairroInicial'] || $params['codigoBairroFinal']) {
            if ($params['codigoBairroInicial'] && $params['codigoBairroFinal']) {
                $filtroImovel[] = sprintf(' B.cod_bairro BETWEEN %d AND %d', $params['codigoBairroInicial'], $params['codigoBairroFinal']);
            }
            if (!$params['codigoBairroInicial'] || !$params['codigoBairroFinal']) {
                if (!$params['codigoBairroInicial']) {
                    $params['codigoBairroInicial'] = $params['codigoBairroFinal'];
                }
                $filtroImovel[] = sprintf(' B.cod_bairro = %s', $params['codigoBairroInicial']);
            }
        }
        
        if ($params['proprietarioInicial'] || $params['proprietarioFinal']) {
            if ($params['proprietarioInicial'] && $params['proprietarioFinal']) {
                $filtroImovel[] = sprintf(' I.numcgm BETWEEN %d AND %d', $params['proprietarioInicial'], $params['proprietarioFinal']);
            }
            if (!$params['proprietarioInicial'] || !$params['proprietarioFinal']) {
                if (!$params['proprietarioInicial']) {
                    $params['proprietarioInicial'] = $params['proprietarioFinal'];
                }
                $filtroImovel[] = sprintf(' I.numcgm = %s', $params['proprietarioInicial']);
            }
        }
        
        if (isset($params['tipoImovel']) && $params['tipoImovel'] != 2) {
            $filtroImovel[] = "IUA.inscricao_municipal IS ".($params['tipoImovel'] == 2?"NOT":"")." NULL";
        }
        
        $situacao = null;
        if (strlen($params['situacao']) && $params['situacao'] != 'todos') {
            $situacao = $params['situacao'];
        }
        
        $ordenacao = null;
        if (strlen($params['ordem'])) {
            $ordenacao = $params['ordem'];
        }
        
        $filtro = [$filtroLote, $filtroImovel, $situacao, $ordenacao];

        return $filtro;
    }
    
    /**
     * @param $params
     * @return array
     */
    private function _getAtributos($paramAttr)
    {
        $em = $this->getDoctrine()->getManager();
        
        $atributos = [];
        
        if ($paramAttr) {
            foreach ($this->_atributoStringParaArray($paramAttr) as $attr) {
                $atributo = $em->getRepository(AtributoDinamico::class)->findOneByCodAtributo($attr);
                $atributos[] = $atributo;
            }
        }
        
        return $atributos;
    }
    
    /**
     * @param $parametro
     * @return array
     */
    private function _atributoStringParaArray($parametro)
    {
        $codAtributosSelecionados = array();
        if (isset($parametro)) {
            $codAtributosSelecionados = explode(', ', $parametro);
        }
        
        return $codAtributosSelecionados;
    }
}
