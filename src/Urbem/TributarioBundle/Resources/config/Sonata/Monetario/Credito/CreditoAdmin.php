<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Monetario\Credito;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Urbem\CoreBundle\Entity\Monetario\Acrescimo;
use Urbem\CoreBundle\Entity\Monetario\Agencia;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Entity\Monetario\Carteira;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrente;
use Urbem\CoreBundle\Entity\Monetario\ContaCorrenteConvenio;
use Urbem\CoreBundle\Entity\Monetario\Convenio;
use Urbem\CoreBundle\Entity\Monetario\Credito;
use Urbem\CoreBundle\Entity\Monetario\CreditoAcrescimo;
use Urbem\CoreBundle\Entity\Monetario\CreditoCarteira;
use Urbem\CoreBundle\Entity\Monetario\CreditoContaCorrente;
use Urbem\CoreBundle\Entity\Monetario\CreditoIndicador;
use Urbem\CoreBundle\Entity\Monetario\CreditoMoeda;
use Urbem\CoreBundle\Entity\Monetario\CreditoNorma;
use Urbem\CoreBundle\Entity\Monetario\EspecieCredito;
use Urbem\CoreBundle\Entity\Monetario\GeneroCredito;
use Urbem\CoreBundle\Entity\Monetario\IndicadorEconomico;
use Urbem\CoreBundle\Entity\Monetario\Moeda;
use Urbem\CoreBundle\Entity\Monetario\NaturezaCredito;
use Urbem\CoreBundle\Entity\Monetario\RegraDesoneracaoCredito;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class CreditoAdmin extends AbstractSonataAdmin
{
    const TIPO_INDEXACAO_INDICADOR_ECONOMICO = 'indicador-economico';
    const TIPO_INDEXACAO_MOEDA = 'moeda';
    const TIPO_INDEXACOES = [
        self::TIPO_INDEXACAO_INDICADOR_ECONOMICO => 'Indicador Econômico',
        self::TIPO_INDEXACAO_MOEDA => 'Moeda',
    ];

    protected $baseRouteName = 'urbem_tributario_monetario_credito';
    protected $baseRoutePattern = 'tributario/cadastro-monetario/credito';
    protected $includeJs = ['/tributario/javascripts/monetario/credito.js'];

    /**
     * @param mixed $object
     */
    public function preRemove($object)
    {
        $canRemove = $this->canRemove(
            $object,
            [
                'fkMonetarioCreditoAcrescimos',
                'fkMonetarioCreditoNormas',
                'fkMonetarioCreditoIndicadores',
            ]
        );

        if ($canRemove) {
            return;
        }

        $container = $this->getConfigurationPool()->getContainer();

        $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.monetarioCredito.erroDelecao'));

        $this->modelManager->getEntityManager($this->getClass())->clear();

        return $this->forceRedirect($this->generateObjectUrl('list', $object));
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $this->populateObject($object);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $this->populateObject($object);
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        if (!$object->getFkMonetarioCreditoNormas()->count()) {
            $error = $this->getTranslator()->trans('label.monetarioCredito.erroNorma');
            $errorElement->addViolation($error)->end();

            return;
        }
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $qs = $this->getRequest()->get('filter');
        $query = parent::createQuery($context);
        if (!empty($qs['codGenero']['value'])) {
            $query->andWhere('o.codGenero = :codGenero');
            $query->setParameter('codGenero', $qs['codGenero']['value']);
        }

        if (!empty($qs['codEspecie']['value'])) {
            $query->andWhere('o.codEspecie = :codEspecie');
            $query->setParameter('codEspecie', $qs['codEspecie']['value']);
        }

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $qs = $this->getRequest()->get('filter');
        $datagridMapper
            ->add('codCredito', null, ['label' => 'label.monetarioCredito.codCredito'])
            ->add('descricaoCredito', null, ['label' => 'label.monetarioCredito.descricaoCredito'])
            ->add(
                'fkMonetarioEspecieCredito.fkMonetarioGeneroCredito.fkMonetarioNaturezaCredito',
                null,
                [
                    'label' => 'label.monetarioCredito.codNatureza'
                ],
                'entity',
                [
                    'class' => NaturezaCredito::class,
                    'placeholder' => 'Selecione',
                    'attr' => [
                        'class' => 'select2-parameters js-select-natureza',
                    ],
                ]
            )
            ->add(
                'codGenero',
                null,
                [
                    'label' => 'label.monetarioCredito.codGenero',
                ],
                'entity',
                [
                    'class' => GeneroCredito::class,
                    'mapped' => false,
                    'query_builder' => function ($em) use ($qs) {
                        $qb = $em->createQueryBuilder('o');
                        if (empty($qs) || empty($qs['fkMonetarioEspecieCredito__fkMonetarioGeneroCredito__fkMonetarioNaturezaCredito']['value'])) {
                            $qb->where('o.codNatureza IS NULL');
                        }

                        if ($qs && !empty($qs['fkMonetarioEspecieCredito__fkMonetarioGeneroCredito__fkMonetarioNaturezaCredito']['value'])) {
                            $qb = $em->createQueryBuilder('o');
                            $qb->andWhere('o.codNatureza = :codNatureza');
                            $qb->setParameter('codNatureza', $qs['fkMonetarioEspecieCredito__fkMonetarioGeneroCredito__fkMonetarioNaturezaCredito']['value']);
                        }

                        return $qb;
                    },
                    'choice_value' => 'codGenero',
                    'attr' => [
                        'class' => 'select2-parameters js-select-genero',
                    ],
                ]
            )
            ->add(
                'codEspecie',
                null,
                [
                    'label' => 'label.monetarioCredito.codEspecie'
                ],
                'entity',
                [
                    'class' => EspecieCredito::class,
                    'mapped' => false,
                    'query_builder' => function ($em) use ($qs) {
                        $qb = $em->createQueryBuilder('o');
                        if (empty($qs) || empty($qs['codGenero']['value'])) {
                            $qb->where('o.codNatureza IS NULL');
                            $qb->andWhere('o.codGenero IS NULL');
                        }

                        if ($qs && !empty($qs['codGenero']['value'])) {
                            $qb->andWhere('o.codGenero = :codGenero');
                            $qb->setParameter('codGenero', $qs['codGenero']['value']);
                        }

                        if ($qs && !empty($qs['fkMonetarioEspecieCredito__fkMonetarioGeneroCredito__fkMonetarioNaturezaCredito']['value'])) {
                            $qb->andWhere('o.codNatureza = :codNatureza');
                            $qb->setParameter('codNatureza', $qs['fkMonetarioEspecieCredito__fkMonetarioGeneroCredito__fkMonetarioNaturezaCredito']['value']);
                        }

                        return $qb;
                    },
                    'choice_value' => 'codEspecie',
                    'attr' => [
                        'class' => 'select2-parameters js-select-especie',
                    ],
                ]
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codCredito', null, ['label' => 'label.monetarioCredito.codCredito'])
            ->add('fkMonetarioEspecieCredito.fkMonetarioGeneroCredito.fkMonetarioNaturezaCredito', null, ['label' => 'label.monetarioCredito.codNatureza'])
            ->add('fkMonetarioEspecieCredito.fkMonetarioGeneroCredito', null, ['label' => 'label.monetarioCredito.codGenero'])
            ->add('fkMonetarioEspecieCredito.nomEspecie', null, ['label' => 'label.monetarioCredito.codEspecie'])
            ->add('descricaoCredito', null, ['label' => 'label.monetarioCredito.descricaoCredito']);
        $this->setBreadCrumb();
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

        $this->addButtonsCollection();

        $credito = $this->getSubject();

        $fieldOptions['codNatureza'] = [
            'class' => NaturezaCredito::class,
            'mapped' => false,
            'choice_label' => function (NaturezaCredito $naturezaCredito) {
                return sprintf('%d - %s', $naturezaCredito->getCodNatureza(), $naturezaCredito->getNomNatureza());
            },
            'required' => true,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters js-select-natureza'
            ],
            'label' => 'label.monetarioCredito.codNatureza',
        ];

        $fieldOptions['codGenero'] = [
            'class' => GeneroCredito::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                $qb = $em->createQueryBuilder('o');

                return $qb;
            },
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters js-select-genero'
            ],
            'label' => 'label.monetarioCredito.codGenero',
        ];

        $fieldOptions['codEspecie'] = [
            'class' => EspecieCredito::class,
            'choice_value' => function (EspecieCredito $especieCredito = null) {
                if (!$especieCredito) {
                    return;
                }

                return sprintf('%d~%d~%d', $especieCredito->getCodNatureza(), $especieCredito->getCodGenero(), $especieCredito->getCodEspecie());
            },
            'required' => true,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters js-select-especie'
            ],
            'label' => 'label.monetarioCredito.codEspecie',
        ];

        $fieldOptions['fkMonetarioRegraDesoneracaoCredito'] = [
            'label' => 'label.monetarioCredito.regraDesoneracaoCredito',
            'class' => Funcao::class,
            'mapped' => false,
            'required' => false,
            'route' => ['name' => 'administracao_funcao_carrega_funcao'],
            'placeholder' => 'Selecione'
        ];

        $fieldOptions['fkMonetarioConvenio'] = [
            'class' => Convenio::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->where('o.numConvenio = :numConvenio');
                $qb->setParameter('numConvenio', (int) $term);

                $qb->orderBy('o.numConvenio', 'ASC');

                return $qb;
            },
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.monetarioCredito.codConvenio',
        ];

        $fieldOptions['codBanco'] = [
            'class' => Banco::class,
            'mapped' => false,
            'choice_value' => 'codBanco',
            'choice_label' => function (Banco $codBanco) {
                return sprintf('%d - %s', $codBanco->getNumBanco(), $codBanco->getNomBanco());
            },
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters js-select-banco'
            ],
            'label' => 'label.monetarioCredito.codBanco',
        ];

        $fieldOptions['codAgencia'] = [
            'class' => Agencia::class,
            'mapped' => false,
            'choice_value' => function (Agencia $agencia = null) {
                if (!$agencia) {
                    return;
                }

                return sprintf('%s~%s', $agencia->getCodBanco(), $agencia->getCodAgencia());
            },
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters js-select-agencia'
            ],
            'label' => 'label.monetarioCredito.codAgencia',
        ];

        $fieldOptions['codContaCorrente'] = [
            'class' => ContaCorrente::class,
            'mapped' => false,
            'choice_value' => function (ContaCorrente $contaCorrente = null) {
                if (!$contaCorrente) {
                    return;
                }

                return sprintf('%s~%s~%s', $contaCorrente->getCodBanco(), $contaCorrente->getCodAgencia(), $contaCorrente->getCodContaCorrente());
            },
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters js-select-conta-corrente'
            ],
            'label' => 'label.monetarioCredito.codContaCorrente',
        ];

        $fieldOptions['codCarteira'] = [
            'class' => Carteira::class,
            'mapped' => false,
            'choice_value' => 'codCarteira',
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters js-select-carteira'
            ],
            'label' => 'label.monetarioCredito.codCarteira',
        ];

        $fieldOptions['tipoIndexacao'] = [
            'mapped' => false,
            'choices' => array_flip($this::TIPO_INDEXACOES),
            'expanded' => true,
            'multiple' => false,
            'required' => true,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata js-indexacao ',
            ],
            'label' => 'label.monetarioCredito.indexacao',
        ];

        $fieldOptions['fkMonetarioIndicadorEconomico'] = [
            'class' => IndicadorEconomico::class,
            'mapped' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.monetarioCredito.codIndicador',
        ];

        $fieldOptions['fkMonetarioMoeda'] = [
            'class' => Moeda::class,
            'mapped' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.monetarioCredito.codMoeda',
        ];

        $fieldOptions['codAcrescimo'] = [
            'choices' => $em->getRepository(Acrescimo::class)->findBy([], ['descricaoAcrescimo' => 'ASC']),
            'choice_label' => function (Acrescimo $acrescimo) {
                return sprintf('%s - %s', $acrescimo->getDescricaoAcrescimo(), $acrescimo->getFkMonetarioTipoAcrescimo()->getNomTipo());
            },
            'choice_value' => function (Acrescimo $acrescimo) {
                return sprintf('%d~%d', $acrescimo->getCodAcrescimo(), $acrescimo->getCodTipo());
            },
            'mapped' => false,
            'multiple' => true,
            'required' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters js-select-credito-acrescimo'
            ],
            'label' => 'label.monetarioCreditoAcrescimo.codAcrescimo',
        ];

        $fieldOptions['fkMonetarioCreditoNormas'] = array(
            'by_reference' => false,
            'label' => false);

        $fieldOptions['fkMonetarioCreditoNormasOptions'] = array(
            'edit' => 'inline',
            'inline' => 'table',
            'delete' => true,
            'extra_fields_message' => [
                'name_button' => 'secondButton'
            ],
            'sortable' => 'position'
        );

        if ($id) {
            $fieldOptions['codNatureza']['data'] = $credito->getFkMonetarioEspecieCredito()->getFkMonetarioGeneroCredito()->getFkMonetarioNaturezaCredito();
            $fieldOptions['codNatureza']['disabled'] = true;

            $fieldOptions['codGenero']['query_builder'] = function ($em) use ($credito) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.codNatureza = :codNatureza');
                $qb->setParameter('codNatureza', $credito->getCodNatureza());
                $qb->orderBy('o.nomGenero', 'ASC');

                return $qb;
            };
            $fieldOptions['codGenero']['choice_value'] = 'codGenero';
            $fieldOptions['codGenero']['data'] = $credito->getFkMonetarioEspecieCredito()->getFkMonetarioGeneroCredito();
            $fieldOptions['codGenero']['disabled'] = true;

            $fieldOptions['codEspecie']['query_builder'] = function ($em) use ($credito) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('o.codNatureza = :codNatureza');
                $qb->setParameter('codNatureza', $credito->getCodNatureza());
                $qb->andWhere('o.codGenero = :codGenero');
                $qb->setParameter('codGenero', $credito->getCodGenero());
                $qb->orderBy('o.nomEspecie', 'ASC');

                return $qb;
            };
            $fieldOptions['codEspecie']['choice_value'] = 'codEspecie';
            $fieldOptions['codEspecie']['data'] = $credito->getFkMonetarioEspecieCredito();
            $fieldOptions['codEspecie']['disabled'] = true;

            if ($credito->getFkMonetarioRegraDesoneracaoCredito()) {
                $fieldOptions['fkMonetarioRegraDesoneracaoCredito']['data'] = $credito->getFkMonetarioRegraDesoneracaoCredito()->getFkAdministracaoFuncao();
            }

            if ($credito->getFkMonetarioCreditoContaCorrente()) {
                $fieldOptions['fkMonetarioConvenio']['data'] = $credito->getFkMonetarioCreditoContaCorrente()->getFkMonetarioContaCorrenteConvenio()->getFkMonetarioContaCorrente()->getFkMonetarioContaCorrenteConvenios()->last()->getFkMonetarioConvenio();

                $fieldOptions['codBanco']['data'] = $credito->getFkMonetarioCreditoContaCorrente()->getFkMonetarioContaCorrenteConvenio()->getFkMonetarioContaCorrente()->getFkMonetarioAgencia()->getFkMonetarioBanco();

                $fieldOptions['codAgencia']['data'] = $credito->getFkMonetarioCreditoContaCorrente()->getFkMonetarioContaCorrenteConvenio()->getFkMonetarioContaCorrente()->getFkMonetarioAgencia();

                $fieldOptions['codContaCorrente']['data'] = $credito->getFkMonetarioCreditoContaCorrente()->getFkMonetarioContaCorrenteConvenio()->getFkMonetarioContaCorrente();
            }

            if ($carteira = $credito->getFkMonetarioCreditoCarteira()) {
                $fieldOptions['codCarteira']['data'] = $carteira->getFkMonetarioCarteira();
            }

            $tipoIndexacao = '';
            $indicadorEconomico = $em->getRepository(CreditoIndicador::class)->findOneBy(['codCredito' => $credito->getCodCredito()], ['timestamp' => 'DESC']);
            $moeda = $em->getRepository(CreditoMoeda::class)->findOneBy(['codCredito' => $credito->getCodCredito()], ['timestamp' => 'DESC']);

            if ($indicadorEconomico && $moeda) {
                $tipoIndexacao = $indicadorEconomico->getTimestamp() > $moeda->getTimestamp() ? $this::TIPO_INDEXACAO_INDICADOR_ECONOMICO : $this::TIPO_INDEXACAO_MOEDA;
            }

            if ($indicadorEconomico && !$moeda) {
                $tipoIndexacao = $this::TIPO_INDEXACAO_INDICADOR_ECONOMICO;
            }

            if (!$indicadorEconomico && $moeda) {
                $tipoIndexacao = $this::TIPO_INDEXACAO_MOEDA;
            }

            if (($indicadorEconomico && !$moeda) || $tipoIndexacao == $this::TIPO_INDEXACAO_INDICADOR_ECONOMICO) {
                $fieldOptions['tipoIndexacao']['data'] = $this::TIPO_INDEXACAO_INDICADOR_ECONOMICO;
                $fieldOptions['fkMonetarioIndicadorEconomico']['data'] = $credito->getFkMonetarioCreditoIndicadores()->first()->getFkMonetarioIndicadorEconomico();
            }

            if ((!$indicadorEconomico && $moeda) || $tipoIndexacao == $this::TIPO_INDEXACAO_MOEDA) {
                $fieldOptions['tipoIndexacao']['data'] = $this::TIPO_INDEXACAO_MOEDA;
                $fieldOptions['fkMonetarioMoeda']['data'] = $credito->getFkMonetarioCreditoMoedas()->first()->getFkMonetarioMoeda();
            }

            $fieldOptions['codAcrescimo']['data'] = $em->getRepository(Acrescimo::class)
                ->createQueryBuilder('o')
                ->join(CreditoAcrescimo::class, 'ca', 'WITH', 'o.codAcrescimo = ca.codAcrescimo AND o.codTipo = ca.codTipo')
                ->where('ca.codCredito = :codCredito')
                ->andWhere('ca.codNatureza = :codNatureza')
                ->andWhere('ca.codGenero = :codGenero')
                ->andWhere('ca.codEspecie = :codEspecie')
                ->setParameter('codCredito', $credito->getCodCredito())
                ->setParameter('codNatureza', $credito->getCodNatureza())
                ->setParameter('codGenero', $credito->getCodGenero())
                ->setParameter('codEspecie', $credito->getCodEspecie())
                ->getQuery()
                ->getResult();
        }

        $formMapper
            ->with('label.monetarioCredito.cabecalhoCredito')
            ->add('codNatureza', 'entity', $fieldOptions['codNatureza'])
            ->add('codGenero', 'entity', $fieldOptions['codGenero'])
            ->add('fkMonetarioEspecieCredito', 'entity', $fieldOptions['codEspecie'])
            ->add('descricaoCredito', null, ['label' => 'label.monetarioCredito.descricaoCredito'])
            ->add('fkAdministracaoFuncao', 'autocomplete', $fieldOptions['fkMonetarioRegraDesoneracaoCredito'])
            ->add('fkMonetarioConvenio', 'autocomplete', $fieldOptions['fkMonetarioConvenio'])
            ->add('codBanco', 'entity', $fieldOptions['codBanco'])
            ->add('codAgencia', 'entity', $fieldOptions['codAgencia'])
            ->add('codContaCorrente', 'entity', $fieldOptions['codContaCorrente'])
            ->add('codCarteira', 'entity', $fieldOptions['codCarteira'])
            ->add('tipoIndexacao', 'choice', $fieldOptions['tipoIndexacao'])
            ->add('fkMonetarioIndicadorEconomico', 'entity', $fieldOptions['fkMonetarioIndicadorEconomico'])
            ->add('fkMonetarioMoeda', 'entity', $fieldOptions['fkMonetarioMoeda'])
            ->end()
            ->with('label.monetarioCredito.cabecalhoFundamentacao')
            ->add('fkMonetarioCreditoNormas', 'sonata_type_collection', $fieldOptions['fkMonetarioCreditoNormas'], $fieldOptions['fkMonetarioCreditoNormasOptions'])
            ->end()
            ->with('label.monetarioCredito.cabecalhoAcrescimos')
            ->add('codAcrescimo', 'choice', $fieldOptions['codAcrescimo'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $em = $this->getModelManager()->getEntityManager($this->getClass());
        $credito = $this->getSubject();

        $carteira = 'fkMonetarioCreditoCarteira';
        if ($credito->getFkMonetarioCreditoCarteira()) {
            $carteira = 'fkMonetarioCreditoCarteira.fkMonetarioCarteira.codCarteira';
        }

        $this->creditoIndicador = $em->getRepository(CreditoIndicador::class)->findOneBy(['codCredito' => $credito->getCodCredito()], ['timestamp' => 'DESC']);

        $this->creditoMoeda = $em->getRepository(CreditoMoeda::class)->findOneBy(['codCredito' => $credito->getCodCredito()], ['timestamp' => 'DESC']);

        $this->tipoIndexacao = null;

        if ($this->creditoIndicador && $this->creditoMoeda) {
            $this->tipoIndexacao = $this->creditoIndicador->getTimestamp() > $this->creditoMoeda->getTimestamp() ? $this->creditoIndicador : $this->creditoMoeda;
        }

        if ($this->creditoIndicador && !$this->creditoMoeda) {
            $this->tipoIndexacao = $this->creditoIndicador;
        }

        if (!$this->creditoIndicador && $this->creditoMoeda) {
            $this->tipoIndexacao = $this->creditoMoeda;
        }

        $fieldOptions['tipoIndexacao'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Monetario/Credito/credito_indicador_moeda_show.html.twig'
        ];

        $this->creditoAcrescimos = $em->getRepository(CreditoAcrescimo::class)->findBy(['codCredito' => $credito->getCodCredito()]);

        $this->creditoNormas = $em->getRepository(CreditoNorma::class)->findBy(['codCredito' => $credito->getCodCredito()]);

        $fieldOptions['fkMonetarioCreditoAcrescimos'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Monetario/Credito/credito_acrescimos_show.html.twig',
        ];

        $fieldOptions['fkMonetarioCreditoNormas'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Monetario/Credito/credito_normas_show.html.twig',
        ];

        $showMapper
            ->add(
                'fkMonetarioEspecieCredito.fkMonetarioGeneroCredito.fkMonetarioNaturezaCredito',
                null,
                [
                    'label' => 'label.monetarioCredito.codNatureza'
                ]
            )
            ->add('fkMonetarioEspecieCredito.fkMonetarioGeneroCredito', null, ['label' => 'label.monetarioCredito.codGenero'])
            ->add('fkMonetarioEspecieCredito.nomEspecie', null, ['label' => 'label.monetarioCredito.codEspecie'])
            ->add('descricaoCredito', null, ['label' => 'label.monetarioCredito.descricaoCredito'])
            ->add('fkMonetarioRegraDesoneracaoCredito.fkAdministracaoFuncao', null, ['label' => 'label.monetarioCredito.regraDesoneracaoCredito'])
            ->add(
                'fkMonetarioCreditoContaCorrente.fkMonetarioContaCorrenteConvenio.fkMonetarioContaCorrente.fkMonetarioAgencia.fkMonetarioBanco.nomBanco',
                null,
                [
                    'label' => 'label.monetarioCredito.codBanco'
                ]
            )
            ->add(
                'fkMonetarioCreditoContaCorrente.fkMonetarioContaCorrenteConvenio.fkMonetarioContaCorrente.fkMonetarioAgencia.numAgencia',
                null,
                [
                    'label' => 'label.monetarioCredito.codAgencia'
                ]
            )
            ->add(
                'fkMonetarioCreditoContaCorrente.fkMonetarioContaCorrenteConvenio.fkMonetarioContaCorrente.numContaCorrente',
                null,
                [
                    'label' => 'label.monetarioCredito.codContaCorrente'
                ]
            )
            ->add($carteira, null, ['label' => 'label.monetarioCredito.codCarteira'])
            ->add('tipoIndexacao', 'customField', $fieldOptions['tipoIndexacao'])
            ->add('fkMonetarioCreditoAcrescimos', 'customField', $fieldOptions['fkMonetarioCreditoAcrescimos'])
            ->add('fkMonetarioCreditoNormas', 'customField', $fieldOptions['fkMonetarioCreditoNormas']);
    }

    /**
     * @return void
     */
    protected function addButtonsCollection()
    {
        $this->addlegendBtnCatalogue(['icon' => 'add_circle', 'text' => 'Adicionar Acréscimo'], 'firstButton');
        $this->addlegendBtnCatalogue(['icon' => 'add_circle', 'text' => 'Adicionar Fundamentação Legal'], 'secondButton');
    }

    /**
     * @param Credito $object
     */
    protected function populateObject(Credito $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        if ($this->isCurrentRoute('create')) {
            $lastCredito = $em->getRepository(Credito::class)->findOneBy([], ['codCredito' => 'DESC']);
            $codCredito = $lastCredito ? $lastCredito->getCodCredito() : 0;

            $object->setCodCredito(++$codCredito);
        }

        $object->setFkMonetarioConvenio($this->getForm()->get('fkMonetarioConvenio')->getData());

        if ($this->getForm()->get('fkAdministracaoFuncao')->getData()) {
            $regraDesoneracaoCredito = new regraDesoneracaoCredito();
            $regraDesoneracaoCredito->setFkAdministracaoFuncao($this->getForm()->get('fkAdministracaoFuncao')->getData());
            $object->setFkMonetarioRegraDesoneracaoCredito($regraDesoneracaoCredito);
        }

        $contaCorrenteConvenio = $em->getRepository(ContaCorrenteConvenio::class)->findOneBy(
            [
                'codConvenio' => (int) $this->getForm()->get('fkMonetarioConvenio')->getData()->getCodConvenio(),
                'codBanco' => $this->getForm()->get('codBanco')->getData()->getCodBanco(),
                'codAgencia' => $this->getForm()->get('codAgencia')->getData()->getCodAgencia(),
                'codContaCorrente' => $this->getForm()->get('codContaCorrente')->getData()->getCodContaCorrente(),
            ]
        );

        $creditoContaCorrente = new CreditoContaCorrente();
        $creditoContaCorrente->setFkMonetarioContaCorrenteConvenio($contaCorrenteConvenio);
        $object->setFkMonetarioCreditoContaCorrente($creditoContaCorrente);

        if ($this->getForm()->get('codCarteira')->getViewData()) {
            $carteira = $em->getRepository(Carteira::class)->findOneBy(
                [
                    'codConvenio' => (int) $this->getForm()->get('fkMonetarioConvenio')->getData()->getCodConvenio(),
                    'codCarteira' => (int) $this->getForm()->get('codCarteira')->getViewData(),
                ]
            );
            $creditoCarteira = new CreditoCarteira();
            $creditoCarteira->setFkMonetarioCarteira($carteira);
            $object->setFkMonetarioCreditoCarteira($creditoCarteira);
        }

        if ($this->getForm()->get('tipoIndexacao')->getData() == $this::TIPO_INDEXACAO_INDICADOR_ECONOMICO) {
            $creditoIndicador = new CreditoIndicador();
            $creditoIndicador->setFkMonetarioIndicadorEconomico($this->getForm()->get('fkMonetarioIndicadorEconomico')->getData());
            $object->addFkMonetarioCreditoIndicadores($creditoIndicador);
        }

        if ($this->getForm()->get('tipoIndexacao')->getData() == $this::TIPO_INDEXACAO_MOEDA) {
            $creditoMoeda = new CreditoMoeda();
            $creditoMoeda->setFkMonetarioMoeda($this->getForm()->get('fkMonetarioMoeda')->getData());
            $object->addFkMonetarioCreditoMoedas($creditoMoeda);
        }

        $qb = $em->createQueryBuilder();
        $qb->where('o.codCredito = :codCredito');
        $qb->andWhere('o.codNatureza = :codNatureza');
        $qb->andWhere('o.codGenero = :codGenero');
        $qb->andWhere('o.codEspecie = :codEspecie');
        $qb->setParameter('codCredito', $object->getCodCredito());
        $qb->setParameter('codNatureza', $object->getCodNatureza());
        $qb->setParameter('codGenero', $object->getCodGenero());
        $qb->setParameter('codEspecie', $object->getCodEspecie());
        $qb->delete(RegraDesoneracaoCredito::class, 'o');
        $qb->getQuery()->getResult();

        $qb->where('o.codCredito = :codCredito');
        $qb->andWhere('o.codNatureza = :codNatureza');
        $qb->andWhere('o.codGenero = :codGenero');
        $qb->andWhere('o.codEspecie = :codEspecie');
        $qb->setParameter('codCredito', $object->getCodCredito());
        $qb->setParameter('codNatureza', $object->getCodNatureza());
        $qb->setParameter('codGenero', $object->getCodGenero());
        $qb->setParameter('codEspecie', $object->getCodEspecie());
        $qb->delete(CreditoCarteira::class, 'o');
        $qb->getQuery()->getResult();

        $qb->where('o.codCredito = :codCredito');
        $qb->andWhere('o.codNatureza = :codNatureza');
        $qb->andWhere('o.codGenero = :codGenero');
        $qb->andWhere('o.codEspecie = :codEspecie');
        $qb->setParameter('codCredito', $object->getCodCredito());
        $qb->setParameter('codNatureza', $object->getCodNatureza());
        $qb->setParameter('codGenero', $object->getCodGenero());
        $qb->setParameter('codEspecie', $object->getCodEspecie());
        $qb->delete(CreditoContaCorrente::class, 'o');
        $qb->getQuery()->getResult();

        $qb->where('o.codCredito = :codCredito');
        $qb->andWhere('o.codNatureza = :codNatureza');
        $qb->andWhere('o.codGenero = :codGenero');
        $qb->andWhere('o.codEspecie = :codEspecie');
        $qb->setParameter('codCredito', $object->getCodCredito());
        $qb->setParameter('codNatureza', $object->getCodNatureza());
        $qb->setParameter('codGenero', $object->getCodGenero());
        $qb->setParameter('codEspecie', $object->getCodEspecie());
        $qb->delete(CreditoAcrescimo::class, 'o');
        $qb->getQuery()->getResult();

        foreach ($this->getForm()->get('codAcrescimo')->getData() as $acrescimo) {
            $creditoAcrescimo = new CreditoAcrescimo();
            $creditoAcrescimo->setFkMonetarioCredito($object);
            $creditoAcrescimo->setFkMonetarioAcrescimo($acrescimo);

            $object->addFkMonetarioCreditoAcrescimo($creditoAcrescimo);
        }

        foreach ($object->getFkMonetarioCreditoNormas() as $creditoNorma) {
            if ($creditoNorma->getFkNormasNorma()) {
                $creditoNorma->setFkMonetarioCredito($object);

                continue;
            }

            $object->removeFkMonetarioCreditoNorma($creditoNorma);
        }
    }
}
