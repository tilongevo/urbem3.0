<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Economico\VigenciaServico;
use Urbem\CoreBundle\Model\Economico\NivelServicoModel;
use Urbem\CoreBundle\Model\Economico\VigenciaServicoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class NivelServicoAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Economico
 */
class NivelServicoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_nivel_servico';
    protected $baseRoutePattern = 'tributario/cadastro-economico/hierarquia-servico/nivel';
    protected $includeJs =  array('/tributario/javascripts/economico/nivel-servico.js');
    protected $codNivel;

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (!$this->getPersistentParameter('codVigencia')) {
            $query->andWhere('1 = 0');
        } else {
            $query->andWhere('o.codVigencia = :codVigencia');
            $query->setParameter('codVigencia', $this->getPersistentParameter('codVigencia'));
        }
        return $query;
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('nivel_superior', 'nivel-superior');
    }

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'codVigencia' => $this->getRequest()->get('codVigencia'),
        );
    }

    /**
     * @param string $name
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'TributarioBundle:Economico\NivelServico:list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codVigencia', null, ['label' => 'label.economico.nivel.vigencia'])
            ->add('nomNivel', null, ['label' => 'label.economico.nivel.nomNivel'])
        ;
    }

    /**
     * @return null|string
     */
    public function getVigencia()
    {
        if ($this->getPersistentParameter('codVigencia')) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $vigencia = $em->getRepository(VigenciaServico::class)
                ->find($this->getPersistentParameter('codVigencia'));
            return (string) $vigencia;
        } else {
            return null;
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->customHeader = 'TributarioBundle:Sonata\Economico\NivelServico\CRUD:header.html.twig';

        $this->setBreadCrumb();

        $listMapper
            ->add('codNivel', null, ['label' => 'label.economico.nivel.codNivel'])
            ->add('codVigencia', null, ['label' => 'label.economico.nivel.vigencia'])
            ->add('nomNivel', null, ['label' => 'label.economico.nivel.nomNivel'])
            ->add('mascara', null, ['label' => 'label.economico.nivel.mascara'])
        ;
        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->customHeader = 'TributarioBundle:Sonata\Economico\NivelServico\CRUD:header.html.twig';

        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if (!$this->codNivel) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $nivelModel = new NivelServicoModel($em);
            $this->codNivel = $nivelModel->nextCodNivel();
        }

        $formMapper
           ->with('label.economico.nivel.dadosNivel')
            ->add(
                'codVigencia',
                'hidden',
                [
                    'data' => $this->request->get('codVigencia')
                ]
            )
            ->add('nomNivel', null, ['label' => 'label.economico.nivel.nomNivel'])
            ->add(
                'nivelSuperior',
                'text',
                [
                    'label' => 'label.economico.nivel.nivelSuperior',
                    'mapped' => false,
                    'required' => false,
                    'attr' => [
                        'readonly' => true
                    ]
                ]
            )
            ->add('mascara', null, ['label' => 'label.economico.nivel.mascara'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->customHeader = 'TributarioBundle:Sonata\Economico\NivelServico\CRUD:header.html.twig';

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with('label.economico.nivel.dadosNivel')
            ->add('codNivel', null, ['label' => 'label.economico.nivel.codNivel'])
            ->add('codVigencia', null, ['label' => 'label.economico.nivel.vigencia'])
            ->add('nomNivel', null, ['label' => 'label.economico.nivel.nomNivel'])
            ->add('mascara', null, ['label' => 'label.economico.nivel.mascara'])
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $vigencia = $this->getForm()->get('codVigencia')->getData();

        $em = $this->modelManager->getEntityManager(VigenciaServico::class);
        $vigencia = (new VigenciaServicoModel($em))
            ->findOneByCodVigencia($vigencia);

        $object->setFkEconomicoVigenciaServico($vigencia);
        $object->setCodNivel($this->codNivel);
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return ($object)
            ? (string) $object->getCodNivel().' - '.$object->getNomNivel()
            : $this->getTranslator()->trans('label.economico.nivel.modulo');
    }
}
