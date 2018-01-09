<?php

namespace Urbem\FinanceiroBundle\Controller\Tesouraria;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Contabilidade\HistoricoContabilModel;
use Urbem\CoreBundle\Model\Contabilidade\PlanoBancoModel;
use Urbem\CoreBundle\Model\Contabilidade\PlanoContaModel;
use Urbem\CoreBundle\Model\Empenho\ReciboExtraModel;
use Urbem\CoreBundle\Model\Orcamento\RecursoModel;
use Urbem\CoreBundle\Model\PessoaFisicaJuridicaModel;
use Urbem\CoreBundle\Model\Tesouraria\ArrecadacaoModel;
use Urbem\CoreBundle\Model\Tesouraria\Boletim\BoletimModel;
use Urbem\CoreBundle\Model;

class ArrecadacaoController extends BaseController
{
    /**
     * Home
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::Tesouraria/Arrecadacao/home.html.twig');
    }

    public function permissaoAction(Request $request)
    {
        $codigo = md5(uniqid(rand(), true));

        $parametros = array(
            'titulo' => 'Acesso negado!',
            'mensagem' => 'Informe o Nome de Usuário e o Código do Terminal ao Administrador do sistema.',
            'voltar' => '/financeiro/tesouraria/arrecadacao/',
            'codigo' => $codigo
        );

        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::Tesouraria/Arrecadacao/permissao.html.twig', array(
            'parametro' => $parametros
        ));
    }

    public function buscaBoletimAction(Request $request)
    {
        $params = [
            sprintf("exercicio = '%s'", $this->getExercicio()),
            sprintf("cod_entidade IN (%s)", $request->get('entidade')),
        ];

        $boletimModel = new BoletimModel($this->db);
        $boletins = $boletimModel->getBoletins($params);

        $response = new Response();
        $response->setContent(json_encode($boletins));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function buscaReciboAction(Request $request)
    {
        $paramsBoletim = [
            sprintf('cod_boletim = %s', $request->get('boletim')),
            sprintf('cod_entidade = %s', $request->get('entidade')),
        ];
        $boletim = new BoletimModel($this->db);
        $boletim = current($boletim->getBoletins($paramsBoletim));
        list($diaBoletim, $mesBoletim, $anoBoletim) = explode('/', $boletim->dt_boletim);

        $arrecadacaoModel = new ArrecadacaoModel($this->db);
        if (!$arrecadacaoModel->isValidBoletimMes($this->getExercicio(), $mesBoletim)) {
            $error = ['error' => "Mês do Boletim encerrado!"];
            $response = new Response();
            $response->setContent(json_encode($error));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        $params = [
            "tipo_recibo = 'R'",
            sprintf("exercicio = '%s'", $this->getExercicio()),
            sprintf("cod_recibo_extra = '%s'", (int) $request->get('recibo')),
            sprintf("cod_entidade = %s", (int) $request->get('entidade')),
        ];

        $reciboExtraModel = new ReciboExtraModel($this->db);
        $recibos = $reciboExtraModel->getReciboExtra($params);

        $response = new Response();
        $response->setContent(json_encode($recibos));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function buscaCredorAction(Request $request)
    {
        $numcgm = $request->get('q');
        $searchSql = is_numeric($numcgm) ?
            sprintf("numcgm = %s", $numcgm) :
            sprintf("(lower(nom_cgm) LIKE '%%%s%%')", $request->get('q'));

        $params = [$searchSql];
        $credorModel = new PessoaFisicaJuridicaModel($this->db);
        $result = $credorModel->getPessoaFisicaJuridica($params);
        $credores = [];

        foreach ($result as $credor) {
            array_push($credores, ['id' => $credor->numcgm, 'label' => $credor->numcgm . " - " . $credor->nom_cgm]);
        }

        $items = [
            'items' => $credores
        ];
        return new JsonResponse($items);
    }

    public function buscaRecursoAction(Request $request)
    {
        $params = [
            sprintf("(lower(nom_recurso) LIKE '%%%s%%' OR lower(cod_fonte) LIKE '%%%s%%')", $request->get('q'), $request->get('q')),
            sprintf("exercicio = '%s'", $this->getExercicio())
        ];
        $recursoModel = new RecursoModel($this->db);
        $result = $recursoModel->getRecursos($params);
        $recursos = [];

        foreach ($result as $recurso) {
            array_push($recursos, ['id' => $recurso->cod_recurso, 'label' => $recurso->cod_fonte . " - " . $recurso->nom_recurso]);
        }

        $items = [
            'items' => $recursos
        ];
        return new JsonResponse($items);
    }

    public function buscaHistoricoPadraoAction(Request $request)
    {
        $historicoContabilModel = new HistoricoContabilModel($this->db);
        $tipoOperacao = $request->get('tipoOperacao', false);

        $result = $historicoContabilModel->getHistoricoContabil($this->getExercicio(), $request->get('q'));
        $historicos = [];

        foreach ($result as $historico) {
            array_push($historicos, ['id' => $historico->getCodHistorico(), 'label' => $historico->getCodHistorico() . " - " . $historico->getNomHistorico()]);
        }

        $items = [
            'items' => $historicos
        ];

        return new JsonResponse($items);
    }

    public function buscaContaReceitaAction(Request $request)
    {
        $params = [
            sprintf("pc.exercicio = '%s'", $this->getExercicio()),
            sprintf("(lower(pc.nom_conta) LIKE lower('%%%s%%') OR lower(pc.cod_estrutural) LIKE '%%%s%%')", $request->get('q'), $request->get('q'))
        ];
        $planoContasModel = new PlanoContaModel($this->db);
        $result = $planoContasModel->getContasExtra($params, $this->getExercicio());
        $contas = [];

        foreach ($result as $conta) {
            array_push($contas, ['id' => $conta->cod_plano, 'label' => $conta->cod_reduzido . " - " . $conta->nom_conta]);
        }

        $items = [
            'items' => $contas
        ];

        return new JsonResponse($items);
    }

    public function buscaContaDespesaAction(Request $request)
    {
        $params = [
            sprintf("pc.exercicio = '%s'", $this->getExercicio()),
            sprintf("(lower(pc.nom_conta) LIKE lower('%%%s%%') OR lower(pc.cod_estrutural) LIKE '%%%s%%')", $request->get('q'), $request->get('q'))
        ];
        $planoContasModel = new PlanoContaModel($this->db);
        $result = $planoContasModel->getContasExtra($params, $this->getExercicio(), "pagamento_extra");
        $contas = [];

        foreach ($result as $conta) {
            array_push($contas, ['id' => $conta->cod_plano, 'label' => $conta->cod_reduzido . " - " . $conta->nom_conta]);
        }

        $items = [
            'items' => $contas
        ];

        return new JsonResponse($items);
    }

    public function buscaContaCaixaAction(Request $request)
    {
        $codEntidade = $request->get('codEntidade');
        $params = [
            "pa.cod_plano is not null",
            sprintf("pc.exercicio = '%s'", $this->getExercicio()),
            "(pb.cod_banco is not null AND pb.cod_entidade in ({$codEntidade}) AND (pc.cod_estrutural like '1.1.1.%' OR pc.cod_estrutural like '1.1.4.%'))",
            sprintf("(lower(pc.nom_conta) LIKE lower('%%%s%%') OR lower(pc.cod_estrutural) LIKE '%%%s%%')", $request->get('q'), $request->get('q'))
        ];

        $planoBancoModel = new PlanoBancoModel($this->db);
        $result = $planoBancoModel->getPlanoBanco($params);
        $contaBancos = [];

        foreach ($result as $contaBanco) {
            array_push($contaBancos, ['id' => $contaBanco->cod_plano, 'label' => $contaBanco->cod_reduzido . " - " . $contaBanco->nom_conta]);
        }

        $items = [
            'items' => $contaBancos
        ];

        return new JsonResponse($items);
    }
}
