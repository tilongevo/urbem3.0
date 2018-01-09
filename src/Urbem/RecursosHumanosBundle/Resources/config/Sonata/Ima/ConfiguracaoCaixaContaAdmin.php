<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Ima;

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



class ConfiguracaoCaixaContaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_ima_configuracao_caixa';
    protected $baseRoutePattern = 'recursos-humanos/ima/configuracao-caixa';
    protected $includeJs = ['/recursoshumanos/javascripts/ima/configuracao-caixa.js'];
    protected $model = null;
    protected $numBanco = '104';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codConvenio', null, [
                'label' => 'label.configuracaoCaixa.codConvenio'
            ])
            ->add('codAgencia', null, [
                'label' => 'label.configuracaoCaixa.codAgencia'
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
            ->add('codConvenio', null, array('label' => 'label.configuracaoCaixa.codConvenio'))
            ->add('codAgencia', null, array(
                'label' => 'label.configuracaoCaixa.codAgencia',
                'associated_property' => function ($codAgencia) {
                    return $codAgencia->getNomAgencia();
                }
            ))
            ->add('codContaCorrente', null, array(
                'label' => 'label.configuracaoCaixa.codContaCorrente',
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

        $codBanco = $em->getRepository(Monetario\Banco::class)->findOneByNumBanco($this->numBanco)->getCodBanco();
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

        $fieldOptions['codConvenio'] = [
            'label' => 'label.configuraCaixa.codConvenio',
            'mapped' => false
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
            'label' => 'label.configuracaoCaixa.codConvenio',
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
            'label' => 'label.configuracaoCaixa.banco',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'disabled' => true,
            'mapped' => false
        ];

        $fieldOptions['layout'] = [
            'label' => 'label.configuracaoCaixa.layout',
            'mapped' => false,
            'choices' => [
                'Selecione' => '',
                'SIACC 150' => 1,
                'SICOV 150 - PADRAO 150 FEBRABAN' => 2
            ]

        ];

        if ($this->id($this->getSubject())) {
            /** @var Ima\ConfiguracaoConvenioCaixaEconomicaFederal $caixaConta */
            $caixaConta = $em->getRepository($this->getClass())->find($id);
            $fieldOptions['codConvenio']['data']                = $caixaConta->getCodConvenio();
            $fieldOptions['codConvenio']['attr']['readonly']    = true;
            $fieldOptions['codBanco']['data']                   = $caixaConta->getCodBanco();
            $fieldOptions['codAgencia']['data']                 = $caixaConta->getCodAgencia();
            $fieldOptions['codContaCorrente']['data']           = $caixaConta->getCodContaCorrente();
            $fieldOptions['layout']['data']                     = $caixaConta->getCodTipo();
            $fieldOptions['codContaCorrente']['query_builder'] = function ($cc) use ($caixaConta) {
                $qb = $cc->createQueryBuilder('c');
                $qb->where('c.codAgencia = ?1')
                    ->setParameter(1, $caixaConta->getCodAgencia());
                return $qb;
            };
            $fieldOptions['codContaCorrente']['disabled'] = false;
        }

        $formMapper
            ->with('label.configuracaoCaixa.contasConvenio')
            ->add('codConvenio', null, $fieldOptions['codConvenio'])
            ->add('codBanco', 'entity', $fieldOptions['codBanco'])
            ->add('codAgencia', 'entity', $fieldOptions['codAgencia'])
            ->add('codContaCorrente', 'entity', $fieldOptions['codContaCorrente'])
            ->add('layout', 'choice', $fieldOptions['layout'])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        $showMapper
            ->add('codConvenio', null, array('label' => 'label.configuracaoCaixa.codConvenio'))
            ->add('codAgencia', null, array(
                'label' => 'label.configuracaoCaixa.codAgencia',
                'associated_property' => function ($codAgencia) {
                    return $codAgencia->getNomAgencia();
                }
            ))
            ->add('codContaCorrente', null, array(
                'label' => 'label.configuracaoCaixa.codContaCorrente',
                'associated_property' => function ($codContaCorrente) {
                    return $codContaCorrente->getNumContaCorrente();
                }
            ))
        ;
    }


    /**
     * @param ErrorElement $errorElement
     * @param Ima\ConfiguracaoConvenioCaixaEconomicaFederal $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $params = $this->getRequest()->request->get($this->getUniqid());
        $params['codBanco'] = $codBanco = $em
            ->getRepository(Monetario\Banco::class)
            ->findOneByNumBanco($this->numBanco)
            ->getCodBanco()
        ;
        $object->setCodConvenio($params['codConvenio']);
        
        $conta = $em
            ->getRepository(Ima\ConfiguracaoConvenioCaixaEconomicaFederal::class)
            ->findOneBy([
                'codConvenio' => $params['codConvenio'],
            ]);
        
        if ($conta) {
            $errorElement->addViolation('Convenio duplicado')->end();
        }
        return true;
    }

    /**
     * @param Ima\ConfiguracaoConvenioCaixaEconomicaFederal $object
     * @param Form $form
     */
    private function saveRelationships($object, $form)
    {
        $params = $this->getRequest()->request->get($this->getUniqid());
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $params['codBanco'] = $codBanco = $em
            ->getRepository(Monetario\Banco::class)
            ->findOneByNumBanco($this->numBanco)
            ->getCodBanco()
        ;

        $object->setCodConvenioBanco($params['codConvenio']);
        $object->setCodContaCorrente($params['codContaCorrente']);
        $object->setCodAgencia($params['codAgencia']);
        $object->setCodBanco($params['codBanco']);
        $object->setCodTipo($params['layout']);

        $ccCaixa = $em->getRepository(Ima\ConfiguracaoConvenioCaixaEconomicaFederal::class)
            ->findAll();
        if (count($ccCaixa)) {
            $ccCaixa = $ccCaixa[0];
            $ccCaixa->setCodConvenioBanco($object->getCodConvenioBanco());
            $ccCaixa->setCodContaCorrente($object->getCodContaCorrente());
            $ccCaixa->setCodAgencia($object->getCodAgencia());
            $ccCaixa->setCodBanco($object->getCodBanco());
            $ccCaixa->setCodTipo($object->getCodTipo());

            $em->persist($ccCaixa);
            $em->flush();
            $this->getFlashBag()->add('success', $this->trans('label.configuracaoCaixa.dadosAtualizados'));
            $this->forceRedirect('/recursos-humanos/ima/configuracao-caixa/create');
        }
    }

    /**
     * @param Ima\ConfiguracaoConvenioCaixaEconomicaFederal $object
     */
    public function prePersist($object)
    {
        $this->saveRelationships($object, $this->getForm());
    }

    /**
     * @param Ima\ConfiguracaoConvenioCaixaEconomicaFederal $object
     */
    public function preUpdate($object)
    {
        $this->saveRelationships($object, $this->getForm());
    }

    /**
     * @param Ima\ConfiguracaoConvenioCaixaEconomicaFederal $object
     */
    public function postPersist($object)
    {
        $this->forceRedirect('/recursos-humanos/ima/configuracao-caixa/create');
    }

    /**
     * @param Ima\ConfiguracaoConvenioCaixaEconomicaFederal $object
     */
    public function postUpdate($object)
    {
        $this->forceRedirect('/recursos-humanos/ima/configuracao-caixa/create');
    }
}
