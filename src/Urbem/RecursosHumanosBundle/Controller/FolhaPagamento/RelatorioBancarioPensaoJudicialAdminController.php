<?php
namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Helper\ArrayHelper;
use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Controller\CRUDController;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;

class RelatorioBancarioPensaoJudicialAdminController extends CRUDController
{
    
    /**
     * @param Request $request
     * @return Response
     */
    public function agenciasPorBancoAction(Request $request)
    {
        if (!$request->request->has('bancos')) {
            $codsBanco = [];
        } else {
            $codsBanco = $request->request->get('bancos');
        }

        $return = [];
        
        if (is_array($codsBanco)) {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository('CoreBundle:Tesouraria\Cheque');
            
            foreach ($codsBanco as $cod) {
                $agencias = $repository->findAllAgenciasPorBancoExercicio(intval($cod), $this->admin->getExercicio());
                $return = array_merge($return, ArrayHelper::parseArrayToChoice($agencias, 'cod_agencia', 'nom_agencia'));
            }
        }
        
        $response = new Response();
        $response->setContent(json_encode(['dados' => $return]));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
    /**
     * @param Request $request
     * @return Response
     */
    public function folhasPorCompetenciaAction(Request $request)
    {
        if ($request->request->has('competencia')) {
            $periodoCompetencia = $request->request->get('competencia');
        }
        
        $complementarArr = [];
        if (isset($periodoCompetencia)) {
            $em = $this->getDoctrine()->getManager();
            $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
            
            $competencia = $periodoMovimentacao->consultaPeriodoMovimentacaoCompetencia($periodoCompetencia);
            $folhasComplementares = $periodoMovimentacao->fetchFolhaComplementar($competencia["cod_periodo_movimentacao"]);
            
            foreach ($folhasComplementares as $folha) {
                $complementarArr[$folha['cod_complementar']] = $folha['cod_complementar'];
            }
        }
        
        $response = new Response();
        $response->setContent(json_encode(['dados' => $complementarArr]));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}
