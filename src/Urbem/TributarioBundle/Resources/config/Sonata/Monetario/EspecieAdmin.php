<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Monetario;

use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Entity\Monetario\EspecieCredito;
use Urbem\CoreBundle\Entity\Monetario\NaturezaCredito;
use Urbem\CoreBundle\Entity\Monetario\GeneroCredito;
use Urbem\CoreBundle\Model\Monetario\EspecieCreditoModel;

class EspecieAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_monetario_especie';
    protected $baseRoutePattern = 'tributario/cadastro-monetario/especie';
    protected $includeJs = ['/tributario/javascripts/monetario/especie.js'];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDatagrid()->getPager();
        $pager->setCountColumn(['codEspecie','codGenero','codNatureza']);

        $datagridMapper
            ->add(
                'codNatureza',
                'doctrine_orm_callback',
                [
                    'label' => 'label.monetarioEspecie.natureza',
                    'callback' => function ($queryBuilder, $alias, $field, $value) {
                        if (!$value['value']) {
                            return;
                        }

                        $filter = $this->getDataGrid()->getValues();

                        $queryBuilder
                            ->where('o.codNatureza = :codNatureza')
                            ->setParameter('codNatureza', $filter['codNatureza']['value'])
                        ;

                        return true;
                    }
                ],
                'entity',
                [
                    'class' => 'CoreBundle:Monetario\NaturezaCredito',
                    'attr' => [
                        'class' => 'select2-parameters js-natureza',
                    ],
                ]
            )
            ->add(
                'codGenero',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.monetarioEspecie.genero',
                    'callback' => function ($queryBuilder, $alias, $field, $value) {
                        if (!$value['value']) {
                            return;
                        }

                        $filter = $this->getDataGrid()->getValues();

                        $queryBuilder
                            ->andWhere('o.codNatureza = :codNatureza')
                            ->setParameter('codNatureza', $filter['codNatureza']['value'])
                            ->andWhere('o.codGenero = :codGenero')
                            ->setParameter('codGenero', $filter['codGenero']['value'])
                        ;

                        return true;
                    }
                ),
                'entity',
                [
                    'class' => 'CoreBundle:Monetario\GeneroCredito',
                    'attr' => [
                        'class' => 'select2-parameters js-genero',
                    ],
                ]
            )
            ->add('nomEspecie', null, ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkMonetarioGeneroCredito.fkMonetarioNaturezaCredito', null, ['label' => 'label.monetarioEspecie.natureza'])
            ->add('fkMonetarioGeneroCredito.nomGenero', null, ['label' => 'label.monetarioEspecie.genero'])
            ->add('nomEspecie', null, ['label' => 'label.monetarioEspecie.especie']);

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $especie = $this->getSubject();

        $fieldOptions = [];
        $fieldOptions['codNatureza'] = [
            'class' => NaturezaCredito::class,
            'mapped' => false,
            'required' => true,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters js-natureza'
            ],
            'label' => 'label.monetarioEspecie.natureza',
        ];

        $fieldOptions['codGenero'] = [
            'class' => GeneroCredito::class,
            'mapped' => false,
            'required' => true,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters js-genero'
            ],
            'label' => 'label.monetarioEspecie.genero',
        ];

        if ($especie->getCodNatureza()) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $natureza = $em->getRepository(NaturezaCredito::class)
                ->findOneBy(
                    [
                        'codNatureza' => $especie->getCodNatureza()
                    ]
                );

            $fieldOptions['codNatureza']['data'] = $natureza;
            $fieldOptions['codNatureza']['disabled'] = true;
        }

        if ($especie->getCodGenero()) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $genero = $em->getRepository(GeneroCredito::class)
                ->findOneBy(
                    [
                        'codGenero' => $especie->getCodGenero()
                    ]
                );

            $fieldOptions['codGenero']['data'] = $genero;
            $fieldOptions['codGenero']['disabled'] = true;
        }

        $formMapper
             ->with('label.monetarioEspecie.dados')
                ->add('codNatureza', 'entity', $fieldOptions['codNatureza'])
                ->add('codGenero', 'entity', $fieldOptions['codGenero'])
                ->add('nomEspecie', 'textarea', ['label' => 'label.monetarioEspecie.nomEspecie'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with('label.monetarioEspecie.dados')
                ->add('codEspecie', null, ['label' => 'label.monetarioEspecie.codEspecie'])
                ->add('fkMonetarioGeneroCredito.nomGenero', null, ['label' => 'label.monetarioEspecie.genero'])
                ->add('fkMonetarioGeneroCredito.fkMonetarioNaturezaCredito', null, ['label' => 'label.monetarioEspecie.natureza'])
                ->add('nomEspecie', null, ['label' => 'label.monetarioEspecie.nomEspecie'])
            ->end();
        ;
    }

    /**
    * @param mixed $object
    */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $lastEspecie = $em->getRepository(EspecieCredito::class)
            ->findOneBy(
                [],
                [
                    'codEspecie' => 'DESC'
                ]
            );

        $natureza = $em->getRepository(NaturezaCredito::class)
            ->findOneBy(
                [
                    'codNatureza' => $this->getForm()->get('codNatureza')->getData(),
                ]
            );

        $genero = $em->getRepository(GeneroCredito::class)
            ->findOneBy(
                [
                    'codGenero' => $this->getForm()->get('codGenero')->getData()->getCodGenero()
                ]
            );

        $object->setCodEspecie($lastEspecie ? $lastEspecie->getCodEspecie() + 1 : 1);
        $object->setCodNatureza($natureza);
        $object->setFkMonetarioGeneroCredito($genero);
    }

    /**
     * @param Construcao $construcao
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function preRemove($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $especieCredito = $em->getRepository(EspecieCredito::class)
            ->findOneBy(
                [
                    'codEspecie' => $object->getCodEspecie(),
                    'codGenero' => $object->getCodGenero(),
                    'codNatureza' => $object->getCodNatureza()
                ]
            );

        $especieModel = new EspecieCreditoModel($this->getEntityManager());

        $container = $this->getConfigurationPool()->getContainer();
        if (!$especieModel->canRemove($especieCredito)) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.monetarioEspecie.erroExcluir', ['%especie%' => $object->getNomEspecie()]));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $especie = $em->getRepository(EspecieCredito::class)
            ->findOneBy(
                [
                    'nomEspecie' => $object->getNomEspecie()
                ]
            );

        if ($especie) {
            $error = $this->getTranslator()->trans('label.monetarioEspecie.erroEspecie');
            $errorElement->with('nomEspecie')->addViolation($error)->end();
        }
    }

    /**
    * @param mixed $object
    * @return string
    */
    public function toString($object)
    {
        return ($object->getCodEspecie())
            ? (string) $object
            : $this->getTranslator()->trans('label.monetarioEspecie.modulo');
    }
}
