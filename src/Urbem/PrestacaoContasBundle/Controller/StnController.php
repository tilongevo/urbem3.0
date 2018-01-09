<?php

namespace Urbem\PrestacaoContasBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Helper\StringHelper;

class StnController extends BaseController
{
    /**
     * Renderiza a home de configurações de STN
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function configuracoesAction(Request $request)
    {
        $configuracoes = [
            [
                'icon' => 'settings',
                'title' => 'Recurso com FUNDEB',
                'route_list' => null,
                'route_add' => null,
                'route_edit' => null
            ],
            [
                'icon' => 'settings',
                'title' => 'Recurso com MDE',
                'route_list' => null,
                'route_add' => null,
                'route_edit' => null
            ],
            [
                'icon' => 'settings',
                'title' => 'Recurso com salário educação',
                'route_list' => null,
                'route_add' => null,
                'route_edit' => null
            ],
            [
                'icon' => 'settings',
                'title' => 'Recurso com Operações de Crédito MDE',
                'route_list' => null,
                'route_add' => null,
                'route_edit' => null
            ],
            [
                'icon' => 'settings',
                'title' => 'Recurso com Outros Recursos da Educação',
                'route_list' => null,
                'route_add' => null,
                'route_edit' => null
            ],
            [
                'icon' => 'settings',
                'title' => 'Recurso Transferencias SUS',
                'route_list' => null,
                'route_add' => null,
                'route_edit' => null
            ],
            [
                'icon' => 'settings',
                'title' => 'Recurso Operações Crédito Saúde',
                'route_list' => null,
                'route_add' => null,
                'route_edit' => null
            ],
            [
                'icon' => 'settings',
                'title' => 'Outros Recursos Saúde',
                'route_list' => null,
                'route_add' => null,
                'route_edit' => null
            ],
            [
                'icon' => 'settings',
                'title' => 'Receita Corrente Líquida',
                'route_list' => null,
                'route_add' => null,
                'route_edit' => null
            ],
            [
                'icon' => 'settings',
                'title' => 'Despesa Pessoal',
                'route_list' => null,
                'route_add' => null,
                'route_edit' => null
            ],
            [
                'icon' => 'settings',
                'title' => 'Parametros Anexo 13 RREO',
                'route_list' => null,
                'route_add' => null,
                'route_edit' => null
            ],
            [
                'icon' => 'settings',
                'title' => 'Riscos Fiscais',
                'route_list' => null,
                'route_add' => null,
                'route_edit' => null
            ],
            [
                'icon' => 'settings',
                'title' => 'Manter Notas Explicativas',
                'route_list' => null,
                'route_add' => null,
                'route_edit' => null
            ],
            [
                'icon' => 'settings',
                'title' => 'Anexo 3 RCL',
                'route_list' => null,
                'route_add' => null,
                'route_edit' => null
            ],
            [
                'icon' => 'settings',
                'title' => 'Conta Fundeb',
                'route_list' => null,
                'route_add' => null,
                'route_edit' => null
            ],
            [
                'icon' => 'settings',
                'title' => 'RREO Anexo 4',
                'route_list' => null,
                'route_add' => null,
                'route_edit' => null
            ],
        ];

        return $this->processRequestDefaultTemplate('Configurações', $configuracoes);
    }

    /**
     * @param $title
     * @param $configuracoes
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function processRequestDefaultTemplate($title, $configuracoes)
    {
        $this->setBreadCrumb();

        return $this->render(
            'PrestacaoContasBundle::Stn/Configuracoes/home.html.twig',
            [
                'titlePage' => $title,
                'configuracoes' => $configuracoes
            ]
        );
    }
}
