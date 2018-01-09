<?php
namespace Urbem\PatrimonialBundle\Controller\Almoxarifado\Relatorios;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller\BaseController;

class CatalogoItemController extends BaseController
{
    const TIPO_RELATORIO_SINTETICO = 'sintetico';
    const TIPO_RELATORIO_ANALITICO = 'analitico';
    const TIPOS_RELATORIO = [
        self::TIPO_RELATORIO_SINTETICO => 'Sintético',
        self::TIPO_RELATORIO_ANALITICO => 'Analítico',
    ];

    /**
     * @param Request $request
     * @return Response
     */
    public function filtroAction(Request $request)
    {
        $this->setBreadCrumb();

        $form = $this->generateForm();
        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            return $this->render(
                'PatrimonialBundle::Almoxarifado/Relatorios/CatalogoItem/filtro.html.twig',
                [
                    'form' => $form->createView(),
                ]
            );
        }

        $redirectUrl = $this->generateUrl('urbem_patrimonial_almoxarifado_relatorios_catalogo_item_sintetico_list');
        if ($form->get('tipoRelatorio')->getData() == $this::TIPO_RELATORIO_ANALITICO) {
            $redirectUrl = $this->generateUrl('urbem_patrimonial_almoxarifado_relatorios_catalogo_item_analitico_create');
        }

        return $this->redirect($redirectUrl);
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    private function generateForm()
    {
        $form = $this->createFormBuilder([])
            ->add(
                'tipoRelatorio',
                'choice',
                [
                    'choices' => array_flip($this::TIPOS_RELATORIO),
                    'required' => true,
                    'placeholder' => 'label.selecione',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'label' => 'label.almoxarifadoRelatoriosCatalogoItem.tipoRelatorio',
                ]
            )
            ->setAction($this->generateUrl('patrimonio_almoxarifado_relatorios_catalogo_item_filtro'))
            ->getForm();

        return $form;
    }
}
