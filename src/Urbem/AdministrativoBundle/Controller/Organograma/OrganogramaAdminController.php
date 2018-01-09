<?php

namespace Urbem\AdministrativoBundle\Controller\Organograma;

use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Normas\Norma;

class OrganogramaAdminController extends Controller
{
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
    }

    public function consultarNormaAction(Request $request)
    {
        $tipo = $request->attributes->get('id');

        $normas = [];
        if (isset($tipo)) {
            $normas = $this
                ->getDoctrine()
                ->getRepository(Norma::class)
                ->findByCodTipoNorma($tipo, [
                    'numNorma' => 'ASC',
                    'exercicio' => 'ASC'
                ]);
        }

        $listNormas = [];

        /** @var Norma $norma */
        foreach ($normas as $norma) {
            $listNormas[] = [
                'label' => $norma->getNomNorma(),
                'value' => $norma->getCodNorma()
            ];
        }

        $response = new Response();
        $response->setContent(json_encode($listNormas));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
