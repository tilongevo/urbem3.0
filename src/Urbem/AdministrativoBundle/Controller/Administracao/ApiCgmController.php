<?php
namespace Urbem\AdministrativoBundle\Controller\Administracao;

//use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;


class ApiCgmController extends Controller
{
    public function getAllCgmPessoaFisicaAction()
    {
        $cgms = $this->getDoctrine()->getRepository(SwCgmPessoaFisica::class)
            ->findAll();

        $cgmPessoaFisica = [];
        $i =0;
        if (count($cgms)) {
            foreach ($cgms as $cgm) {
                if ($i > 50) break;
                if ($cgm instanceof  SwCgmPessoaFisica);
                $cgmPessoaFisica[] = [
                    'id' => $cgm->getNumcgm(),
                    'label' => $cgm->getFkSwCgm()->getNomCgm(),
                ];

                $i++;
            }
        }

        return new JsonResponse(['items' => $cgmPessoaFisica]);
    }
}
