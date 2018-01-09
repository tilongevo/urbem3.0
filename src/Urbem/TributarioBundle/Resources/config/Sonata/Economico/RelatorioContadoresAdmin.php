<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class RelatorioContadoresAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_relatorio_contadores';
    protected $baseRoutePattern = 'tributario/cadastro-economico/relatorios/contadores';
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Gerar Relatório'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
        $collection->add('relatorio', 'relatorio');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['nomcgm'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.economicoRelatorioContadores.nome'
        ];

        $fieldOptions['numcgm'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.economicoRelatorioContadores.cgmInicio'
        ];

        $fieldOptions['numcgmFinal'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.economicoRelatorioContadores.cgmFinal'
        ];

        $fieldOptions['inscricaoEconomicaInicial'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.economicoRelatorioContadores.inscricaoEconomicaInicio'
        ];

        $fieldOptions['inscricaoEconomicaFinal'] =  [
            'mapped' => false,
            'required' => false,
            'label' => 'label.economicoRelatorioContadores.inscricaoEconomicaFinal'
        ];

        $fieldOptions['tipoRelatorio'] = [
            'label' => 'label.economicoRelatorioContadores.tipoRelatorio',
            'choices' => array(
                'label.economicoRelatorioContadores.sintetico' => 'sintetico',
                'label.economicoRelatorioContadores.analitico' => 'analitico'
            ),
            'mapped' => false,
            'required' => true,
        ];

        $fieldOptions['ordenacao'] = [
            'choices' => [
                'Código CGM' => 'numcgm',
                'Nome do Colaborador' => 'nom_cgm',
            ],
            'mapped' => false,
            'placeholder' => 'Selecione',
            'label' => 'label.economicoRelatorioContadores.ordenacao',
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $formMapper
            ->with('label.economicoRelatorioContadores.cabecalhoFiltro')
            ->add('nomcgm', 'text', $fieldOptions['nomcgm'])
            ->add('numcgm', 'number', $fieldOptions['numcgm'])
            ->add('numcgmFinal', 'number', $fieldOptions['numcgmFinal'])
            ->add('inscricaoEconomicaInicial', 'number', $fieldOptions['inscricaoEconomicaInicial'])
            ->add('inscricaoEconomicaFinal', 'number', $fieldOptions['inscricaoEconomicaFinal'])
            ->add('ordenacao', ChoiceType::class, $fieldOptions['ordenacao'])
            ->add('tipoRelatorio', ChoiceType::class, $fieldOptions['tipoRelatorio']);
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $params = [
            'nomcgm' => (!is_null($this->getForm()->get('nomcgm')->getData())) ? $this->getForm()->get('nomcgm')->getData() : null,
            'numcgm' => !($this->getForm()->get('numcgm')->getData()) ? $this->getForm()->get('numcgm')->getData() : null,
            'numcgmFinal' => !($this->getForm()->get('numcgmFinal')->getData()) ? $this->getForm()->get('numcgmFinal')->getData() : null,
            'inscricaoEconomicaInicial' => !($this->getForm()->get('inscricaoEconomicaInicial')->getData()) ? $this->getForm()->get('inscricaoEconomicaInicial')->getData() : null,
            'inscricaoEconomicaFinal' => !($this->getForm()->get('inscricaoEconomicaFinal')->getData()) ? $this->getForm()->get('inscricaoEconomicaFinal')->getData() : null,
            'tipoRelatorio' => $this->getForm()->get('tipoRelatorio')->getData(),
            'ordenacao' => $this->getForm()->get('ordenacao')->getData()
        ];
        $this->forceRedirect($this->generateUrl('relatorio', $params));
    }
}
