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

use Urbem\CoreBundle\Model\Ima\ConfiguracaoHsbcContaModel;

class ConfiguracaoHsbcContaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_ima_configuracao_hsbc';
    protected $baseRoutePattern = 'recursos-humanos/ima/configuracao-hsbc';
    protected $includeJs = ['/recursoshumanos/javascripts/ima/configuracao-hsbc.js'];
    protected $model = null;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'vigencia',
                'doctrine_orm_datetime',
                [
                    'label' => 'label.configuracaoHsbc.vigencia',
                    'field_type' => 'sonata_type_datetime_picker',
                    'field_options' =>
                    [
                        'format' => 'dd/MM/yyyy'
                    ]
                ]
            )
            ->add('codConvenio', null, [
                'label' => 'label.configuracaoHsbc.codConvenio'
            ])
            ->add('codAgencia', null, [
                'label' => 'label.configuracaoHsbc.codAgencia'
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
            ->add('vigencia', null, array('label' => 'label.configuracaoHsbc.vigencia'))
            ->add('codConvenio', null, array('label' => 'label.configuracaoHsbc.codConvenio'))
            ->add('codAgencia', null, array(
                'label' => 'label.configuracaoHsbc.codAgencia',
                'associated_property' => function ($codAgencia) {
                    return $codAgencia->getNomAgencia();
                }
            ))
            ->add('codContaCorrente', null, array(
                'label' => 'label.configuracaoHsbc.codContaCorrente',
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

        $codBanco = $em->getRepository(Monetario\Banco::class)->findOneByNumBanco('399')->getCodBanco();
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

        $fieldOptions['configuracaoHsbcLocalCollection'] = [
            'class' => Organograma\Local::class,
            'choice_label' => function ($configuracaoHsbcLocalCollection) {
                return $configuracaoHsbcLocalCollection->getCodLocal()
                    . ' - '
                    . $configuracaoHsbcLocalCollection->getDescricao();
            },
            'label' => 'label.configuracaoHsbc.local',
            'mapped' => false,
            'multiple' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $fieldOptions['configuracaoHsbcOrgaoCollection'] = [
            'class' => Organograma\Orgao::class,
            'choice_label' => function ($configuracaoHsbcOrgaoCollection) {
                return $configuracaoHsbcOrgaoCollection->getSiglaOrgao();
            },
            'label' => 'label.configuracaoHsbc.orgao',
            'mapped' => false,
            'multiple' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $fieldOptions['configuracaoHsbcBancosCollection'] = [
            'class' => Monetario\Banco::class,
            'query_builder' => function ($configuracaoHsbcBancosCollection) {
                $qb = $configuracaoHsbcBancosCollection->createQueryBuilder('b');
                $qb->where($qb->expr()->orX(
                    $qb->expr()->neq('b.nomBanco', '?1')
                ))
                ->setParameter(1, 'HSBC');

                return $qb;
            },
            'choice_label' => function ($configuracaoHsbcBancosCollection) {
                return $configuracaoHsbcBancosCollection->getNumBanco()
                    . ' - '
                    . $configuracaoHsbcBancosCollection->getNomBanco();
            },
            'label' => 'label.configuracaoHsbc.outrosBancos',
            'mapped' => false,
            'multiple' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $fieldOptions['vigencia'] = [
            'dp_default_date' =>  $now->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'mapped' => false,
            'label' => 'label.configuracaoHsbc.vigencia'
        ];

        $fieldOptions['codConvenio'] = [
            'label' => 'label.configuracaoHsbc.codConvenio',
            'mapped' => false
        ];

        $fieldOptions['codBanco'] = [
            'class' => Monetario\Banco::class,
            'query_builder' => function ($codBanco) {
                $qb = $codBanco->createQueryBuilder('b');
                $qb->where($qb->expr()->andX(
                    $qb->expr()->eq('b.numBanco', '?1')
                ))
                ->setParameter(1, '399');
                return $qb;
            },
            'choice_label' => function ($codBanco) {
                return $codBanco->getNomBanco();
            },
            'label' => 'label.configuracaoHsbc.banco',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'disabled' => true,
            'mapped' => false
        ];

        $fieldOptions['descricao'] = [
            'label' => 'label.configuracaoHsbc.descricao',
            'mapped' => false
        ];

        if ($this->id($this->getSubject())) {

            /*
            *   Configuração HSBC Conta
            */
            $HsbcConta = $em->getRepository($this->getClass())->findOneByCodConfiguracaoHsbcConta($id);
            $fieldOptions['vigencia']['data']                   = $HsbcConta->getVigencia();
            $fieldOptions['vigencia']['attr']['readonly']       = true;
            $fieldOptions['codConvenio']['data']                = $HsbcConta->getCodConvenio();
            $fieldOptions['codConvenio']['attr']['readonly']    = true;

            $fieldOptions['codBanco']['data']           = $HsbcConta->getCodBanco();
            $fieldOptions['codAgencia']['data']         = $HsbcConta->getCodAgencia();
            $fieldOptions['codContaCorrente']['data']   = $HsbcConta->getCodContaCorrente();
            $fieldOptions['descricao']['data']          = $HsbcConta->getDescricao();

            $fieldOptions['codContaCorrente']['query_builder'] = function ($cc) use ($HsbcConta) {
                $qb = $cc->createQueryBuilder('c');
                $qb->where('c.codAgencia = ?1')
                    ->setParameter(1, $HsbcConta->getCodAgencia());
                return $qb;
            };
            $fieldOptions['codContaCorrente']['disabled'] = false;


            /*
            *   Configuração HSBC Locais
            */
            $configuracaoHsbcLocal = $em->getRepository('CoreBundle:Ima\ConfiguracaoHsbcLocal')->findByCodConfiguracaoHsbcConta($id);
            if (count($configuracaoHsbcLocal) > 0) {
                $fieldOptions['configuracaoHsbcLocalCollection']['choice_attr'] = function ($evento, $key, $index) use ($configuracaoHsbcLocal) {
                    foreach ($configuracaoHsbcLocal as $HsbcLocal) {
                        if ($HsbcLocal->getCodLocal() == $evento) {
                            return ['selected' => 'selected'];
                        }
                    }

                    return ['selected' => false];
                };
            }

            /*
            *   Configuração HSBC Orgão
            */
            $configuracaoHsbcOrgao = $em->getRepository('CoreBundle:Ima\ConfiguracaoHsbcOrgao')->findByCodConfiguracaoHsbcConta($id);
            if (count($configuracaoHsbcOrgao) > 0) {
                $fieldOptions['configuracaoHsbcOrgaoCollection']['choice_attr'] = function ($evento, $key, $index) use ($configuracaoHsbcOrgao) {
                    foreach ($configuracaoHsbcOrgao as $HsbcOrgao) {
                        if ($HsbcOrgao->getCodOrgao() == $evento) {
                            return ['selected' => 'selected'];
                        }
                    }

                    return ['selected' => false];
                };
            }

            /*
            *   Configuração HSBC Orgão
            */
            $configuracaoHsbcBancos = $em->getRepository('CoreBundle:Ima\ConfiguracaoHsbcBancos')->findByCodConfiguracaoHsbcConta($id);
            if (count($configuracaoHsbcBancos) > 0) {
                $fieldOptions['configuracaoHsbcBancosCollection']['choice_attr'] = function ($evento, $key, $index) use ($configuracaoHsbcBancos) {
                    foreach ($configuracaoHsbcBancos as $HsbcBanco) {
                        if ($HsbcBanco->getCodBancoOutros() == $evento) {
                            return ['selected' => 'selected'];
                        }
                    }

                    return ['selected' => false];
                };
            }
        }

        $formMapper
            ->with('label.configuracaoHsbc.with_modulo')
                ->add(
                    'vigencia',
                    'sonata_type_date_picker',
                    $fieldOptions['vigencia']
                )
                ->add('codConvenio', null, $fieldOptions['codConvenio'])
            ->end()
            ->with('label.configuracaoHsbc.contasConvenio')
                ->add('codBanco', 'entity', $fieldOptions['codBanco'])
                ->add('codAgencia', 'entity', $fieldOptions['codAgencia'])
                ->add('codContaCorrente', 'entity', $fieldOptions['codContaCorrente'])
                ->add('descricao', null, $fieldOptions['descricao'])
                ->add('configuracaoHsbcLocalCollection', 'entity', $fieldOptions['configuracaoHsbcLocalCollection'])
                ->add('configuracaoHsbcOrgaoCollection', 'entity', $fieldOptions['configuracaoHsbcOrgaoCollection'])
                ->add('configuracaoHsbcBancosCollection', 'entity', $fieldOptions['configuracaoHsbcBancosCollection'])
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

            ->add(
                'vigencia',
                null,
                [
                    'label' => 'label.dtVigencia',
                ],
                'sonata_type_date_picker',
                [
                    'required'        => false,
                    'format'          => 'dd/MM/yyyy',
                    'label'           => 'label.vigencia',
                ]
            )
            ->add('codConvenio', null, array('label' => 'label.configuracaoHsbc.codConvenio'))
            ->add('codAgencia', null, array(
                'label' => 'label.configuracaoHsbc.codAgencia',
                'associated_property' => function ($codAgencia) {
                    return $codAgencia->getNomAgencia();
                }
            ))
            ->add('codContaCorrente', null, array(
                'label' => 'label.configuracaoHsbc.codContaCorrente',
                'associated_property' => function ($codContaCorrente) {
                    return $codContaCorrente->getNumContaCorrente();
                }
            ))
            ->add('descricao', null, array('label' => 'label.configuracaoHsbc.descricao'))

            ->add('configuracaoHsbcLocalCollection', null, array(
                'associated_property' => function ($configuracaoHsbcLocalCollection) {
                    return $configuracaoHsbcLocalCollection->getCodLocal()->getCodLocal().' - '.$configuracaoHsbcLocalCollection->getCodLocal()->getDescricao();
                },
                'label' => 'label.configuracaoHsbc.local'
            ))
            ->add('configuracaoHsbcOrgaoCollection', null, array(
                'associated_property' => function ($configuracaoHsbcOrgaoCollection) {
                    return $configuracaoHsbcOrgaoCollection->getCodOrgao()->getSiglaOrgao();
                },
                'label' => 'label.configuracaoHsbc.orgao'
            ))
            ->add('configuracaoHsbcBancosCollection', null, array(
                'associated_property' => function ($configuracaoHsbcBancosCollection) {
                    return $configuracaoHsbcBancosCollection->getCodBancoOutros()->getNumBanco().' - '.$configuracaoHsbcBancosCollection->getCodBancoOutros()->getNomBanco();
                },
                'label' => 'label.configuracaoHsbc.outrosBancos'
            ))
        ;
    }


    public function validate(ErrorElement $errorElement, $object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $params = $this->getRequest()->request->get($this->getUniqid());
        $params['codBanco'] = $codBanco = $em
            ->getRepository(Monetario\Banco::class)
            ->findOneByNumBanco('399')
            ->getCodBanco()
        ;
        $object->setDescricao($params['descricao']);
        
        $conta = $em
            ->getRepository(Ima\ConfiguracaoHsbcConta::class)
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
     * @param Ima\ConfiguracaoHsbcConta $object
     * @param Form $form
     */
    private function saveRelationships($object, $form)
    {
        $params = $this->getRequest()->request->get($this->getUniqid());
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $params['vigencia'] = \DateTime::createFromFormat('d/m/Y', $params['vigencia']);
        $params['codBanco'] = $codBanco = $em
            ->getRepository(Monetario\Banco::class)
            ->findOneByNumBanco('399')
            ->getCodBanco()
        ;

        $object->setCodConvenio($params['codConvenio']);
        $object->setVigencia($params['vigencia']);
        $object->setCodContaCorrente($params['codContaCorrente']);
        $object->setCodAgencia($params['codAgencia']);
        $object->setCodBanco($params['codBanco']);
        $object->setDescricao($params['descricao']);
        $object->setTimestamp(new DateTimeMicrosecondPK());

        //Salva ConfiguracaoConvenioHsbc
        $ConfiguracaoConvenioHsbc = $object->getFkImaConfiguracaoConvenioHsbc();
        if (!$ConfiguracaoConvenioHsbc) {
            $ConfiguracaoConvenioHsbc = new Ima\ConfiguracaoConvenioHsbc();
            $ConfiguracaoConvenioHsbc->setCodConvenio($object->getCodConvenio());
            $ConfiguracaoConvenioHsbc->setCodBanco($object->getCodBanco());
            $ConfiguracaoConvenioHsbc->setcodConvenioBanco($object->getCodConvenio());
            $em->persist($ConfiguracaoConvenioHsbc);
            $object->setFkImaConfiguracaoConvenioHsbc($ConfiguracaoConvenioHsbc);
        }

        //Adiciona configuracaoHsbcLocalCollection a Collection em ConfiguracaoHsbcConta
        $configHsbcLocal = $form->get('configuracaoHsbcLocalCollection')->getData();
        /** @var Organograma\Local $local */
        foreach ($configHsbcLocal as $local) {
            $ConfiguracaoHsbcLocal = new Ima\ConfiguracaoHsbcLocal();
            $ConfiguracaoHsbcLocal->setCodContaCorrente($object->getCodContaCorrente());
            $ConfiguracaoHsbcLocal->setCodAgencia($object->getCodAgencia());
            $ConfiguracaoHsbcLocal->setCodBanco($object->getCodBanco());
            $ConfiguracaoHsbcLocal->setCodConvenio($object->getCodConvenio());
            $ConfiguracaoHsbcLocal->setCodLocal($local->getCodLocal());
            $ConfiguracaoHsbcLocal->setFkImaConfiguracaoHsbcConta($object);
            $object->addFkImaConfiguracaoHsbcLocais($ConfiguracaoHsbcLocal);
        }

        //Adiciona configuracaoHsbcOrgaoCollection a Collection em ConfiguracaoHsbcConta
        $configHsbcOrgao = $form->get('configuracaoHsbcOrgaoCollection')->getData();
        /** @var Organograma\Orgao $orgao */
        foreach ($configHsbcOrgao as $orgao) {
            $ConfiguracaoHsbcOrgao = new Ima\ConfiguracaoHsbcOrgao();
            $ConfiguracaoHsbcOrgao->setCodContaCorrente($object->getCodContaCorrente());
            $ConfiguracaoHsbcOrgao->setCodAgencia($object->getCodAgencia());
            $ConfiguracaoHsbcOrgao->setCodBanco($object->getCodBanco());
            $ConfiguracaoHsbcOrgao->setCodConvenio($object->getCodConvenio());
            $ConfiguracaoHsbcOrgao->setCodOrgao($orgao->getCodOrgao());
            $ConfiguracaoHsbcOrgao->setFkImaConfiguracaoHsbcConta($object);
            $object->addFkImaConfiguracaoHsbcOrgoes($ConfiguracaoHsbcOrgao);
        }

        //Adiciona configuracaoHsbcBancosCollection a Collection em ConfiguracaoHsbcConta
        $configHsbcBancos = $form->get('configuracaoHsbcBancosCollection')->getData();
        /** @var Monetario\Banco $bancos */
        foreach ($configHsbcBancos as $bancos) {
            $ConfiguracaoHsbcBancos = new Ima\ConfiguracaoHsbcBancos();
            $ConfiguracaoHsbcBancos->setCodContaCorrente($object->getCodContaCorrente());
            $ConfiguracaoHsbcBancos->setCodAgencia($object->getCodAgencia());
            $ConfiguracaoHsbcBancos->setCodBanco($object->getCodBanco());
            $ConfiguracaoHsbcBancos->setCodConvenio($object->getCodConvenio());
            $ConfiguracaoHsbcBancos->setCodBancoOutros($bancos->getCodBanco());
            $ConfiguracaoHsbcBancos->setFkImaConfiguracaoHsbcConta($object);
            $object->addFkImaConfiguracaoHsbcBancos($ConfiguracaoHsbcBancos);
        }
    }

    /**
     * @param Ima\ConfiguracaoHsbcConta $object
     */
    public function prePersist($object)
    {
        $this->saveRelationships($object, $this->getForm());
    }

    /**
     * @param Ima\ConfiguracaoHsbcConta $object
     */
    public function preUpdate($object)
    {
        $id = $this->getAdminRequestId();
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $hsbcLocal = $em->getRepository('CoreBundle:Ima\ConfiguracaoHsbcLocal');
        foreach ($hsbcLocal->findByCodConfiguracaoHsbcConta($id) as $local) {
            $em->remove($local);
        }

        $hsbcOrgao = $em->getRepository('CoreBundle:Ima\ConfiguracaoHsbcOrgao');
        foreach ($hsbcOrgao->findByCodConfiguracaoHsbcConta($id) as $orgao) {
            $em->remove($orgao);
        }

        $hsbcBancos = $em->getRepository('CoreBundle:Ima\ConfiguracaoHsbcBancos');
        foreach ($hsbcBancos->findByCodConfiguracaoHsbcConta($id) as $bancos) {
            $em->remove($bancos);
        }

        $this->saveRelationships($object, $this->getForm());
    }

    /**
     * @param Ima\ConfiguracaoHsbcConta $object
     */
    public function postPersist($object)
    {
        $this->forceRedirect('/recursos-humanos/ima/configuracao-hsbc/create');
    }

    /**
     * @param Ima\ConfiguracaoHsbcConta $object
     */
    public function postUpdate($object)
    {
        $this->forceRedirect('/recursos-humanos/ima/configuracao-hsbc/create');
    }
}
