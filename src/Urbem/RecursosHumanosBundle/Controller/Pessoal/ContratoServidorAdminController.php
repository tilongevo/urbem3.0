<?php
namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Folhapagamento\Padrao;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Pessoal\CargoModel;
use Urbem\CoreBundle\Model\Pessoal\EspecialidadeModel;
use Urbem\CoreBundle\Model\Pessoal\FaixaTurnoModel;
use Urbem\CoreBundle\Model\Pessoal\SubDivisaoModel;

/**
 * Class ContratoServidorAdminController
 * @package Urbem\RecursosHumanosBundle\Controller\Pessoal
 */
class ContratoServidorAdminController extends Controller
{
    /**
     * Retorna os dados de subdivisao por regime
     * @param  Request $request
     * @return JsonResponse
     */
    public function consultaSubDivisaoRegimeAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $subdivisoes = (new SubDivisaoModel($entityManager))
        ->consultaSubDivisaoRegime($request->request->get('codRegime'));

        return new JsonResponse($subdivisoes);
    }

    /**
     * Retorna lista de cargos por subdivisao
     * @param Request $request
     * @return JsonResponse
     */
    public function consultaCargoSubDivisaoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $cargos = (new CargoModel($entityManager))
        ->consultaCargoSubDivisao($request->request->get('codSubDivisao'));

        return new JsonResponse($cargos);
    }

    /**
     * Retorna a lista de de especialidades por cargo e subdivisao
     * @param Request $request
     * @return JsonResponse
     */
    public function consultaEspecialidadeCargoSubDivisaoAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $especialidades = (new EspecialidadeModel($entityManager))
        ->consultaEspecialidadeCargoSubDivisao(
            $request->request->get('codSubDivisao'),
            $request->request->get('codCargo')
        );

        return new JsonResponse($especialidades);
    }

    /**
     * Retorna a informações salariais
     * @param Request $request
     * @return JsonResponse
     */
    public function consultaInformacoesSalariaisAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $informacoesSalariais = (new CargoModel($entityManager))
        ->consultaInformacoesSalariais([
            'cod_cargo' => $request->request->get('codCargo')
        ]);

        return new JsonResponse($informacoesSalariais);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function calculaSalarioAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $periodoMovimentacao = new PeriodoMovimentacaoModel($entityManager);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        $periodoUnico = reset($periodoUnico);

        $horasMensais = $request->request->get('horasMensais');
        $codPadrao =  $request->request->get('codPadrao');

        $horasMensaisPadrao = ($horasMensais > 0.00) ? $horasMensais : 1;

        $padrao = $entityManager->getRepository(Padrao::class)
        ->getPadraoSalarial([
            'codPadrao' => $codPadrao,
            'vigencia' => $periodoUnico->dt_final
        ]);
        
        $salarioHoraPadrao = $padrao->valor / $horasMensaisPadrao;
        $salario = $salarioHoraPadrao * $horasMensais;

        $numberformat = (new \NumberFormatter(locale_get_default(), \NumberFormatter::DECIMAL));

        return new JsonResponse($numberformat->format($salario));
    }

    public function recuperaGradeHorarioAction(Request $request)
    {
        $codGrade = $request->get('codGrade');

        $em = $this->getDoctrine()->getManager();

        $faixaTurnoModel = new FaixaTurnoModel($em);
        $faixaTurno = $faixaTurnoModel->getFaixaTurno($codGrade);

        return $this->render('@RecursosHumanos/Pessoal/FaixaTurno/turnos.html.twig', [
            "turnos" => $faixaTurno
        ]);
    }
}
