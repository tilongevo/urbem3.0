<?php
namespace Urbem\RecursosHumanosBundle\Controller\Api;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Model\Pessoal\EspecialidadeModel;

/**
 * Folhapagamento\Fgts controller.
 *
 */
class EspecialidadeController extends ControllerCore\BaseController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function carregaCargoEspecialidadeAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var EspecialidadeModel $especialidadeModel */
        $especialidadeModel = new EspecialidadeModel($em);

        $filtro = $request->get('q');

        $cargoList = $especialidadeModel->consultaCargoSubDivisaoRegime($filtro);

        $cargos = array();

        foreach ($cargoList as $key => $cargo) {
            array_push(
                $cargos,
                array(
                    'id' => $key,
                    'label' => $cargo
                )
            );
        }

        $items = array(
            'items' => $cargos
        );

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function carregaEspecialidadeByCargoAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var EspecialidadeModel $especialidadeModel */
        $especialidadeModel = new EspecialidadeModel($em);
        
        list($codRegime, $codSubDivisao, $codCargo) = explode('~', $request->get('codCargo'));

        $especialidadeList = $especialidadeModel->consultaEspecialidadeCargo($codCargo, false, true);

        $especialidades = [];

        foreach ($especialidadeList as $especialidade) {
                $especialidades[$especialidade['cod_especialidade']]['value'] = $especialidade['cod_especialidade'];
                $especialidades[$especialidade['cod_especialidade']]['label'] = (isset($especialidade['descricao'])) ? $especialidade['descricao'] : '';
        }

        return new JsonResponse($especialidades);
    }
}
