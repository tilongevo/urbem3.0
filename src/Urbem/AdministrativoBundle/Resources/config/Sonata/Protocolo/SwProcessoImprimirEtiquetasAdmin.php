<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Protocolo;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;

class SwProcessoImprimirEtiquetasAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_administrativo_protocolo_processo_imprimir_etiqueta';
    protected $baseRoutePattern = 'administrativo/protocolo/processo/imprimir-etiqueta';
    protected $layoutDefaultReport = '/gestaoAdministrativa/fontes/RPT/protocolo/report/design/etiquetas.rptdesign';

    protected $includeJs = array(
        '/administrativo/javascripts/administracao/imprimir-etiquetas.js',
    );

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'create'));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadcrumb();

        $formMapper
            ->with('Dados para filtro')
            ->add(
                'codProcessoInicial',
                'text',
                array(
                    'mapped' => false,
                    'required' => false,
                    'label' => 'label.processo.codProcessoInicial'
                )
            )
            ->add(
                'codProcessoFinal',
                'text',
                array(
                    'mapped' => false,
                    'required' => false,
                    'label' => 'label.processo.codProcessoFinal'
                )
            )

            ->add(
                'prmDataIni',
                'sonata_type_date_picker',
                array(
                    'required' => false,
                    'format'    => 'dd/MM/yyyy',
                    'label'     => 'label.processo.prmDataIni',
                    'mapped' => false
                )
            )
            ->add(
                'prmDataFim',
                'sonata_type_date_picker',
                array(
                    'required' => false,
                    'format'    => 'dd/MM/yyyy',
                    'label'     => 'label.processo.prmDataFim',
                    'mapped' => false
                )
            )
            ->end()
            ->with('label.processo.etiqueta')
            ->add(
                'stFormatoEtiqueta',
                'choice',
                array(
                    'label' => 'label.processo.stFormatoEtiqueta',
                    'choices' => $this->getSubject()->getStFormatoEtiqueta(),
                    'mapped' => false,
                    'attr' => array(
                        'class' => 'select2-parameters '
                    ),
                )
            )
            ->end()
        ;

        // SOMENTE APOS PADRONIZACAO DO BIRT
        $js = "$(document).ready(function() {";
        $js .= '$(".btn-success").attr("disabled", true);';
        $js .= "});";

        $this->scriptDynamicBlock = $js;
    }

    public function prePersist($object)
    {
        $prmProcessoIni = "";
        $prmExercicioInicial = "";
        if ($this->getForm()->get('codProcessoInicial')->getData()) {
            $codProcessoInicial = explode("/", $this->getForm()->get('codProcessoInicial')->getData());

            $prmProcessoIni = str_pad($codProcessoInicial[0], 5, "0", STR_PAD_LEFT);
            $prmExercicioInicial = $codProcessoInicial[1];
        }

        $prmProcessoFim = "";
        $prmExercicioFinal = "";
        if ($this->getForm()->get('codProcessoFinal')->getData()) {
            $codProcessoFinal = explode("/", $this->getForm()->get('codProcessoFinal')->getData());

            $prmProcessoFim = str_pad($codProcessoFinal[0], 5, "0", STR_PAD_LEFT);
            $prmExercicioFinal = $codProcessoFinal[1];
        }

        $params = array(
            'inCodGestao' => 1,
            'inCodModulo' => 5,
            'inCodRelatorio' => 1,
            'prmProcessoIni' => $prmProcessoIni,
            'prmExercicioInicial' => $prmExercicioInicial,
            'prmProcessoFim' => $prmProcessoFim,
            'prmExercicioFinal' => $prmExercicioFinal,
            'prmDataIni' => (!empty($this->getForm()->get('prmDataIni')->getData())) ? $this->getForm()->get('prmDataIni')->getData()->format('Y-m-d') : null,
            'prmDataFim' => (!empty($this->getForm()->get('prmDataFim')->getData())) ? $this->getForm()->get('prmDataFim')->getData()->format('Y-m-d') : null
        );


        $apiService = $this->getApiService();
        $apiService->setLayoutDefaultReport($this->layoutDefaultReport);
        $res = $apiService->getReportOldProject($params);
    }
}
