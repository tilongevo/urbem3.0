<?php

namespace Urbem\PatrimonialBundle\Controller\Almoxarifado;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CentroCustoModel;

/**
 * Compras\Contrato controller.
 *
 */
class CentroCustoController extends ControllerCore\BaseController
{
    public function getByCodEntidadeAction(Request $request)
    {
        /**
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getDoctrine()->getEntityManager();

        /**
         * @var Usuario $usuarioLogado
         */
        $usuarioLogado = $this->getUser();

        $codEntidade = $request->get('cod_entidade');

        $entidade = $entityManager
            ->getRepository(Orcamento\Entidade::class)
            ->find($codEntidade);

        $centroCustoModel = new CentroCustoModel($entityManager);
        $result = $centroCustoModel->getCentroCustoByPermission($usuarioLogado->getNumcgm(), $entidade);

        $normalizer = new ObjectNormalizer();
        $encoder = new JsonEncoder();

        $serializer = new Serializer([$normalizer], [$encoder]);
        $centrosCusto = $serializer->serialize($result, 'json');

        $response = new Response();
        $response->setContent($centrosCusto);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
