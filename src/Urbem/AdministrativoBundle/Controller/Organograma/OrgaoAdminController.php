<?php

namespace Urbem\AdministrativoBundle\Controller\Organograma;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Urbem\CoreBundle\Model\Organograma\OrgaoModel;

class OrgaoAdminController extends Controller
{
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
    }

    public function consultarNivelAction(Request $request)
    {
        $organograma = $request->request->get('organograma');

        $niveis = $this->getDoctrine()
            ->getRepository('CoreBundle:Organograma\Nivel')
            ->findByCodOrganograma($organograma, array('codNivel' => 'ASC'));

        $listNiveis = array();
        foreach ($niveis as $nivel) {
            $listNiveis[$nivel->getCodNivel()] = [$nivel->getDescricao(), $nivel->getMascaracodigo()];
        }

        $response = new Response();
        $response->setContent(json_encode($listNiveis));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function consultarSuperiorAction(Request $request)
    {
        $codNivel = $request->request->get('codNivel');
        $codOrganograma = $request->request->get('codOrganograma');

        $listOrgaos = array();

        $em = $this->getDoctrine()->getManager();
        $orgaoModel = new OrgaoModel($em);
        $orgaos = $orgaoModel->getOrgaoSuperiorByCodNivel($codOrganograma, $codNivel - 1);

        foreach ($orgaos as $orgao) {
            if ($orgao->getInativacao() == null) {
                $codOrgao = $orgao->getCodOrgao();
                $descricao = $orgao->getFkOrganogramaOrgaoDescricoes()->last()->getDescricao();
                $listOrgaos[$codOrgao] = $descricao;
            }
        }

        $response = new Response();
        $response->setContent(json_encode($listOrgaos));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function consultarOrgaosAction(Request $request)
    {
        $codOrganograma = $request->request->get('codOrganograma');
        $nivel = $request->request->get('nivel');
        $codOrgao = $request->request->get('codOrgao');

        $em = $this->getDoctrine()->getManager();
        $orgaoModel = new OrgaoModel($em);
        $orgaoReduzido = null;
        if ($codOrgao > 0) {
            $orgao = $orgaoModel->getOneOrgaoByCodOrgao($codOrgao);
            $orgaoReduzido = $orgaoModel->getOrgaoReduzido($orgao);
        }

        $orgaos = $orgaoModel->getOrgaosByCodNivel($codOrganograma, $nivel, $orgaoReduzido);

        $listOrgaos = [];
        if (is_array($orgaos)) {
            foreach ($orgaos as $orgao) {
                $listOrgaos[$orgao->getCodOrgao()] = (string) $orgao;
            }
        }

        $response = new Response();
        $response->setContent(json_encode($listOrgaos));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function consultarSubOrgaosAction(Request $request)
    {
        $orgao = $request->request->get('orgao');

        $em = $this->getDoctrine()->getManager();
        $orgaoModel = new OrgaoModel($em);

        $orgaos = $orgaoModel->getFilhoByCodOrgao($orgao);

        $listOrgaos = [];
        if (is_array($orgaos)) {
            foreach ($orgaos as $orgao) {
                $listOrgaos[$orgao->getCodOrgao()] = $orgao->getDescricao()->getDescricao();
            }
        }

        $response = new Response();
        $response->setContent(json_encode($listOrgaos));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function buscaSwCgmPessoaJuridicaAction(Request $request)
    {
        $parameter = $request->get('q');

        $em = $this->getDoctrine()->getManager();
        $orgaoModel = new OrgaoModel($em);

        $result = $orgaoModel->getCgmPessoaJuridica($parameter);

        $cgmPessoaJuridica = [];
        foreach ($result as $value) {
            array_push($cgmPessoaJuridica, ['id' => $value->getNumcgm(), 'label' => $value->getFkSwCgm()->getNomCgm()]);
        }

        $items = [
            'items' => $cgmPessoaJuridica
        ];

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function consultarValorNivelAction(Request $request)
    {
        $codOrgao = $request->request->get('codOrgao');
        $organograma = $request->request->get('organograma');

        $orgaoNiveis = $this->getDoctrine()
            ->getRepository('CoreBundle:Organograma\OrgaoNivel')
            ->findBy(
                [
                    'codOrganograma' => $organograma,
                    'codOrgao' => $codOrgao
                ],
                ['codNivel' => 'ASC']
            );

        $listNiveis = array();
        foreach ($orgaoNiveis as $nivel) {
            $listNiveis[] = str_pad($nivel->getValor(), strlen($nivel->getFkOrganogramaNivel()->getMascaracodigo()), '0', STR_PAD_LEFT);
        }

        $response = new Response();
        $response->setContent(json_encode($listNiveis));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
