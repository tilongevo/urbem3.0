<?php

namespace Urbem\TributarioBundle\Controller\DividaAtiva;

use DateTime;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Repository\Tributario\DividaAtiva\InscreverDividaAtivaRepository;

/**
 * Class InscreverDividaAtivaAdminController
 * @package Urbem\TributarioBundle\Controller\DividaAtiva
 */
class InscreverDividaAtivaAdminController extends CRUDController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function detalheAction(Request $request)
    {
        $this->admin->setBreadCrumb();

        $em = $this->getDoctrine()->getManager();
        $repository = new InscreverDividaAtivaRepository($em);

        $form = $this->generateDetalheForm();
        $form->handleRequest($request);

        $filtro = $request->get($request->get('uniqid'));
        if (!$filtro) {
            return (new RedirectResponse($this->generateUrl('urbem_tributario_divida_ativa_inscrever_divida_ativa_create')))->send();
        }

        $dividas = $repository->fetchDividas($filtro);

        return $this->render(
            'TributarioBundle::DividaAtiva/InscreverDividaAtiva/detalhe.html.twig',
            [
                'form' => $form->createView(),
                'dividas' => $dividas,
                'valorTotal' => array_sum(array_column($dividas, 'valor_lancamento')),
                'filtro' => $filtro,
            ]
        );
    }

    public function inscreverAction(Request $request)
    {
        $filtro = $request->get($request->get('uniqid'));
        if (!$filtro) {
            return (new RedirectResponse($this->generateUrl('urbem_tributario_divida_ativa_inscrever_divida_ativa_create')))->send();
        }

        $dividasAtivas = $this->admin->inscreverDividaAtiva($filtro);
        if (is_bool($dividasAtivas)) {
            $this->container->get('session')->getFlashBag()->add('error', $this->admin->getTranslator()->trans('label.dividaAtivaInscreverDividaAtiva.erroConfiguracaoLivroVazia'));

            return (new RedirectResponse($this->generateUrl('urbem_tributario_divida_ativa_inscrever_divida_ativa_create')))->send();
        }

        if ($dividasAtivas) {
            $this->container->get('session')->getFlashBag()->add('sonata_flash_success', $this->admin->getTranslator()->trans('label.dividaAtivaInscreverDividaAtiva.sucesso'));
        }

        if (!empty($filtro['emitirTermo'])) {
            return $this->listaDownloads($dividasAtivas);
        }

        return (new RedirectResponse($this->generateUrl('urbem_tributario_divida_ativa_inscrever_divida_ativa_create')))->send();
    }

    /**
     * @param array $dividasAtivas
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listaDownloads(array $dividasAtivas = [])
    {
        $this->admin->setBreadCrumb();

        $this->admin->emitirDocumentos($dividasAtivas);

        return $this->render(
            'TributarioBundle::DividaAtiva/InscreverDividaAtiva/lista_downloads.html.twig',
            [
                'admin' => $this->admin,
                'dividasAtivas' => $dividasAtivas,
            ]
        );
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    private function generateDetalheForm()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = new InscreverDividaAtivaRepository($em);

        $fieldOptions = [];
        $fieldOptions['autoridade'] = [
            'mapped' => false,
            'choices' => array_flip($repository->fetchAutoridades()),
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.dividaAtivaInscreverDividaAtiva.autoridade',
        ];

        $fieldOptions['fkSwClassificacao'] = [
            'class' => SwClassificacao::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                return $em->createQueryBuilder('o')
                    ->orderBy('o.codClassificacao', 'ASC');
            },
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters processo-classificacao',
            ]
        ];

        $fieldOptions['fkSwAssunto'] = [
            'class' => SwAssunto::class,
            'mapped' => false,
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters processo-assunto',
            ],
            'label' => 'label.dividaAtivaInscreverDividaAtiva.assunto',
        ];

        $fieldOptions['processos'] = [
            'class' => SwProcesso::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.codProcesso = :codProcesso');
                $qb->setParameter('codProcesso', 0);

                return $qb;
            },
            'required' => false,
            'placeholder' => 'Selecione',
            'label' => 'label.dividaAtivaInscreverDividaAtiva.processo',
        ];

        $fieldOptions['emitirTermo'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'checked' => true,
            ],
            'label' => 'label.dividaAtivaInscreverDividaAtiva.emitirTermo',
        ];

        return $this->createFormBuilder([])
            ->add('autoridade', 'choice', $fieldOptions['autoridade'])
            ->add('codClassificacao', 'entity', $fieldOptions['fkSwClassificacao'])
            ->add('codAssunto', 'entity', $fieldOptions['fkSwAssunto'])
            ->add('codProcesso', 'entity', $fieldOptions['processos'])
            ->add('emitirTermo', 'checkbox', $fieldOptions['emitirTermo'])
            ->setAction($this->generateUrl('urbem_tributario_divida_ativa_inscrever_divida_ativa_inscrever'))
            ->getForm();
    }
}
