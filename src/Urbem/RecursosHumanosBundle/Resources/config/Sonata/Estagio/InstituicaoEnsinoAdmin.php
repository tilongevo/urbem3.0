<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Estagio;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Estagio;
use Urbem\CoreBundle\Entity\Administracao;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class InstituicaoEnsinoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_estagio_instituicao_ensino';

    protected $baseRoutePattern = 'recursos-humanos/estagio/instituicao-ensino';

    protected $model = Model\Estagio\InstituicaoEnsinoModel::class;

    protected $includeJs = [
        '/recursoshumanos/javascripts/estagio/entidadesintermediadoras.js',
    ];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
           ->add(
               'numcgm',
               'doctrine_orm_callback',
               [
                    'label' => 'label.estagio.instituicao_ensino',
                    'callback' => [$this, 'callbackInsEnsino']
               ]
           )
            ->add(
                'numcgm.cnpj',
                'doctrine_orm_callback',
                [
                    'label' => 'label.cnpj',
                    'callback' => [$this,'callbackCnpj']
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkSwCgmPessoaJuridica', null, [
                'label' => 'label.estagio.instituicao_ensino'
            ])
            ->add('fkSwCgmPessoaJuridica.cnpj', 'text', [
                'label' => 'label.cnpj'
            ])
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

        $fieldOptions = [];

        $fieldOptions['codMes'] = [
            'class' => Administracao\Mes::class,
            'choice_label' => function ($codMes) {
                return $codMes->getDescricao();
            },
            'label' => 'label.periodoAvaliacao',
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $formMapper
            ->add('fkSwCgmPessoaJuridica', 'autocomplete', [
                'class' => Entity\SwCgmPessoaJuridica::class,
                'label' => 'label.estagio.instituicao_ensino',
                'attr' => [
                    'class' => 'select2-parameters '
                ],
                'route' => ['name' => 'carrega_sw_cgm_pessoa_juridica'],
                'placeholder' => 'Selecione',
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
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        /** @var Estagio\InstituicaoEnsino $instituicaoEnsino */
        $instituicaoEnsino = $this->getSubject();

        /** @var Estagio\Curso cursos */
        $instituicaoEnsino->cursos = $instituicaoEnsino->getFkEstagioCursoInstituicaoEnsinos();

        $showMapper
            ->add('fkEstagioInstituicaoEnsino.fkSwCgmPessoaJuridica', 'text', [
                'label' => 'label.estagio.instituicao_ensino'
            ])
            ->add(
                'fkEstagioInstituicaoEnsino.fkSwCgmPessoaJuridica.cnpj',
                'text',
                [
                    'label' => 'label.cnpj',
                ]
            )
            ->add(
                'endereco',
                'text',
                [
                    'label' => 'label.servidor.endereco',
                ]
            )
            ->add(
                'bairro',
                'text',
                [
                    'label' => 'label.servidor.bairro',
                ]
            )
            ->add(
                'cidade',
                'text',
                [
                    'label' => 'label.servidor.municipio',
                ]
            )
            ->add(
                'telefone',
                'text',
                [
                    'label' => 'label.telefone',
                ]
            )
            ->add('vlBolsa', null, ['label' => 'label.vlBolsa'])
        ;
    }

    /**
     * Callback DatagridMapper do filtro instituicao de ensino
     *
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function callbackInsEnsino($queryBuilder, $alias, $field, $value)
    {
        if (empty($value['value'])) {
            return;
        }
        $queryBuilder->leftJoin('o.fkSwCgmPessoaJuridica', 'pj');
        $queryBuilder->leftJoin('pj.fkSwCgm', 'swc');
        $queryBuilder->where('swc.nomCgm LIKE :nomcgmUpper');
        $queryBuilder->orWhere('swc.nomCgm LIKE :nomcgmLower');
        $queryBuilder->setParameter('nomcgmUpper', '%'.strtoupper($value['value']).'%');
        $queryBuilder->setParameter('nomcgmLower', '%'.strtolower($value['value']).'%');
        return true;
    }

    /**
     * Callback DatagridMapper do filtro CNPJ
     *
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function callbackCnpj($queryBuilder, $alias, $field, $value)
    {
        if (empty($value['value'])) {
            return;
        }
        $queryBuilder->leftJoin('o.fkSwCgmPessoaJuridica', 'pj');
        $queryBuilder->where('pj.cnpj LIKE :cnpj');
        $queryBuilder->setParameter('cnpj', '%'.$value['value'].'%');
        return true;
    }

    /**
     * @param Estagio\InstituicaoEnsino $instituicaoEnsino
     */
    public function postPersist($instituicaoEnsino)
    {
        $this->redirectByRoute('urbem_recursos_humanos_estagio_instituicao_ensino_show', ['id' => $this->getObjectKey($instituicaoEnsino)]);
    }
}
