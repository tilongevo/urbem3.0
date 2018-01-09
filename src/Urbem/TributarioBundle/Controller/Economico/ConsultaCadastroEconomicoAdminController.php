<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Economico\Licenca;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;

/**
 * Class ConsultaCadastroEconomicoAdminController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class ConsultaCadastroEconomicoAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function apiLoteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $results = ['items' => []];
        if (!$request->get('q')) {
            return new JsonResponse($results);
        }

        $qb = $em->getRepository(Lote::class)->createQueryBuilder('lote');
        $qb->join('lote.fkImobiliarioImovelLotes', 'il');

        $qb->where('lote.codLote >= :codLote');
        $qb->setParameter('codLote', (int) $request->get('q'));

        if ($request->get('codLocalizacao')) {
            $qb->join('lote.fkImobiliarioLoteLocalizacao', 'll');

            $qb->andWhere('ll.codLocalizacao = :codLocalizacao');
            $qb->setParameter('codLocalizacao', $request->get('codLocalizacao'));
        }

        $qb->orderBy('lote.codLote', 'ASC');

        foreach ((array) $qb->getQuery()->getResult() as $lote) {
            $results['items'][] = [
                'id' => $lote->getCodLote(),
                'label' => (string) $lote,
            ];
        }

        return new JsonResponse($results);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function empresaAction(Request $request)
    {
        $admin = $this->admin;
        $admin->showAction = $admin::SHOW_ACTION_EMPRESA;

        return $this->showAction();
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function responsavelAction(Request $request)
    {
        $admin = $this->admin;
        $admin->showAction = $admin::SHOW_ACTION_RESPONSAVEL;

        return $this->showAction();
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function atividadeAction(Request $request)
    {
        $admin = $this->admin;
        $admin->showAction = $admin::SHOW_ACTION_ATIVIDADE;

        return $this->showAction();
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function licencaAction(Request $request)
    {
        $admin = $this->admin;
        $admin->showAction = $admin::SHOW_ACTION_LICENCA;

        return $this->showAction();
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function apiLicencaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $result = [];
        if (!$request->get('codLicenca') || !$request->get('exercicio')) {
            return new JsonResponse($result);
        }

        $licenca = $em->getRepository(Licenca::class)->findOneBy(
            [
                'codLicenca' => $request->get('codLicenca'),
                'exercicio' => $request->get('exercicio'),
            ]
        );

        if (!$licenca) {
            return new JsonResponse($result);
        }

        $result['codLicenca'] = $licenca->getCodLicenca();
        $result['exercicio'] = $licenca->getExercicio();

        $result['licencaAtividades'] = [];
        foreach ($licenca->getFkEconomicoLicencaAtividades() as $licencaAtividade) {
            $result['licencaAtividades'][] = [
                'codAtividade' => $licencaAtividade->getCodAtividade(),
                'atividade' => (string) $licencaAtividade->getFkEconomicoAtividadeCadastroEconomico()->getFkEconomicoAtividade(),
            ];
        }

        foreach ($licenca->getFkEconomicoLicencaEspeciais() as $licencaEspecial) {
            $result['licencaAtividades'][] = [
                'codAtividade' => $licencaEspecial->getCodAtividade(),
                'atividade' => (string) $licencaEspecial->getFkEconomicoAtividadeCadastroEconomico()->getFkEconomicoAtividade(),
            ];
        }

        $results['licencaDiasSemana'] = [];
        foreach ($licenca->getFkEconomicoLicencaDiasSemanas() as $licencaDiasSemana) {
            $result['licencaDiasSemana'][] = [
                'nomDia' => $licencaDiasSemana->getFkAdministracaoDiasSemana()->getNomDia(),
                'hrInicio' => $licencaDiasSemana->getHrInicio()->format('H:i:s'),
                'hrTermino' => $licencaDiasSemana->getHrTermino()->format('H:i:s'),
            ];
        }

        return new JsonResponse($result);
    }
}
