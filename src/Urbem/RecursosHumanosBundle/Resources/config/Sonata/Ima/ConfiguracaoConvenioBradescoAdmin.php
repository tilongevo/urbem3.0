<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Ima;

use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Helper\DateTimePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Ima;
use Urbem\CoreBundle\Entity\Monetario;
use Urbem\CoreBundle\Entity\Organograma;

use Urbem\CoreBundle\Model\Ima\ConfiguracaoHsbcContaModel;

class ConfiguracaoConvenioBradescoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_ima_configuracao_bradesco';
    protected $baseRoutePattern = 'recursos-humanos/ima/configuracao-bradesco';
    protected $includeJs = ['/recursoshumanos/javascripts/ima/configuracao-bradesco.js'];
    protected $model = null;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codConvenio', null, [
                'label' => 'label.configuracaoBradesco.codConvenio'
            ])
            ->add('codAgencia', null, [
                'label' => 'label.configuracaoBradesco.codAgencia'
            ], 'entity', [
                'class' => Monetario\Agencia::class,
                'choice_label' => function ($codAgencia) {
                    return $codAgencia->getNomAgencia();
                },
                'attr' => array(
                    'class' => 'select2-parameters '
                )
            ])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codConvenio', null, array('label' => 'label.configuracaoBradesco.codConvenio'))
            ->add('codAgencia', null, array(
                'label' => 'label.configuracaoBradesco.codAgencia',
                'associated_property' => function ($codAgencia) {
                    return $codAgencia->getNomAgencia();
                }
            ))
            ->add('codContaCorrente', null, array(
                'label' => 'label.configuracaoBradesco.codContaCorrente',
                'associated_property' => function ($codContaCorrente) {
                    return $codContaCorrente->getNumContaCorrente();
                }
            ))
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $em = $this->modelManager->getEntityManager($this->getClass());
        $now = new \DateTime();

        $codBanco = $em->getRepository(Monetario\Banco::class)->findOneByNumBanco('237')->getCodBanco();
        $fieldOptions['codAgencia'] = [
            'class' => Monetario\Agencia::class,
            'choice_label' => 'nomAgencia',
            'choice_value' => 'codAgencia',
            'label' => 'label.agencia',
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'query_builder' => function ($agencia) use ($codBanco) {
                /** @var QueryBuilder $qb */
                $qb = $agencia->createQueryBuilder('a');
                $qb->where('a.codBanco = ?1')
                    ->setParameter(1, $codBanco);
                return $qb;
            },
        ];

        $fieldOptions['codContaCorrente'] = [
            'attr' => [
                'class' => 'select2-parameters ',
                'data-related-from' => '_codAgencia'
            ],
            'class' => Monetario\ContaCorrente::class,
            'choice_label' => 'numContaCorrente',
            'choice_value' => 'codContaCorrente',
            'label' => 'label.fornecedor.numConta',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'disabled' => true
        ];


        $fieldOptions['codConvenio'] = [
            'label' => 'label.configuracaoBradesco.codConvenio',
            'mapped' => false
        ];

        $fieldOptions['codBanco'] = [
            'class' => Monetario\Banco::class,
            'query_builder' => function ($banco) use ($codBanco) {
                $qb = $banco->createQueryBuilder('b');
                $qb->where($qb->expr()->andX(
                    $qb->expr()->eq('b.codBanco', '?1')
                ))
                ->setParameter(1, $codBanco);
                return $qb;
            },
            'choice_label' => function ($codBanco) {
                return $codBanco->getNomBanco();
            },
            'label' => 'label.configuracaoBradesco.banco',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'disabled' => true,
            'mapped' => false
        ];


        if ($this->id($this->getSubject())) {
            /** @var Ima\ConfiguracaoConvenioBradesco $convenioBradesco */
            $convenioBradesco = $em->getRepository($this->getClass())->findOne($id);
            $fieldOptions['codConvenio']['data'] = $convenioBradesco->getCodConvenio();
            $fieldOptions['codConvenio']['attr']['readonly'] = true;
            $fieldOptions['codBanco']['data'] = $convenioBradesco->getCodBanco();
            $fieldOptions['codAgencia']['data'] = $convenioBradesco->getCodAgencia();
            $fieldOptions['codContaCorrente']['data'] = $convenioBradesco->getCodContaCorrente();
            $fieldOptions['codContaCorrente']['query_builder'] = function ($cc) use ($convenioBradesco) {
                $qb = $cc->createQueryBuilder('c');
                $qb->where('c.codAgencia = ?1')
                    ->setParameter(1, $convenioBradesco->getCodAgencia());
                return $qb;
            };
            $fieldOptions['codContaCorrente']['disabled'] = false;
        }

        $formMapper
            ->with('label.configuracaoBradesco.modulo')
            ->add('codConvenio', null, $fieldOptions['codConvenio'])
            ->add('codBanco', 'entity', $fieldOptions['codBanco'])
            ->add('codAgencia', 'entity', $fieldOptions['codAgencia'])
            ->add('codContaCorrente', 'entity', $fieldOptions['codContaCorrente'])
            ->end()
        ;
    }


    /**
     * @param ErrorElement $errorElement
     * @param Ima\ConfiguracaoConvenioBradesco $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $params = $this->getRequest()->request->get($this->getUniqid());
        $params['codBanco'] = $codBanco = $em
            ->getRepository(Monetario\Banco::class)
            ->findOneByNumBanco('237')
            ->getCodBanco()
        ;
        $object->setCodConvenio($params['codConvenio']);
        
        $conta = $em
            ->getRepository(Ima\ConfiguracaoConvenioBradesco::class)
            ->findOneBy([
                'codBanco' => $params['codBanco'],
                'codConvenio' => $params['codConvenio'],
            ]);
        
        if ($conta) {
            $errorElement->addViolation('Convenio duplicado')->end();
        }

        return true;
    }

    /**
     * @param Ima\ConfiguracaoConvenioBradesco $object
     * @param Form $form
     */
    private function saveRelationships($object, $form)
    {
        $params = $this->getRequest()->request->get($this->getUniqid());
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $params['codBanco'] = $codBanco = $em
            ->getRepository(Monetario\Banco::class)
            ->findOneByNumBanco('237')
            ->getCodBanco()
        ;
        $object->setCodEmpresa($params['codConvenio']);
        $object->setCodContaCorrente($params['codContaCorrente']);
        $object->setCodAgencia($params['codAgencia']);
        $object->setCodBanco($params['codBanco']);

        $ccbradesco = $em->getRepository(Ima\ConfiguracaoConvenioBradesco::class)
            ->findAll();
        if (count($ccbradesco)) {
            $ccbradesco = $ccbradesco[0];
            $ccbradesco->setCodEmpresa($object->getCodEmpresa());
            $ccbradesco->setCodContaCorrente($object->getCodContaCorrente());
            $ccbradesco->setCodAgencia($object->getCodAgencia());
            $ccbradesco->setCodBanco($object->getCodBanco());

            $em->persist($ccbradesco);
            $em->flush();
            $this->getFlashBag()->add('success', $this->trans('label.configuracaoBradesco.dadosAtualizados'));
            $this->forceRedirect('/recursos-humanos/ima/configuracao-bradesco/create');
        }
    }

    /**
     * @param Ima\ConfiguracaoConvenioBradesco $object
     */
    public function prePersist($object)
    {
        $this->saveRelationships($object, $this->getForm());
    }

    /**
     * @param Ima\ConfiguracaoConvenioBradesco $object
     */
    public function preUpdate($object)
    {
        $id = $this->getAdminRequestId();
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $this->saveRelationships($object, $this->getForm());
    }

    /**
     * @param Ima\ConfiguracaoConvenioBradesco $object
     */
    public function postPersist($object)
    {
        $this->forceRedirect('/recursos-humanos/ima/configuracao-bradesco/create');
    }

    /**
     * @param Ima\ConfiguracaoConvenioBradesco $object
     */
    public function postUpdate($object)
    {
        $this->forceRedirect('/recursos-humanos/ima/configuracao-bradesco/create');
    }
}
