<?php
namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Doctrine\Common\Collections\ArrayCollection;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\SwCgm;

/**
 * Class AlmoxarifadoAdminController
 * @package Urbem\PatrimonialBundle\Controller\Almoxarifado
 */
class AlmoxarifadoAdminController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function dadosAlmoxarifadoAction(Request $request)
    {
        $numcgm = $request->attributes->get('id');

        /** @var SwCgm $cgm */
        $cgm = $this->getDoctrine()
            ->getRepository(SwCgm::class)
            ->find($numcgm);

        $dados = new ArrayCollection();
        $dados->set('telefone', trim($cgm->getFoneComercial()));
        $dados->set('endereco', sprintf(
            "%s, %s, %s",
            trim($cgm->getLogradouro()),
            trim($cgm->getNumero()),
            trim($cgm->getBairro())
        ));

        $response = new Response();
        $response->setContent(json_encode($dados->toArray()));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
