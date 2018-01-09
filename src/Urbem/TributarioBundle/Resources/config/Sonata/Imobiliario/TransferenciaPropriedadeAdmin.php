<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Entity\Imobiliario\Corretagem;
use Urbem\CoreBundle\Entity\Imobiliario\TransferenciaImovel;
use Urbem\CoreBundle\Entity\Imobiliario\TransferenciaAdquirente;
use Urbem\CoreBundle\Entity\Imobiliario\TransferenciaProcesso;
use Urbem\CoreBundle\Entity\Imobiliario\TransferenciaCorretagem;
use Urbem\CoreBundle\Entity\Imobiliario\TransferenciaEfetivacao;
use Urbem\CoreBundle\Entity\Imobiliario\TransferenciaDocumento;
use Urbem\CoreBundle\Entity\Imobiliario\TransferenciaCancelamento;
use Urbem\CoreBundle\Entity\Imobiliario\NaturezaTransferencia;
use Urbem\CoreBundle\Entity\Imobiliario\DocumentoNatureza;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Entity\SwCgm;

class TransferenciaPropriedadeAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_transferencia_propriedade';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/transferencia-propriedade';
    protected $includeJs = [
        '/tributario/javascripts/imobiliario/transferencia-propriedade.js',
        '/tributario/javascripts/imobiliario/processo.js'
    ];

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('inscricaoMunicipal', null, ['label' => 'label.imobiliarioTransferenciaPropriedade.inscricaoImobiliaria'])
            ->add(
                'fkImobiliarioTransferenciaAdquirentes.fkSwCgm',
                'doctrine_orm_model_autocomplete',
                [
                    'label' => 'label.imobiliarioTransferenciaPropriedade.adquirente'
                ],
                'sonata_type_model_autocomplete',
                [
                    'attr' => ['class' => 'select2-parameters '],
                    'callback' => function (AbstractSonataAdmin $admin, $property, $value) {
                        $datagrid = $admin->getDatagrid();

                        /** @var QueryBuilder|ProxyQueryInterface $query */
                        $query = $datagrid->getQuery();

                        $rootAlias = $query->getRootAlias();
                        $query->where("LOWER({$rootAlias}.nomCgm) LIKE :nomCgm");
                        $query->setParameter('nomCgm', sprintf('%%%s%%', strtolower($value)));

                        $datagrid->setValue($property, 'LIKE', $value);
                    },
                    'property' => 'nomCgm'
                ],
                [
                    'admin_code' => 'core.admin.filter.sw_cgm',
                ]
            )
        ;
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $qb = parent::createQuery($context);

        $qb->leftJoin(
            TransferenciaEfetivacao::class,
            'te',
            'WITH',
            sprintf('%s.codTransferencia = te.codTransferencia', $qb->getRootAlias())
        );
        $qb->andWhere('te.dtEfetivacao IS NULL');

        $qb->leftJoin(
            TransferenciaCancelamento::class,
            'tc',
            'WITH',
            sprintf('%s.codTransferencia = tc.codTransferencia', $qb->getRootAlias())
        );
        $qb->andWhere('tc.dtCancelamento IS NULL');

        return $qb;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codTransferencia', null, ['label' => 'label.codigo'])
            ->add('inscricaoMunicipal', null, ['label' => 'label.imobiliarioTransferenciaPropriedade.inscricaoImobiliaria'])
            ->add('fkImobiliarioNaturezaTransferencia', 'string', ['label' => 'label.imobiliarioTransferenciaPropriedade.naturezaTransferencia'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'efetivar' => array('template' => 'TributarioBundle:Sonata/Imobiliario/TransferenciaPropriedade/CRUD:list__action_efetivar.html.twig'),
                    'cancelar' => array('template' => 'TributarioBundle:Sonata/Imobiliario/TransferenciaPropriedade/CRUD:list__action_cancelar.html.twig')
                ),
                'header_style' => 'width: 20%'
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

        $em = $this->modelManager->getEntityManager($this->getClass());

        $transferenciaImovel = $this->getSubject();

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

        $fieldOptions['creci'] = [
            'class' => Corretagem::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->where('o.creci >= :creci');
                $qb->setParameter('creci', (int) $term);

                $qb->orderBy('o.creci', ' ASC');

                return $qb;
            },
            'json_choice_label' => function (Corretagem $corretagem) {
                if ($corretagem->getFkImobiliarioCorretor()) {
                    return sprintf('%d - %s', $corretagem->getCreci(), $corretagem->getFkImobiliarioCorretor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomCgm());
                }

                if ($corretagem->getFkImobiliarioImobiliaria()) {
                    return sprintf('%d - %s', $corretagem->getCreci(), $corretagem->getFkImobiliarioImobiliaria()->getFkSwCgmPessoaJuridica()->getFkSwCgm()->getNomCgm());
                }
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.imobiliarioImovel.creci',
        ];

        $fieldOptions['cgm'] = [
            'class' => SwCgm::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');
                $qb->where('LOWER(o.nomCgm) LIKE :nomCgm');
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));
                if ((int) $term) {
                    $qb->orWhere('o.numcgm = :numcgm');
                    $qb->setParameter('numcgm', (int) $term);
                }
                $qb->orderBy('o.nomCgm', ' ASC');
                return $qb;
            },
            'attr' => [
                'class' => 'select2-parameters js-cgm ',
            ],
            'label' => 'label.cgm',
            'required' => false,
        ];

        $fieldOptions['listaProprietarios'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Imobiliario/TransferenciaPropriedade/proprietarios.html.twig',
            'data' => [
                'proprietarios' => array(),
            ],
        ];

        $fieldOptions['listaAdquirentes'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Imobiliario/TransferenciaPropriedade/adquirentes.html.twig',
            'data' => [
                'adquirentes' => array(),
            ],
        ];

        $fieldOptions['fkImobiliarioImovel'] =  [
            'label' => 'label.imobiliarioImovel.inscricaoImobiliaria',
            'minimum_input_length' => 1,
            'class' => Imovel::class,
            'req_params' => [
                'codLocalizacao' => 'varJsCodLocalizacao',
                'codLote' => 'varJsCodLote'
            ],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                $qb->innerJoin('o.fkImobiliarioImovelConfrontacao', 'ic');
                if ($request->get('codLocalizacao') != '') {
                    $qb->innerJoin('ic.fkImobiliarioConfrontacaoTrecho', 't');
                    $qb->innerJoin('t.fkImobiliarioConfrontacao', 'c');
                    $qb->innerJoin('c.fkImobiliarioLote', 'l');
                    $qb->innerJoin('l.fkImobiliarioLoteLocalizacao', 'll');
                    $qb->andWhere('ll.codLocalizacao = :codLocalizacao');
                    $qb->setParameter('codLocalizacao', $request->get('codLocalizacao'));
                }
                if ($request->get('codLote') != '') {
                    $qb->andWhere('ic.codLote = :codLote');
                    $qb->setParameter('codLote', $request->get('codLote'));
                }
                $qb->andWhere('o.inscricaoMunicipal = :inscricaoMunicipal');
                $qb->setParameter('inscricaoMunicipal', $term);
                $qb->orderBy('o.inscricaoMunicipal', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => true,
        ];

        $fieldOptions['fkImobiliarioNaturezaTransferencia'] = [
            'label' => 'label.imobiliarioTransferenciaPropriedade.naturezaTransferencia',
            'class' => NaturezaTransferencia::class,
            'required' => true,
            'placeholder' => 'label.selecione',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->orderBy('o.descricao');
            },
            'attr' => ['class' => 'select2-parameters']
        ];

        $fieldOptions['fkImobiliarioLocalizacao'] = [
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
            'required' => false
        ];

        $fieldOptions['fkImobiliarioLote'] = [
            'label' => 'label.imobiliarioTransferenciaPropriedade.numeroLote',
            'minimum_input_length' => 1,
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
                $qb->leftJoin('o.fkImobiliarioLoteLocalizacao', 'll');
                $qb->andWhere('lpad(upper(ll.valor), 10, \'0\') = :valor');
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
                $qb->orderBy('o.codLote', 'ASC');
                return $qb;
            },
            'attr' => [
                'class' => 'select2-parameters js-imovel-lote ',
            ],
            'required' => false,
            'mapped' => false
        ];

        $loteSelected = false;

        if ($id) {
            $fieldOptions['listaAdquirentes']['data']['adquirentes'] = $transferenciaImovel->getFkImobiliarioTransferenciaAdquirentes();

            if ($this->getSubject()->getFkImobiliarioTransferenciaCorretagem()) {
                $creci = $this->getSubject()->getFkImobiliarioTransferenciaCorretagem()->getFkImobiliarioCorretagem();
                $fieldOptions['creci']['data'] = $creci;
            }

            /** @var Imovel $imovel */
            $imovel = $this->getSubject()->getFkImobiliarioImovel();
            $fieldOptions['fkImobiliarioImovel']['data'] = $imovel;
            $fieldOptions['fkImobiliarioImovel']['disabled'] = true;

            $fieldOptions['fkImobiliarioLote']['data'] = $imovel->getLote();
            $fieldOptions['fkImobiliarioLote']['disabled'] = true;

            $fieldOptions['fkImobiliarioLocalizacao']['data'] = $imovel->getLocalizacao();
            $fieldOptions['fkImobiliarioLocalizacao']['disabled'] = true;


            if ($this->getSubject()->getFkImobiliarioTransferenciaProcesso()) {
                /** @var SwProcesso $processo */
                $processo = $this->getSubject()->getFkImobiliarioTransferenciaProcesso()->getFkSwProcesso();
                $fieldOptions['fkSwProcesso']['data'] = $processo;
                $fieldOptions['fkSwClassificacao']['data'] = $processo->getFkSwAssunto()->getFkSwClassificacao();
                $fieldOptions['fkSwAssunto']['data'] = $processo->getFkSwAssunto();
            }

            if ($this->getSubject()->getFkImobiliarioNaturezaTransferencia()) {
                $fieldOptions['fkImobiliarioNaturezaTransferencia']['data'] = $this->getSubject()->getFkImobiliarioNaturezaTransferencia();
                $fieldOptions['fkImobiliarioNaturezaTransferencia']['disabled'] = true;
            }
        }

        $formMapper
            ->with('label.imobiliarioTransferenciaPropriedade.dados')
                ->add(
                    'fkImobiliarioLocalizacao',
                    'autocomplete',
                    $fieldOptions['fkImobiliarioLocalizacao']
                )
                ->add(
                    'fkImobiliarioImovel.fkImobiliarioImovelLotes',
                    'autocomplete',
                    $fieldOptions['fkImobiliarioLote'],
                    [
                        'admin_code' => 'tributario.admin.lote'
                    ]
                )
                ->add(
                    'fkImobiliarioImovel',
                    'autocomplete',
                    $fieldOptions['fkImobiliarioImovel'],
                    [
                        'admin_code' => 'tributario.admin.imovel'
                    ]
                )
                ->add(
                    'fkImobiliarioNaturezaTransferencia',
                    'entity',
                    $fieldOptions['fkImobiliarioNaturezaTransferencia']
                )
                ->add(
                    'creci',
                    'autocomplete',
                    $fieldOptions['creci']
                )
            ->end()
            ->with('label.imobiliarioTransferenciaPropriedade.processo')
                ->add(
                    'fkSwClassificacao',
                    'entity',
                    $fieldOptions['fkSwClassificacao']
                )
                ->add(
                    'fkSwAssunto',
                    'entity',
                    $fieldOptions['fkSwAssunto']
                )
                ->add(
                    'fkSwProcesso',
                    'autocomplete',
                    $fieldOptions['fkSwProcesso'],
                    [
                        'admin_code' => 'administrativo.admin.processo'
                    ]
                )
            ->add('listaProprietarios', 'customField', $fieldOptions['listaProprietarios'])
            ->end()
            ->with('label.imobiliarioTransferenciaPropriedade.dadosAdquirentes')
                ->add('cgm', 'autocomplete', $fieldOptions['cgm'])
                ->add(
                    'cota',
                    'percent',
                    [
                        'label' => 'label.imobiliarioTransferenciaPropriedade.quota',
                        'mapped' => false,
                        'attr' => ['class' => 'cota '],
                        'required' => false,
                    ]
                )
                ->add('listaAdquirentes', 'customField', $fieldOptions['listaAdquirentes'])
            ->end()
        ;
    }

    /**
     * @param TransferenciaImovel $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $object->setFkImobiliarioImovel($this->getForm()->get('fkImobiliarioImovel')->getData());
        $em->persist($object);

        $this->persistAdquirentes($object);
        $this->persistProcesso($object);
        $this->persistCorretagem($object);
        $this->persistDocumentos($object);
    }

    /**
     * @param TransferenciaImovel $object
     */
    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $this->persistAdquirentes($object);
        $this->persistProcesso($object);
        $this->persistCorretagem($object);
        $this->persistDocumentos($object);
    }

    /**
     * @param TransferenciaImovel $object
     */
    protected function persistCorretagem($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $codTransferencia = $object->getCodTransferencia();
        $creci = $this->getForm()->get('creci')->getData();

        if (!$codTransferencia || !$creci) {
            return;
        }

        $transferenciaCorretagem = $this->modelManager->getEntityManager($this->getClass())->getRepository(TransferenciaCorretagem::class)->findOneBy(
            [
                'codTransferencia' => $codTransferencia
            ]
        );

        $transferenciaCorretagem = $transferenciaCorretagem ?: new TransferenciaCorretagem();
        $transferenciaCorretagem->setCodTransferencia($codTransferencia);
        $transferenciaCorretagem->setCreci($creci);

        $object->setFkImobiliarioTransferenciaCorretagem($transferenciaCorretagem);
    }

    /**
     * @param TransferenciaImovel $object
     */
    protected function persistProcesso($object)
    {
        $codTransferencia = $object->getCodTransferencia();
        $processo = $this->getForm()->get('fkSwProcesso')->getData();

        if (!$codTransferencia || !$processo) {
            return;
        }

        $transferenciaProcesso = $this->modelManager->getEntityManager($this->getClass())
            ->getRepository(TransferenciaProcesso::class)
            ->findOneBy(
                [
                    'codTransferencia' => $codTransferencia
                ]
            );

        $transferenciaProcesso = $transferenciaProcesso ?: new TransferenciaProcesso();
        $transferenciaProcesso->setCodTransferencia($codTransferencia);
        $transferenciaProcesso->setFkSwProcesso($processo);

        $object->setFkImobiliarioTransferenciaProcesso($transferenciaProcesso);
    }

    /**
     * @param TransferenciaImovel $object
     */
    protected function persistAdquirentes(TransferenciaImovel $object)
    {
        /** @var EntityRepository $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        // Remove all
        foreach ($object->getFkImobiliarioTransferenciaAdquirentes() as $transferenciaAdquirente) {
            $em->remove($transferenciaAdquirente);
        }
        $em->flush();

        $adquirentes = $this->getRequest()->get('adquirente');
        $quotas = $this->getRequest()->get('adquirente_quotas');

        $ordem = 1;
        foreach ($adquirentes as $key => $adquirente) {
            if ($adquirente != '') {
                /** @var SwCgm $swCgm */
                $swCgm = $em->getRepository(SwCgm::class)->find($adquirente);

                $transferenciaAdquirente = new TransferenciaAdquirente();
                $transferenciaAdquirente->setFkSwCgm($swCgm);
                $transferenciaAdquirente->setOrdem($ordem);
                $transferenciaAdquirente->setCota($quotas[$key]);
                $object->addFkImobiliarioTransferenciaAdquirentes($transferenciaAdquirente);
                $ordem++;
            }
        }
    }

    /**
     * @param TransferenciaImovel $object
     */
    protected function persistDocumentos(TransferenciaImovel $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $documentoNatureza = $this->modelManager->getEntityManager($this->getClass())->getRepository(DocumentoNatureza::class)->findBy(
            [
                'codNatureza' => (int) $object->getCodNatureza()
            ]
        );

        $transferenciaDocumentos = [];
        foreach ((array) $documentoNatureza as $documento) {
            $transferenciaDocumento = new TransferenciaDocumento();
            $transferenciaDocumento->setCodTransferencia($object->getCodTransferencia());
            $transferenciaDocumento->setCodDocumento($documento->getCodDocumento());

            $transferenciaDocumentos[] = $transferenciaDocumento;
        }

        // Remove all
        foreach ($object->getFkImobiliarioTransferenciaDocumentos() as $transferenciaDocumento) {
            $em->remove($transferenciaDocumento);
        }
        $em->flush();

        // Add again
        foreach ($transferenciaDocumentos as $documento) {
            $object->addFkImobiliarioTransferenciaDocumentos($documento);
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $this->adquirentesArray = [];
        if ($adquirentes = $this->getSubject()->getFkImobiliarioTransferenciaAdquirentes()) {
            foreach ($adquirentes as $key => $adquirente) {
                $this->adquirentesArray[$key]['nomCgm'] = $adquirente->getNumCgm() . ' - ' . $adquirente->getFkSwCgm()->getNomCgm();
                $this->adquirentesArray[$key]['cota'] = $adquirente->getCota() . '%';
            }
        }

        $showMapper
            ->with('label.imobiliarioTransferenciaPropriedade.modulo')
                ->add('codTransferencia', null, ['label' =>'label.codigo'])
                ->add('fkImobiliarioNaturezaTransferencia.descricao', null, ['label' => 'label.imobiliarioTransferenciaPropriedade.naturezaTransferencia'])
                ->add('inscricaoMunicipal', null, ['label' => 'label.imobiliarioTransferenciaPropriedade.inscricaoImobiliaria'])
                ->add(
                    'fkImobiliarioTransferenciaProcesso',
                    null,
                    [
                        'label' => 'label.imobiliarioTransferenciaPropriedade.processo',
                        'mapped' => false,
                    ]
                )
                ->add('fkImobiliarioTransferenciaCorretagem.creci', null, ['label' => 'label.imobiliarioTransferenciaPropriedade.creci'])
                ->add('dtCadastro', null, ['label' => 'label.imobiliarioTransferenciaPropriedade.dtCadastro'])
            ->end()
            ->with('label.imobiliarioTransferenciaPropriedade.listaAdquirentes')
                ->add(
                    'codAtributo',
                    'customField',
                    [
                        'label' => 'label.atributos',
                        'template' => 'TributarioBundle::Imobiliario/TransferenciaPropriedade/adquirentes_show.html.twig',
                    ]
                )
            ->end()
        ;
    }

    /**
     *  @param  RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('efetivar', $this->getRouterIdParameter() . '/efetivar');
        $collection->add('efetivar_salvar', 'efetivar-salvar');
        $collection->add('cancelar', $this->getRouterIdParameter() . '/cancelar');
        $collection->add('cancelar_transferencia', 'cancelar-transferencia');
        $collection->add('assunto', 'assunto');
        $collection->add('consulta_proprietarios', 'consulta-proprietarios');
        $collection->add('consulta_adquirente', 'consulta-adquirente');
        $collection->add('consulta_imovel', 'consulta-imovel');
    }

    /**
    * @param mixed $object
    * @return string
    */
    public function toString($object)
    {
        return ($object->getCodTransferencia())
            ? (string) $object
            : $this->getTranslator()->trans('label.imobiliarioTransferenciaPropriedade.modulo');
    }
}
