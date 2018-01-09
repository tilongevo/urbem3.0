<?php

namespace Urbem\FinanceiroBundle\Controller\Tesouraria;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Model\Tesouraria\Terminal\TerminalModel;

class TerminalAdminController extends Controller
{

    private $routeBase = 'urbem_financeiro_tesouraria_terminal';

    public function gerarVerificadorAction(Request $request)
    {
        $response = new Response();
        $response->setContent(json_encode(['codigo' => $this->gerarVerificador($request)]));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Gera o verificador
     * @param Request $request
     * @return string
     */
    protected function gerarVerificador(Request $request)
    {
        return md5(uniqid(rand(), true));
    }

    /**
     * Desativar o terminal
     * Condições para desaticar um terminal:
     * Os boletins vinculdos com o terminal, não podem estar abertos
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function desativarTerminalAction(Request $request)
    {
        list($terminal, $container, $model) = $this->dados($request);

        //Se existir boletins abertos
        if ($model->verificarSeTemBoletinsAbertos($terminal)) {
            $container->get('session')->getFlashBag()->add('error', 'Você não pode desativar um terminal com boletins em aberto.');
        } else {
            try {
                $terminal = $model->dadosDesativarTerminal($terminal);
                $model->save($terminal);
                $container->get('session')->getFlashBag()->add('success', 'Terminal desativado com sucesso!');
            } catch (\Exception $e) {
                $container->get('session')->getFlashBag()->add('error', 'Erro ao desativar o terminal.');
            }
        }

        return $this->redirectToRoute($this->routeBase . '_list');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function ativarTerminalAction(Request $request)
    {
        $redirect = $this->redirectToRoute($this->routeBase . '_list');
        list($terminal, $container, $model) = $this->dados($request);
        if (empty($terminal->getFkTesourariaTerminalDesativado())) {
            $container->get('session')->getFlashBag()->add('success', 'Você não pode ativar esse terminal, ele não esta desativado!');
            return $redirect;
        }

        try {
            $model->remove($terminal->getFkTesourariaTerminalDesativado());
            $container->get('session')->getFlashBag()->add('success', 'Terminal ativado com sucesso!');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', 'Erro ao ativado o terminal.');
        }

        return $redirect;
    }

    /**
     * Fecha um determinado terminal
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function fecharTerminalAction(Request $request)
    {
        list($terminal, $container, $model) = $this->dados($request);
        $redirect = $this->redirectToRoute($this->routeBase . '_list');

        //Verifica se o terminal esta inativo, o terminal só pode ser fechado se estiver com o status Ativo
        if ($model->verificaAtivoInativo($terminal) == "Inativo") {
            $container->get('session')->getFlashBag()->add('error', 'Você não pode fechar um terminal desativado!');
            return $redirect;
        }

        //Valida se o terminal tem boletins em aberto
        if ($this->seTerminalNaoTemBoletim($terminal)) {
            $container->get('session')->getFlashBag()->add('error', 'Para fechar um terminal, é necessário ter boletins em aberto.');
            return $redirect;
        }

        $model->populaFechamento($terminal);

        try {
            $model->save($terminal);
            $container->get('session')->getFlashBag()->add('success', 'Terminal fechado com sucesso!');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', 'Erro ao fechar o terminal.');
        }

        return $redirect;
    }

    /**
     * Fecha todos os terminais
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function fecharTodosTerminaisAction()
    {
        $redirect = $this->redirectToRoute($this->routeBase . '_list');
        $em = $this->getDoctrine()->getManager();
        $model = new TerminalModel($em);
        $container = $this->container;

        $terminais = $model->findAll();

        foreach ($terminais as $terminal) {
            if ($model->verificaAtivoInativo($terminal) == "Inativo") {
                $container->get('session')->getFlashBag()->add('error', 'Você não pode fechar um terminal desativado!');
                return $redirect;
            }

            if ($this->seTerminalNaoTemBoletim($terminal)) {
                $container->get('session')->getFlashBag()->add('error', 'Um dos terminais não tem boletim.');
                return $redirect;
            }
        }

        $model->populaNFechamento($terminais);

        try {
            $model->fecharNTerminais($terminais);
            $container->get('session')->getFlashBag()->add('success', 'Terminais fechados com sucesso!');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', 'Erro ao fechar os Terminais, alguns terminais podem estar fechados.');
        }

        return $redirect;
    }

    /**
     * Reabrir um terminal
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function reabrirTerminalAction(Request $request)
    {
        $redirect = $this->redirectToRoute($this->routeBase . '_list');
        list($terminal, $container, $model) = $this->dados($request);

        //Verifica se o terminal esta inativo, o terminal só pode ser fechado se estiver com o status Ativo
        if ($model->verificaAtivoInativo($terminal) == "Inativo") {
            $container->get('session')->getFlashBag()->add('error', 'Você não pode reabrir um terminal desativado!');
            return $redirect;
        }

        $model->populaTerminalReabertura($terminal);

        try {
            $model->save($terminal);
            $container->get('session')->getFlashBag()->add('success', 'Terminal reaberto com sucesso!');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', 'Erro ao reabrir o terminal.');
        }

        return $redirect;
    }

    /**
     * valida se o terminal não tem boletim
     * @param $terminal
     * @return bool
     */
    public function seTerminalNaoTemBoletim($terminal)
    {
        if (empty($terminal->getFkTesourariaAberturas()->count())) {
            return true;
        }
        return false;
    }


    /**
     * Retorna os dados necessários para as ações do controller
     * @param Request $request
     * @return array
     */
    protected function dados(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $model = new TerminalModel($em);
        $container = $this->container;

        list($codTerminal, $timesteampTerminal) = explode("~", $request->attributes->get('id'));
        $dadosBusca = ['codTerminal' => $codTerminal, 'timestampTerminal' => $timesteampTerminal];
        $terminal = $model->findOneBy($dadosBusca);

        return [$terminal, $container, $model, $dadosBusca];
    }
}
