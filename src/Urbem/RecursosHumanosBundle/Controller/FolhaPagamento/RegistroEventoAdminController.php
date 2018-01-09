<?php

namespace Urbem\RecursosHumanosBundle\Controller\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Entity\Folhapagamento\RegistroEventoComplementar;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoComplementarModel;
use Urbem\CoreBundle\Model\Folhapagamento\RegistroEventoModel;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorModel;

class RegistroEventoAdminController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function recuperaRelacionamentoConfiguracaoAction(Request $request)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        $inCodigoEvento = $request->request->get('inCodigoEvento');
        $inCodSubDivisao = $request->request->get('inCodSubDivisao');
        $inCodCargo = $request->request->get('inCodCargo');
        $inCodEspecialidade = $request->request->get('inCodEspecialidade');

        $stFiltro  = " AND evento.cod_evento = '".$inCodigoEvento."'";
        $stFiltro .= " AND sub_divisao.cod_sub_divisao = ".$inCodSubDivisao;
        $stFiltro .= " AND cargo.cod_cargo = ".$inCodCargo;
        $stFiltro .= ($inCodEspecialidade ) ? " AND especialidade.cod_especialidade = ".$inCodEspecialidade : "";

        $mensagem = '';
        $registroEventoModel = new RegistroEventoModel($entityManager);

        $registros = $registroEventoModel->recuperaRelacionamentoConfiguracao($stFiltro);

        if (!empty($registros)) {
            $mensagem = $this->admin->getTranslator()->trans(
                'rh.folhas.registroEvento.errors.eventoSemConfiguracao',
                [],
                'validators'
            );
        }

        $return = [
            'mensagem' => $mensagem,
        ];

        return new JsonResponse($return);
    }
}
