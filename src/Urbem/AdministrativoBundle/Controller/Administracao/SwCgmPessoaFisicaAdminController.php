<?php

namespace Urbem\AdministrativoBundle\Controller\Administracao;

use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Model\SwCgmPessoaFisicaModel;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SwCgmPessoaFisicaAdminController
 * @package Urbem\AdministrativoBundle\Controller\Administracao
 */
class SwCgmPessoaFisicaAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function autocompleteAction(Request $request)
    {
        $q = strtolower(trim($request->get('q', '')));
        $items = [];

        try {
            /** @var $qb \Doctrine\ORM\QueryBuilder */
            $qb = $this->getDoctrine()
                ->getManager()
                ->getRepository(SwCgmPessoaFisica::class)
                ->createQueryBuilder('pf');

            $qb->leftJoin(SwCgm::class, 'cgm', 'WITH', 'pf.numcgm = cgm.numcgm')
                ->orWhere($qb->expr()->like('LOWER(pf.cpf)', $qb->expr()->literal(sprintf('%%%s%%', $q))))
                ->orWhere($qb->expr()->like('LOWER(cgm.nomCgm)', $qb->expr()->literal(sprintf('%%%s%%', $q))))
                ->setMaxResults(10)
            ;

            /** @var $swCgmPessoaFisica SwCgmPessoaFisica */
            foreach ($qb->getQuery()->getResult() as $swCgmPessoaFisica) {
                $items[] = [
                    'id' => $swCgmPessoaFisica->getNumcgm(),
                    'label' => $swCgmPessoaFisica->getNumcgm() . ' - ' . $swCgmPessoaFisica->getFkSwCgm()->getNomCgm()
                ];
            }
        } catch (\Exception $e) {
            return new JsonResponse(['items' => [], 'error' => true]);
        }

        return new JsonResponse(['items' => $items]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function recuperaEnderecoAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $cgm = $request->get('cgm');

        $swCgmPessoaFisicaModel = new SwCgmPessoaFisicaModel($em);
        $endereco = $swCgmPessoaFisicaModel->getEnderecoByNumCgm($cgm);

        return new JsonResponse($endereco);
    }

    public function recuperaDadosAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $cgm = $request->get('cgm');

        $swCgmPessoaFisicaModel = new SwCgmPessoaFisicaModel($em);
        $dadosPessoaFisica = $swCgmPessoaFisicaModel->getDadosPessoaFisicaByCgm($cgm);

        return new JsonResponse($dadosPessoaFisica);
    }
}
