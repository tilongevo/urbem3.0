<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Imobiliario\Corretagem;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelCorrespondencia;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwBairro;
use Urbem\CoreBundle\Entity\SwCepLogradouro;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwLogradouro;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Imobiliario\ImovelModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ImovelAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_imovel';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/imovel';
    protected $includeJs = array(
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/tributario/javascripts/imobiliario/processo.js',
        '/tributario/javascripts/imobiliario/proprietarios.js',
        '/tributario/javascripts/imobiliario/imovel.js'
    );

    const NAO_INFORMADO = 0;

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consultar_lote_bairro', 'consultar-lote-bairro');
        $collection->add('consultar_lote_endereco', 'consultar-lote-endereco');
        $collection->add('consultar_lote_cep', 'consultar-lote-cep');
        $collection->add('consultar_logradouro_cep', 'consultar-logradouro-cep');
    }

    /**
     * @param Imovel $imovel
     * @return boolean
     */
    public function verificaBaixa(Imovel $imovel)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new ImovelModel($em))->verificaBaixa($imovel);
    }

    /**
     * @return bool
     */
    public function verificaCaracteristicas()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new ImovelModel($em))->verificaCaracteristicas();
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $choices = array(
            Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO => 'label.imobiliarioLote.urbano.modulo',
            Cadastro::CADASTRO_TRIBUTARIO_LOTE_RURAL => 'label.imobiliarioLote.rural.modulo'
        );

        $datagridMapper
            ->add(
                'inscricaoMunicipal',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.imobiliarioImovel.numInscricao',
                    'callback' => array($this, 'getSearchFilter')
                )
            )
            ->add(
                'numLote',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.imobiliarioImovel.numLote',
                    'callback' => array($this, 'getSearchFilter')
                )
            )
            ->add(
                'tipoLote',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.imobiliarioImovel.tipoLote',
                    'callback' => array($this, 'getSearchFilter')
                ),
                'choice',
                array(
                    'choices' => array_flip($choices)
                )
            )
            ->add(
                'fkImobiliarioImovelLotes.fkImobiliarioLote.fkImobiliarioLoteLocalizacao.fkImobiliarioLocalizacao',
                null,
                array(
                    'label' => 'label.imobiliarioImovel.localizacao'
                )
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

        if (!count($value['value'])) {
            return;
        }

        $queryBuilder->resetDQLPart('join');

        if ($filter['inscricaoMunicipal']['value'] != '') {
            $queryBuilder->where('o.inscricaoMunicipal = :inscricaoMunicipal');
            $queryBuilder->setParameter('inscricaoMunicipal', $filter['inscricaoMunicipal']['value']);
        }

        $queryBuilder->leftJoin('o.fkImobiliarioImovelLotes', 'il');
        $queryBuilder->leftJoin('il.fkImobiliarioLote', 'l');

        if ($filter['tipoLote']['value'] != '') {
            if ($filter['tipoLote']['value'] == Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO) {
                $queryBuilder->leftJoin('l.fkImobiliarioLoteUrbano', 'lu');
                $queryBuilder->andWhere('lu.codLote is not null');
            } else {
                $queryBuilder->leftJoin('l.fkImobiliarioLoteRural', 'lr');
                $queryBuilder->andWhere('lr.codLote is not null');
            }
        }

        if ($filter['numLote']['value'] != '') {
            $queryBuilder->leftJoin('l.fkImobiliarioLoteLocalizacao', 'll');
            $queryBuilder->andWhere('lpad(upper(ll.valor), 10, \'0\') = :valor');
            $queryBuilder->setParameter('valor', str_pad($filter['numLote']['value'], 10, '0', STR_PAD_LEFT));
        }
    }

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'codLote' => $this->getRequest()->get('codLote'),
        );
    }

    /**
     * @return null|Lote
     */
    public function getLote()
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $lote = null;
        if ($this->getPersistentParameter('codLote')) {
            /** @var Lote $lote */
            $lote = $em->getRepository(Lote::class)->find($this->getPersistentParameter('codLote'));
        }
        return $lote;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('localizacao', 'text', array('label' => 'label.imobiliarioImovel.localizacao'))
            ->add('lote', 'text', array('label' => 'label.imobiliarioImovel.lote'))
            ->add('inscricaoMunicipal', 'text', array('label' => 'label.imobiliarioImovel.inscricaoImobiliaria'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Imovel/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Imovel/CRUD:list__action_delete.html.twig'),
                    'baixar' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Imovel/CRUD:list__action_baixar.html.twig'),
                    'caracteristicas' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Imovel/CRUD:list__action_caracteristicas.html.twig'),
                    'fotos' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Imovel/CRUD:list__action_fotos.html.twig'),
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
        $configuracaoModel = new ConfiguracaoModel($em);
        $codUf = $configuracaoModel->pegaConfiguracao('cod_uf', Modulo::MODULO_ADMINISTRATIVO, $this->getExercicio(), true);
        $codMunicipio = $configuracaoModel->pegaConfiguracao('cod_municipio', Modulo::MODULO_ADMINISTRATIVO, $this->getExercicio(), true);

        $uf = $municipio = null;
        if (((int) $codUf) && ((int) $codMunicipio)) {
            $uf = $em->getRepository(SwUf::class)->find((integer) $codUf);
            $municipio = $em->getRepository(SwMunicipio::class)->findOneBy(array('codMunicipio' => (integer) $codMunicipio, 'codUf' => (integer) $codUf));
        }

        $dtAtual = new \DateTime();

        $fieldOptions = array();

        $fieldOptions['inscricaoMunicipal'] = array();

        $choices = array(
            Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO => 'label.imobiliarioLote.urbano.modulo',
            Cadastro::CADASTRO_TRIBUTARIO_LOTE_RURAL => 'label.imobiliarioLote.rural.modulo'
        );

        $fieldOptions['tipoLote'] = array(
            'label' => 'label.imobiliarioLote.tipoLote',
            'choices' => array_flip($choices),
            'mapped' => false,
            'required' => true,
            'data' => Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['bairro'] = array(
            'label' => 'label.imobiliarioImovel.bairro',
            'mapped' => false,
            'required' => false,
            'disabled' => true
        );

        $fieldOptions['endereco'] = array(
            'label' => 'label.imobiliarioImovel.endereco',
            'choices' => array(),
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['cep'] = array(
            'label' => 'label.imobiliarioImovel.cep',
            'choices' => array(),
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['imobiliariaImovel_creci'] = array(
            'label' => 'label.imobiliarioImovel.creci',
            'class' => Corretagem::class,
            'mapped' => false,
            'required' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['dtCadastro'] = array(
            'label' => 'label.imobiliarioImovel.dataInscricao',
            'format' => 'dd/MM/yyyy',
            'data' => $dtAtual
        );

        $fieldOptions['matriculaImovel_matRegistroImovel'] = array(
            'label' => 'label.imobiliarioImovel.matRegistroImovel',
            'mapped' => false,
            'required' => true,
        );

        $fieldOptions['matriculaImovel_zona'] = array(
            'label' => 'label.imobiliarioImovel.zona',
            'mapped' => false,
            'required' => true,
        );

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

        $fieldOptions['proprietario_numcgm'] = array(
            'label' => 'label.imobiliarioImovel.cgm',
            'class' => SwCgm::class,
            'req_params' => array(),
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                $qb->where('LOWER(o.nomCgm) LIKE :nomCgm');
                $qb->setParameter('nomCgm', '%' . strtolower($term) . '%');
                return $qb;
            },
            'mapped' => false,
            'required' => false,
        );

        $fieldOptions['localizacao'] = array(
            'label' => 'label.imobiliarioLote.localizacao',
            'class' => Localizacao::class,
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['lote'] = array(
            'label' => 'label.imobiliarioLote.lote',
            'class' => Lote::class,
            'req_params' => array(
                'tipoLote' => 'varJsTipoLote',
                'codLocalizacao' => 'varJsCodLocalizacao',
            ),
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                if ($request->get('tipoLote') == Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO) {
                    $qb->leftJoin('o.fkImobiliarioLoteUrbano', 'lu');
                    $qb->where('lu.codLote is not null');
                } else {
                    $qb->leftJoin('o.fkImobiliarioLoteRural', 'lr');
                    $qb->where('lr.codLote is not null');
                }
                $qb->leftJoin('o.fkImobiliarioLoteLocalizacao', 'll');
                if ($request->get('codLocalizacao')) {
                    $qb->andWhere('ll.codLocalizacao = :codLocalizacao');
                    $qb->setParameter('codLocalizacao', $request->get('codLocalizacao'));
                }
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
            'mapped' => false,
            'required' => true,
        );

        $fieldOptions['proprietario_quota'] = array(
            'label' => 'label.imobiliarioImovel.quota',
            'mapped' => false,
            'required' => false,
            'data' => 100
        );

        $fieldOptions['proprietario_promitente'] = array(
            'label' => 'label.imobiliarioImovel.situacao',
            'mapped' => false,
            'required' => false,
            'choices' => array(
                'label.imobiliarioImovel.proprietario' => 0,
                'label.imobiliarioImovel.promitente' => 1
            ),
            'data' => 0,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['proprietario_lista'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Imobiliario/Imovel/proprietarios.html.twig',
            'attr' => array(
                'style' => 'display:none;'
            ),
            'data' => array(
                'proprietarios' => array()
            )
        );

        $fieldOptions['fkSwUf'] = array(
            'label' => 'label.imobiliarioImovel.estado',
            'class' => SwUf::class,
            'choice_label' => 'nomUf',
            'choice_value' => 'codUf',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('uf')
                    ->where('uf.codUf != :codUf')
                    ->setParameter('codUf', self::NAO_INFORMADO);
            },
            'data' => $uf,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkSwMunicipio'] = array(
            'label' => 'label.imobiliarioImovel.municipio',
            'class' => SwMunicipio::class,
            'choice_label' => 'nomMunicipio',
            'choice_value' => 'codMunicipio',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('m')
                    ->where('m.codMunicipio != :codMunicipio')
                    ->setParameter('codMunicipio', self::NAO_INFORMADO);
            },
            'data' => $municipio,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkSwBairro'] = array(
            'label' => 'label.imobiliarioImovel.bairro',
            'class' => SwBairro::class,
            'choice_label' => 'nomBairro',
            'choice_value' => 'codBairro',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('m')
                    ->where('m.codBairro != :codBairro')
                    ->setParameter('codBairro', self::NAO_INFORMADO);
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkSwLogradouro'] = array(
            'label' => 'label.imobiliarioImovel.logradouro',
            'class' => SwLogradouro::class,
            'req_params' => array(
                'codUf' => 'varJsCodUf',
                'codMunicipio' => 'varJsCodMunicipio',
                'codBairro' => 'varJsCodBairro'
            ),
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                $qb->leftJoin('o.fkSwBairroLogradouros', 'b');
                $qb->leftJoin('o.fkSwNomeLogradouros', 'n');
                $qb->leftJoin('n.fkSwTipoLogradouro', 't');
                $qb->where('b.codUf = :codUf');
                $qb->andWhere('b.codMunicipio = :codMunicipio');
                $qb->andWhere('b.codBairro = :codBairro');
                $qb->andWhere('LOWER(CONCAT(t.nomTipo, \' \', n.nomLogradouro)) LIKE :nomLogradouro');
                $qb->setParameters(
                    array(
                        'codUf' => $request->get('codUf'),
                        'codMunicipio' => $request->get('codMunicipio'),
                        'codBairro' => $request->get('codBairro'),
                        'nomLogradouro' => '%' . strtolower($term) . '%'
                    )
                );
                return $qb;
            },
            'mapped' => false,
            'required' => true,
        );

        $fieldOptions['correspondencia_cep'] = array(
            'label' => 'label.imobiliarioImovel.cep',
            'choices' => array(),
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['correspondencia_caixa_postal'] = array(
            'label' => 'label.imobiliarioImovel.caixaPostal',
            'mapped' => false,
            'required' => false,
        );

        $fieldOptions['correspondencia_numero'] = array(
            'label' => 'label.imobiliarioImovel.numero',
            'mapped' => false,
            'required' => true
        );

        $fieldOptions['correspondencia_complemento'] = array(
            'label' => 'label.imobiliarioImovel.complemento',
            'mapped' => false,
            'required' => false
        );

        $fieldOptions['imovelCorrespondencia'] =  array(
            'label' => 'label.imobiliarioImovel.habilitarEnderecoDeEntregaDeCorrespondencias',
            'mapped' => false,
            'required' => false
        );

        $fieldOptions['seguirCadastroEdificacao'] = array(
            'label' => 'label.imobiliarioConstrucao.seguirCadastroEdificacao',
            'mapped' => false,
            'required' => false,
            'data' => true
        );

        if ($this->id($this->getSubject())) {
            /** @var Imovel $imovel */
            $imovel = $this->getSubject();

            $fieldOptions['inscricaoMunicipal']['data'] = $imovel->getInscricaoMunicipal();
            $fieldOptions['dtCadastro']['data'] = $imovel->getDtCadastro();

            /** @var Lote $lote */
            $lote = $imovel->getFkImobiliarioImovelConfrontacao()->getFkImobiliarioConfrontacaoTrecho()->getFkImobiliarioConfrontacao()->getFkImobiliarioLote();

            $fieldOptions['tipoLote']['disabled'] = true;
            $fieldOptions['tipoLote']['data'] = ($lote->getFkImobiliarioLoteUrbano()) ? Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO : Cadastro::CADASTRO_TRIBUTARIO_LOTE_RURAL;
            $fieldOptions['localizacao']['disabled'] = true;
            $fieldOptions['localizacao']['data'] = $lote->getFkImobiliarioLoteLocalizacao()->getFkImobiliarioLocalizacao();
            $fieldOptions['lote']['data'] = $lote;

            $fieldOptions['matriculaImovel_matRegistroImovel']['data'] = $imovel->getFkImobiliarioMatriculaImoveis()->last()->getMatRegistroImovel();
            $fieldOptions['matriculaImovel_zona']['data'] = $imovel->getFkImobiliarioMatriculaImoveis()->last()->getZona();
            $fieldOptions['bairro']['data'] = (string) $lote->getFkImobiliarioLoteBairros()->last()->getFkSwBairro();
            $fieldOptions['endereco'] = array(
                'label' => 'label.imobiliarioImovel.endereco',
                'class' => SwLogradouro::class,
                'placeholder' => 'label.selecione',
                'required' => true,
                'mapped' => false,
                'data' => $imovel->getFkImobiliarioImovelConfrontacao()->getFkImobiliarioConfrontacaoTrecho()->getFkImobiliarioTrecho()->getFkSwLogradouro(),
                'query_builder' => function (EntityRepository $er) use ($lote) {
                    return $er->createQueryBuilder('o')
                        ->leftJoin('o.fkImobiliarioTrechos', 't')
                        ->leftJoin('t.fkImobiliarioConfrontacaoTrechos', 'ct')
                        ->where('ct.codLote = :codLote')
                        ->setParameter('codLote', $lote->getCodLote());
                },
                'attr' => array(
                    'class' => 'select2-parameters '
                )
            );

            $cep = $em->getRepository(SwCepLogradouro::class)
                ->findOneBy(
                    array(
                        'cep' => $imovel->getCep(),
                        'codLogradouro' => $imovel->getFkImobiliarioImovelConfrontacao()->getFkImobiliarioConfrontacaoTrecho()->getCodLogradouro()
                    )
                );
            $fieldOptions['cep'] = array(
                'label' => 'label.imobiliarioImovel.cep',
                'class' => SwCepLogradouro::class,
                'choice_label' => 'cep',
                'choice_value' => 'cep',
                'placeholder' => 'label.selecione',
                'required' => true,
                'mapped' => false,
                'data' => $cep,
                'query_builder' => function (EntityRepository $er) use ($lote) {
                    return $er->createQueryBuilder('o')
                        ->leftJoin('o.fkSwLogradouro', 'l')
                        ->leftJoin('l.fkImobiliarioTrechos', 't')
                        ->leftJoin('t.fkImobiliarioConfrontacaoTrechos', 'ct')
                        ->where('ct.codLote = :codLote')
                        ->setParameter('codLote', $lote->getCodLote());
                },
                'attr' => array(
                    'class' => 'select2-parameters '
                )
            );

            if ($imovel->getFkImobiliarioImovelCorrespondencias()->count()) {
                /** @var ImovelCorrespondencia $imovelCorrespondencia */
                $imovelCorrespondencia = $imovel->getFkImobiliarioImovelCorrespondencias()->last();
                $fieldOptions['imovelCorrespondencia']['data'] = true;

                $fieldOptions['fkSwUf']['data'] = $imovelCorrespondencia->getFkSwBairroLogradouro()->getFkSwLogradouro()->getFkSwMunicipio()->getFkSwUf();
                $fieldOptions['fkSwMunicipio']['data'] = $imovelCorrespondencia->getFkSwBairroLogradouro()->getFkSwLogradouro()->getFkSwMunicipio();
                $fieldOptions['fkSwBairro']['data'] = $imovelCorrespondencia->getFkSwBairroLogradouro()->getFkSwBairro();
                $fieldOptions['fkSwLogradouro']['data'] = $imovelCorrespondencia->getFkSwBairroLogradouro()->getFkSwLogradouro();
                $fieldOptions['correspondencia_caixa_postal']['data'] = $imovelCorrespondencia->getCaixaPostal();
                $fieldOptions['correspondencia_numero']['data'] = $imovelCorrespondencia->getNumero();
                $fieldOptions['correspondencia_complemento']['data'] = $imovelCorrespondencia->getComplemento();

                $correspondenciaCep = $em->getRepository(SwCepLogradouro::class)
                    ->findOneBy(
                        array(
                            'cep' => $imovel->getFkImobiliarioImovelCorrespondencias()->last()->getCep(),
                            'codLogradouro' => $imovel->getFkImobiliarioImovelCorrespondencias()->last()->getCodLogradouro(),
                        )
                    );
                $fieldOptions['correspondencia_cep'] = array(
                    'label' => 'label.imobiliarioImovel.cep',
                    'class' => SwCepLogradouro::class,
                    'choice_label' => 'cep',
                    'choice_value' => 'cep',
                    'placeholder' => 'label.selecione',
                    'required' => true,
                    'mapped' => false,
                    'data' => $correspondenciaCep,
                    'query_builder' => function (EntityRepository $er) use ($imovel) {
                        return $er->createQueryBuilder('o')
                            ->where('o.codLogradouro = :codLogradouro')
                            ->setParameter('codLogradouro', $imovel->getFkImobiliarioImovelCorrespondencias()->last()->getCodLogradouro());
                    },
                    'attr' => array(
                        'class' => 'select2-parameters '
                    )
                );
            }

            $fieldOptions['proprietario_lista']['data'] = array(
                'proprietarios' => $imovel->getFkImobiliarioProprietarios()
            );

            $fieldOptions['imobiliariaImovel_creci']['data'] = ($imovel->getFkImobiliarioImovelImobiliaria()) ? $imovel->getFkImobiliarioImovelImobiliaria()->getFkImobiliarioCorretagem() : null;
        }

        if ($this->getLote()) {
            $fieldOptions['localizacao']['data'] = $this->getLote()->getFkImobiliarioLoteLocalizacao()->getFkImobiliarioLocalizacao();
            $fieldOptions['lote']['data'] = $this->getLote();
        }

        $formMapper->tab('label.imobiliarioImovel.inscricaoImobiliaria');

        $formMapper->with('label.imobiliarioImovel.lote');
        $formMapper->add('tipoLote', 'choice', $fieldOptions['tipoLote']);
        $formMapper->add('localizacao', 'entity', $fieldOptions['localizacao']);
        $formMapper->add('lote', 'autocomplete', $fieldOptions['lote']);
        $formMapper->add('bairro', 'text', $fieldOptions['bairro']);
        $formMapper->end();

        $formMapper->with('label.imobiliarioImovel.dados');
        $formMapper->add('inscricaoMunicipal', 'hidden', $fieldOptions['inscricaoMunicipal']);
        $formMapper->add('dtCadastro', 'sonata_type_date_picker', $fieldOptions['dtCadastro']);
        $formMapper->add('matriculaImovel_matRegistroImovel', 'text', $fieldOptions['matriculaImovel_matRegistroImovel']);
        $formMapper->add('matriculaImovel_zona', 'text', $fieldOptions['matriculaImovel_zona']);
        if ($this->id($this->getSubject())) {
            $formMapper->add('endereco', 'entity', $fieldOptions['endereco']);
        } else {
            $formMapper->add('endereco', 'choice', $fieldOptions['endereco']);
        }
        $formMapper->add('numero', null, array('label' => 'label.imobiliarioImovel.numero'));
        $formMapper->add('complemento', null, array('label' => 'label.imobiliarioImovel.complemento'));
        if ($this->id($this->getSubject())) {
            $formMapper->add('cep', 'entity', $fieldOptions['cep']);
        } else {
            $formMapper->add('cep', 'choice', $fieldOptions['cep']);
        }

        $formMapper->add('imobiliariaImovel_creci', 'entity', $fieldOptions['imobiliariaImovel_creci']);
        $formMapper->end();

        $formMapper->with('label.imobiliarioImovel.processo');
        $formMapper->add('fkSwClassificacao', 'entity', $fieldOptions['fkSwClassificacao']);
        $formMapper->add('fkSwAssunto', 'entity', $fieldOptions['fkSwAssunto']);
        $formMapper->add('fkSwProcesso', 'autocomplete', $fieldOptions['fkSwProcesso']);
        $formMapper->end();

        $formMapper->with('');
        $formMapper->add('imovelCorrespondencia', 'checkbox', $fieldOptions['imovelCorrespondencia']);
        $formMapper->add('seguirCadastroEdificacao', 'checkbox', $fieldOptions['seguirCadastroEdificacao']);
        $formMapper->end();

        $formMapper->with('label.imobiliarioImovel.enderecoEntrega', array('class' => 'imovel-correspondencia'));
        $formMapper->add('fkSwUf', 'entity', $fieldOptions['fkSwUf']);
        $formMapper->add('fkSwMunicipio', 'entity', $fieldOptions['fkSwMunicipio']);
        $formMapper->add('fkSwBairro', 'entity', $fieldOptions['fkSwBairro']);
        $formMapper->add('fkSwLogradouro', 'autocomplete', $fieldOptions['fkSwLogradouro']);
        if (($this->id($this->getSubject())) && (isset($correspondenciaCep))) {
            $formMapper->add('correspondencia_cep', 'entity', $fieldOptions['correspondencia_cep']);
        } else {
            $formMapper->add('correspondencia_cep', 'choice', $fieldOptions['correspondencia_cep']);
        }
        $formMapper->add('correspondencia_caixa_postal', 'text', $fieldOptions['correspondencia_caixa_postal']);
        $formMapper->add('correspondencia_numero', 'text', $fieldOptions['correspondencia_numero']);
        $formMapper->add('correspondencia_complemento', 'text', $fieldOptions['correspondencia_complemento']);
        $formMapper->end();

        $formMapper->end();

        $formMapper->tab('label.imobiliarioImovel.proprietarios');

        $formMapper->with('label.imobiliarioImovel.proprietarios');
        $formMapper->add('proprietario_numcgm', 'autocomplete', $fieldOptions['proprietario_numcgm']);
        $formMapper->add('proprietario_quota', 'percent', $fieldOptions['proprietario_quota']);
        $formMapper->add('proprietario_promitente', 'choice', $fieldOptions['proprietario_promitente']);
        $formMapper->add('proprietario_lista', 'customField', $fieldOptions['proprietario_lista']);
        $formMapper->end();

        $formMapper->end();

        $formMapper->tab('label.imobiliarioImovel.caracteristicas');

        if ($this->id($this->getSubject())) {
            $atributosDinamicos = (new ImovelModel($em))->getNomAtributoValorByImovel($imovel);

            $fieldOptions['atributosDinamicos'] = array(
                'label' => false,
                'mapped' => false,
                'template' => 'TributarioBundle::Imobiliario/Lote/atributosDinamicos.html.twig',
                'data' => array(
                    'atributosDinamicos' => $atributosDinamicos
                )
            );

            $formMapper->with('label.imobiliarioImovel.atributos');
            $formMapper->add('atributosDinamicos', 'customField', $fieldOptions['atributosDinamicos']);
            $formMapper->end();
        } else {
            $formMapper->with('label.imobiliarioLote.atributos', array('class' => 'atributoDinamicoWith'));
            $formMapper->add('atributosDinamicos', 'text', array('mapped' => false, 'required' => false));
            $formMapper->end();
        }

        $formMapper->end();

        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin) {
                $form = $event->getForm();
                $data = $event->getData();
                $subject = $admin->getSubject($data);

                if ($form->has('endereco')) {
                    $form->remove('endereco');
                }

                $endereco = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                    'endereco',
                    'entity',
                    null,
                    array(
                        'class' => SwLogradouro::class,
                        'label' => 'label.imobiliarioImovel.endereco',
                        'mapped' => false,
                        'auto_initialize' => false,
                        'query_builder' => function (EntityRepository $er) use ($data) {
                            return $er->createQueryBuilder('o')
                                ->innerJoin('o.fkImobiliarioTrechos', 't')
                                ->innerJoin('t.fkImobiliarioConfrontacaoTrechos', 'ct')
                                ->where('ct.codLote = :codLote')
                                ->setParameter('codLote', $data['lote']);
                        },
                        'placeholder' => 'label.selecione',
                        'attr' => array(
                            'class' => 'select2-parameters'
                        )
                    )
                );
                $form->add($endereco);

                if ($form->has('cep')) {
                    $form->remove('cep');
                }

                $cep = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                    'cep',
                    'entity',
                    null,
                    array(
                        'class' => SwCepLogradouro::class,
                        'label' => 'label.imobiliarioImovel.cep',
                        'choice_label' => 'cep',
                        'choice_value' => 'cep',
                        'mapped' => false,
                        'auto_initialize' => false,
                        'query_builder' => function (EntityRepository $er) use ($data) {
                            return $er->createQueryBuilder('o')
                                ->where('o.codLogradouro = :codLogradouro')
                                ->setParameter('codLogradouro', (int) $data['endereco']);
                        },
                        'placeholder' => 'label.selecione',
                        'attr' => array(
                            'class' => 'select2-parameters'
                        )
                    )
                );
                $form->add($cep);

                if ($form->has('correspondencia_cep')) {
                    $form->remove('correspondencia_cep');
                }

                if (isset($data['fkSwLogradouro'])) {
                    $correspondenciaCep = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'correspondencia_cep',
                        'entity',
                        null,
                        array(
                            'class' => SwCepLogradouro::class,
                            'label' => 'label.imobiliarioImovel.cep',
                            'choice_label' => 'cep',
                            'choice_value' => 'cep',
                            'mapped' => false,
                            'auto_initialize' => false,
                            'query_builder' => function (EntityRepository $er) use ($data) {
                                return $er->createQueryBuilder('o')
                                    ->where('o.codLogradouro = :codLogradouro')
                                    ->setParameter('codLogradouro', (int) $data['fkSwLogradouro']);
                            },
                            'placeholder' => 'label.selecione',
                            'attr' => array(
                                'class' => 'select2-parameters'
                            )
                        )
                    );
                    $form->add($correspondenciaCep);
                }
            }
        );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $em = $this->modelManager->getEntityManager($this->getClass());
        $atributosDinamicos = (new ImovelModel($em))->getNomAtributoValorByImovel($this->getSubject());

        $showMapper
            ->with('label.imobiliarioImovel.dados')
            ->add('localizacao', null, array('label' => 'label.imobiliarioImovel.localizacao'))
            ->add('lote', null, array('label' => 'label.imobiliarioImovel.lote'))
            ->add('inscricaoMunicipal', null, array('label' => 'label.imobiliarioImovel.numInscricao'))
            ->add('dtCadastro', null, array('label' => 'label.imobiliarioImovel.dataInscricao'))
            ->add('matRegistroImovel', 'text', array('label' => 'label.imobiliarioImovel.matRegistroImovel'))
            ->add('zona', 'text', array('label' => 'label.imobiliarioImovel.zona'))
            ->add('logradouro', 'text', array('label' => 'label.imobiliarioImovel.endereco'))
            ->add('numero', null, array('label' => 'label.imobiliarioImovel.numero'))
            ->add('complemento', null, array('label' => 'label.imobiliarioImovel.complemento'))
            ->add('cep', null, array('label' => 'label.imobiliarioImovel.cep'))
            ->add('fkImobiliarioImovelProcessos', 'collection', array('label' => 'label.imobiliarioImovel.processo'))
            ->add('proprietarios', 'customField', array(
                'label' => 'label.imobiliarioImovel.proprietario',
                'template' => 'TributarioBundle:Sonata/Imobiliario/Imovel/CRUD:custom_show_proprietarios.html.twig',
                'data' => $this->getSubject()->getFkImobiliarioProprietarios()
            ))
            ->add('atributos', 'customField', array(
                'label' => 'label.imobiliarioImovel.atributos',
                'template' => 'TributarioBundle:Sonata/Imobiliario/Lote/CRUD:custom_show_atributos.html.twig',
                'data' => $atributosDinamicos
            ))
        ;
    }

    /**
     * @param Imovel $object
     */
    public function prePersist($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $imovelModel = new ImovelModel($em);

        $imovelModel->salvarImovel($object, $this->getForm(), $this->request->request);
    }

    /**
     * @param Imovel $object
     */
    public function preUpdate($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $imovelModel = new ImovelModel($em);

        $imovelModel->alterarImovel($object, $this->getForm(), $this->request->request);
    }

    /**
     * @param Imovel $object
     */
    public function postPersist($object)
    {
        if ($this->getForm()->get('seguirCadastroEdificacao')->getData()) {
            $this->forceRedirect(sprintf('/tributario/cadastro-imobiliario/edificacao/imovel/create?inscricaoMunicipal=%d', $object->getInscricaoMunicipal()));
        }
    }

    /**
     * @param Imovel $object
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function preRemove($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        if ($object->getFkImobiliarioUnidadeAutonomas()->count()) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.imobiliarioImovel.erroExcluir'));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }
    }
}
