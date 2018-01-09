<?php
namespace Urbem\RecursosHumanosBundle\Controller\Estagio;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EntidadeIntermediadoraAdminController extends Controller
{
    public function consultarDadosEntidadeAction(Request $request)
    {
        $swnumcgm = $request->attributes->get('id');

        $swpessoa = $this->getDoctrine()
            ->getRepository('CoreBundle:SwCgmPessoaJuridica')
            ->findByNumcgm($swnumcgm);

        $dados = array();
        foreach ($swpessoa as $chave => $pessoa) {
            $dados['cnpj']      = $pessoa->getCnpj();
            $dados['endereco']  = $pessoa->getFkSwCgm()->getLogradouro();
            $dados['endereco']  = $pessoa->getFkSwCgm()->getLogradouro();
            $dados['bairro']    = $pessoa->getFkSwCgm()->getBairro();
            $dados['municipio'] = $pessoa->getFkSwCgm()->getFkSwMunicipio()->getNomMunicipio();
            $dados['telefone']  = $pessoa->getFkSwCgm()->getFoneComercial();
            $dados['email']     = $pessoa->getFkSwCgm()->getEmail();
        }

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
