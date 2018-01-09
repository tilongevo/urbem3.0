<?php
namespace Urbem\PatrimonialBundle\Controller\Licitacao;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\PedidoTransferenciaModel;
use Symfony\Component\HttpFoundation\RedirectResponse;

class EditalImpugnadoAdminController extends Controller
{
    public function getAssuntoByClassificacaoAction(Request $request)
    {
        $codClassificacao = $_GET['codClassificacao'];

        $em = $this->getDoctrine()->getManager();

        $assuntos = $em
            ->getRepository(Entity\SwAssunto::class)
            ->findBy([
                'codClassificacao' => $codClassificacao,
            ]);

        $dados = array();
        foreach ($assuntos as $assunto) {
            $dados[$assunto->getCodAssunto()] = $assunto->getCodAssunto() . '-' .$assunto->getNomAssunto();
        }

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getProcessoByClassificacaoAndAssuntoAction(Request $request)
    {
        $codClassificacao = $_GET['codClassificacao'];
        $codAssunto = $_GET['codAssunto'];

        $em = $this->getDoctrine()->getManager();

        $swModel = new Model\SwProcessoModel($em);
        $processos = $swModel->getProcessoByClassificacaoAndAssunto($codClassificacao, $codAssunto);

        $dados = array();
        foreach ($processos as $processo) {
            $dados[$processo->cod_processo] = $processo->cod_processo_completo;
        }

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
