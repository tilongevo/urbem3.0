<?php

namespace Urbem\FinanceiroBundle\Controller\Tesouraria;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Tesouraria\Arrecadacao;
use Urbem\CoreBundle\Entity\Tesouraria\ArrecadacaoReceita;
use Urbem\CoreBundle\Helper\BreadCrumbsHelper;

class ArrecadacaoAdminController extends CRUDController
{
    public function boletimAction(Request $request)
    {
        $exercicio = $request->request->get('exercicio');
        $codEntidade = $request->request->get('codEntidade');

        $return = array();

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Tesouraria\Arrecadacao');
        $boletins = $repository->getBoletim($exercicio, $codEntidade);

        foreach ($boletins as $boletim) {
            $return[$boletim['cod_boletim'] . ' - ' . $boletim['dt_boletim']] = $boletim['cod_boletim'];
        }

        $response = new Response();
        $response->setContent(json_encode($return));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function receitaAction(Request $request)
    {
        $exercicio = $request->request->get('exercicio');
        $codEntidade = $request->request->get('codEntidade');

        $return = array();

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Tesouraria\Arrecadacao');
        $receitas = $repository->getReceita($exercicio, $codEntidade);

        foreach ($receitas as $receita) {
            $return[$receita['cod_receita'] . ' - ' . $receita['descricao']] = $receita['cod_receita'];
        }

        $response = new Response();
        $response->setContent(json_encode($return));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function contaDeducaoAction(Request $request)
    {
        $exercicio = $request->request->get('exercicio');
        $codEntidade = $request->request->get('codEntidade');

        $return = array();

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Tesouraria\Arrecadacao');
        $receitas = $repository->getContaDeducao($exercicio, $codEntidade);

        foreach ($receitas as $receita) {
            $return[$receita['cod_receita'] . ' - ' . $receita['descricao']] = $receita['cod_receita'];
        }

        $response = new Response();
        $response->setContent(json_encode($return));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function contaAction(Request $request)
    {
        $exercicio = $request->request->get('exercicio');
        $codEntidade = $request->request->get('codEntidade');

        $return = array();

        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('CoreBundle:Tesouraria\Arrecadacao');
        $contas = $repository->getConta($exercicio, $codEntidade);

        foreach ($contas as $conta) {
            $return[$conta['cod_plano'] . ' - ' . $conta['nom_conta']] = $conta['cod_plano'];
        }

        $response = new Response();
        $response->setContent(json_encode($return));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function emissaoAction(Request $request)
    {
        $id = $request->get('id');
        $this->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));

        list($codArrecadacao, $exercicio, $timestampArrecadacao) = explode('~', $request->attributes->get('id'));

        $em = $this->getDoctrine()->getManager();

        /** @var Arrecadacao $arrecadacao */
        $arrecadacao = $em->getRepository(Arrecadacao::class)->findOneBy([
            'codArrecadacao' => $codArrecadacao,
            'exercicio' => $exercicio,
            'timestampArrecadacao' => $timestampArrecadacao,
        ]);

        /** @var ArrecadacaoReceita $arrecadacaoReceita */
        $arrecadacaoReceita = $arrecadacao->getFkTesourariaArrecadacaoReceitas()->last();

        $receita = sprintf(
            "PMMP%s %s ARR RECEITA %s %s ",
            str_pad($arrecadacao->getCodAutenticacao(), 6, '0', STR_PAD_LEFT),
            $arrecadacao->getDtAutenticacao()->format('d/m/y'),
            sprintf('%d/%s', $arrecadacaoReceita->getCodReceita(), substr($arrecadacaoReceita->getExercicio(), -2)),
            str_pad(number_format($arrecadacaoReceita->getVlArrecadacao(), 2, ',', '.'), 14, '*', STR_PAD_LEFT)
        );

        $conta = sprintf('%d - %s', $arrecadacao->getCodPlano(), $arrecadacao->getFkContabilidadePlanoAnalitica()->getFkContabilidadePlanoConta()->getNomConta());

        return $this->render('FinanceiroBundle::Tesouraria/Arrecadacao/comunicacao.html.twig', array(
            'voltar' => $this->admin->generateUrl('create'),
            'receita' => $receita,
            'conta' => $conta
        ));
    }

    /**
     * @param array $param
     * @param null $route
     */
    public function setBreadCrumb($param = [], $route = null)
    {
        $entityManager = $this->getDoctrine()->getManager();

        BreadCrumbsHelper::getBreadCrumb(
            $this->get("white_october_breadcrumbs"),
            $this->get("router"),
            $route,
            $entityManager,
            $param
        );
    }
}
