<?php
namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PensaoAdminController extends Controller
{
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
    }

    public function consultarMatriculaAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $numcgm = $request->request->get('numcgm');

        $matriculas = (new \Urbem\CoreBundle\Model\Pessoal\PensaoModel($entityManager))
            ->getMatricula($numcgm);

        $response = new Response();
        $response->setContent(json_encode($matriculas));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function consultarDependenteAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $numcgm = $request->request->get('numcgm');

        $dependentes = (new \Urbem\CoreBundle\Model\Pessoal\PensaoModel($entityManager))
            ->getDependentes($numcgm);

        $response = new Response();
        $response->setContent(json_encode($dependentes));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function consultarAgenciaAction(Request $request)
    {
        $codBanco = $request->request->get('codBanco');

        $agenciasList = $this->getDoctrine()
            ->getManager()
            ->getRepository('CoreBundle:Monetario\Agencia')
            ->findByCodBanco($codBanco);

        $agencias = array();
        foreach ($agenciasList as $agenciaKey => $agencia) {
            $agencias[$agencia->getCodAgencia()] = $agencia->getNumAgencia() . " - " . $agencia->getNomAgencia();
        }

        $response = new Response();
        $response->setContent(json_encode($agencias));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function listarDependentesAction(Request $request)
    {
        $codContrato = $request->attributes->get('id');

        $listaDependentes = $this->getDoctrine()
            ->getRepository('CoreBundle:Pessoal\ServidorDependente')
            ->findByCodServidor($codContrato)
        ;

        $dependentesList = [];

        foreach ($listaDependentes as $key => $dataDependente) {
            $nomeDependente = $dataDependente->getCodDependente()->getNumcgm()->getNumcgm()->getNomCgm();
            $cgmDependente =  $dataDependente->getCodDependente()->getCodDependente();

            $dependentesList[$nomeDependente] = $cgmDependente;
        }

        $response = new Response();
        $response->setContent(json_encode($dependentesList));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
