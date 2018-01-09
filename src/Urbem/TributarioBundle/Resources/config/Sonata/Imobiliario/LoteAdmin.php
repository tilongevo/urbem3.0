<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Administracao\UnidadeMedida;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteRuralValor;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteUrbanoValor;
use Urbem\CoreBundle\Entity\Imobiliario\Localizacao;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\PontoCardeal;
use Urbem\CoreBundle\Entity\Imobiliario\Trecho;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwBairro;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwMunicipio;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Imobiliario\LocalizacaoModel;
use Urbem\CoreBundle\Model\Imobiliario\LoteModel;
use Urbem\CoreBundle\Model\SwAssuntoModel;
use Urbem\CoreBundle\Model\SwProcessoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

class LoteAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_lote';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/lote';
    protected $exibirBotaoExcluir = true;
    protected $exibirBotaoEditar = true;
    protected $includeJs = array(
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/core/javascripts/sw-processo.js',
        '/tributario/javascripts/imobiliario/lote.js',
    );

    const COD_GRANDEZA_AREA = 2;
    const COD_UNIDADE_M2 = 1;
    const COD_UNIDADE_HA = 3;
    const NAO_INFORMADO = 0;

    /**
     * @param Lote $lote
     * @return boolean
     */
    public function verificaBaixa(Lote $lote)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new LoteModel($em))->verificaBaixa($lote);
    }

    /**
     * @return bool
     */
    public function verificaCaracteristicas()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new LoteModel($em))->verificaCaracteristicas();
    }

    /**
     * @param Lote $lote
     * @return bool
     */
    public function verificaImoveis(Lote $lote)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new LoteModel($em))->verificaLoteImovel($lote);
    }

    /**
     * @param Lote $lote
     * @return bool
     */
    public function verificaLoteParceladoValidado(Lote $lote)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new LoteModel($em))->verificaLoteParceladoValidado($lote);
    }


    public function verificaLoteValidar(Lote $lote)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new LoteModel($em))->verificaLoteValidar($lote);
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('show');
        $collection->add('consultar_assunto', 'consultar-assunto');
        $collection->add('consultar_lote_localizacao_valor', 'consultar-lote-localizacao-valor');
        $collection->add('consultar_proprietarios', 'consultar-proprietarios');
        $collection->add('consultar_imoveis', 'consultar-imoveis');
        $collection->add('consultar_processo', 'consultar-processo');
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
                'tipoLote',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.imobiliarioLote.tipoLote',
                    'callback' => array($this, 'getSearchFilter')
                ),
                'choice',
                array(
                    'choices' => array_flip($choices)
                )
            )
            ->add(
                'numLote',
                'doctrine_orm_callback',
                array(
                    'label' => 'label.imobiliarioLote.lote',
                    'callback' => array($this, 'getSearchFilter')
                )
            )
            ->add('fkImobiliarioLoteLocalizacao.fkImobiliarioLocalizacao', null, array('label' => 'label.imobiliarioLote.localizacao'))
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

        if ($filter['tipoLote']['value'] != '') {
            if ($filter['tipoLote']['value'] == Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO) {
                $queryBuilder->leftJoin('o.fkImobiliarioLoteUrbano', 'lu');
                $queryBuilder->where('lu.codLote is not null');
            } else {
                $queryBuilder->leftJoin('o.fkImobiliarioLoteRural', 'lr');
                $queryBuilder->where('lr.codLote is not null');
            }
        }

        if ($filter['numLote']['value'] != '') {
            $queryBuilder->leftJoin('o.fkImobiliarioLoteLocalizacao', 'll');
            $queryBuilder->andWhere('lpad(upper(ll.valor), 10, \'0\') = :valor');
            $queryBuilder->setParameter('valor', str_pad($filter['numLote']['value'], 10, '0', STR_PAD_LEFT));
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('fkImobiliarioLoteLocalizacao.fkImobiliarioLocalizacao', 'text', array('label' => 'label.imobiliarioLote.localizacao'))
            ->add('__toString', 'text', array('label' => 'label.imobiliarioLote.lote'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Lote/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Lote/CRUD:list__action_delete.html.twig'),
                    'baixar' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Lote/CRUD:list__action_baixar.html.twig'),
                    'caracteristicas' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Lote/CRUD:list__action_caracteristicas.html.twig'),
                    'aglutinar' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Lote/CRUD:list__action_aglutinar.html.twig'),
                    'desmembrar' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Lote/CRUD:list__action_desmembrar.html.twig'),
                    'validar' => array('template' => 'TributarioBundle:Sonata/Imobiliario/Lote/CRUD:list__action_validar.html.twig')
                ),
                'header_style' => 'width: 35%'
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

        $this->exibirBotaoExcluir = false;

        $dtAtual = new \DateTime();

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $loteModel = new LoteModel($em);
        $configuracaoModel = new ConfiguracaoModel($em);
        $codUf = $configuracaoModel->pegaConfiguracao('cod_uf', Modulo::MODULO_ADMINISTRATIVO, $this->getExercicio(), true);
        $codMunicipio = $configuracaoModel->pegaConfiguracao('cod_municipio', Modulo::MODULO_ADMINISTRATIVO, $this->getExercicio(), true);

        $uf = $municipio = null;
        if (((int) $codUf) && ((int) $codMunicipio)) {
            /** @var SwUf $uf */
            $uf = $em->getRepository(SwUf::class)->find($codUf);
            /** @var SwMunicipio $municipio */
            $municipio = $em->getRepository(SwMunicipio::class)->findOneBy(array('codMunicipio' => $codMunicipio, 'codUf' => $codUf));
        }

        $fieldOptions = array();

        $choices = array(
            Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO => 'label.imobiliarioLote.urbano.modulo',
            Cadastro::CADASTRO_TRIBUTARIO_LOTE_RURAL => 'label.imobiliarioLote.rural.modulo'
        );

        $fieldOptions['codLote'] = array(
            'mapped' => false
        );

        $fieldOptions['codCadastro'] = array(
            'mapped' => false,
            'data' => Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO
        );

        $fieldOptions['tipoLote'] = array(
            'label' => 'label.imobiliarioLote.tipoLote',
            'mapped' => false,
            'required' => true,
            'expanded' => true,
            'data' => Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO,
            'choices' => array_flip($choices),
            'label_attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'attr' => array(
                'class' => 'checkbox-sonata'
            )
        );

        //Lote Localizacao Valor
        $fieldOptions['numLote'] = array(
            'label' => 'label.imobiliarioLote.numLote',
            'mapped' => false
        );

        $localizacaoModel = new LocalizacaoModel($em);
        $localizacoes = $localizacaoModel->getLocalizacoes();
        $codLocalizacao = array_column($localizacoes, 'cod_localizacao');

        $fieldOptions['fkImobiliarioLocalizacao'] = array(
            'label' => 'label.imobiliarioLote.localizacao',
            'class' => Localizacao::class,
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'query_builder' => function (EntityRepository $er) use ($codLocalizacao) {
                return $er->createQueryBuilder('o')
                    ->where('o.codLocalizacao IN (:codLocalizacao)')
                    ->setParameter('codLocalizacao', $codLocalizacao);
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['area'] = array(
            'label' => false,
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'money '
            )
        );

        $fieldOptions['fkAdministracaoUnidadeMedida'] = array(
            'label' => false,
            'class' => UnidadeMedida::class,
            'mapped' => false,
            'required' => true,
            'query_builder' => function (EntityRepository $er) {
                $qb = $er->createQueryBuilder('o');
                $qb->where('o.codGrandeza = :codGrandeza');
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->eq('o.codUnidade', ':codUnidadeM2'),
                    $qb->expr()->eq('o.codUnidade', ':codUnidadeHA')
                ));
                $qb->setParameters(
                    array(
                        'codGrandeza' => self::COD_GRANDEZA_AREA,
                        'codUnidadeM2' => self::COD_UNIDADE_M2,
                        'codUnidadeHA' => self::COD_UNIDADE_HA
                    )
                );
                return $qb;
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['profundidadeMedia'] = array(
            'label' => 'label.imobiliarioLote.profundidadeMedia',
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'money '
            )
        );



        // Infos Básicas
        $fieldOptions['codClassificacao'] = [
            'class' => SwClassificacao::class,
            'mapped' => false,
            'required' => false,
            'label' => 'label.imobiliarioLote.classificacao',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->orderBy('o.codClassificacao', 'ASC');
            },
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['codAssunto'] = [
            'class' => SwAssunto::class,
            'mapped' => false,
            'required' => false,
            'label' => 'label.imobiliarioLote.assunto',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $fieldOptions['procAdministrativo'] = [
            'label' => 'label.imobiliarioLote.processo',
            'attr'          => [
                'class' => 'select2-parameters ',
            ],
            'class' => SwProcesso::class,
            'mapped' => false,
            'placeholder' => 'label.selecione',
            'required' => false,
            'query_builder' => function (EntityRepository $entityManager) {
                $qb = $entityManager->createQueryBuilder('o');
                $qb->where('o.codProcesso = :codProcesso');
                $qb->setParameter('codProcesso', 0);

                return $qb;
            },
        ];

        $fieldOptions['dtInscricao'] = array(
            'label' => 'label.imobiliarioLote.dataInscricao',
            'format' => 'dd/MM/yyyy',
            'data' => $dtAtual
        );

        $fieldOptions['fkSwBairro'] = array(
            'label' => 'label.imobiliarioLote.bairro',
            'class' => SwBairro::class,
            'choice_label' => 'nomBairro',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'query_builder' => function (EntityRepository $er) use ($uf, $municipio) {
                $qb = $er->createQueryBuilder('o');
                if ($uf != null) {
                    $qb->where('o.codUf = :codUf');
                    $qb->andWhere('o.codMunicipio = :codMunicipio');
                    $qb->setParameters(
                        array(
                            'codUf' => $uf->getCodUf(),
                            'codMunicipio' => $municipio->getCodMunicipio()
                        )
                    );
                }
                $qb->orderBy('o.nomBairro', 'ASC');
                return $qb;
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['seguirCadastroImovel'] = array(
            'label' => 'label.imobiliarioLote.seguirCadastroImovel',
            'mapped' => false,
            'required' => false,
            'data' => true
        );

        $fieldOptions['fkImobiliarioPontoCardeal'] = array(
            'label' => 'label.imobiliarioLote.pontoCardeal',
            'class' => PontoCardeal::class,
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $choices = array(
            'trecho' => $this->getTranslator()->trans('label.imobiliarioLote.trecho'),
            'lote' => $this->getTranslator()->trans('label.imobiliarioLote.lote'),
            'outros' => $this->getTranslator()->trans('label.imobiliarioLote.outros'),
        );

        $fieldOptions['confrontacaoTipo'] = array(
            'label' => 'label.imobiliarioLote.tipo',
            'mapped' => false,
            'expanded' => true,
            'choices' => array_flip($choices),
            'data' => 'trecho',
            'label_attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'attr' => array(
                'class' => 'checkbox-sonata'
            )
        );

        $fieldOptions['extensao'] = array(
            'label' => 'label.imobiliarioLote.extensao',
            'mapped' => false,
            'required' => true,
            'attr' => array(
                'class' => 'money '
            )
        );

        // Opção Trecho
        // ConfrontacaoTrecho $principal boolean
        $fieldOptions['principal'] = array(
            'label' => 'label.imobiliarioLote.testada',
            'mapped' => false,
            'expanded' => true,
            'required' => true,
            'choices' => array(
                'sim' => 1,
                'nao' => 0
            ),
            'data' => 0,
            'label_attr' => array(
                'class' => 'checkbox-sonata'
            ),
            'attr' => array(
                'class' => 'checkbox-sonata'
            )
        );

        $fieldOptions['fkSwUf'] = array(
            'label' => 'label.imobiliarioFaceQuadra.estado',
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
            'label' => 'label.imobiliarioFaceQuadra.municipio',
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

        $fieldOptions['fkImobiliarioTrecho'] = array(
            'label' => 'label.imobiliarioFaceQuadra.trecho',
            'class' => Trecho::class,
            'req_params' => [
                'codUf' => 'varJsCodUf',
                'codMunicipio' => 'varJsCodMunicipio'
            ],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                $qb->innerJoin('o.fkSwLogradouro', 'l');
                $qb->innerJoin('l.fkSwNomeLogradouros', 'nl');
                $qb->innerJoin('nl.fkSwTipoLogradouro', 'tl');
                $qb->where('l.codUf = :codUf');
                $qb->andWhere('l.codMunicipio = :codMunicipio');
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->eq('o.codTrecho', ':codTrecho'),
                    $qb->expr()->like("LOWER(CONCAT(tl.nomTipo, ' ', nl.nomLogradouro))", $qb->expr()->literal('%' . strtolower($term) . '%'))
                ));
                $qb->setParameter('codUf', (int) $request->get('codUf'));
                $qb->setParameter('codMunicipio', (int) $request->get('codMunicipio'));
                $qb->setParameter('codTrecho', (int) $term);
                $qb->orderBy('o.codTrecho', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => true,
        );

        // Opção Lote
        $fieldOptions['fkImobiliarioLote'] = array(
            'label' => 'label.imobiliarioLote.lote',
            'class' => Lote::class,
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->leftJoin('o.fkImobiliarioBaixaLotes', 'b')
                    ->where('b.dtInicio is not null')
                    ->andWhere('b.dtTermino is not null')
                    ->orWhere('b.dtInicio is null')
                    ->orderBy('o.codLote', 'ASC');
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        //Opção Outros
        $fieldOptions['descricao'] = array(
            'label' => 'label.imobiliarioLote.descricao',
            'mapped' => false,
            'required' => true
        );

        $fieldOptions['fkImobiliarioConfrontacoes'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Imobiliario/Lote/confrontacoes.html.twig',
            'attr' => array(
                'style' => 'display:none;'
            ),
            'data' => array(
                'confrontacoes' => array()
            )
        );

        if ($this->id($this->getSubject())) {
            /** @var Lote $lote */
            $lote = $this->getSubject();

            $fieldOptions['codLote']['data'] = $lote->getCodLote();

            $fieldOptions['tipoLote']['disabled'] = true;
            $fieldOptions['tipoLote']['data'] = ($lote->getFkImobiliarioLoteUrbano()) ? Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO : Cadastro::CADASTRO_TRIBUTARIO_LOTE_RURAL;

            $fieldOptions['codCadastro']['data'] = ($lote->getFkImobiliarioLoteUrbano()) ? Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO : Cadastro::CADASTRO_TRIBUTARIO_LOTE_RURAL;

            $fieldOptions['numLote']['disabled'] = true;
            $fieldOptions['numLote']['data'] = $lote->getFkImobiliarioLoteLocalizacao()->getValor();

            $fieldOptions['fkImobiliarioLocalizacao']['disabled'] = true;
            $fieldOptions['fkImobiliarioLocalizacao']['data'] = $lote->getFkImobiliarioLoteLocalizacao()->getFkImobiliarioLocalizacao();

            $fieldOptions['area']['data'] = number_format($lote->getFkImobiliarioAreaLotes()->last()->getAreaReal(), 2, ',', '.');
            $fieldOptions['fkAdministracaoUnidadeMedida']['data'] = $lote->getFkImobiliarioAreaLotes()->last()->getFkAdministracaoUnidadeMedida();

            $fieldOptions['profundidadeMedia']['data'] = number_format($lote->getFkImobiliarioProfundidadeMedias()->last()->getVlProfundidadeMedia(), 2, ',', '.');

            $fieldOptions['fkSwBairro']['data'] = $lote->getFkImobiliarioLoteBairros()->last()->getFkSwBairro();

            $fieldOptions['fkImobiliarioConfrontacoes']['data'] = array(
                'confrontacoes' => $lote->getFkImobiliarioConfrontacoes()
            );

            $loteProcessos = $lote->getFkImobiliarioLoteProcessos()->last();

            if ($loteProcessos) {
                /** @var SwProcesso $processo */
                $processo = $loteProcessos->getFkSwProcesso();

                $fieldOptions['procAdministrativo']['choice_value'] = function (SwProcesso $processo) {
                    return $this->getObjectKey($processo);
                };

                $fieldOptions['procAdministrativo']['data'] = $processo;

                $fieldOptions['procAdministrativo']['query_builder'] = function (EntityRepository $er) use ($processo) {
                    return $er->createQueryBuilder('o')
                        ->where('o.codClassificacao = :codClassificacao')
                        ->andWhere('o.codAssunto = :codAssunto')
                        ->setParameters([
                            'codClassificacao' => $processo->getCodClassificacao(),
                            'codAssunto' => $processo->getCodAssunto()
                        ]);
                };

                $fieldOptions['codAssunto']['choice_value'] = function (SwAssunto $assunto) {
                    return $this->getObjectKey($assunto);
                };

                $fieldOptions['codAssunto']['data'] = $processo->getFkSwAssunto();

                $fieldOptions['codAssunto']['query_builder'] = function (EntityRepository $er) use ($processo) {
                    return $er->createQueryBuilder('o')
                        ->where('o.codClassificacao = :codClassificacao')
                        ->setParameter('codClassificacao', $processo->getCodClassificacao());
                };

                $fieldOptions['codClassificacao']['data'] = $processo->getFkSwAssunto()->getFkSwClassificacao();
            }
        } else {
            $fieldOptions['procAdministrativo']['choices'] = [];
        }

        $formMapper->tab('label.imobiliarioLote.lote');
        $formMapper->with('label.imobiliarioLote.dadosLote');
        $formMapper->add('codLote', 'hidden', $fieldOptions['codLote']);
        $formMapper->add('codCadastro', 'hidden', $fieldOptions['codCadastro']);
        $formMapper->add('tipoLote', 'choice', $fieldOptions['tipoLote']);
        $formMapper->add('numLote', 'text', $fieldOptions['numLote']);
        $formMapper->add('fkImobiliarioLocalizacao', 'entity', $fieldOptions['fkImobiliarioLocalizacao']);
        $formMapper->end();

        $formMapper->with('label.imobiliarioLote.area');
        $formMapper->add('area', 'text', $fieldOptions['area']);
        $formMapper->add('fkAdministracaoUnidadeMedida', 'entity', $fieldOptions['fkAdministracaoUnidadeMedida']);
        $formMapper->end();

        $formMapper->with('label.imobiliarioLote.processo');

        $formMapper->add('codClassificacao', 'entity', $fieldOptions['codClassificacao']);
        $formMapper->add('codAssunto', 'entity', $fieldOptions['codAssunto']);
        $formMapper->add('codProcesso', 'entity', $fieldOptions['procAdministrativo']);


        $formMapper->end();

        $formMapper->with('');
        $formMapper->add('profundidadeMedia', 'text', $fieldOptions['profundidadeMedia']);
        $formMapper->add('dtInscricao', 'sonata_type_date_picker', $fieldOptions['dtInscricao']);
        $formMapper->add('fkSwBairro', 'entity', $fieldOptions['fkSwBairro']);
        $formMapper->add('seguirCadastroImovel', 'checkbox', $fieldOptions['seguirCadastroImovel']);
        $formMapper->end();

        $formMapper->end();

        $formMapper->tab('label.imobiliarioLote.confrontacoes');

        $formMapper->with('label.imobiliarioLote.confrontacoes');
        $formMapper->add('fkImobiliarioPontoCardeal', 'entity', $fieldOptions['fkImobiliarioPontoCardeal']);
        $formMapper->add('confrontacaoTipo', 'choice', $fieldOptions['confrontacaoTipo']);
        $formMapper->add('extensao', 'text', $fieldOptions['extensao']);
        $formMapper->end();

        $formMapper->with('label.imobiliarioLote.trecho', array('class' => 'fieldset-trecho'));
        $formMapper->add('fkSwUf', 'entity', $fieldOptions['fkSwUf']);
        $formMapper->add('fkSwMunicipio', 'entity', $fieldOptions['fkSwMunicipio']);
        $formMapper->add('fkImobiliarioTrecho', 'autocomplete', $fieldOptions['fkImobiliarioTrecho']);
        $formMapper->add('principal', 'choice', $fieldOptions['principal']);
        $formMapper->end();

        $formMapper->with('');
        $formMapper->add('fkImobiliarioLote', 'entity', $fieldOptions['fkImobiliarioLote']);
        $formMapper->add('descricao', 'textarea', $fieldOptions['descricao']);
        $formMapper->add('fkImobiliarioConfrontacoes', 'customField', $fieldOptions['fkImobiliarioConfrontacoes']);
        $formMapper->end();

        $formMapper->end();

        $formMapper->tab('label.imobiliarioLote.caracteristicas');

        if ($this->id($this->getSubject())) {
            $atributoLoteValor = null;
            $atributosDinamicos = array();
            if ($lote->getFkImobiliarioLoteUrbano()) {
                $atributoLoteValor = $em->getRepository(AtributoLoteUrbanoValor::class)->findOneByCodLote($lote->getCodLote(), array('timestamp' => 'DESC'));
            } else {
                $atributoLoteValor = $em->getRepository(AtributoLoteRuralValor::class)->findOneByCodLote($lote->getCodLote(), array('timestamp' => 'DESC'));
            }
            if ($atributoLoteValor) {
                $atributosDinamicos = $loteModel->getNomAtributoValorByLote($lote, $atributoLoteValor->getTimestamp());
            }
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

        $processoModel = new SwProcessoModel($em);
        $assuntoModel = new SwAssuntoModel($em);
        $admin = $this;

        //codAssunto
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $assuntoModel) {
                $form = $event->getForm();
                $data = $event->getData();

                if (isset($data['codAssunto']) && $data['codAssunto'] != "") {
                    $assuntos = $assuntoModel->findByCodClassificacao($data['codClassificacao']);

                    $dados = array();
                    foreach ($assuntos as $assunto) {
                        $choiceKey = (string) $assunto;
                        $choiceValue = $assuntoModel->getObjectIdentifier($assunto);

                        $dados[$choiceKey] = $choiceValue;
                    }

                    $comAssunto = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codAssunto', 'choice', null, [
                            'attr' => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices' => $dados,
                            'label' => 'label.bem.codAssunto',
                            'mapped' => false,
                        ]);

                    $form->add($comAssunto);
                }
            }
        );
        //codProcesso
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $processoModel) {
                $form = $event->getForm();
                $data = $event->getData();

                if (strpos($data['codAssunto'], '~')) {
                    list($codAssunto, $codClassificacao) = explode('~', $data['codAssunto']);
                } else {
                    $codAssunto = $data['codAssunto'];
                    $codClassificacao = $data['codClassificacao'];
                }

                if (isset($data['codProcesso']) && $data['codProcesso'] != "") {
                    $processos = $processoModel->getProcessoByClassificacaoAndAssunto($codClassificacao, $codAssunto);

                    $dados = array();
                    foreach ($processos as $processo) {
                        $processoCompleto = $processo->cod_processo_completo;
                        $processoAssunto = " | " . $processo->nom_assunto;

                        $choiceKey = $processoCompleto . $processoAssunto;
                        $choiceValue = $processo->cod_processo.'~'.$processo->ano_exercicio;

                        $dados[$choiceKey] = $choiceValue;
                    }

                    $comProcesso = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed('codProcesso', 'choice', null, [
                            'attr' => ['class' => 'select2-parameters '],
                            'auto_initialize' => false,
                            'choices' => $dados,
                            'label' => 'label.bem.procAdministrativo',
                            'mapped' => false,
                        ]);

                    $form->add($comProcesso);
                }
            }
        );
    }

    /**
     * @param Lote $object
     */
    public function prePersist($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $loteModel = new LoteModel($em);

        $form = $this->getForm();

        /** @var Localizacao $localizacao */
        $localizacao = $form->get('fkImobiliarioLocalizacao')->getData();

        $object->setCodLote($loteModel->getProximoCodLote());
        $object->setLocalizacao($localizacao->getCodigoComposto());
        $em->persist($object);

        $confrontacoes = $this->request->request->get('confrontacoes');

        $dtAtual = new DateTimeMicrosecondPK();

        $loteModel->salvarLote($object, $form, $confrontacoes, $dtAtual);

        $loteModel->atributoDinamico($object, $this->request->request->get('atributoDinamico'), $dtAtual);
    }

    /**
     * @param Lote $object
     */
    public function postPersist($object)
    {
        if ($this->getForm()->get('seguirCadastroImovel')->getData()) {
            $this->forceRedirect(sprintf('/tributario/cadastro-imobiliario/imovel/create?codLote=%d', $object->getCodLote()));
        }
    }

    /**
     * @param Lote $object
     */
    public function preUpdate($object)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $loteModel = new LoteModel($em);

        $form = $this->getForm();

        $confrontacoes = $this->request->request->get('confrontacoes');
        $confrontacoesOld = ($this->request->request->get('confrontacoes_old')) ? $this->request->request->get('confrontacoes_old') : array();

        $loteModel->alterarLote($object, $form, $confrontacoes, $confrontacoesOld);
    }

    /**
     * @param Lote $lote
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function preRemove($lote)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $imovelConfrontacao = (new LoteModel($em))->verificaDependentes($lote);

        $container = $this->getConfigurationPool()->getContainer();
        if ($imovelConfrontacao) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.imobiliarioLote.erroExcluir', array('%codConfrontacao%' => $imovelConfrontacao->getFkImobiliarioConfrontacaoTrecho()->getFkImobiliarioTrecho()->getCodigoComposto(), '%inscricaoMunicipal%' => $imovelConfrontacao->getInscricaoMunicipal())));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }
    }
}
