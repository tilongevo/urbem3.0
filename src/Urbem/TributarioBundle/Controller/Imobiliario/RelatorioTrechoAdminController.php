<?php

namespace Urbem\TributarioBundle\Controller\Imobiliario;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoTrechoValor;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Model\Imobiliario\TrechoModel;

class RelatorioTrechoAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function relatorioAction(Request $request)
    {
        $container = $this->container;
        $usuario = $container->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $params = $request->query->all();
        $params['rsmd'] = false;
        $params['aliquota'] = false;

        try {
            $trechoModel = (new TrechoModel($em));
            $trechos = $trechoModel->filtraTrecho($params);

            // Verifica se em cofiguração existe o valor Trecho.
            $verificaValorConfiguracao = $em->getRepository(Configuracao::class)
                ->createQueryBuilder('c')
                ->select('c')
                ->where('c.codModulo = ' . Modulo::MODULO_CADASTRO_IMOBILIARIO)
                ->andWhere('c.exercicio = :exercicio')
                ->andWhere('c.valor = :parametro')
                ->setParameter('exercicio', $params['exercicio'])
                ->setParameter('parametro', 'Trecho')
                ->getQuery()
                ->getResult();
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('contactSupport'));
            throw $e;
        }

        // Verifica se em cofiguração existe o valor Trecho.
        if ($verificaValorConfiguracao) {
            $params['rsmd'] = true;
            $params['aliquota'] = true;
        }

        if ($params['tipoRelatorio'] == 'analitico') {
            $orietation = 'landscape';
            $pathHtmlTwig = 'TributarioBundle:Imobiliario/Relatorios:trechos_analitico.html.twig';

            $atributoDinamicoModel = new AtributoDinamicoModel($em);

            $results = array();
            $codAtributoSelecionados = explode(', ', $params['atributoValores']);
            foreach ($trechos as $trecho) {
                $parametros['cod_trecho'] = $trecho['cod_trecho'];
                $parametros['cod_logradouro'] = $trecho['cod_logradouro'];
                $atributos = $atributoDinamicoModel->getAtributoDinamicoTrecho($parametros);
                // Compara os atributos do banco com os selecionados no formulário
                foreach ($atributos as $atributo) {
                    $index = 0;
                    foreach ($codAtributoSelecionados as $codAtributoSelecionado) {
                        if ($atributo['cod_atributo'] == $codAtributoSelecionado) {
                            $trecho['atributos'][$index] = $atributo;
                        }
                        $index++;
                    }
                }
                $results[] = $trecho;
            }
        } else {
            $orietation = 'portrait';
            $results = $trechos;
            $pathHtmlTwig = 'TributarioBundle:Imobiliario/Relatorios:trechos_sintetico.html.twig';
        }

        $html = $this->renderView(
            $pathHtmlTwig,
            [
                'trechos' => $results,
                'filtros' => $params,
                'entidade' => $this->get('urbem.entidade')->getEntidade(),
                'modulo' => 'Cadastro Imobiliário',
                'subModulo' => 'Relatórios',
                'funcao' => 'Trechos',
                'nomRelatorio' => 'Trechos',
                'dtEmissao' => new \DateTime(),
                'usuario' => $usuario,
                'versao' => $container->getParameter('version')
            ]
        );

        $filename = sprintf('RelatorioTrechos_%s.pdf', date('Y-m-d-His'));

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
                    'orientation' => $orietation
                ]
            ),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            ]
        );
    }
}
