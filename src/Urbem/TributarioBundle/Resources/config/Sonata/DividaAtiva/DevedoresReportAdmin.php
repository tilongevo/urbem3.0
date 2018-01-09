<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\DividaAtiva;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito;
use Urbem\CoreBundle\Entity\Monetario\Credito;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\TributarioBundle\Controller\DividaAtiva\RelatoriosController;

class DevedoresReportAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_divida_ativa_relatorio_devedores';
    protected $baseRoutePattern = 'tributario/divida_ativa/relatorios/devedores';
    protected $legendButtonSave = ['icon' => 'save', 'text' => 'Gerar Relatório'];
    protected $includeJs = array(
        '/tributario/javascripts/dividaAtiva/relatorios/devedores.js'
    );

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('credito', 'credito');
        $collection->add('grupo_credito', 'grupo-credito');
        $collection->add('relatorio', 'relatorio');
        $collection->clearExcept(['create', 'credito', 'grupo_credito', 'relatorio']);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['filtroPor'] = array();
        $classExercicio = 'hidden';
        $template = 'TributarioBundle::DividaAtiva/Relatorios/Devedores/grupo_creditos.html.twig';

        $fieldOptions['filtroPor'] = array(
            'class' => GrupoCredito::class,
            'choice_value' => function ($grupocredito) {
                if ($grupocredito) {
                    return sprintf('%d/%s', $grupocredito->getCodGrupo(), $grupocredito->getAnoExercicio());
                }
            },
            'mapped' => false,
            'required' => false,
            'placeholder' => 'Selecione',
            'attr' => array(
                'class' => 'select2-parameters'
            ),
            'label' => 'label.dividaAtivaDevedoresReport.grupoCredito',
        );

        if (isset($this->filtroPor) and $this->filtroPor == RelatoriosController::CREDITO) {
            $fieldOptions['filtroPor'] = array(
                'class' => Credito::class,
                'choice_value' => function ($credito) {
                    if ($credito) {
                        return sprintf('%d.%d.%d.%d', $credito->getCodCredito(), $credito->getCodEspecie(), $credito->getCodGenero(), $credito->getCodNatureza());
                    }
                },
                'choice_label' => function ($credito) {
                    return sprintf('%s', $credito->getDescricaoCredito());
                },
                'mapped' => false,
                'required' => false,
                'label' => 'label.dividaAtivaDevedoresReport.credito',
            );

            $classExercicio = null;
            $template = 'TributarioBundle::DividaAtiva/Relatorios/Devedores/creditos.html.twig';
        }

        $fieldOptions['listaCreditos'] = array(
            'label' => false,
            'mapped' => false,
            'template' => $template,
            'attr' => array(
                'style' => 'display:none;'
            ),
            'data' => array(
                'creditos' => array()
            )
        );

        $fieldOptions['exercicio'] = [
            'label' => 'label.dividaAtivaDevedoresReport.exercicio',
            'required' => false,
            'mapped' => false
        ];

        $numerosRegistros =  [
            'Todos' => '',
            10 => 10,
            20 => 20,
            30 => 30,
            40 => 40,
            50 => 50,
        ];

        $fieldOptions['numeroRegistros'] = [
            'label' => 'label.dividaAtivaDevedoresReport.numeroRegistros',
             'required' => true,
             'mapped' => false,
             'choices' => $numerosRegistros,
             'attr' => [
                 'class' => 'select2-parameters'
             ]
        ];


        $formMapper
            ->with('label.dividaAtivaDevedoresReport.dados')
            ->add('filtroPor', 'entity', $fieldOptions['filtroPor'])
            ->add('exercicio', $classExercicio, $fieldOptions['exercicio'])
            ->add('listaCreditos', 'customField', $fieldOptions['listaCreditos'])
            ->end()
            ->with('label.dividaAtivaDevedoresReport.dadosLimite')
            ->add('numeroRegistros', ChoiceType::class, $fieldOptions['numeroRegistros']);
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        if ($creditos = $this->request->request->get('creditos')) {
            $this->forceRedirect($this->generateUrl('relatorio', $creditos));
        }
    }
}
