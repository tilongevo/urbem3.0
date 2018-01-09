<?php
namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Model\Pessoal\PensionistaModel;

class PensionistaAdminController extends Controller
{
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
    }
    
    /**
     * Retorna a data de inclusão do processo
     * @param  Request $request
     * @return JsonResponse
     */
    public function consultarDataInclusaoProcessoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $codProcesso = explode("~", $request->request->get('codProcesso'));
        
        $swProcesso = $entityManager->getRepository(SwProcesso::class)
        ->findOneBy(
            array(
                'codProcesso' => $codProcesso[0],
                'anoExercicio' => $codProcesso[1]
            )
        );
        
        return new JsonResponse($swProcesso->getTimestamp()->format("d/m/Y"));
    }
    
    /**
     * Retorna a lista de previdências
     * @param  Request $request
     * @return JsonResponse
     */
    public function previdenciaAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $contratoServidor = $entityManager->getRepository(ContratoServidor::class)
        ->findOneByNumcgm($request->request->get('numcgm'));
        
        $codContrato = null;
        if ($contratoServidor) {
            $codContrato = $contratoServidor['codContrato'];
        }
        
        $previdenciaList = (new PensionistaModel($entityManager))
        ->getPrevidencias($codContrato);
        
        return new JsonResponse($previdenciaList);
    }
}
