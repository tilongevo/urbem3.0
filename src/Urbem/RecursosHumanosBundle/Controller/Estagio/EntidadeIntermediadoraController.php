<?php
namespace Urbem\RecursosHumanosBundle\Controller\Estagio;

use Urbem\CoreBundle\Controller as ControllerCore;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EntidadeIntermediadoraController extends ControllerCore\BaseController
{
    public function findInstituicaoEnsinoAction(Request $request)
    {
        $swnumcgm = $request->attributes->get('id');

        $swpessoa = $this->getDoctrine()
            ->getRepository('CoreBundle:SwCgmPessoaJuridica')
            ->findByNumcgm($swnumcgm);

        $dados = array();
        foreach ($swpessoa as $chave => $pessoa) {
            $dados['cnpj']      = $pessoa->getCnpj();
            $dados['endereco']  = $pessoa->getNumcgm()->getLogradouro();
            $dados['bairro']    = $pessoa->getNumcgm()->getBairro();
            $dados['municipio'] = $pessoa->getNumcgm()->getCodMunicipio()->getNomMunicipio();
            $dados['telefone']  = $pessoa->getNumcgm()->getFoneComercial();
            $dados['email']     = $pessoa->getNumcgm()->getEmail();
        }

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
