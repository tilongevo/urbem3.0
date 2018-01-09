<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Protocolo;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Urbem\AdministrativoBundle\Form\Protocolo\Processo\ApensarType;
use Urbem\AdministrativoBundle\Form\Protocolo\Processo\ArquivarType;
use Urbem\AdministrativoBundle\Form\Protocolo\Processo\DesapensarType;
use Urbem\AdministrativoBundle\Form\Protocolo\Processo\DespacharType;
use Urbem\AdministrativoBundle\Form\Protocolo\Processo\EncaminharType;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractOrganogramaSonata;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class ProcessoEtapasAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Protocolo
 */
class ProcessoEtapasAdmin extends AbstractOrganogramaSonata
{
    protected $baseRouteName = 'urbem_administrativo_protocolo_processo_etapa';
    protected $baseRoutePattern = 'administrativo/protocolo/processo/etapas';

    const ETAPAS = [
        'receber'                 => [
            'routePattern' => '{id}/receber'
        ],
        'encaminhar'              => [
            'formType'     => EncaminharType::class,
            'routePattern' => '{id}/encaminhar'
        ],
        'arquivar'                => [
            'formType'     => ArquivarType::class,
            'routePattern' => '{id}/arquivar'
        ],
        'cancelar_encaminhamento' => [
            'routePattern' => '{id}/cancelar-encaminhamento'
        ],
        'despachar'               => [
            'formType'     => DespacharType::class,
            'routePattern' => '{id}/despachar'
        ],
        'desarquivar'             => [
            'routePattern' => '{id}/desarquivar'
        ],
        'apensar'                 => [
            'formType'     => ApensarType::class,
            'routePattern' => '{id}/apensar'
        ],
        'desapensar'              => [
            'formType'     => DesapensarType::class,
            'routePattern' => '{id}/desapensar'
        ],
        'imprimir_etiqueta'       => [
            'routePattern' => '{id}/imprimir-etiqueta'
        ]
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['edit']);

        foreach (self::ETAPAS as $routeName => $action) {
            $collection->add($routeName, $action['routePattern']);
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
     * Busca na request a action atual e retorna o FormType correspondente.
     *
     * @return array
     */
    private function getProcessoEtapa()
    {
        // TODO redirecionar um erro caso a action não exista.
        $actionName = $this->getRequest()->get('routeName');

        $etapa = self::ETAPAS[$actionName] + ['routeName' => $actionName];

        return $etapa;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        /** @var SwProcesso $swProcesso */
        $swProcesso = $this->getSubject();

        $usuario = $this->getCurrentUser();

        $fieldOptions = [];
        $fieldDescriptionOptions = [];

        $fieldOptions['formType'] = [
            'label'  => false,
            'mapped' => false
        ];

        $fieldDescriptionOptions['formType'] = [
            'swProcesso' => $swProcesso,
            'orgao'      => $usuario->getFkOrganogramaOrgao(),
            'type'       => CollectionType::class
        ];

        $fieldOptions['processo'] = [
            'data'     => [
                'swProcesso' => $swProcesso
            ],
            'label'    => false,
            'mapped'   => false,
            'template' => '@Administrativo/Sonata/Processo/CRUD/field__custom_processo.html.twig'
        ];

        $etapa = $this->getProcessoEtapa();

        $formMapper->add('processo', 'customField', $fieldOptions['processo']);

        if ('encaminhar' === $etapa['routeName']) {
            $this->createFormOrganograma($formMapper, false);

        } else {
            $formMapper->add('formType', $etapa['formType'], $fieldOptions['formType'], $fieldDescriptionOptions['formType']);

        }

        $formMapper->getFormBuilder()->setAction($etapa['routeName']);
    }
}
