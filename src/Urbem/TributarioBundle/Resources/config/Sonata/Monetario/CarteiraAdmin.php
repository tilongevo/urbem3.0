<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Monetario;

use Doctrine\Common\Collections\Collection;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Monetario\Carteira;
use Urbem\CoreBundle\Entity\Monetario\Convenio;
use Urbem\CoreBundle\Entity\Monetario\TipoConvenio;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class CarteiraAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_monetario_carteira';
    protected $baseRoutePattern = 'tributario/cadastro-monetario/carteira';
    protected $includeJs = ['/tributario/javascripts/monetario/carteira.js'];

    /**
     * @param mixed $object
     */
    public function preRemove($object)
    {
        if ($this->canRemove($object)) {
            return;
        }

        $container = $this->getConfigurationPool()->getContainer();

        $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.monetarioCarteira.erroDelecao'));

        $this->modelManager->getEntityManager($this->getClass())->clear();

        return $this->forceRedirect($this->generateObjectUrl('list', $object));
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $lastCarteira = $em->getRepository(Carteira::class)
            ->findOneBy(
                [],
                [
                    'codCarteira' => 'DESC'
                ]
            );

        $convenio = $em->getRepository(Convenio::class)
            ->findOneBy(
                [
                    'codConvenio' => $this->getForm()->get('codConvenio')->getData(),
                ]
            );

        $object->setCodCarteira($lastCarteira ? $lastCarteira->getCodCarteira() + 1 : 1);
        $object->setFkMonetarioConvenio($convenio);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $convenio = $em->getRepository(Convenio::class)
            ->findOneBy(
                [
                    'codConvenio' => $this->getForm()->get('codConvenio')->getData(),
                ]
            );

        $object->setFkMonetarioConvenio($convenio);
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $oldObject = $em->getUnitOfWork()->getOriginalEntityData($object);

        if (!empty($oldObject['codCarteira'])
            && $oldObject['numCarteira'] == $object->getNumCarteira()) {
            return;
        }

        $carteira = $em->getRepository(Carteira::class)
            ->findOneBy(
                [
                    'codConvenio' => $this->getForm()->get('codConvenio')->getData(),
                    'numCarteira' => $this->getForm()->get('numCarteira')->getData(),
                ]
            );

        if ($carteira) {
            $error = $this->getTranslator()->trans('label.monetarioCarteira.erroCarteira');
            $errorElement->with('numCarteira')->addViolation($error)->end();
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $qs = $this->getRequest()->get('filter');
        $datagridMapper
            ->add(
                'fkMonetarioConvenio.fkMonetarioTipoConvenio',
                null,
                [
                    'label' => 'label.monetarioConvenio.codTipo',
                ],
                'entity',
                [
                    'attr' => [
                        'class' => 'select2-parameters js-tipo-convenio',
                    ],
                ]
            )
            ->add(
                'fkMonetarioConvenio',
                null,
                [
                    'label' => 'label.monetarioCarteira.codConvenio',
                ],
                'entity',
                [
                    'class' => 'CoreBundle:Monetario\Convenio',
                    'query_builder' => function ($em) use ($qs) {
                        $qb = $em->createQueryBuilder('o');
                        if (empty($qs)) {
                            $qb->where('o.codTipo IS NULL');
                        }

                        if ($qs && !empty($qs['fkMonetarioConvenio__fkMonetarioTipoConvenio']['value'])) {
                            $qb->where('o.codTipo = :codTipo');
                            $qb->setParameter('codTipo', $qs['fkMonetarioConvenio__fkMonetarioTipoConvenio']['value']);
                        }

                        return $qb;
                    },
                    'attr' => [
                        'class' => 'select2-parameters js-convenio',
                    ],
                ]
            )
            ->add('numCarteira', null, ['label' => 'label.monetarioCarteira.numCarteira']);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkMonetarioConvenio.fkMonetarioTipoConvenio', null, ['label' => 'label.monetarioConvenio.codTipo'])
            ->add('fkMonetarioConvenio', null, ['label' => 'label.monetarioCarteira.codConvenio'])
            ->add('numCarteira', null, ['label' => 'label.monetarioCarteira.numCarteira']);

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $carteira = $this->getSubject();

        $fieldOptions = [];
        $fieldOptions['codTipo'] = [
            'class' => TipoConvenio::class,
            'mapped' => false,
            'required' => true,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters js-tipo-convenio'
            ],
            'label' => 'label.monetarioConvenio.codTipo',
        ];

        $fieldOptions['codConvenio'] = [
            'class' => Convenio::class,
            'mapped' => false,
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters js-convenio js-convenio-edit'
            ],
            'label' => 'label.monetarioConvenio.codConvenio',
        ];

        $fieldOptions['numCarteira'] = [
            'required' => true,
            'label' => 'label.monetarioCarteira.numCarteira',
            'attr' => [
                'min' => 1,
                'maxlength' => 10,
                'class' => 'select2-parameters'
            ],
        ];

        $fieldOptions['variacao'] = [
            'required' => true,
            'label' => 'label.monetarioCarteira.variacao',
            'attr' => [
                'min' => 1,
                'max' => 2147483647,
            ],
        ];

        if ($carteira->getFkMonetarioConvenio()) {
            $fieldOptions['codTipo']['data'] = $carteira->getFkMonetarioConvenio()->getFkMonetarioTipoConvenio();
            $fieldOptions['codTipo']['disabled'] = true;
            $fieldOptions['codConvenio']['data'] = $carteira->getFkMonetarioConvenio();
            $fieldOptions['codConvenio']['disabled'] = true;
        }

        if ($this->id($this->getSubject())) {
            $fieldOptions['numCarteira']['disabled'] = true;
        }

        $formMapper
            ->with('label.monetarioCarteira.dados')
            ->add('codTipo', 'entity', $fieldOptions['codTipo'])
            ->add('codConvenio', 'entity', $fieldOptions['codConvenio'])
            ->add('numCarteira', null, $fieldOptions['numCarteira'])
            ->add('variacao', null, $fieldOptions['variacao']);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->with('label.monetarioCarteira.dados')
            ->add('fkMonetarioConvenio.fkMonetarioTipoConvenio', null, ['label' => 'label.monetarioConvenio.codTipo'])
            ->add('fkMonetarioConvenio', null, ['label' => 'label.monetarioCarteira.codConvenio'])
            ->add('numCarteira', null, ['label' => 'label.monetarioCarteira.numCarteira'])
            ->add('variacao', null, ['label' => 'label.monetarioCarteira.variacao']);
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return ($object->getCodCarteira())
            ? (string) $object
            : $this->getTranslator()->trans('label.monetarioCarteira.modulo');
    }
}
