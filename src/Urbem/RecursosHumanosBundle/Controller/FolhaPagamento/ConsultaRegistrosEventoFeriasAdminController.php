<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoFerias;
use Urbem\CoreBundle\Helper\ReportHelper;

/**
 * Class ConsultaRegistrosEventoFeriasAdminController
 * @package Urbem\RecursosHumanosBundle\Controller\FolhaPagamento
 */
class ConsultaRegistrosEventoFeriasAdminController extends CRUDController
{
    const COD_CONFIGURACAO = 2;

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function detalheAction(Request $request)
    {
        $id = $this->admin->getIdParameter();

        $this->admin->setBreadCrumb($id ? ['id' => $id] : [], $request->get('_route'));
        $container = $this->container;
        $em = $this->getDoctrine()->getManager();
        $em->getConnection()->beginTransaction();

        try {
            $id = $request->get($this->admin->getIdParameter());
            list($codContrato, $codPeriodoMovimentacao, $nomCgm, $numCgm, $matricula) = explode('~', $id);

            $eventosCadastrados = $em->getRepository(RegistroEventoFerias::class)
                ->montaRecuperaRelacionamento(' AND cod_contrato = '.$codContrato.' AND cod_periodo_movimentacao = '.$codPeriodoMovimentacao. 'AND natureza != \'B\'');

            $codEventoArray = array();
            foreach ($eventosCadastrados as $eventosCodEvento) {
                array_push($codEventoArray, $eventosCodEvento['cod_evento']);
            }

            $baseCalculos = $em->getRepository(RegistroEventoFerias::class)
                -> recuperaBaseCalculos(
                    array(
                        'codEventos' =>  ReportHelper::getValoresComVirgula($codEventoArray, ''),
                        'codConfiguracao' => self::COD_CONFIGURACAO,
                        'codContrato' =>  $codContrato,
                        'codPeriodoMovimentacao' => $codPeriodoMovimentacao
                    )
                );

            $periodoMovimentacao = $em
                ->getRepository(PeriodoMovimentacao::class)
                ->findOneBy([
                    'codPeriodoMovimentacao' => $codPeriodoMovimentacao,
                ]);

            $object['nome'] = $nomCgm;
            $object['cgm'] = $numCgm;
            $object['matricula'] = $matricula;
            $object['competencia'] = ReportHelper::getMesEmPortugues($periodoMovimentacao->getDtInicial()->format('m')) .'/'.$periodoMovimentacao->getDtInicial()->format('Y');
            $object['periodo'] = $periodoMovimentacao->getDtInicial()->format('d/m/Y'). " à " . $periodoMovimentacao->getDtFinal()->format('d/m/Y');
            $object['eventos'] = $eventosCadastrados;
            $object['calculos'] = $baseCalculos;

            return $this->render('RecursosHumanosBundle::FolhaPagamento/FolhaFerias/ConsultaRegistrosEventoFerias/show.html.twig', array(
                'object' => $object,
            ));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.recursosHumanos.registrosEventoFerias.erro'));
            throw $e;
        }
    }
}
