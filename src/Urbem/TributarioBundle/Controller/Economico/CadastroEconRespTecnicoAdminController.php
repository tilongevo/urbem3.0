<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Economico\BaixaCadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico;

/**
 * Class CadastroEconRespTecnicoAdminController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class CadastroEconRespTecnicoAdminController extends CRUDController
{
    protected $em;

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function definirAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getEntityManager();

        $baixaCadastroEconomico = $this->em->getRepository(BaixaCadastroEconomico::class)
            ->findOneBy(['inscricaoEconomica' => $request->get('id'), 'dtTermino' => null], ['timestamp' => 'desc']);

        if ($baixaCadastroEconomico) {
            return $this->redirect($request->server->get('HTTP_REFERER'));
        }

        return $this->editAction();
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAction(Request $request)
    {
        $this->em = $this->getDoctrine()->getEntityManager();

        $respTecnico = $this->em->getRepository(ResponsavelTecnico::class)->findOneByNumcgm($request->get('id'));
        if (!$respTecnico) {
            return new JsonResponse([], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse(
            [
                'numcgm' => $respTecnico->getNumcgm(),
                'nomCgm' => $respTecnico->getFkSwCgm()->getNomCgm(),
                'numRegistro' => $respTecnico->getNumRegistro(),
                'siglaUf' => $respTecnico->getFkSwUf()->getSiglaUf(),
                'nomProfissao' => $respTecnico->getFkCseProfissao()->getNomProfissao(),
            ]
        );
    }
}
