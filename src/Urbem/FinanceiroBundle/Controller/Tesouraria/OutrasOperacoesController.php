<?php
namespace Urbem\FinanceiroBundle\Controller\Tesouraria;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Tesouraria\SaldoTesouraria;
use Urbem\CoreBundle\Entity\Tesouraria\Transferencia;
use Urbem\CoreBundle\Repository\Financeiro\Tesouraria\TransferenciaRepository;
use Urbem\CoreBundle\Model;

class OutrasOperacoesController extends BaseController
{
    /**
     * Home
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::Tesouraria/OutrasOperacoes/home.html.twig');
    }

    public function getContasAction(Request $request)
    {
        $codEntidade = $request->get('codEntidade', false);
        $tipoOperacao = $request->get('tipoOperacao', false);
        if (!$codEntidade) {
            throw new \HttpMalformedHeadersException('Entidade parameter is missing');
        }

        //@TODO Melhorar esses ifs
        $filtro = " OR pc.cod_estrutural LIKE '1.1.4.%'";
        if ($tipoOperacao == Model\Tesouraria\TransferenciaModel::APLICACAO) {
            $filtro .= " OR pc.cod_estrutural like '1.2.2.3%'";
        } elseif ($tipoOperacao == Model\Tesouraria\TransferenciaModel::DEPOSITO) {
            $filtro = " OR pc.cod_estrutural like '1.2.2.3%'";
        }

        $params = [
            "pa.cod_plano is not null",
            sprintf("pc.exercicio = '%s'", $this->getExercicio()),
            "(pb.cod_banco is not null AND pb.cod_entidade in ({$codEntidade}) AND (pc.cod_estrutural like '1.1.1.%' {$filtro}))",
            sprintf("(pa.cod_plano = %d OR lower(pc.nom_conta) LIKE lower('%%%s%%') OR lower(pc.cod_estrutural) LIKE '%%%s%%')", $request->get('q'), $request->get('q'), $request->get('q'))
        ];

        $planoBancoModel = new Model\Contabilidade\PlanoBancoModel($this->db);

        $result = $planoBancoModel->getPlanoBanco($params);

        $contaBancos = [];

        foreach ($result as $contaBanco) {
            array_push($contaBancos, ['id' => $contaBanco->cod_plano, 'label' => $contaBanco->cod_reduzido . " - " . $contaBanco->cod_plano ." - ". $contaBanco->nom_conta]);
        }

        $items = [
            'items' => $contaBancos
        ];

        return $this->returnJsonResponse($items);
    }

    public function getSaldoByContaAction(Request $request)
    {
        $conta = $request->get('conta', false);

        if (!$conta) {
            throw new \HttpMalformedHeadersException('Conta parameter is missing');
        }

        $saldoTesourariaEntity = $this->getDoctrine()
            ->getRepository(SaldoTesouraria::class);
        $params = [$this->getExercicio(), $conta, "01/01/" . $this->getExercicio(), ''];

        $saldo = $saldoTesourariaEntity->consultarSaldo($params);

        return $this->returnJsonResponse($saldo);
    }
}
