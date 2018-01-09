<?php

namespace Urbem\TributarioBundle\Controller\Economico;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomicoAutonomo;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaFato;
use Urbem\CoreBundle\Entity\SwCgm;

/**
 * Class CadastroEconomicoController
 * @package Urbem\TributarioBundle\Controller\Economico
 */
class CadastroEconomicoController extends BaseController
{
    const ENQUADRAMENTO_EMPRESA_FATO = 'empresa_fato';
    const ENQUADRAMENTO_EMPRESA_DIREITO = 'empresa_direito';
    const ENQUADRAMENTO_AUTONOMO = 'autonomo';
    const ENQUADRAMENTOS = [
        'Empresa de Fato' => self::ENQUADRAMENTO_EMPRESA_FATO,
        'Empresa de Direito' => self::ENQUADRAMENTO_EMPRESA_DIREITO,
        'Autônomo' => self::ENQUADRAMENTO_AUTONOMO,
    ];

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function homeAction(Request $request)
    {
        $this->setBreadCrumb();

        $form = $this->generateForm();
        $form->handleRequest($request);
        if (!$form->isSubmitted() || !in_array($form->get('enquadramento')->getData(), $this::ENQUADRAMENTOS)) {
            return $this->render(
                'TributarioBundle::Economico/CadastroEconomico/home.html.twig',
                [
                    'form' => $form->createView(),
                ]
            );
        }

        $path = sprintf('urbem_tributario_economico_cadastro_economico_%s_list', $form->get('enquadramento')->getData());

        return $this->redirect($this->generateUrl($path));
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    private function generateForm()
    {
        $form = $this->createFormBuilder([])
            ->add(
                'enquadramento',
                'choice',
                [
                    'choices' => $this::ENQUADRAMENTOS,
                    'required' => true,
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->setAction($this->generateUrl('tributario_economico_cadastro_economico_home'))
            ->getForm();

        return $form;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function apiInscricaoEconomicaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $results = ['items' => []];
        if (!$request->get('q')) {
            return new JsonResponse($results);
        }

        $qb = $em->getRepository(CadastroEconomico::class)->createQueryBuilder('ce');
        $qb->leftJoin(
            CadastroEconomicoAutonomo::class,
            'cea',
            'WITH',
            sprintf('%s.inscricaoEconomica = cea.inscricaoEconomica', $qb->getRootAlias())
        );
        $qb->leftJoin(
            CadastroEconomicoEmpresaFato::class,
            'ceef',
            'WITH',
            sprintf('%s.inscricaoEconomica = ceef.inscricaoEconomica', $qb->getRootAlias())
        );
        $qb->leftJoin(
            CadastroEconomicoEmpresaDireito::class,
            'ceed',
            'WITH',
            sprintf('%s.inscricaoEconomica = ceed.inscricaoEconomica', $qb->getRootAlias())
        );

        $qb->join(
            SwCgm::class,
            'cgm',
            'WITH',
            'cgm.numcgm = COALESCE(cea.numcgm, ceef.numcgm, ceed.numcgm)'
        );

        $qb->where('LOWER(cgm.nomCgm) LIKE :nomCgm');
        $qb->orWhere('cgm.numcgm = :numcgm');
        $qb->orWhere('cgm.numcgm = :numcgm');
        $qb->orWhere(sprintf('%s.inscricaoEconomica = :inscricaoEconomica', $qb->getRootAlias()));

        $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($request->get('q'))));
        $qb->setParameter('numcgm', sprintf('%d', $request->get('q')));
        $qb->setParameter('inscricaoEconomica', sprintf('%d', $request->get('q')));

        $qb->orderBy('cgm.nomCgm', 'ASC');

        foreach ((array) $qb->getQuery()->getResult() as $inscricaoEconomica) {
            $results['items'][] = [
                'id' => $inscricaoEconomica->getInscricaoEconomica(),
                'label' => (string) $inscricaoEconomica,
            ];
        }

        return new JsonResponse($results);
    }
}
