<?php

namespace Urbem\FinanceiroBundle\Controller\Orcamento;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;

class ConfiguracaoController extends BaseController
{
    /**
     * Home
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::Orcamento/Configuracao/home.html.twig');
    }

    public function permissaoAction(Request $request)
    {
        $id = $request->query->get('id');

        $parametros['padrao'] = array(
            'titulo' => 'Ação não permitida',
            'mensagem' => 'O sistema não está configurado para utilizar a Destinação de Recursos.',
            'voltar' => '/financeiro/plano-plurianual/destinacao-recursos/',
        );

        if (isset($parametros[$id])) {
            $parametro = $parametros[$id];
        } else {
            $parametro = $parametros['padrao'];
        }

        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::Orcamento/Configuracao/configuracao.html.twig', array(
            'parametro'  => $parametro
        ));
    }
}
