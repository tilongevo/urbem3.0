<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Imobiliario\Condominio;
use Urbem\CoreBundle\Entity\Imobiliario\Construcao;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\Imobiliario\TipoEdificacao;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Model\Imobiliario\ConstrucaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ConstrucaoCondominioAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_edificacao_condominio';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/edificacao/condominio';
    protected $includeJs = array(
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/tributario/javascripts/imobiliario/processo.js',
        '/tributario/javascripts/imobiliario/edificacao.js'
    );

    /**
     * @param Construcao $construcao
     * @return boolean
     */
    public function verificaBaixa(Construcao $construcao)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new ConstrucaoModel($em))->verificaBaixa($construcao);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codConstrucao',
                'doctrine_orm_callback',
                [
                    'label' => 'label.codigo',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'text'
            )
            ->add(
                'fkImobiliarioTipoEdificacao',
                'doctrine_orm_callback',
                [
                    'label' => 'label.tipo',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'entity',
                [
                    'class' => TipoEdificacao::class
                ]
            )
            ->add(
                'fkImobiliarioCondominio',
                'doctrine_orm_callback',
                [
                    'label' => 'label.imobiliarioConstrucao.condominio',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'text'
            )
            ->add(
                'codLote',
                'doctrine_orm_callback',
                [
                    'label' => 'label.imobiliarioConstrucao.numLote',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'text'
            )
            ->add(
                'codLocalizacao',
                'doctrine_orm_callback',
                [
                    'label' => 'label.imobiliarioImovel.localizacao',
                    'callback' => array($this, 'getSearchFilter')
                ],
                'autocomplete',
                [
                    'class' => Localizacao::class,
                    'route' => [
                        'name' => 'urbem_tributario_imobiliario_localizacao_autocomplete_localizacao'
                    ]
                ]
            )
        ;
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        $filter = $this->getDataGrid()->getValues();

        $queryBuilder->resetDQLPart('join');

        $queryBuilder->leftJoin('o.fkImobiliarioConstrucaoCondominios', 'cc');
        $queryBuilder->leftJoin('o.fkImobiliarioConstrucaoEdificacoes', 'e');
        $queryBuilder->leftJoin('o.fkImobiliarioUnidadeDependentes', 'd');
        $queryBuilder->leftJoin('e.fkImobiliarioUnidadeAutonomas', 'a');
        $queryBuilder->leftJoin('cc.fkImobiliarioCondominio', 'c');
        $queryBuilder->leftJoin('c.fkImobiliarioLoteCondominios', 'lc');
        $queryBuilder->leftJoin('lc.fkImobiliarioLote', 'l');
        $queryBuilder->leftJoin('l.fkImobiliarioLoteLocalizacao', 'll');

        $queryBuilder->where('(cc.codConstrucao is not null OR (cc.codConstrucao is null AND a.codConstrucao is null AND d.codConstrucaoDependente is null))');

        if ((array_key_exists("codConstrucao", $filter)) && ($filter['codConstrucao']['value'] != '')) {
            $queryBuilder->andWhere('o.codConstrucao = :codConstrucao');
            $queryBuilder->setParameter('codConstrucao', $filter['codConstrucao']['value']);
        }

        if ((array_key_exists("fkImobiliarioCondominio", $filter)) && ($filter['fkImobiliarioCondominio']['value'] != '')) {
            $queryBuilder->andWhere('c.codCondominio = :codCondominio');
            $queryBuilder->setParameter('codCondominio', $filter['fkImobiliarioCondominio']['value']);
        }

        if ((array_key_exists("codLote", $filter)) && ($filter['codLote']['value'] != '')) {
            $queryBuilder->andWhere('lpad(upper(ll.valor), 10, \'0\') = :valor');
            $queryBuilder->setParameter('valor', str_pad($filter['codLote']['value'], 10, '0', STR_PAD_LEFT));
        }

        if ((array_key_exists("codLocalizacao", $filter)) && ($filter['codLocalizacao']['value'] != '')) {
            $queryBuilder->andWhere('ll.codLocalizacao = :codLocalizacao');
            $queryBuilder->setParameter('codLocalizacao', $filter['codLocalizacao']['value']);
        }

        if ((array_key_exists("fkImobiliarioTipoEdificacao", $filter)) &&($filter['fkImobiliarioTipoEdificacao']['value'] != '')) {
            $queryBuilder->andWhere('e.codTipo = :codTipo');
            $queryBuilder->setParameter('codTipo', $filter['fkImobiliarioTipoEdificacao']['value']);
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codConstrucao', null, array('label' => 'label.codigo'))
            ->add('condominio', null, array('label' => 'label.imobiliarioConstrucao.condominio'))
            ->add('tipoEdificacao', null, array('label' => 'label.tipo'))
            ->add('area', null, array('label' => 'label.imobiliarioConstrucao.area'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Edificacao/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Edificacao/CRUD:list__action_delete.html.twig'),
                    'baixar' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Edificacao/CRUD:list__action_baixar.html.twig'),
                    'reforma' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Edificacao/CRUD:list__action_reforma.html.twig'),
                    'caracteristicas' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Edificacao/CRUD:list__action_caracteristicas.html.twig')
                ),
                'header_style' => 'width: 30%'
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $construcaoModel = new ConstrucaoModel($em);

        $dtAtual = new \DateTime();

        $fieldOptions = array();

        $fieldOptions['codConstrucao'] = [
            'mapped' => false
        ];

        $fieldOptions['fkImobiliarioCondominio'] = array(
            'label' => 'label.imobiliarioConstrucao.condominio',
            'class' => Condominio::class,
            'req_params' => [],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term) {
                $qb = $er->createQueryBuilder('o');
                $qb->where('o.codCondominio = :codCondominio');
                $qb->orWhere('LOWER(o.nomCondominio) LIKE :nomCondominio');
                $qb->setParameter('codCondominio', (int) $term);
                $qb->setParameter('nomCondominio', sprintf('%%%s%%', strtolower($term)));
                $qb->orderBy('o.codCondominio', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => false
        );

        $fieldOptions['fkImobiliarioTipoEdificacao'] = [
            'class' => TipoEdificacao::class,
            'label' => 'label.imobiliarioConstrucao.tipoEdificacao',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['dataConstrucao'] = [
            'label' => 'label.imobiliarioConstrucao.dataConstrucao',
            'format' => 'dd/MM/yyyy',
            'mapped' => false
        ];

        $fieldOptions['areaReal'] = [
            'label' => 'label.imobiliarioConstrucao.areaEdificacao',
            'mapped' => false,
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['fkSwClassificacao'] = array(
            'label' => 'label.imobiliarioImovel.classificacao',
            'class' => SwClassificacao::class,
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->orderBy('o.codClassificacao', 'ASC');
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkSwAssunto'] = array(
            'label' => 'label.imobiliarioImovel.assunto',
            'class' => SwAssunto::class,
            'choice_value' => 'codAssunto',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->orderBy('o.codAssunto', 'ASC');
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkSwProcesso'] = array(
            'label' => 'label.imobiliarioImovel.processo',
            'class' => SwProcesso::class,
            'req_params' => [
                'codClassificacao' => 'varJsCodClassificacao',
                'codAssunto' => 'varJsCodAssunto'
            ],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                $qb->innerJoin('o.fkAdministracaoUsuario', 'u');
                $qb->innerJoin('u.fkSwCgm', 'cgm');
                if ($request->get('codClassificacao') != '') {
                    $qb->andWhere('o.codClassificacao = :codClassificacao');
                    $qb->setParameter('codClassificacao', (int) $request->get('codClassificacao'));
                }
                if ($request->get('codAssunto') != '') {
                    $qb->andWhere('o.codAssunto = :codAssunto');
                    $qb->setParameter('codAssunto', (int) $request->get('codAssunto'));
                }
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->eq('o.codProcesso', ':codProcesso'),
                    $qb->expr()->eq('cgm.numcgm', ':numCgm'),
                    $qb->expr()->like('LOWER(cgm.nomCgm)', $qb->expr()->literal('%' . strtolower($term) . '%'))
                ));
                $qb->setParameter('numCgm', (int) $term);
                $qb->setParameter('codProcesso', (int) $term);
                $qb->orderBy('o.codProcesso', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => false,
        );

        if ($this->id($this->getSubject())) {
            /** @var Construcao $construcao */
            $construcao = $this->getSubject();

            $fieldOptions['codConstrucao']['data'] = $construcao->getCodConstrucao();

            $fieldOptions['fkImobiliarioCondominio']['disabled'] = true;
            $fieldOptions['fkImobiliarioCondominio']['data'] = ($construcao->getFkImobiliarioConstrucaoCondominios()->count()) ? $construcao->getFkImobiliarioConstrucaoCondominios()->current()->getFkImobiliarioCondominio() : null;

            $fieldOptions['fkImobiliarioTipoEdificacao']['disabled'] = true;
            $fieldOptions['fkImobiliarioTipoEdificacao']['data'] = $construcao->getFkImobiliarioConstrucaoEdificacoes()->current()->getFkImobiliarioTipoEdificacao();

            if ($construcao->getFkImobiliarioDataConstrucao()) {
                $fieldOptions['dataConstrucao']['data'] = $construcao->getFkImobiliarioDataConstrucao()->getDataConstrucao();
            }

            if ($construcao->getFkImobiliarioUnidadeDependentes()->count()) {
                $fieldOptions['areaReal']['data'] = number_format($construcao->getFkImobiliarioUnidadeDependentes()->current()->getFkImobiliarioAreaUnidadeDependentes()->current()->getArea(), 2, ',', '.');
            } else {
                $fieldOptions['areaReal']['data'] = number_format($construcao->getFkImobiliarioAreaConstrucoes()->current()->getAreaReal(), 2, ',', '.');
            }

            if ($construcao->getFkImobiliarioConstrucaoProcessos()->count()) {
                $fieldOptions['fkSwClassificacao']['disabled'] = true;
                $fieldOptions['fkSwClassificacao']['data'] = $construcao->getFkImobiliarioConstrucaoProcessos()->current()->getFkSwProcesso()->getFkSwAssunto()->getFkSwClassificacao();
                $fieldOptions['fkSwAssunto']['disabled'] = true;
                $fieldOptions['fkSwAssunto']['data'] = $construcao->getFkImobiliarioConstrucaoProcessos()->current()->getFkSwProcesso()->getFkSwAssunto();
                $fieldOptions['fkSwProcesso']['disabled'] = true;
                $fieldOptions['fkSwProcesso']['data'] = $construcao->getFkImobiliarioConstrucaoProcessos()->current()->getFkSwProcesso();
            }
        } else {
            $fieldOptions['dataConstrucao']['data'] = $dtAtual;
        }

        $formMapper->tab('label.imobiliarioConstrucao.modulo');
        $formMapper->with('label.imobiliarioConstrucao.dados');
        $formMapper->add('codConstrucao', 'hidden', $fieldOptions['codConstrucao']);
        $formMapper->add('fkImobiliarioCondominio', 'autocomplete', $fieldOptions['fkImobiliarioCondominio']);
        $formMapper->add('fkImobiliarioTipoEdificacao', 'entity', $fieldOptions['fkImobiliarioTipoEdificacao']);
        $formMapper->add('dataConstrucao', 'sonata_type_date_picker', $fieldOptions['dataConstrucao']);
        $formMapper->add('areaReal', 'text', $fieldOptions['areaReal']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioImovel.processo');
        $formMapper->add('fkSwClassificacao', 'entity', $fieldOptions['fkSwClassificacao']);
        $formMapper->add('fkSwAssunto', 'entity', $fieldOptions['fkSwAssunto']);
        $formMapper->add('fkSwProcesso', 'autocomplete', $fieldOptions['fkSwProcesso']);
        $formMapper->end();
        $formMapper->end();
        $formMapper->tab('label.imobiliarioConstrucao.caracteristicas');
        if ($this->id($this->getSubject())) {
            $atributosDinamicos = $construcaoModel->getNomAtributoValorByConstrucao($construcao);

            $fieldOptions['atributosDinamicos'] = array(
                'label' => false,
                'mapped' => false,
                'template' => 'TributarioBundle::Imobiliario/Lote/atributosDinamicos.html.twig',
                'data' => array(
                    'atributosDinamicos' => $atributosDinamicos
                )
            );

            $formMapper->with('label.imobiliarioLote.atributos');
            $formMapper->add('atributosDinamicos', 'customField', $fieldOptions['atributosDinamicos']);
            $formMapper->end();
        } else {
            $formMapper->with('label.imobiliarioLote.atributos', array('class' => 'atributoDinamicoWith'));
            $formMapper->add('atributosDinamicos', 'text', array('mapped' => false, 'required' => false));
            $formMapper->end();
        }
        $formMapper->end();
    }

    /**
     * @param Construcao $construcao
     */
    public function prePersist($construcao)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $construcaoModel = new ConstrucaoModel($em);

        $construcaoModel->popularConstrucaoCondominio($construcao, $this->getForm(), $this->request->request);
    }

    /**
     * @param Construcao $construcao
     */
    public function preUpdate($construcao)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $construcaoModel = new ConstrucaoModel($em);

        $construcaoModel->alterarConstrucaoCondominio($construcao, $this->getForm());
    }
}
