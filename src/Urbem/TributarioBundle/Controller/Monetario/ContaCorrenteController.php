<?php

namespace Urbem\TributarioBundle\Controller\Monetario;

use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrente;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio;

/**
 * Class ContaCorrenteController
 * @package Urbem\TributarioBundle\Controller\Monetario
 */
class ContaCorrenteController extends BaseController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository(ContaCorrente::class)->createQueryBuilder('o');

        $this->filterQueryString($qb, $request);

        $results = [];
        foreach ((array) $qb->getQuery()->getResult() as $contaCorrente) {
            $results[] = [
                'id' => sprintf('%d~%d~%d', $contaCorrente->getCodBanco(), $contaCorrente->getCodAgencia(), $contaCorrente->getCodContaCorrente()),
                'cod_conta_corrente' => $contaCorrente->getCodContaCorrente(),
                'num_conta_corrente' => $contaCorrente->getNumContaCorrente(),
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
            return $this->redirect($this->generateUrl('urbem_tributario_monetario_conta_corrente_list', array('codBanco' => $request['banco'])));
        } else {
            return $this->render(
                'TributarioBundle::Monetario/ContaCorrente/filtro.html.twig',
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
            ->setAction($this->generateUrl('tributario_monetario_conta_corrente_filtro'))
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
        $qb->leftjoin(ContaCorrenteConvenio::class, 'ccc', 'WITH', 'ccc.codBanco = o.codBanco AND ccc.codAgencia = o.codAgencia AND ccc.codContaCorrente = o.codContaCorrente');

        $codBanco = $request->get('codBanco');
        $qb->andWhere(sprintf('%s.codBanco = :codBanco', $qb->getRootAlias()));
        $qb->setParameter('codBanco', $codBanco);

        $codAgencia = $request->get('codAgencia');
        $qb->andWhere(sprintf('%s.codAgencia = :codAgencia', $qb->getRootAlias()));
        $qb->setParameter('codAgencia', $codAgencia);

        $codConvenio = $request->get('codConvenio');
        if ($codConvenio) {
            $qb->andWhere('ccc.codConvenio = :codConvenio');
            $qb->setParameter('codConvenio', $codConvenio);
        }
    }
}
