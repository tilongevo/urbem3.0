<?php

namespace Urbem\RecursosHumanosBundle\Controller\Calendario;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Repository\RecursosHumanos\Calendario\FeriadoRepository;

class CalendarioCadastroAdminController extends CRUDController
{
    /**
     * The default value is 0 to skip the calendar search
     */
    const CALENDAR_DEFAULT_CODE = 0;

    /**
     * @param Request $request
     * @return Response
     */
    public function listarFeriadosAction(Request $request)
    {
        $ano = $request->attributes->get('id');
        $date = new \Datetime();
        $date->setDate($ano, 01, 01);

        $feriadosResult = $this->getDoctrine()
            ->getRepository('CoreBundle:Calendario\Feriado')
            ->getFeriadoPorAno(
                self::CALENDAR_DEFAULT_CODE,
                $date,
                FeriadoRepository::FREE_DATES
            );

        $retorno = [];
        $feriados = array();
        if ($feriadosResult) {
            foreach ($feriadosResult as $chave => $feriado) {
                $dataFeriado = new \DateTime($feriado->dt_feriado);
                $feriados[$feriado->cod_feriado] = $dataFeriado->format("d/m/Y"). ' - ' . $feriado->descricao;
            }
            $retorno['feriados'] = $feriados;
        } else {
            $retorno['feriados'] = null;
        }

        $response = new Response();
        $response->setContent(json_encode($retorno));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
