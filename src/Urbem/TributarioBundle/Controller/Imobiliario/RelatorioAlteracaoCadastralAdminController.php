<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;

class RelatorioAlteracaoCadastralAdminController extends CRUDController
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

        list($filtroLote, $filtroImovel) = $this->getWhere($params);

        $imoveis = $em->getRepository(Imovel::class)->getAlteracaoCadastralList($filtroLote, $filtroImovel, null, $params['ordenacao']);

        $entidade = $this->get('urbem.entidade')->getEntidade();

        $atributos = $this->getAtributos($params);

        $html = $this->renderView(
            sprintf(
                'TributarioBundle:Imobiliario/Relatorios:alteracaoCadastral_%s.html.twig',
                (!$atributos && $params['tipoRelatorio'] == 'analitico') ? 'sintetico' : $params['tipoRelatorio']
            ),
            [
                'imoveis' => $imoveis,
                'admin' => $this->admin,
                'atributos' => $atributos,
                'entidade' => $entidade,
                'modulo' => 'Cadastro Imobiliário',
                'subModulo' => 'Relatórios',
                'funcao' => 'Relatório de Alteração Cadastral',
                'nomRelatorio' => 'Alteração Cadastral',
                'dtEmissao' => new \DateTime(),
                'usuario' => $container->get('security.token_storage')->getToken()->getUser(),
                'versao' => $container->getParameter('version'),
                'filtros' => $params,
                'logoTipo' => $container->get('urbem.configuracao')->getLogoTipo(),
            ]
        );

        $filename = sprintf('RelatorioAlteracaoCadastral_%s.pdf', date('Y-m-d-His'));

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
    protected function getAtributos($params)
    {
        $em = $this->getDoctrine()->getManager();

        $atributos = [];

        if ($params['atributos']) {
            foreach ((array) $params['atributos'] as $key => $value) {
                $atributo = $em->getRepository(AtributoDinamico::class)->findOneByCodAtributo($value);
                $atributos[] = $atributo;
            }
        }

        return $atributos;
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
                $params['codigoLogradouroInicial'] = $params['codigoLogradouroFinal'];
                $filtroImovel[] = sprintf(' LO.cod_logradouro = %s', $params['codigoLogradouroInicial']);
            }
        }

        if ($params['codigoBairroInicial'] || $params['codigoBairroFinal']) {
            if ($params['codigoBairroInicial'] && $params['codigoBairroFinal']) {
                $filtroImovel[] = sprintf(' B.cod_bairro BETWEEN %d AND %d', $params['codigoBairroInicial'], $params['codigoBairroFinal']);
            }

            if (!$params['codigoBairroInicial'] || !$params['codigoBairroFinal']) {
                $params['codigoBairroInicial'] = $params['codigoBairroFinal'];
                $filtroImovel[] = sprintf(' B.cod_bairro = %s', $params['codigoBairroInicial']);
            }
        }

        $filtro = [$filtroLote, $filtroImovel];

        return $filtro;
    }
}
