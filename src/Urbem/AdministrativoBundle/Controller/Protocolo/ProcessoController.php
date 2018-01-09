<?php

namespace Urbem\AdministrativoBundle\Controller\Protocolo;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Model\Protocolo\AssuntoAcaoModel;
use Urbem\CoreBundle\Model\SwAssuntoAtributoModel;
use Urbem\CoreBundle\Model\SwDocumentoProcessoModel;
use Urbem\CoreBundle\Model\SwProcessoModel;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProcessoController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();

        return $this->render('AdministrativoBundle::Protocolo/Processo/home.html.twig');
    }

    public function encaminharAction(Request $request)
    {
        $container = $this->container;

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->getConnection()->beginTransaction();
        try {
            $usuario = $container->get('security.token_storage')->getToken()->getUser()->getId();

            $dataForm = $request->request->all();

            foreach ($dataForm['encaminhar'] as $campo => $orgao) {
                if (($orgao != "") && ($campo != "_token")) {
                    $codOrgao = $orgao;
                }
            }

            $codProcesso = $dataForm['processo'];
            $anoExercicio = $dataForm['exercicio'];

            $orgao = $entityManager->getRepository('CoreBundle:Organograma\Orgao')->findOneByCodOrgao($codOrgao);

            $processo = $entityManager->getRepository('CoreBundle:SwProcesso')->findOneBy(['codProcesso' => $codProcesso, 'anoExercicio' => $anoExercicio]);

            $situacao = $entityManager->getRepository('CoreBundle:SwSituacaoProcesso')->findOneByNomSituacao('Em andamento, a receber');

            $swProcessoModel = new SwProcessoModel($entityManager);
            $swProcessoModel->encaminhar($processo, $situacao, $usuario, $orgao);

            $entityManager->getConnection()->commit();
            $container->get('session')->getFlashBag()->add('success', 'Encaminhamento realizado com sucesso.');
        } catch (Exception $e) {
            $entityManager->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', 'Erro ao encaminhar processo.');
            throw $e;
        }

        (new RedirectResponse("/administrativo/protocolo/processo/perfil?id={$codProcesso}~{$anoExercicio}"))->send();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaSwProcessoAction(Request $request)
    {
        $filtro = $request->get('q');
        $exercicio = $request->get('exercicio') ? $request->get('exercicio') : $this->get('urbem.session.service')->getExercicio();
        
        $swProcessoModel = new SwProcessoModel($this->db);
        $queryBuilder = $swProcessoModel->carregaSwProcessosQuery(strtolower($filtro));
        if ($exercicio) {
            $queryBuilder
                ->andWhere("{$queryBuilder->getRootAlias()}.anoExercicio = :exercicio")
                ->setParameter('exercicio', $exercicio);
        }
        $result = $queryBuilder->getQuery()->getResult();
        $processos = [];

        /** @var SwProcesso $processo */
        foreach ($result as $processo) {
            array_push(
                $processos,
                [
                    'id' => $swProcessoModel->getObjectIdentifier($processo),
                    'label' => (string) $processo
                ]
            );
        }

        $items = [
            'items' => $processos
        ];
        return new JsonResponse($items);
    }
}
