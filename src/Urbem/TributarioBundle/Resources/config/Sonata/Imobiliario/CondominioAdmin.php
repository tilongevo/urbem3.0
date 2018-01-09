<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Imobiliario\Condominio;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Model\Imobiliario\CondominioModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CondominioAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_condominio';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/condominio';
    protected $includeJs = array(
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/tributario/javascripts/imobiliario/processo.js',
        '/tributario/javascripts/imobiliario/condominio.js'
    );

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consultar_lote_condominio', 'consultar-lote-condominio');
        $collection->add('autocomplete_condominio', 'autocomplete-condominio');
    }

    /**
     * @return bool
     */
    public function verificaCaracteristicas()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new CondominioModel($em))->verificaCaracteristicas();
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codCondominio', null, ['label' => 'label.codigo'])
            ->add('nomCondominio', null, ['label' => 'label.nome'])
            ->add('fkImobiliarioTipoCondominio', null, ['label' => 'label.tipo'])
            ->add(
                'fkImobiliarioCondominioCgns.fkSwCgmPessoaJuridica',
                'doctrine_orm_model_autocomplete',
                [
                    'label' => 'label.cgm',
                ],
                'sonata_type_model_autocomplete',
                [
                    'attr' => ['class' => 'select2-parameters '],
                    'callback' => function (AbstractAdmin $admin, $property, $value) {
                        $datagrid = $admin->getDatagrid();

                        /** @var QueryBuilder|ProxyQueryInterface $qb */
                        $qb = $datagrid->getQuery();

                        $qb->join("{$qb->getRootAlias()}.fkSwCgm", 'cgm');
                        $qb->andWhere($qb->expr()->orX(
                            $qb->expr()->eq("{$qb->getRootAlias()}.numcgm", ':numcgm'),
                            $qb->expr()->like("LOWER({$qb->getRootAlias()}.nomFantasia)", ':parameter'),
                            $qb->expr()->like("{$qb->getRootAlias()}.cnpj", ':parameter'),
                            $qb->expr()->like("LOWER(cgm.nomCgm)", ':parameter')
                        ));
                        $qb->setParameter('parameter', sprintf('%%%s%%', strtolower($value)));
                        $qb->setParameter('numcgm', (integer) $value);

                        $datagrid->setValue($property, 'LIKE', $value);
                    },
                    'property' => 'fkSwCgm.nomCgm'
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
            ->add('codCondominio', null, ['label' => 'label.codigo'])
            ->add('nomCondominio', null, ['label' => 'label.nome'])
            ->add('fkImobiliarioTipoCondominio.nomTipo', null, ['label' => 'label.tipo'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                    'reforma' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Condominio/CRUD:list__action_reforma.html.twig'),
                    'caracteristicas' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Condominio/CRUD:list__action_caracteristicas.html.twig')
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

        $fieldOptions = [];

        $fieldOptions['codCondominio'] = [
            'mapped' => false
        ];

        $fieldOptions['fkImobiliarioTipoCondominio'] = [
            'label' => 'label.tipo',
            'required' => true,
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $fieldOptions['fkSwCgmPessoaJuridica'] = array(
            'label' => 'label.cgm',
            'class' => SwCgmPessoaJuridica::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term) {
                $qb = $er->createQueryBuilder('o');

                $qb->join('o.fkSwCgm', 'cgm');
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->eq('o.numcgm', ':numcgm'),
                    $qb->expr()->like('LOWER(o.nomFantasia)', ':parameter'),
                    $qb->expr()->like('o.cnpj', ':parameter'),
                    $qb->expr()->like('LOWER(cgm.nomCgm)', ':parameter')
                ));
                $qb->setParameter('parameter', sprintf('%%%s%%', strtolower($term)));
                $qb->setParameter('numcgm', (integer) $term);
                $qb->orderBy('cgm.nomCgm', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => false,
        );

        $fieldOptions['areaTotalComum'] = [
            'label' => 'label.imobiliarioCondominio.areaTotalComum',
            'mapped' => false,
            'required' => true,
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['fkSwClassificacao'] = array(
            'label' => 'label.imobiliarioCondominio.classificacao',
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
            'label' => 'label.imobiliarioCondominio.assunto',
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
            'label' => 'label.imobiliarioCondominio.processo',
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

        $fieldOptions['fkImobiliarioLocalizacao'] = array(
            'label' => 'label.imobiliarioCondominio.localizacao',
            'class' => Localizacao::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term) {
                $qb = $er->createQueryBuilder('o');
                $qb->andWhere('o.codigoComposto LIKE :codigoComposto');
                $qb->setParameter('codigoComposto', sprintf('%%%s%%', strtolower($term)));
                $qb->orderBy('o.codLocalizacao', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => false,
        );

        $fieldOptions['fkImobiliarioLote'] = array(
            'label' => 'label.imobiliarioCondominio.lote',
            'class' => Lote::class,
            'req_params' => [
                'codLocalizacao' => 'varJsCodLocalizacao'
            ],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                $qb->innerJoin('o.fkImobiliarioLoteLocalizacao', 'l');
                if ($request->get('codLocalizacao') != '') {
                    $qb->andWhere('l.codLocalizacao = :codLocalizacao');
                    $qb->setParameter('codLocalizacao', $request->get('codLocalizacao'));
                }
                $qb->andWhere('lpad(upper(l.valor), 10, \'0\') = :valor');
                $qb->setParameter('valor', str_pad($term, 10, '0', STR_PAD_LEFT));
                // Parcelado
                $qb->leftJoin('o.fkImobiliarioLoteParcelados', 'p');
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->isNull('p.validado'),
                    $qb->expr()->eq('p.validado', 'true')
                ));
                // Baixa
                $qb->leftJoin('o.fkImobiliarioBaixaLotes', 'b');
                $qb->andWhere('b.dtInicio is not null AND b.dtTermino is not null OR b.dtInicio is null');
                // Imóvel
                $qb->leftJoin('o.fkImobiliarioImovelLotes', 'i');
                $qb->andWhere('i.inscricaoMunicipal is not null');
                $qb->orderBy('o.codLote', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => false,
        );

        $fieldOptions['listaLotes'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Imobiliario/Condominio/lotes.html.twig',
            'attr' => array(
                'style' => 'display:none;'
            ),
            'data' => array(
                'lotes' => array()
            )
        );

        if ($this->id($this->getSubject())) {
            /** @var Condominio $condominio */
            $condominio = $this->getSubject();

            $fieldOptions['codCondominio']['data'] = $condominio->getCodCondominio();
            $fieldOptions['fkSwCgmPessoaJuridica']['data'] = $condominio->getFkImobiliarioCondominioCgns()->last()->getFkSwCgmPessoaJuridica();
            $fieldOptions['areaTotalComum']['data'] = number_format($condominio->getFkImobiliarioCondominioAreaComuns()->last()->getAreaTotalComum(), 2, ',', '.');
            if ($condominio->getFkImobiliarioCondominioProcessos()->count()) {
                $fieldOptions['fkSwClassificacao']['data'] = $condominio->getFkImobiliarioCondominioProcessos()->last()->getFkSwProcesso()->getFkSwAssunto()->getFkSwClassificacao();
                $fieldOptions['fkSwAssunto']['data'] = $condominio->getFkImobiliarioCondominioProcessos()->last()->getFkSwProcesso()->getFkSwAssunto();
                $fieldOptions['fkSwProcesso']['data'] = $condominio->getFkImobiliarioCondominioProcessos()->last()->getFkSwProcesso();
            }

            $fieldOptions['listaLotes']['data'] = [
                'lotes' => $condominio->getFkImobiliarioLoteCondominios()
            ];
        }

        $formMapper->with('label.imobiliarioCondominio.dados');
        $formMapper->add('codCondominio', 'hidden', $fieldOptions['codCondominio']);
        $formMapper->add('nomCondominio', null, ['label' => 'label.nome']);
        $formMapper->add('fkImobiliarioTipoCondominio', null, $fieldOptions['fkImobiliarioTipoCondominio']);
        $formMapper->add('fkSwCgmPessoaJuridica', 'autocomplete', $fieldOptions['fkSwCgmPessoaJuridica']);
        $formMapper->add('areaTotalComum', 'text', $fieldOptions['areaTotalComum']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioCondominio.processo');
        $formMapper->add('fkSwClassificacao', 'entity', $fieldOptions['fkSwClassificacao']);
        $formMapper->add('fkSwAssunto', 'entity', $fieldOptions['fkSwAssunto']);
        $formMapper->add('fkSwProcesso', 'autocomplete', $fieldOptions['fkSwProcesso']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioLote.atributos', array('class' => 'atributoDinamicoWith'));
        $formMapper->add('atributosDinamicos', 'text', array('mapped' => false, 'required' => false));
        $formMapper->end();
        $formMapper->with('label.imobiliarioCondominio.lotes');
        $formMapper->add('fkImobiliarioLocalizacao', 'autocomplete', $fieldOptions['fkImobiliarioLocalizacao']);
        $formMapper->add('fkImobiliarioLote', 'autocomplete', $fieldOptions['fkImobiliarioLote']);
        $formMapper->add('listaLotes', 'customField', $fieldOptions['listaLotes']);
        $formMapper->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $em = $this->modelManager->getEntityManager($this->getClass());
        $atributosDinamicos = (new CondominioModel($em))->getNomAtributoValorByCondominio($this->getSubject());

        $showMapper
            ->with('label.imobiliarioCondominio.dados')
            ->add('codCondominio', null, ['label' => 'label.codigo'])
            ->add('nomCondominio', null, ['label' => 'label.nome'])
            ->add('fkImobiliarioTipoCondominio.nomTipo', null, ['label' => 'label.tipo'])
            ->add('fkImobiliarioCondominioCgns', 'collection', ['label' => 'label.cgm'])
            ->add('fkImobiliarioCondominioAreaComuns', 'collection', ['label' => 'label.imobiliarioCondominio.areaTotalComum'])
            ->add('fkImobiliarioCondominioProcessos', 'collection', ['label' => 'label.imobiliarioCondominio.processo'])
            ->add('atributos', 'customField', [
                'label' => 'label.imobiliarioCondominio.atributos',
                'template' => 'TributarioBundle:Sonata/Imobiliario/Lote/CRUD:custom_show_atributos.html.twig',
                'data' => $atributosDinamicos
            ])
            ->add('fkImobiliarioLoteCondominios', 'collection', ['label' => 'label.imobiliarioCondominio.listaLotes'])
            ->end()
        ;
    }

    /**
     * @param Condominio $condominio
     */
    public function prePersist($condominio)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        (new CondominioModel($em))->popularCondominio($condominio, $this->getForm(), $this->request->request);
    }

    /**
     * @param Condominio $condominio
     */
    public function preUpdate($condominio)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        (new CondominioModel($em))->popularAlteracaoCondominio($condominio, $this->getForm(), $this->request->request);
    }
}
