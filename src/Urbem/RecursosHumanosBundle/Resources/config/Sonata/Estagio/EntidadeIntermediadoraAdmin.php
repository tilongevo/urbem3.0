<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Estagio;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Estagio\InstituicaoEnsino;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Model\Estagio\EntidadeIntermediadoraModel;
use Symfony\Component\Validator\Constraints as Assert;

class EntidadeIntermediadoraAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_estagio_entidade_intermediadora';

    protected $baseRoutePattern = 'recursos-humanos/estagio/entidade-intermediadora';

    protected $model = Model\Estagio\EntidadeIntermediadoraModel::class;

    protected $includeJs = [
        '/recursoshumanos/javascripts/estagio/entidadesintermediadoras.js',
    ];

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consultar_dados_entidade', 'consultar-dados-entidade/' . $this->getRouterIdParameter());
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $fieldOptions['fkSwCgmPessoaJuridica'] = [
            'label' => 'label.estagio.entidade_intermediadora',
            'callback' => [$this, 'getSearchFilter'],
        ];

        $datagridMapper
            ->add('fkSwCgmPessoaJuridica', 'doctrine_orm_callback', $fieldOptions['fkSwCgmPessoaJuridica'], 'autocomplete', [
                    'class' => Entity\SwCgmPessoaJuridica::class,
                    'route' => [
                        'name' => 'carrega_sw_cgm_pessoa_juridica'
                    ],
                    'json_choice_label' => function ($pj) use ($em) {
                        $nomcgm = $pj;

                        return $nomcgm;
                    },
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
            ]);
    }

    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        if ($filter['fkSwCgmPessoaJuridica']['value']) {
            $entidades = $filter['fkSwCgmPessoaJuridica']['value'];

            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere(
                $queryBuilder->expr()->in('o.numcgm', $entidades)
            );
        }

        return true;
    }

    public function getSearchFilterCNPJ($queryBuilder, $alias, $field, $value)
    {
        if (! $value['value']) {
            return;
        }

        /**
         * Auxilia na execuçao das Models
         *
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $entidadeIntermediadoraModel = new EntidadeIntermediadoraModel($entityManager);

        $entidadeIntermediadoraModel
            ->searchByCnpjEntidadeIntermediadora($queryBuilder, $value['value'], $alias);
        return true;
    }

    public function getSearchFilterInstituicao($queryBuilder, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        /**
         * Auxilia na execuçao das Models
         *
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $entidadeIntermediadoraModel = new EntidadeIntermediadoraModel($entityManager);

        $entidadeIntermediadoraModel
            ->searchByInstituicaoEntidadeIntermediadora($queryBuilder, $value['value'], $alias);
        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkSwCgmPessoaJuridica', null, ['label' => 'label.estagio.entidade_intermediadora'])
            ->add('percentualAtual', null, [
                'label' => 'label.percentualAtual',
            ]);

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var Entity\Estagio\EntidadeIntermediadora $entidadeIntermediadora */
        $entidadeIntermediadora = $this->getSubject();

        if ($entidadeIntermediadora->getFkEstagioInstituicaoEntidades()->count() > 0) {
            $callback = function (Entity\Estagio\InstituicaoEntidade $instituicaoEntidade) {
                return $instituicaoEntidade->getFkEstagioInstituicaoEnsino();
            };

            $instituicoesEnsino = $entidadeIntermediadora
                                        ->getFkEstagioInstituicaoEntidades()
                                        ->map($callback);
        }

        if ($entidadeIntermediadora->getPercentualAtual()) {
            $percentualParticipacao = $entidadeIntermediadora->getPercentualAtual() * 100;
        }

        $formMapper
            /* Entidade Intermediária do Estágio */
            ->with('label.estagio.entidade_intermediaria_estagio')
                ->add('fkSwCgmPessoaJuridica', 'autocomplete', [
                    'class' => Entity\SwCgmPessoaJuridica::class,
                    'label' => 'EntidadeIntermediadora',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                    'mapped' => false,
                    'route' => ['name' => 'carrega_sw_cgm_pessoa_juridica'],
                    'placeholder' => 'Selecione',
                    'data' => $entidadeIntermediadora->getFkSwCgmPessoaJuridica() ? $entidadeIntermediadora->getFkSwCgmPessoaJuridica(): null
                ])
                ->add(
                    'cnpj',
                    'text',
                    [
                        'label' => 'label.cnpj',
                        'attr' => [
                            'readonly' => true,
                            'disabled' => true
                        ],
                        'required' => false,
                        'mapped' => false
                    ]
                )
                ->add(
                    'endereco',
                    'text',
                    [
                        'label' => 'label.servidor.endereco',
                        'attr' => [
                            'readonly' => true,
                            'disabled' => true
                        ],
                        'required' => false,
                        'mapped' => false
                    ]
                )
                ->add(
                    'bairro',
                    'text',
                    [
                        'label' => 'label.servidor.bairro',
                        'attr' => [
                            'readonly' => true,
                            'disabled' => true
                        ],
                        'required' => false,
                        'mapped' => false
                    ]
                )
                ->add(
                    'cidade',
                    'text',
                    [
                        'label' => 'label.servidor.municipio',
                        'attr' => [
                            'readonly' => true,
                            'disabled' => true
                        ],
                        'required' => false,
                        'mapped' => false
                    ]
                )
                ->add(
                    'telefone',
                    'text',
                    [
                        'label' => 'label.telefone',
                        'attr' => [
                            'readonly' => true,
                            'disabled' => true
                        ],
                        'required' => false,
                        'mapped' => false
                    ]
                )
                ->add('entidadeIntermediadora', 'hidden', [
                    'mapped' => false,
                    'data' => $entidadeIntermediadora->getNumcgm() ? $entidadeIntermediadora->getNumcgm() : null
                ])
            ->end()

            /* Contribuição Patronal à Entidade */
            ->with('label.estagio.contribuicao_patronal_entidade')
                ->add('percentualAtual', 'percent', [
                    'required' => false,
                    'constraints' => [new Assert\Callback(function ($percentual, $context) {
                        if ($percentual > 100) {
                            $message = $this->trans('recursosHumanos.entidadeIntermediadora.errors.campoPercentualInvalido', [], 'validators');
                            $context->addViolation($message);
                        }
                    })],
                    'attr' => [
                        'class' => 'percent ',
                    ],
                    'data' => isset($percentualParticipacao) ? (float) $percentualParticipacao : null,
                    'type' => 'integer'
                ])
            ->end()

            /* Instituição de Ensino */
            ->with('InstituicaoEnsino')
                ->add('instituicaoEnsino', 'entity', [
                    'class' => InstituicaoEnsino::class,
                    'label' => 'label.estagio.instituicao_ensino',
                    'mapped' => false,
                    'multiple' => true,
                    'placeholder' => 'label.selecione',
                    'data' => isset($instituicoesEnsino) ? $instituicoesEnsino : null
                ])
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        /** @var Entity\Estagio\InstituicaoEntidade $instituicoes */
        $instituicoes = $this->getSubject()->getFkEstagioInstituicaoEntidades();

        $showMapper
            ->add('numcgm')
            ->add('percentualAtual', 'percent', [
                'label' => 'label.percentualAtual'
            ])
            ->add('cgmInstituicao', 'customField', [
                'label' => 'label.estagio.instituicao_ensino',
                'data' => ['instituicoes' => $instituicoes],
                'template' => 'RecursosHumanosBundle:\Estagio\InstituicaoEnsino:linha.html.twig',
            ])
        ;
    }

    /**
     * @param Entity\Estagio\EntidadeIntermediadora $entidadeIntermediadora
     */
    public function preUpdate($entidadeIntermediadora)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();
        $instituicoesEnsino = $form->get('instituicaoEnsino')->getData();

        $entidadeIntermediadoraModel = new EntidadeIntermediadoraModel($em);
        $entidadeIntermediadoraModel
            ->updateInstituicaoEntidade($entidadeIntermediadora, $instituicoesEnsino);
    }

    /**
     * @param Entity\Estagio\EntidadeIntermediadora $entidadeIntermediadora
     */
    public function prePersist($entidadeIntermediadora)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();
        $instituicoesEnsino = $form->get('instituicaoEnsino')->getData();
        $pessoaJuridica = $form->get('fkSwCgmPessoaJuridica')->getData();
        $percentualAtual = $form->get('percentualAtual')->getData();

        $entidadeIntermediadoraModel = new EntidadeIntermediadoraModel($em);
        $entidadeIntermediadora = $entidadeIntermediadoraModel
                                      ->saveEntidadeIntermediadora($pessoaJuridica, $percentualAtual);

        $entidadeIntermediadora
            ->setFkSwCgmPessoaJuridica($pessoaJuridica);

        $entidadeIntermediadoraModel
            ->saveEntidadeContribuicao($entidadeIntermediadora, $percentualAtual);

        foreach ($instituicoesEnsino as $instituicao) {
            $entidadeIntermediadoraModel
                ->saveInstituicaoEntidade($entidadeIntermediadora, $instituicao);
        }

        $message = $this->trans('rh.entidadeIntermediadora.itemCriado', [], 'flashes');

        $container = $this->getConfigurationPool()->getContainer();

        $container->get('session')->getFlashBag()->add('success', $message);

        $this->redirectToUrl("/recursos-humanos/estagio/entidade-intermediadora/list");
    }

    /**
     * @param ErrorElement $errorElement
     * @param Entity\Estagio\EntidadeIntermediadora $entidadeIntermediadora
     */
    public function validate(ErrorElement $errorElement, $entidadeIntermediadora)
    {
        $em = $this->getEntityManager();
        $entidade = $em->getRepository('CoreBundle:Estagio\EntidadeIntermediadora')
                        ->findOneBy(['numcgm' => $entidadeIntermediadora->getNumcgm()]);

        if (!is_null($entidade)) {
            $message = $this->trans('rh.entidadeIntermediadora.itemJaCadastrado', [], 'flashes');
            $errorElement->with('fkSwCgmPessoaJuridica')->addViolation($message);
        }
    }
}
