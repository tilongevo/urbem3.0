<?php
namespace Urbem\PatrimonialBundle\Controller\Frota;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;

class MotoristaAdminController extends Controller
{
    public function consultarDadosCgmMotoristaAction(Request $request)
    {
        $numcgm = $request->attributes->get('id');

        $swPessoa = $this->getDoctrine()
            ->getRepository('CoreBundle:SwCgmPessoaFisica')
            ->findByNumcgm($numcgm);

        $dados = array();

        /** @var SwCgmPessoaFisica $pessoa */
        foreach ($swPessoa as $chave => $pessoa) {
            $dados['numCnh']        = ($pessoa->getNumCnh() ? $pessoa->getNumCnh() : '');
            $dados['dtValidadeCnh'] = ($pessoa->getDtValidadeCnh() ? $pessoa->getDtValidadeCnh()->format('d/m/Y') : '');
            $dados['categoriaCnh']  = ($pessoa->getCodCategoriaCnh() ? $pessoa->getCodCategoriaCnh() : 1);
        }

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function getVeiculosCnhCategoriaAction(Request $request)
    {
        $categoria = $request->attributes->get('id');

        $veiculos = $this->getDoctrine()
            ->getRepository('CoreBundle:Frota\Veiculo')
            ->findByCodCategoria($categoria);

        $dados = array();
        foreach ($veiculos as $veiculo) {
            $dados[$veiculo->getCodVeiculo()] = (string) $veiculo;
        }

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
