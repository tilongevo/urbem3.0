<?php

namespace Urbem\CoreBundle\Controller\API;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Model\Organograma\OrganogramaModel;

/**
* OrgaoController.
*/
class OrgaoController extends ControllerCore\BaseController
{
    const NIVEL_UM = 1;
    const NIVEL_DOIS = 2;
    const NIVEL_TRES = 3;

    public function findSecretariaUnidadesByOrgaoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $codOrganograma = $request->get('codOrganograma');
        $codOrgao = $request->get('codOrgao');

        $codOrgao = explode(".",$codOrgao);
        $codOrgao = $codOrgao[0].".";

        $organogramaModel = new OrganogramaModel($entityManager);
        $secretarias = $organogramaModel->listarOrgaosRelacionadosDescricaoComponente($codOrganograma,self::NIVEL_DOIS,$codOrgao);

        $jsonResponse = [];

        foreach ($secretarias as $secretaria) {
            $jsonResponse[] = [
                'cod_orgao' => $secretaria['cod_orgao'],
                'descricao' => $secretaria['descricao']
            ];
        }


        $secretarias = json_encode($jsonResponse);

        $response = new Response();
        $response->setContent($secretarias);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function findUnidadesByOrgaoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $codOrganograma = $request->get('codOrganograma');
        $codOrgao = $request->get('codOrgao');

        $codOrgao = explode(".",$codOrgao);
        $codOrgao = $codOrgao[0].".".$codOrgao[1];

        $organogramaModel = new OrganogramaModel($entityManager);
        $unidades = $organogramaModel->listarOrgaosRelacionadosDescricaoComponente($codOrganograma,self::NIVEL_TRES,$codOrgao);

        $jsonResponse = [];

        foreach ($unidades as $unidade) {
            $jsonResponse[] = [
                'cod_orgao' => $unidade['cod_orgao'],
                'descricao' => $unidade['descricao']
            ];
        }


        $unidades = json_encode($jsonResponse);

        $response = new Response();
        $response->setContent($unidades);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function findConsultaOrgaoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $codOrganograma = $request->get('codOrganograma');
        $codOrgao = $request->get('codOrgao');

        $organogramaModel = new OrganogramaModel($entityManager);
        $orgao = $organogramaModel->consultaOrgao($codOrganograma,$codOrgao);

        $orgao = json_encode($orgao[0]['orgao']);

        $response = new Response();
        $response->setContent($orgao);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
