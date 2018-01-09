<?php

namespace Urbem\TributarioBundle\Controller\Monetario;

use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio;

/**
 * Class AgenciaController
 * @package Urbem\TributarioBundle\Controller\Monetario
 */
class AgenciaController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository(Agencia::class)->createQueryBuilder('o');

        $this->filterQueryString($qb, $request);

        $results = [];
        foreach ((array) $qb->getQuery()->getResult() as $agencia) {
            $results[] = [
                'id' => sprintf('%d~%d', $agencia->getCodBanco(), $agencia->getCodAgencia()),
                'cod_agencia' => $agencia->getCodAgencia(),
                'num_agencia' => $agencia->getNumAgencia(),
            ];
        }
        return new JsonResponse($results);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function filtroAction(Request $request)
    {
        $this->setBreadCrumb();

        $form = $this->generateForm();
        $form->handleRequest($request);

        $retorno = ['form' => $form->createView()];
        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $request = $request->request->get('form');
            return $this->redirect($this->generateUrl('urbem_tributario_monetario_agencia_list', array('codBanco' => $request['banco'])));
        } else {
            return $this->render(
                'TributarioBundle::Monetario/Agencia/filtro.html.twig',
                $retorno
            );
        }
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    private function generateForm()
    {
        $form = $this->createFormBuilder([])
            ->add(
                'banco',
                EntityType::class,
                array(
                    'class' => Banco::class,
                    'label' => false,
                    'required' => true,
                    'choice_value' => 'codBanco',
                    'placeholder' => 'label.selecione',
                    'query_builder' => function ($em) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->orderBy('o.numBanco', 'ASC');

                        return $qb;
                    },
                    'choice_label' => function ($codBanco) {
                        return sprintf('%d - %s', $codBanco->getNumBanco(), $codBanco->getNomBanco());
                    },
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                )
            )
            ->setAction($this->generateUrl('tributario_monetario_agencia_filtro'))
            ->getForm();

        return $form;
    }

    /**
     * @param QueryBuilder $qb
     * @param Request $request
     * @return void
     */
    protected function filterQueryString(QueryBuilder $qb, Request $request)
    {
        $qb->leftjoin(ContaCorrenteConvenio::class, 'ccc', 'WITH', 'ccc.codBanco = o.codBanco AND ccc.codAgencia = o.codAgencia');

        $codBanco = $request->get('codBanco');
        $qb->where(sprintf('%s.codBanco = :codBanco', $qb->getRootAlias()));
        $qb->setParameter('codBanco', $codBanco ?: null);

        $codConvenio = $request->get('codConvenio');
        if ($codConvenio) {
            $qb->andWhere('ccc.codConvenio = :codConvenio');
            $qb->setParameter('codConvenio', $codConvenio);
        }
    }
}
