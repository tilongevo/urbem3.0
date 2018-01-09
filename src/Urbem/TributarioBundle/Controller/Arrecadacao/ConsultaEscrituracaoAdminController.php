<?php

namespace Urbem\TributarioBundle\Controller\Arrecadacao;

use DateTime;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico;
use Urbem\CoreBundle\Model\Arrecadacao\ConsultaEscrituracaoModel;

/**
 * Class ConsultaEscrituracaoAdminController
 * @package Urbem\TributarioBundle\Controller\Arrecadacao
 */
class ConsultaEscrituracaoAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function atividadeAction(Request $request)
    {
        $id = $this->admin->getIdParameter();

        $this->admin->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));
        $container = $this->container;
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        try {
            $id = $request->get($this->admin->getIdParameter());
            list($inscricaoEconomica, $codAtividade, $ocorrenciaAtividade) = explode('~', $id);

            $atividade = $em->getRepository(AtividadeCadastroEconomico::class)
                ->findOneBy([
                   'inscricaoEconomica' =>$inscricaoEconomica,
                    'codAtividade' => $codAtividade,
                    'ocorrenciaAtividade' => $ocorrenciaAtividade
                ]);

            $codCalculo = $atividade->getFkEconomicoCadastroEconomico()->getFkArrecadacaoCadastroEconomicoFaturamentos()->last()
                ->getFkArrecadacaoCadastroEconomicoCalculos()->last()->getCodCalculo();

            if ($dataBase = $request->get('data_base')) {
                $dt = DateTime::createFromFormat('d/m/Y', $dataBase);
            }

            $dt = (isset($dt)) ? $dt : (new DateTime()) ;

            if ($codCalculo) {
                $valores = (new ConsultaEscrituracaoModel($em))->getDetalhamentoValores($codCalculo, $dt->format('Y-m-d'));
            }

            return $this->render('TributarioBundle::Arrecadacao/ConsultaEscrituracao/dadosAtividade.html.twig', array(
                'atividade' => $atividade,
                'valores' => $valores,
                'codCalculo' => $codCalculo
            ));
        } catch (\Exception $e) {
                $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.arrecadacaoConsultaEscrituracao.erro'));
                throw $e;
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function calculaValoresAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($dataBase = $request->query->get('dataBase')) {
            $dt = DateTime::createFromFormat('d/m/Y', $dataBase);
        }

        $valores = $datalhamentoValores = (new ConsultaEscrituracaoModel($em))->getDetalhamentoValores($request->query->get('codCalculo'), $dt->format('Y-m-d'));

        if ($valores) {
            return new JsonResponse($valores);
        }

        return new JsonResponse([]);
    }
}
