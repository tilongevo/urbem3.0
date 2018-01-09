<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Monetario;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrente;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ContaCorrenteAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_monetario_conta_corrente';
    protected $baseRoutePattern = 'tributario/cadastro-monetario/conta-corrente';

    /**
     * @param mixed $object
     */
    public function preRemove($object)
    {
        if ($this->canRemove($object)) {
            return;
        }

        $container = $this->getConfigurationPool()->getContainer();

        $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.monetarioContaCorrente.erroDelecao'));

        $this->modelManager->getEntityManager($this->getClass())->clear();

        return $this->forceRedirect($this->generateObjectUrl('list', $object));
    }

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return [];
        }

        return [
            'codBanco' => $this->getRequest()->get('codBanco'),
        ];
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (!$this->getPersistentParameter('codBanco')) {
            $query->where('1 = 0');
        } else {
            $query->where('o.codBanco = :codBanco');
            $query->setParameter('codBanco', $this->getPersistentParameter('codBanco'));
        }

        return $query;
    }

    /**
     * @return null|string
     */
    public function getNomBanco()
    {
        if (!$this->getPersistentParameter('codBanco')) {
            return;
        }

        $em = $this->modelManager->getEntityManager($this->getClass());
        $banco = $em->getRepository(Banco::class)
            ->findOneBy(
                array(
                    'codBanco' => $this->getRequest()->get('codBanco')
                )
            );

        return (string) $banco;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $lastContaCorrente = $em->getRepository(ContaCorrente::class)
            ->findOneBy(
                [],
                [
                    'codContaCorrente' => 'DESC'
                ]
            );

        $object->setCodContaCorrente($lastContaCorrente ? $lastContaCorrente->getCodContaCorrente() + 1 : 1);
    }

    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (empty($value['value'])) {
            return;
        }

        if ($field == 'fkMonetarioAgencia') {
            $queryBuilder->andWhere("{$alias}.codAgencia = :codAgencia");
            $queryBuilder->setParameter("codAgencia", $value['value']->getCodAgencia());
        }

        return true;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'fkMonetarioAgencia',
                'doctrine_orm_callback',
                [
                    'label' => 'label.monetarioAgencia.nomAgencia',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'entity',
                [
                    'class' => 'CoreBundle:Monetario\Agencia',
                    'query_builder' => function ($em) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->where('o.codBanco = :codBanco');
                        $qb->setParameter('codBanco', $this->getPersistentParameter('codBanco'));
                        $qb->orderBy('o.numAgencia', 'ASC');

                        return $qb;
                    },
                    'choice_label' => function ($codAgencia) {
                        return sprintf('%d - %s', $codAgencia->getNumAgencia(), $codAgencia->getNomAgencia());
                    },
                    'placeholder' => 'label.selecione',
                ]
            )
            ->add('numContaCorrente', null, ['label' => 'label.monetarioContaCorrente.numContaCorrente'])
            ->add(
                'fkMonetarioTipoConta',
                null,
                [
                    'label' => 'label.monetarioContaCorrente.codTipo',
                ],
                'entity',
                [
                    'class' => 'CoreBundle:Monetario\TipoConta',
                    'query_builder' => function ($em) {
                        $qb = $em->createQueryBuilder('o');
                        $qb->orderBy('o.descricao', 'ASC');

                        return $qb;
                    },
                    'placeholder' => 'label.selecione',
                ]
            )
            ->add(
                'dataCriacao',
                'doctrine_orm_datetime',
                [
                    'field_type' => 'sonata_type_datetime_picker',
                    'field_options' => [
                        'format' => 'dd/MM/yyyy'
                    ],
                    'label' => 'label.monetarioContaCorrente.dataCriacao'
                ]
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkMonetarioAgencia.nomAgencia', null, ['label' => 'label.monetarioAgencia.nomAgencia'])
            ->add('numContaCorrente', null, ['label' => 'label.monetarioContaCorrente.numContaCorrente'])
            ->add('fkMonetarioTipoConta.descricao', null, ['label' => 'label.monetarioContaCorrente.codTipo'])
            ->add('dataCriacao', null, ['label' => 'label.monetarioContaCorrente.dataCriacao']);

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];
        $fieldOptions['fkMonetarioAgencia'] = [
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.codBanco = :codBanco');
                $qb->setParameter(':codBanco', $this->getPersistentParameter('codBanco'));
                $qb->orderBy('o.numAgencia', 'ASC');

                return $qb;
            },
            'choice_label' => function ($codAgencia) {
                return sprintf('%d - %s', $codAgencia->getNumAgencia(), $codAgencia->getNomAgencia());
            },
            'required' => true,
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'label' => 'label.monetarioAgencia.nomAgencia',
        ];

        $fieldOptions['fkMonetarioTipoConta'] = [
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');
                $qb->orderBy('o.descricao', 'ASC');

                return $qb;
            },
            'required' => true,
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.monetarioContaCorrente.codTipo',
        ];

        $now = new \DateTime();
        $formMapperOptions['dataCriacao'] = [
            'pk_class' => DatePK::class,
            'dp_default_date' => $now->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'required' => true,
            'label' => 'label.monetarioContaCorrente.dataCriacao',
        ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['fkMonetarioAgencia']['disabled'] = true;
        }

        $formMapper
            ->with($this->getNomBanco())
            ->add('fkMonetarioAgencia', null, $fieldOptions['fkMonetarioAgencia'])
            ->add('numContaCorrente', null, ['label' => 'label.monetarioContaCorrente.numContaCorrente'])
            ->add('fkMonetarioTipoConta', null, $fieldOptions['fkMonetarioTipoConta'])
            ->add('dataCriacao', 'datepkpicker', $formMapperOptions['dataCriacao']);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->with('label.monetarioContaCorrente.dados')
            ->add('fkMonetarioAgencia.fkMonetarioBanco.nomBanco', null, ['label' => 'label.monetarioBanco.nomeBanco'])
            ->add('fkMonetarioAgencia', null, ['label' => 'label.monetarioAgencia.nomAgencia'])
            ->add('numContaCorrente', null, ['label' => 'label.monetarioContaCorrente.numContaCorrente'])
            ->add('fkMonetarioTipoConta', null, ['label' => 'label.monetarioContaCorrente.codTipo'])
            ->add('dataCriacao', null, ['label' => 'label.monetarioContaCorrente.dataCriacao']);
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        if ($object->getCodContaCorrente()) {
            return;
        }

        $em = $this->modelManager->getEntityManager($this->getClass());
        $contaCorrente = $em->getRepository(ContaCorrente::class)
            ->findOneBy(
                [
                    'codBanco' => $this->getRequest()->get('codBanco'),
                    'codAgencia' => $object->getCodAgencia(),
                    'numContaCorrente' => $object->getNumContaCorrente(),
                ]
            );

        if ($contaCorrente) {
            $error = $this->getTranslator()->trans('label.monetarioContaCorrente.erroContaCorrente');
            $errorElement->with('numContaCorrente')->addViolation($error)->end();
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return ($object->getCodContaCorrente())
            ? (string) $object
            : $this->getTranslator()->trans('label.monetarioContaCorrente.modulo');
    }
}
