<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Protocolo;

use Sonata\AdminBundle\Form\FormMapper;

use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Urbem\AdministrativoBundle\Form\Protocolo\Processo\EtiquetasRelatorioType;
use Urbem\AdministrativoBundle\Form\Protocolo\Processo\SalvarRelatorioType;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class ProcessoRelatoriosAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Protocolo
 */
class ProcessoRelatoriosAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_protocolo_processo_relatorio';
    protected $baseRoutePattern = 'administrativo/protocolo/processo/relatorio';

    const RELATORIOS = [
        'etiqueta' => [
            'routePattern' => '{id}/etiqueta'
        ],
        'etiquetas' => [
            'routePattern' => 'etiquetas'
        ],
        'despacho' => [
            'routePattern' => '{id}/despacho'
        ],
        'despachos' => [
            'routePattern' => '{id}/despachos'
        ],
        'recibo_entrega' => [
            'routePattern' => '{id}/recibo-entrega'
        ],
        'arquivamento_temporario' => [
            'routePattern' => '{id}/arquivado-temporario'
        ],
        'arquivamento_definitivo' => [
            'routePattern' => '{id}/arquivado-definitivo'
        ],
        'salvar' => [
            'routePattern' => '{id}/salvar'
        ]
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['edit', 'create']);

        foreach (self::RELATORIOS as $routeName => $relatorioItem) {
            $collection->add($routeName, $relatorioItem['routePattern']);
        }
    }

    /**
     * @param SwProcesso $swProcesso
     *
     * @return string
     */
    public function mascaraDoProcesso(SwProcesso $swProcesso)
    {
        return sprintf("%05d/%s", $swProcesso->getCodProcesso(), $swProcesso->getAnoExercicio());
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb(is_null($id) ? [] : ['id' => $id]);

        $fieldOptions = [];
        $fieldOptions['processo'] = [
            'label'    => false,
            'mapped'   => false,
            'template' => '@Administrativo/Sonata/Processo/CRUD/field__custom_processo.html.twig'
        ];

        $fieldOptions['formType'] = [
            'label'  => false,
            'mapped' => false
        ];

        $fieldDescriptionOptions = [];
        $fieldDescriptionOptions['formType'] = [
            'type' => CollectionType::class
        ];

        $routeName = $this->getRequest()->get('_route');

        $formType = null;
        $actionName = null;

        switch ($routeName) {
            case (sprintf('%s_etiquetas', $this->baseRouteName)):
                $actionName = 'etiquetas';
                $formType = EtiquetasRelatorioType::class;
                break;
            case (sprintf('%s_salvar', $this->baseRouteName)):
                $fieldOptions['processo']['data'] = ['swProcesso' => $this->getSubject()];

                $this->addToIncludeJs('/administrativo/javascripts/protocolo/processo/salvar-relatorio.js');
                $actionName = 'salvar';
                $formType = SalvarRelatorioType::class;

                $formMapper->add('processo', 'customField', $fieldOptions['processo']);
                break;
        }

        $formMapper->add('formType', $formType, $fieldOptions['formType'], $fieldDescriptionOptions['formType']);

        $formMapper
            ->getFormBuilder()
            ->setAction($actionName);
    }
}
