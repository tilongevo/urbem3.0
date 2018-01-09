<?php

namespace Urbem\AdministrativoBundle\Controller\Cgm;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Licitacao\Convenio;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Model\SwCgmPessoaFisicaModel;

class CgmController extends BaseController
{
    /**
     * Home Cgm
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('AdministrativoBundle::Cgm/home.html.twig');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaSwCgmAction(Request $request)
    {
        $swCgmModel = new SwCgmModel($this->db);
        $queryBuilder = $swCgmModel->carregaSwCgmQuery(strtolower($request->get('q')));
        $cgms = [];

        foreach ($queryBuilder->getQuery()->getResult() as $cgm) {
            array_push(
                $cgms,
                [
                    'id' => $swCgmModel->getObjectIdentifier($cgm),
                    'label' => (string) $cgm
                ]
            );
        }
        $items = [
            'items' => $cgms
        ];
        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaSwCgmPessoaJuridicaAction(Request $request)
    {
        $filtro = $request->get('q');

        $swCgmModel = new SwCgmModel($this->db);
        $queryBuilder = $swCgmModel->carregaSwCgmPessoaJuridicaQuery(strtolower($filtro));
        $result = $queryBuilder->getQuery()->getResult();
        $cgms = [];

        foreach ($result as $cgm) {
            array_push(
                $cgms,
                [
                    'id' => $swCgmModel->getObjectIdentifier($cgm),
                    'label' => (string) $cgm
                ]
            );
        }
        $items = [
            'items' => $cgms
        ];
        return new JsonResponse($items);
    }

    /**
     * @deprecated "Use o campo no modo 'sonata_type_model_autocomplete' ou  'autocomplete' ao inves desse endpoint."
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaParticipanteCertificacaoAction(Request $request)
    {
        trigger_error("Use o campo no modo 'sonata_type_model_autocomplete' ou  'autocomplete' ao inves desse endpoint.");

        $filtro = $request->get('q');

        $swCgmModel = new SwCgmModel($this->db);
        $queryBuilder = $swCgmModel->carregaParticipanteCertificacaoQuery(strtolower($filtro));
        $result = $queryBuilder->getQuery()->getResult();
        $cgms = [];

        foreach ($result as $cgm) {
            array_push(
                $cgms,
                [
                    'id' => $swCgmModel->getObjectIdentifier($cgm),
                    'label' => (string) $cgm
                ]
            );
        }
        $items = [
            'items' => $cgms
        ];
        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function filterSwCgmPessoaFisicaAction(Request $request)
    {
        $filtro = $request->get('q');
        $model = new SwCgmPessoaFisicaModel($this->getDoctrine()->getManager());
        $result = $model->filterPessoaFisicaByName($filtro);

        $cgms = [];

        foreach ($result as $pessoaFisica) {
            /** @var SwCgmPessoaFisica $pessoaFisica */
            array_push($cgms, [
                'id' => $model->getObjectIdentifier($pessoaFisica),
                'label' => $pessoaFisica->getFkSwCgm()->getNomCgm(),
            ]);
        }

        return new JsonResponse(['items' => $cgms]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function filterSwCgmPessoaFisicaNonServidorAction(Request $request)
    {
        $filtro = $request->get('q');
        $model = new SwCgmPessoaFisicaModel($this->getDoctrine()->getManager());
        $result = $model->filterPessoaFisicaByNameNotServidor($filtro);

        $cgms = [];

        foreach ($result as $pessoaFisica) {
            /** @var SwCgmPessoaFisica $pessoaFisica */
            array_push($cgms, [
                'id' => $model->getObjectIdentifier($pessoaFisica),
                'label' => sprintf(
                    '%d - %s',
                    $pessoaFisica->getNumcgm(),
                    $pessoaFisica->getFkSwCgm()->getNomCgm()
                ),
            ]);
        }

        return new JsonResponse(['items' => $cgms]);
    }
}
