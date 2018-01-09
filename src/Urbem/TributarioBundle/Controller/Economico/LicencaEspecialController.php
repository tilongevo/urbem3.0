<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Administracao\DiasSemana;
use Urbem\CoreBundle\Model\Economico\LicencaDiasSemanaModel;

/**
 * Class LicencaEspecialController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class LicencaEspecialController extends BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('TributarioBundle::Economico/Licenca/home.html.twig');
    }

    /**
     * @param Request $request
     */
    public function getDiasSemanaByCodLicencaAction(Request $request)
    {
        $codLicenca = $request->query->get('codLicenca');
        $exercicio = $this->getExercicio();
        $em = $this->getDoctrine()->getManager();

        $licencaDiasSemanaModel = new LicencaDiasSemanaModel($em);
        $dias = $licencaDiasSemanaModel
            ->getLicencaDiasByCodLicencaAndExercicio($codLicenca, $exercicio);

        $dias_arr = array();
        foreach ($dias as $d) {
            $nomeDia = $em->getRepository(DiasSemana::class)
                ->findOneByCodDia($d->getCodDia());
            $diaSelecionado = [
                'dia' => $d->getCodDia(),
                'nome' => $nomeDia->getNomDia(),
                'inicio' => $d->getHrInicio()->format('H:m'),
                'termino' => $d->getHrTermino()->format('H:m')
            ];
            array_push($dias_arr, $diaSelecionado);
        }

        $items = [
            'items' => $dias_arr
        ];

        return new JsonResponse($items);
    }
}
