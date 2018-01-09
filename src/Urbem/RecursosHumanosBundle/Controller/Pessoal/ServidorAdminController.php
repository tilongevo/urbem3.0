<?php
namespace Urbem\RecursosHumanosBundle\Controller\Pessoal;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity;
use Symfony\Component\HttpFoundation\JsonResponse;

class ServidorAdminController extends Controller
{
    /**
     * Retorna o dados de pessoa física
     * @param  Request $request
     * @return JsonResponse
     */
    public function consultaDadosCgmPessoaFisicaAction(Request $request)
    {
        $numCgm = $request->attributes->get('id');
        $translator = $this->get('translator');

        $cgm = $this->getDoctrine()
            ->getRepository('CoreBundle:SwCgm')
            ->findOneBynumcgm($numCgm);

        /**
         * @var Entity\SwCgmPessoaFisica $cgmPf
         */
        $cgmPf = $this->getDoctrine()
            ->getRepository('CoreBundle:SwCgmPessoaFisica')
            ->findOneBynumcgm($numCgm);

        $resultado = array();
        $resultado['endereco'] = $cgm->getLogradouro();
        $resultado['bairro'] = $cgm->getBairro();
        $resultado['cep'] = $cgm->getCep();
        $resultado['fone'] = $cgm->getFoneResidencial();
        $resultado['foneResidencial'] = $cgm->getFoneResidencial();
        $resultado['foneCelular'] = $cgm->getFoneCelular();
        $resultado['enderecoCompleto'] = $resultado['endereco']
        . ", " . $cgm->getNumero()
        . ", " . $resultado['bairro']
        . ", " . $cgm->getFkSwMunicipio()->getNomMunicipio()
        . ", " . $cgm->getFkSwMunicipio()->getFkSwUf()->getNomUf()
        ;

        // SwUf
        $uf = $this->getDoctrine()
            ->getRepository('CoreBundle:SwUf')
            ->findOneByCodUf($cgm->getCodUf());
        $resultado['uf'] = $uf->getNomUf();

        // SwMunicipio
        $mun = $this->getDoctrine()
            ->getRepository('CoreBundle:SwMunicipio')
            ->findOneByCodMunicipio($cgm->getCodMunicipio());

        $resultado['municipio'] = $mun->getNomMunicipio();

        // SwEscolaridade
        $escolaridade = $this->getDoctrine()
            ->getRepository('CoreBundle:SwEscolaridade')
            ->findOneByCodEscolaridade($cgmPf->getCodEscolaridade());
        $escola = ($escolaridade) ? $escolaridade->getDescricao() : " ";
        $resultado['escolaridade'] = $escola;

        $resultado['dtNascimento'] = ($cgmPf->getDtNascimento()) ? $cgmPf->getDtNascimento()->format("d/m/Y") : '';
        if (empty($cgmPf->getSexo())) {
            $resultado['sexo'] = '';
        } else {
            $resultado['sexo'] = $translator->trans($cgmPf->getSexo());
        }
        $resultado['cpf'] = $cgmPf->getCpf();
        $resultado['numerocnh'] = $cgmPf->getNumCnh();
        $resultado['rg'] = $cgmPf->getRg();
        $resultado['orgaoemissor'] = $cgmPf->getOrgaoEmissor();
        $resultado['pis'] = trim($cgmPf->getServidorPisPasep());
        $resultado['categoriacnh'] = (($cgmPf->getCodCategoriaCnh()== null) ? $translator->trans('label.naoInformado') : $cgmPf->getCodCategoriaCnh());
        $resultado['nacionalidade'] = $cgmPf->getFkSwPais()->getNacionalidade();

        return new JsonResponse($resultado);
    }
}
