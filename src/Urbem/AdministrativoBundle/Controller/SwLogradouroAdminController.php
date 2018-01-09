<?php

namespace Urbem\AdministrativoBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\SwBairroLogradouro;
use Urbem\CoreBundle\Entity\SwCepLogradouro;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\SwLogradouroModel;
use Urbem\CoreBundle\Model\SwMunicipioModel;
use Urbem\CoreBundle\Entity\SwLogradouro;

/**
 * Class SwLogradouroAdminController
 *
 * @package Urbem\AdministrativoBundle\Controller
 */
class SwLogradouroAdminController extends CRUDController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function apiMunicipiosAction(Request $request)
    {
        $codUf = $request->get('codUf');
        $q = $request->get('q');

        $objectManager = $this->getDoctrine()->getEntityManager();

        /** @var SwUf $swUf */
        $swUf = $objectManager->find(SwUf::class, $codUf);

        $swMunicipioModel = new SwMunicipioModel($objectManager);

        $queryBuilder = $swMunicipioModel->getMunicipiosBySwUfQuery($swUf);

        $rootAlias = $queryBuilder->getRootAliases();
        $rootAlias = reset($rootAlias);

        $queryBuilder
            ->join("{$rootAlias}.fkSwLogradouros", 'l')
            ->andWhere(
                $queryBuilder->expr()->like(
                    $queryBuilder->expr()->lower("{$rootAlias}.nomMunicipio"),
                    $queryBuilder->expr()->lower(":q")
                )
            )
            ->setParameter('q', "%{$q}%")
        ;

        $items = [];

        /** @var SwMunicipio $swMunucipio */
        foreach ($queryBuilder->getQuery()->getResult() as $swMunucipio) {
            $items[] = [
                'id'    => $swMunicipioModel->getObjectIdentifier($swMunucipio),
                'label' => $swMunucipio->getNomMunicipio()
            ];
        }

        $items = [
            'items' => $items
        ];

        return new JsonResponse($items);
    }

    public function consultarLogradouroAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $logradouro = $em->getRepository(SwLogradouro::class)->findOneBy(['codLogradouro' => $request->attributes->get('id')]);
        if (!$logradouro) {
            return new JsonResponse([]);
        }

        $result = [];
        foreach ($logradouro->getFkSwBairroLogradouros() as $bairroLogradouro) {
            $bairro = $bairroLogradouro->getFkSwBairro();

            $result['bairros'][] = [
                'cod_bairro' => $bairro->getCodBairro(),
                'nom_bairro' => $bairro->getNomBairro(),
            ];
        }

        foreach ($logradouro->getFkSwCepLogradouros() as $cepLogradouro) {
            $cep = $cepLogradouro->getFkSwCep();

            $result['ceps'][] = [
                'cep' => $cep->getCep(),
            ];
        }

        $municipio = $logradouro->getFkSwMunicipio();
        $result['municipio'] = sprintf('%s - %s', $municipio->getCodMunicipio(), $municipio->getNomMunicipio());

        $uf = $municipio->getFkSwUf();
        $result['uf'] = sprintf('%s - %s', $uf->getCodUf(), $uf->getNomUf());

        return new JsonResponse($result);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function apiLogradouroAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        /** @var SwLogradouro $swLogradouro */
        $swLogradouro = $entityManager
            ->getRepository(SwLogradouro::class)
            ->find($request->get('id'));

        if (!$swLogradouro) {
            return new JsonResponse([]);
        }

        $swLogradouroModel = new SwLogradouroModel($entityManager);

        $result = [];
        /** @var SwBairroLogradouro $bairroLogradouro */
        foreach ($swLogradouro->getFkSwBairroLogradouros() as $bairroLogradouro) {
            $bairro = $bairroLogradouro->getFkSwBairro();

            $result['bairros'][] = [
                'value'      => $swLogradouroModel->getObjectIdentifier($bairro),
                'nom_bairro' => $bairro->getNomBairro(),
            ];
        }

        /** @var SwCepLogradouro $cepLogradouro */
        foreach ($swLogradouro->getFkSwCepLogradouros() as $cepLogradouro) {
            $cep = $cepLogradouro->getFkSwCep();

            $result['ceps'][] = [
                'value' => $swLogradouroModel->getObjectIdentifier($cep),
                'cep'   => $cep->getCep(),
            ];
        }

        $municipio = $swLogradouro->getFkSwMunicipio();
        $result['municipio'] = sprintf('%s - %s', $municipio->getCodMunicipio(), $municipio->getNomMunicipio());

        $uf = $municipio->getFkSwUf();
        $result['uf'] = sprintf('%s - %s', $uf->getCodUf(), $uf->getNomUf());

        return new JsonResponse($result);
    }
}
