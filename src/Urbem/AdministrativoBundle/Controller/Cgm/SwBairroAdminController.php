<?php

namespace Urbem\AdministrativoBundle\Controller\Cgm;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Controller\CRUDController as Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\SwMunicipioModel;

class SwBairroAdminController extends Controller
{
    public function load(array $configs, ContainerBuilder $container)
    {
        parent::load($configs, $container);
    }

    public function consultarMunicipioAction(Request $request)
    {
        $codUf = $request->attributes->get('id');

        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        /** @var SwUf $swUf */
        $swUf = $entityManager->find(SwUf::class, $codUf);

        $swMunicipioModel = new SwMunicipioModel($entityManager);
        $swMunicipios = $swMunicipioModel->getMunicipiosByUf($swUf);

        $listMunicipios = [];

        /** @var SwMunicipio $swMunicipio */
        foreach ($swMunicipios as $swMunicipio) {
            array_push($listMunicipios, [
                'label' => $swMunicipio->getNomMunicipio(),
                'value' => $swMunicipioModel->getObjectIdentifier($swMunicipio)
            ]);
        }

        $response = new Response();
        $response->setContent(json_encode($listMunicipios));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
