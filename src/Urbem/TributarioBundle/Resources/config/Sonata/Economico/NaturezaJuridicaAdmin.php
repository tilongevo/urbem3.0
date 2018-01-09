<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Economico\NaturezaJuridica;
use Urbem\CoreBundle\Model\Economico\NaturezaJuridicaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class NaturezaJuridicaAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Economico
 */
class NaturezaJuridicaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_natureza_juridica';
    protected $baseRoutePattern = 'tributario/cadastro-economico/natureza-juridica';
    protected $isEdit = false;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('baixar', 'baixar/'.$this->getRouterIdParameter());
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codNatureza',
                null,
                [
                    'label' => 'label.economico.naturezaJuridica.codNatureza'
                ]
            )
            ->add(
                'nomNatureza',
                null,
                [
                    'label' => 'label.economico.naturezaJuridica.nomeNatureza'
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'codNatureza',
                null,
                [
                    'label' => 'label.economico.naturezaJuridica.codNatureza'
                ]
            )
            ->add(
                'nomNatureza',
                null,
                [
                    'label' => 'label.economico.naturezaJuridica.nomeNatureza'
                ]
            )
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                    'baixar' => array('template' => 'TributarioBundle:Sonata/Economico/CRUD:list__action_baixaNatureza.html.twig')
                )
            ))
        ;
    }

    /**
     * @param $object
     * @return bool
     */
    public function verificaBaixaNaturezaJuridica($object)
    {
        return ($object->getFkEconomicoBaixaNaturezaJuridica())
            ? true
            : false;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formOptions['codNatureza'] = [
            'label' => 'label.economico.naturezaJuridica.codNatureza',
            'attr' => [
                'min' => 1
            ]
        ];

        if ($this->id($this->getSubject())) {
            $this->isEdit = true;
            $formOptions['codNatureza']['disabled'] = true;
        }

        $formMapper
            ->with('label.economico.naturezaJuridica.dadosNatureza')
            ->add(
                'codNatureza',
                null,
                $formOptions['codNatureza']
            )
            ->add(
                'nomNatureza',
                null,
                [
                    'label' => 'label.economico.naturezaJuridica.nomeNatureza'
                ]
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with('label.economico.naturezaJuridica.dadosNatureza')
            ->add(
                'codNatureza',
                null,
                [
                    'label' => 'label.economico.naturezaJuridica.codNatureza'
                ]
            )
            ->add(
                'nomNatureza',
                null,
                [
                    'label' => 'label.economico.naturezaJuridica.nomeNatureza'
                ]
            )
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $nomeNatureza = $object->getNomNatureza();
        if ($nomeNatureza) {
            $result = (new NaturezaJuridicaModel($entityManager))
                ->getNaturezaJuridicaByNomeNatureza($nomeNatureza);
            if ($result && $result->getCodNatureza() != $object->getCodNatureza()) {
                $error = $this->getTranslator()->trans('label.economico.naturezaJuridica.validate.nomeNaturezaExistente');
                $errorElement->with('nomNatureza')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
            }
        }
        if (!$this->isEdit) {
            $codNatureza = $this->getForm()->get('codNatureza')->getViewData();
            if ($codNatureza) {
                $result = (new NaturezaJuridicaModel($entityManager))
                    ->getNaturezaJuridicaByCodNatureza($codNatureza);
                if ($result) {
                    $error = $this->getTranslator()->trans('label.economico.naturezaJuridica.validate.naturezaExistente');
                    $errorElement->with('codNatureza')->addViolation($error)->end();
                    $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
                }
            }
        }
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $object->setCodNatureza($this->getForm()->get('codNatureza')->getViewData());
    }

    /**
     * @param NaturezaJuridica $object
     * @return string
     */
    public function toString($object)
    {
        return ($object->getCodNatureza())
            ? (string) $object
            : $this->getTranslator()->trans('label.economico.naturezaJuridica.validate.modulo');
    }
}
