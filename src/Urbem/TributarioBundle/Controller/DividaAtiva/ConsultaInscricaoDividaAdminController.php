<?php

namespace Urbem\TributarioBundle\Controller\DividaAtiva;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Model\Divida\ConsultaInscricaoDividaModel;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ConsultaInscricaoDividaAdminController
 * @package Urbem\TributarioBundle\Controller\DividaAtiva
 */
class ConsultaInscricaoDividaAdminController extends CRUDController
{
    const COD_MODULO = 33;
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function documentoAction(Request $request)
    {
        $admin = $this->admin;
        $admin->showAction = $admin::SHOW_ACTION_DOCUMENTO;

        return $this->showAction();
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detalheAction(Request $request)
    {
        $admin = $this->admin;
        $admin->showAction = $admin::SHOW_ACTION_DETALHE;

        return $this->showAction();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function relatorioAction(Request $request)
    {
        $container = $this->container;
        $usuario = $container->get('security.token_storage')->getToken()->getUser();
        $entidade = $this->get('urbem.entidade')->getEntidade();

        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        $model = new ConsultaInscricaoDividaModel($em);

        $cobrancasDivida = $model->getListaCobrancasDivida($this->admin->getSubject());

        $listaParcelasDivida = array();
        foreach ($cobrancasDivida as $cobrancaDivida) {
            $listaParcelasDivida = $model->getListaParcelasDivida($cobrancaDivida);
        }

        $infoInscricaoDivida = [
            'cobrancas' => $cobrancasDivida,
            'parcelasDivida' => $listaParcelasDivida,
            'dadosConsulta' => $this->admin->getSubject(),
        ];

        $html = $this->renderView(
            'TributarioBundle:DividaAtiva/ConsultaInscricaoDivida:pdf.html.twig',
            array(
                'infoInscricaoDivida' => $infoInscricaoDivida,
                'entidade' => $entidade,
                'modulo' => 'Dívida Ativa',
                'subModulo' => 'Consultas',
                'nomRelatorio' => 'Consultar Inscrição Dívida Ativa',
                'dtEmissao' => new \DateTime(),
                'usuario' => $usuario,
                'versao' => $container->getParameter('version'),
                'exercicio' => $this->admin->getExercicio()
            )
        );

        $filename = sprintf('Inscricao-divida-ativa-%s.pdf', date('Y-m-d'));

        return new Response(
            $this->get('knp_snappy.pdf')
                ->getOutputFromHtml(
                    $html,
                    array(
                        'encoding' => 'utf-8',
                        'enable-javascript' => false,
                        'footer-line' => true,
                        'footer-left' => 'URBEM - CNM',
                        'footer-right' => '[page]',
                        'footer-center' => 'www.cnm.org.br',
                    )
                ),
            200,
            array(
                'Content-Type'        => 'application/html',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename)
            )
        );
    }

    /**
     * @return string
     */
    public function mask($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for ($i=0; $i<=strlen($mask)-1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k])) {
                    $maskared .= $val[$k++];
                }
            } else {
                if (isset($mask[$i])) {
                    $maskared .= $mask[$i];
                }
            }
        }
        return $maskared;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteInscricaoAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $inscricaoAno = $request->get('q');

        $model = new ConsultaInscricaoDividaModel($em);

        $listaInscricao = $model->getInscricaoAno($inscricaoAno);

        $inscricoes = array();

        if (!is_null($listaInscricao)) {
            foreach ($listaInscricao as $inscricao) {
                array_push($inscricoes, array('id' => sprintf('%d/%s', $inscricao['cod_inscricao'], $inscricao['exercicio']), 'label' => sprintf('%d/%s', $inscricao['cod_inscricao'], $inscricao['exercicio'])));
            }
        }

        $items = array(
            'items' => $inscricoes
        );

        return new JsonResponse($items);
    }
}
