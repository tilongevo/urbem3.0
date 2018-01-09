<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\Loteamento;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Model\Imobiliario\LoteamentoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class LoteamentoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_loteamento';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/loteamento';
    protected $includeJs = array(
        '/tributario/javascripts/imobiliario/processo.js',
        '/tributario/javascripts/imobiliario/loteamento.js'
    );

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('lote_disponivel', 'lote-disponivel');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codLoteamento', null, ['label' => 'label.imobiliarioLoteamento.codLoteamento'])
            ->add('nomLoteamento', null, ['label' => 'label.imobiliarioLoteamento.nomLoteamento'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codLoteamento', null, ['label' => 'label.imobiliarioLoteamento.codLoteamento'])
            ->add('nomLoteamento', null, ['label' => 'label.imobiliarioLoteamento.nomLoteamento'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                )
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

        $fieldOptions = array();

        $fieldOptions['codLoteamento'] = [
            'data' => '',
            'mapped' => false
        ];

        $fieldOptions['localizacao'] = [
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
            'required' => true,
        ];

        $fieldOptions['lote'] = [
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
            'required' => true,
        ];

        $fieldOptions['dtAprovacao'] = [
            'label' => 'label.imobiliarioLoteamento.dtAprovacao',
            'format' => 'dd/MM/yyyy',
            'mapped' => false
        ];

        $fieldOptions['dtLiberacao'] = [
            'label' => 'label.imobiliarioLoteamento.dtLiberacao',
            'format' => 'dd/MM/yyyy',
            'mapped' => false
        ];

        $fieldOptions['areaComunitaria'] = [
            'label' => 'label.imobiliarioLoteamento.areaComunitaria'
        ];

        $fieldOptions['areaComunitaria'] = [
            'label' => 'label.imobiliarioLoteamento.areaComunitaria',
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['areaLogradouro'] = [
            'label' => 'label.imobiliarioLoteamento.areaLogradouro',
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['fkSwClassificacao'] = array(
            'label' => 'label.imobiliarioLoteamento.classificacao',
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
            'label' => 'label.imobiliarioLoteamento.assunto',
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
            'label' => 'label.imobiliarioLoteamento.processo',
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

        $fieldOptions['loteLoteamento_localizacao'] = [
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
            'required' => true,
        ];

        $fieldOptions['loteLoteamento_lote'] = [
            'label' => 'label.imobiliarioCondominio.lote',
            'class' => Lote::class,
            'req_params' => [
                'codLocalizacao' => 'varJsLoteLoteamentoCodLocalizacao',
                'codLote' => 'varJsCodLote'
            ],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                $qb->innerJoin('o.fkImobiliarioLoteLocalizacao', 'l');
                if ($request->get('codLocalizacao') != '') {
                    $qb->andWhere('l.codLocalizacao = :codLocalizacao');
                    $qb->setParameter('codLocalizacao', $request->get('codLocalizacao'));
                }
                if ($request->get('codLote') != '') {
                    $qb->andWhere('l.codLote != :codLote');
                    $qb->setParameter('codLote', $request->get('codLote'));
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
            'required' => true,
        ];

        $fieldOptions['loteLoteamento_caucionado'] = [
            'label' => 'label.imobiliarioLoteamento.caucionado',
            'choices' => [
                'label_type_yes' => true,
                'label_type_no' => false
            ],
            'data' => false,
            'mapped' => false
        ];

        $fieldOptions['loteLoteamento_lista'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Imobiliario/Loteamento/loteLoteamentos.html.twig',
            'attr' => array(
                'style' => 'display:none;'
            ),
            'data' => array(
                'loteLoteamentos' => array()
            )
        );

        if ($this->id($this->getSubject())) {
            /** @var Loteamento $loteamento */
            $loteamento = $this->getSubject();

            $fieldOptions['codLoteamento']['data'] = $loteamento->getCodLoteamento();

            $fieldOptions['localizacao']['data'] = $loteamento->getFkImobiliarioLoteamentoLoteOrigens()->current()->getFkImobiliarioLote()->getFkImobiliarioLoteLocalizacao()->getFkImobiliarioLocalizacao();
            $fieldOptions['loteLoteamento_localizacao']['data'] = $loteamento->getFkImobiliarioLoteamentoLoteOrigens()->current()->getFkImobiliarioLote()->getFkImobiliarioLoteLocalizacao()->getFkImobiliarioLocalizacao();
            $fieldOptions['localizacao']['disabled'] = true;

            $fieldOptions['lote']['data'] = $loteamento->getFkImobiliarioLoteamentoLoteOrigens()->current()->getFkImobiliarioLote();
            $fieldOptions['lote']['disabled'] = true;

            $fieldOptions['dtAprovacao']['data'] = $loteamento->getFkImobiliarioLoteamentoLoteOrigens()->current()->getDtAprovacao();
            $fieldOptions['dtLiberacao']['data'] = $loteamento->getFkImobiliarioLoteamentoLoteOrigens()->current()->getDtLiberacao();

            if ($loteamento->getFkImobiliarioProcessoLoteamentos()->count()) {
                $fieldOptions['fkSwClassificacao']['data'] = $loteamento->getFkImobiliarioProcessoLoteamentos()->current()->getFkSwProcesso()->getFkSwAssunto()->getFkSwClassificacao();
                $fieldOptions['fkSwClassificacao']['disabled'] = true;
                $fieldOptions['fkSwAssunto']['data'] = $loteamento->getFkImobiliarioProcessoLoteamentos()->current()->getFkSwProcesso()->getFkSwAssunto();
                $fieldOptions['fkSwAssunto']['disabled'] = true;
                $fieldOptions['fkSwProcesso']['data'] = $loteamento->getFkImobiliarioProcessoLoteamentos()->current()->getFkSwProcesso();
                $fieldOptions['fkSwProcesso']['disabled'] = true;
            }

            $fieldOptions['loteLoteamento_lista']['data'] = ['loteLoteamentos' => $loteamento->getFkImobiliarioLoteLoteamentos()];
        }

        $formMapper
            ->with('label.imobiliarioLoteamento.dados')
            ->add('codLoteamento', 'hidden', $fieldOptions['codLoteamento'])
            ->add('nomLoteamento', null, ['label' => 'label.imobiliarioLoteamento.nomLoteamento'])
            ->add('localizacao', 'autocomplete', $fieldOptions['localizacao'])
            ->add('lote', 'autocomplete', $fieldOptions['lote'])
            ->add('loteamentoLoteOrigen_dtAprovacao', 'sonata_type_date_picker', $fieldOptions['dtAprovacao'])
            ->add('loteamentoLoteOrigen_dtLiberacao', 'sonata_type_date_picker', $fieldOptions['dtLiberacao'])
            ->add('areaComunitaria', null, $fieldOptions['areaComunitaria'])
            ->add('areaLogradouro', null, $fieldOptions['areaLogradouro'])
            ->end()
            ->with('label.imobiliarioLoteamento.processo')
            ->add('fkSwClassificacao', 'entity', $fieldOptions['fkSwClassificacao'])
            ->add('fkSwAssunto', 'entity', $fieldOptions['fkSwAssunto'])
            ->add('fkSwProcesso', 'autocomplete', $fieldOptions['fkSwProcesso'])
            ->end()
            ->with('label.imobiliarioLoteamento.lotes')
            ->add('loteLoteamento_localizacao', 'autocomplete', $fieldOptions['loteLoteamento_localizacao'])
            ->add('loteLoteamento_lote', 'autocomplete', $fieldOptions['loteLoteamento_lote'])
            ->add('loteLoteamento_caucionado', 'choice', $fieldOptions['loteLoteamento_caucionado'])
            ->add('loteLoteamento_lista', 'customField', $fieldOptions['loteLoteamento_lista'])
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
            ->with('label.imobiliarioLoteamento.modulo')
            ->add('codLoteamento', 'text', ['label' => 'label.imobiliarioLoteamento.codLoteamento'])
            ->add('nomLoteamento', 'text', ['label' => 'label.imobiliarioLoteamento.nomLoteamento'])
            ->add('localizacao', 'text', ['label' => 'label.imobiliarioLoteamento.localizacao'])
            ->add('lote', 'text', ['label' => 'label.imobiliarioLoteamento.lote'])
            ->add('dtAprovacao', 'date', ['label' => 'label.imobiliarioLoteamento.dtAprovacao'])
            ->add('dtLiberacao', 'date', ['label' => 'label.imobiliarioLoteamento.dtLiberacao'])
            ->add('areaComunitaria', 'decimal', ['label' => 'label.imobiliarioLoteamento.areaComunitaria'])
            ->add('areaLogradouro', 'decimal', ['label' => 'label.imobiliarioLoteamento.areaLogradouro'])
            ->add('fkImobiliarioProcessoLoteamentos', 'collection', array('label' => 'label.imobiliarioLoteamento.processo'))
            ->add('fkImobiliarioLoteLoteamentos', 'collection', array('label' => 'label.imobiliarioLoteamento.lotes'))
            ->end()
        ;
    }

    /**
     * @param Loteamento $loteamento
     */
    public function prePersist($loteamento)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        (new LoteamentoModel($em))->popularLoteamento($loteamento, $this->getForm(), $this->request->request);
    }

    /**
     * @param Loteamento $loteamento
     */
    public function preUpdate($loteamento)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        (new LoteamentoModel($em))->alterarLoteamento($loteamento, $this->getForm(), $this->request->request);
    }
}
