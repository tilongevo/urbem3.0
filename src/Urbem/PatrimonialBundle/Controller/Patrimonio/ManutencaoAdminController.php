<?php
namespace Urbem\PatrimonialBundle\Controller\Patrimonio;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ManutencaoAdminController extends Controller
{
    public function consultarGrupoAction(Request $request)
    {
        $codNatureza = $request->attributes->get('id');

        $grupos = $this->getDoctrine()
            ->getRepository('CoreBundle:Patrimonio\Grupo')
            ->findByCodNatureza($codNatureza, array('nomGrupo' => 'ASC'));

        $listGrupos = array();
        foreach ($grupos as $chave => $grupo) {
            $listGrupos[$grupo->getCodGrupo()] = (string) $grupo;
        }

        $response = new Response();
        $response->setContent(json_encode($listGrupos));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function consultarEspecieAction(Request $request)
    {
        $codNatureza = $request->attributes->get('cod_natureza');
        $codGrupo = $request->attributes->get('id');

        $especies = $this->getDoctrine()
            ->getRepository('CoreBundle:Patrimonio\Especie')
            ->findBy(
                [
                    'codGrupo' => $codGrupo,
                    'codNatureza' => $codNatureza
                ],
                [
                    'nomEspecie' => 'ASC'
                ]
            );

        $listEspecies = array();
        foreach ($especies as $chave => $especie) {
            $listEspecies[$especie->getCodEspecie()] = (string) $especie;
        }

        $response = new Response();
        $response->setContent(json_encode($listEspecies));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function consultarBemAction(Request $request)
    {
        $codEspecie = $request->attributes->get('id');

        $bens = $this->getDoctrine()
            ->getRepository('CoreBundle:Patrimonio\Bem')
            ->findByCodEspecie($codEspecie, array('descricao' => 'ASC'));

        $listBens = array();
        foreach ($bens as $chave => $bem) {
            $listBens[$bem->getCodBem()] = $bem->getDescricao();
        }

        $response = new Response();
        $response->setContent(json_encode($listBens));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
