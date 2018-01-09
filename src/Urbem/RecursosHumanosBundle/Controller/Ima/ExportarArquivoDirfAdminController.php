<?php

namespace Urbem\RecursosHumanosBundle\Controller\Ima;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Pessoal\SubDivisao;
use Urbem\CoreBundle\Entity\Pessoal\Especialidade;
use Urbem\CoreBundle\Model\Pessoal\CargoSubDivisaoModel;

class ExportarArquivoDirfAdminController extends Controller
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function downloadAction(Request $request)
    {
        $file = $request->query->get('file');

        $content = file_get_contents('/tmp/'.$file);

        $fileName = "DIRF.txt";
        
        return new Response(
            $content,
            200,
            [
                'Content-type' => 'text/plain; charset=ISO-8859-15',
                'Content-disposition' => sprintf('attachment; filename=' . $fileName)
            ]
        );
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function detalhesAction(Request $request)
    {
        $this->admin->setBreadCrumb();
        if ($request->query->has('fs')) {
            $hash = $request->query->get('fs');
            $decoded = base64_decode($hash);
            
            $data = ['file' => $decoded];
        } else {
            $ano = $request->query->get("errConfigDirf");
            $data = ['errConfigDirf' => $ano];
        }
        
        return $this->render('RecursosHumanosBundle:Ima/ExportarArquivoDirf:detalhe.html.twig', $data);
    }
    
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function subDivisaoPorRegimeAction(Request $request)
    {
        if (!$request->request->has('regimes')) {
            $codRegimes = [];
        } else {
            $codRegimes = $request->request->get('regimes');
        }
        
        $return = [];
        
        if (is_array($codRegimes) && !empty($codRegimes)) {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository(SubDivisao::class);
            $arr = $repository->findBy(["codRegime" => $codRegimes]);
            
            foreach ($arr as $subdiv) {
                $return[$subdiv->getCodSubDivisao()] = $subdiv->getCodSubDivisao() . " - " . $subdiv->getDescricao();
            }
        }
        
        $response = new Response();
        $response->setContent(json_encode(['dados' => $return]));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function cargosPorSubdivisaoAction(Request $request)
    {
        if (!$request->request->has('subdivisoes')) {
            $codSubDivisoes = [];
        } else {
            $codSubDivisoes = $request->request->get('subdivisoes');
        }
        $ano = 2016;
        
        $return = [];
        
        if (is_array($codSubDivisoes) && !empty($codSubDivisoes)) {
            $em = $this->getDoctrine()->getManager();
            $cargoSubDiv = new CargoSubDivisaoModel($em);
            $arr = $cargoSubDiv->getCargosPorSubDivisaoPerioro($codSubDivisoes, $ano);
            
            foreach ($arr as $cargo) {
                $return[$cargo['cod_cargo']] = $cargo['cod_cargo'] . " - " . $cargo['descricao'];
            }
        }
        
        $response = new Response();
        $response->setContent(json_encode(['dados' => $return]));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function especialidadePorCargoAction(Request $request)
    {
        if (!$request->request->has('cargos')) {
            $codCargos = [];
        } else {
            $codCargos = $request->request->get('cargos');
        }
        
        $return = [];
        
        if (is_array($codCargos) && !empty($codCargos)) {
            $em = $this->getDoctrine()->getManager();
            $repository = $em->getRepository(Especialidade::class);
            $arr = $repository->findBy(["codCargo" => $codCargos]);
            
            foreach ($arr as $especialidade) {
                $return[$especialidade->getCodEspecialidade()] = 
                    $especialidade->getCodEspecialidade()." - ".
                    $especialidade->getCodCargo()." - ".
                    $especialidade->getDescricao()
                ;
            }
        }
        
        $response = new Response();
        $response->setContent(json_encode(['dados' => $return]));
        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
}
