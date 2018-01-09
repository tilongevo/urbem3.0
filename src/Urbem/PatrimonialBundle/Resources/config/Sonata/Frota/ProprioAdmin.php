<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Helper;
use Urbem\CoreBundle\Model;

use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Frota;

use Urbem\CoreBundle\Model\Patrimonial\Frota\ProprioModel;

/**
 * Class ProprioAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Frota
 */
class ProprioAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_veiculo_proprio';

    protected $baseRoutePattern = 'patrimonial/frota/veiculo-proprio';

    protected $model = Model\Patrimonial\Frota\ProprioModel::class;

    protected $includeJs = [
        '/patrimonial/javascripts/frota/veiculoProprio.js',
    ];

    /**
     * @param Frota\Proprio $object
     * @throws \Exception
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect("/patrimonial/frota/veiculo-proprio/create?id={$object->getCodVeiculo()}");
        }
    }

    /**
     * @param Frota\Proprio $object
     * @param Form $form
     */
    public function saveRelationships($object, $form)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        if (strstr($form->get('fkPatrimonioBem')->getData(), '-')) {
            $codBem = explode(' - ', $form->get('fkPatrimonioBem')->getData());
            $codBem = $codBem[0];
        } else {
            $codBem = $form->get('fkPatrimonioBem')->getData();
        }

        /** @var Entity\Patrimonio\Bem $bem */
        $bem = $entityManager
            ->getRepository(Entity\Patrimonio\Bem::class)
            ->find($codBem);
        $object->setFkPatrimonioBem($bem);
        $bemResponsavel = $bem->getBemResponsavel();
        $bemResponsavel->setDtInicio($form->get('dtInicio')->getData());
        $veiculo = $entityManager
            ->getRepository(Frota\Veiculo::class)
            ->find($object->getCodVeiculo());

        $veiculoPropriedade = new Frota\VeiculoPropriedade();
        $veiculoPropriedade->setFkFrotaVeiculo($veiculo);
        $veiculoPropriedade->setProprio(true);

        $entityManager->persist($veiculoPropriedade);

        $object->setFkFrotaVeiculoPropriedade($veiculoPropriedade);
    }

    /**
     * @param Frota\Proprio $object
     * @throws \Exception
     */
    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            // Remove VeiculoPropriedade
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager(Frota\VeiculoPropriedade::class);
            $veiculoPropriedade = $em->getRepository(Frota\VeiculoPropriedade::class)->findOneBy([
                'codVeiculo' => $object->getCodVeiculo()
            ]);

            if ($veiculoPropriedade) {
                $em->remove($veiculoPropriedade);
            }

            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_EDIT_DATA);
            $this->forceRedirect("/patrimonial/frota/veiculo-proprio/{$object->getCodVeiculo()}~{$object->getTimestamp()}/edit");
        }
    }

    /**
     * @param Frota\Proprio $object
     * @return null
     */
    public function preRemove($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            // Remove VeiculoPropriedade
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager(Frota\VeiculoPropriedade::class);
            $veiculoPropriedade = $em->getRepository(Frota\VeiculoPropriedade::class)->findOneBy([
                'codVeiculo' => $object->getCodVeiculo()
            ]);

            if ($veiculoPropriedade) {
                $em->remove($veiculoPropriedade);
            }
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_REMOVE_DATA);
            $this->forceRedirect("/patrimonial/frota/veiculo-proprio/{$object->getCodVeiculo()}~{$object->getTimestamp()}/delete");
        }
    }

    /**
     * @param Frota\Proprio $object
     */
    public function postPersist($object)
    {
        $this->redirect($object);
    }

    /**
     * @param Frota\Proprio $object
     */
    public function redirect($object)
    {
        $this->forceRedirect("/patrimonial/frota/veiculo/{$this->getObjectKey($object->getFkFrotaVeiculoPropriedade()->getFkFrotaVeiculo())}/show");
    }

    /**
     * @param Frota\Proprio $object
     */
    public function postUpdate($object)
    {
        $this->redirect($object);
    }

    /**
     * @param Frota\Proprio $object
     */
    public function postRemove($object)
    {
        $this->redirect($object);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codVeiculo')
            ->add('codBem');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codVeiculo')
            ->add('codBem');

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $route = $this->getRequest()->get('_sonata_name');
        if (strpos($route, 'edit')) {
            list($codVeiculo, $timestamp) = explode('~', $id);
        } else {
            $codVeiculo = $id;
        }

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codVeiculo = $formData['codVeiculo'];
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $veiculo = $entityManager
            ->getRepository(Frota\Veiculo::class)
            ->findOneBy([
                'codVeiculo' => $codVeiculo
            ]);

        $fieldOptions['veiculo'] = [
            'class' => 'CoreBundle:Frota\Veiculo',
            'choice_label' => function ($veiculo) {
                /** @var Frota\Veiculo $veiculo */
                return $veiculo->getCodVeiculo() . ' - ' .
                $veiculo->getPlaca() . ' - ' .
                $veiculo->getFkFrotaMarca()->getNomMarca() . ' - ' .
                $veiculo->getFkFrotaModelo()->getNomModelo();
            },
            'label' => 'label.veiculoCessao.codVeiculo',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'data' => $veiculo,
            'mapped' => false,
            'disabled' => true,
        ];

        $fieldOptions['responsavel'] = [
            'mapped' => false,
            'label' => 'label.veiculoProprio.responsavel',
            'attr' => [
                'readonly' => 'readonly',
            ]
        ];

        $fieldOptions['dtInicio'] = [
            'mapped' => false,
            'format' => 'dd/MM/yyyy',
            'label' => 'label.veiculoProprio.dtInicio',
            'required' => true,
        ];

        $fieldOptions['codVeiculo'] = [
            'data' => $veiculo->getCodVeiculo()
        ];

        $fieldOptions['codBem'] = [
            'class' => 'CoreBundle:Patrimonio\Bem',
            'choice_label' => function ($codBem) {
                /** @var Entity\Patrimonio\Bem $codBem */
                return $codBem->getNumPlaca() . ' - ' .
                $codBem->getDescricao();
            },
            'label' => 'label.veiculoProprio.codBem',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
        ];

        $fieldOptions['fkPatrimonioBem'] = [
            'label' => 'label.veiculoProprio.codBem',
            'multiple' => false,
            'mapped' => false,
            'route' => ['name' => 'patrimonio_carrega_bem']
        ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['fkPatrimonioBem']['data'] = $this->getSubject()->getFkPatrimonioBem();
        }

        $formMapper
            ->add(
                'veiculo',
                'entity',
                $fieldOptions['veiculo']
            )
            ->add(
                'codVeiculo',
                'hidden',
                $fieldOptions['codVeiculo']
            )
            ->add(
                'fkPatrimonioBem',
                'autocomplete',
                $fieldOptions['fkPatrimonioBem']
            )
            ->add('responsavel', 'text', $fieldOptions['responsavel'])
            ->add('dtInicio', 'sonata_type_date_picker', $fieldOptions['dtInicio']);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('codVeiculo')
            ->add('codBem');
    }
}
