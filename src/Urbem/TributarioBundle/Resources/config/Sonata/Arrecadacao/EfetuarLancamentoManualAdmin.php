<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito;
use Urbem\CoreBundle\Entity\Arrecadacao\Lancamento;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Monetario\Credito;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Model\Arrecadacao\LancamentoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class EfetuarLancamentoManualAdmin extends AbstractAdmin
{
    const TIPO_CREDITO = 0;
    const TIPO_GRUPO_CREDITO = 1;
    const REFERENCIA_CGM = 'cgm';
    const REFERENCIA_INSCRICAO_IMOBILIARIA = 'ii';
    const REFERENCIA_INSCRICAO_ECONOMICA = 'ie';
    const TIPO_PARCELA_UNICA = 0;
    const TIPO_PARCELA_NORMAL = 1;
    const FORMA_DESCONTO_PERCENTUAL = 0;
    const FORMA_DESCONTO_ABSOLUTO = 1;
    const EMISSAO_CARNE_NAO_EMITIR = 0;
    const EMISSAO_CARNE_IMPRESSAO_LOCAL = 0;
    const MODELO_CARNE_ESCRITURACAO = 0;
    const MODELO_CARNE_DIVERSOS = 0;

    protected $baseRouteName = 'urbem_tributario_arrecadacao_calculo_efetuar_lancamento_manual';
    protected $baseRoutePattern = 'tributario/arrecadacao/calculo/efetuar-lancamento/manual';
    protected $exibirBotaoEditar = false;
    protected $exibirBotaoExcluir = false;
    protected $includeJs = array(
        '/tributario/javascripts/arrecadacao/efetuar-lancamentos.js',
        '/tributario/javascripts/arrecadacao/efetuar-lancamentos-parcelas.js',
        '/core/javascripts/sw-processo.js'
    );

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create', 'show']);
        $collection->add('consultar_creditos', 'consultar-creditos');
        $collection->add('consultar_imovel', 'consultar-imovel');
        $collection->add('relatorio', $this->getRouterIdParameter() . '/relatorio');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        // Dados para Cálculo

        $fieldOptions = [];

        $tiposLancamentoManual = [
            'label.arrecadacaoEfetuarLancamento.credito',
            'label.arrecadacaoEfetuarLancamento.grupoCredito'
        ];

        $fieldOptions['lancamentoManualDe'] = [
            'label' => 'label.arrecadacaoEfetuarLancamento.lancamentoManualDe',
            'choices' => array_flip($tiposLancamentoManual),
            'mapped' => false,
            'expanded' => true,
            'required' => true,
            'data' => self::TIPO_CREDITO
        ];

        $fieldOptions['fkMonetarioCredito'] = [
            'label' => 'label.arrecadacaoEfetuarLancamento.credito',
            'class' => Credito::class,
            'placeholder' => 'label.selecione',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->orderBy('o.codCredito', 'ASC');
            },
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkArrecadacaoGrupoCredito'] = [
            'label' => 'label.arrecadacaoEfetuarLancamento.grupoCredito',
            'class' => GrupoCredito::class,
            'choice_value' => 'codGrupoCredito',
            'placeholder' => 'label.selecione',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->orderBy('o.codGrupo', 'ASC')
                    ->addOrderBy('o.anoExercicio', 'ASC');
            },
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['valor'] = [
            'label' => 'label.arrecadacaoEfetuarLancamento.valor',
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money ',
            ],
            'data' => 0.00,
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['valorTotal'] = [
            'label' => 'label.arrecadacaoEfetuarLancamento.valorTotal',
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money ',
            ],
            'data' => 0.00,
            'mapped' => false,
            'required' => false,
            'disabled' => true
        ];

        $fieldOptions['exercicio'] = [
            'label' => 'label.arrecadacaoEfetuarLancamento.exercicio',
            'data' => $this->getExercicio(),
            'mapped' => false,
            'required' => true
        ];

        // Lista de Créditos

        $fieldOptions['listaCreditos'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Arrecadacao/Calculo/EfetuarLancamentos/creditos.html.twig',
            'attr' => array(
                'style' => 'display:none;'
            ),
            'data' => array(
                'parcelas' => array()
            )
        );

        $formMapper
            ->with('label.arrecadacaoEfetuarLancamento.dadosCalculo')
            ->add('lancamentoManualDe', 'choice', $fieldOptions['lancamentoManualDe'])
            ->add('fkMonetarioCredito', 'entity', $fieldOptions['fkMonetarioCredito'])
            ->add('fkArrecadacaoGrupoCredito', 'entity', $fieldOptions['fkArrecadacaoGrupoCredito'])
            ->add('valor', 'money', $fieldOptions['valor'])
            ->add('valorTotal', 'money', $fieldOptions['valorTotal'])
            ->add('exercicio', 'text', $fieldOptions['exercicio'])
            ->add('listaCreditos', 'customField', $fieldOptions['listaCreditos'])
            ->end()
        ;

        // Filtros para Cálculo
        // Dados para Parcelas

        $filtros = [
            self::REFERENCIA_CGM => 'label.arrecadacaoEfetuarLancamento.cgm',
            self::REFERENCIA_INSCRICAO_IMOBILIARIA => 'label.arrecadacaoEfetuarLancamento.inscricaoImobiliaria',
            self::REFERENCIA_INSCRICAO_ECONOMICA => 'label.arrecadacaoEfetuarLancamento.inscricaoEconomica'
        ];

        $fieldOptions['filtrarPor'] = [
            'label' => 'label.arrecadacaoEfetuarLancamento.filtrarPor',
            'choices' => array_flip($filtros),
            'mapped' => false,
            'expanded' => true,
            'required' => true,
            'data' => self::REFERENCIA_CGM,
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr' => ['class' => 'checkbox-sonata']
        ];

        $fieldOptions['fkSwCgm'] = [
            'label' => 'label.arrecadacaoEfetuarLancamento.contribuinte',
            'class' => SwCgm::class,
            'req_params' => array(),
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term) {
                $qb = $er->createQueryBuilder('o');
                $qb->where('LOWER(o.nomCgm) LIKE :nomCgm');
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));
                if ((int) $term) {
                    $qb->orWhere('o.numcgm = :numcgm');
                    $qb->setParameter('numcgm', (int) $term);
                }
                return $qb;
            },
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkImobiliarioImovel'] = [
            'label' => 'label.arrecadacaoEfetuarLancamento.inscricaoImobiliaria',
            'class' => Imovel::class,
            'req_params' => [],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term) {
                $qb = $er->createQueryBuilder('o');
                $qb->andWhere('o.inscricaoMunicipal = :inscricaoMunicipal');
                $qb->setParameter('inscricaoMunicipal', $term);
                $qb->orderBy('o.inscricaoMunicipal', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['fkEconomicoCadastroEconomico'] = [
            'label' => 'label.arrecadacaoEfetuarLancamento.inscricaoEconomica',
            'class' => CadastroEconomico::class,
            'req_params' => [],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term) {
                $qb = $er->createQueryBuilder('o');
                $qb->leftJoin('o.fkArrecadacaoCadastroEconomicoFaturamentos', 'cef');

                $qb->leftJoin('o.fkEconomicoCadastroEconomicoEmpresaFato', 'ef');
                $qb->leftJoin('ef.fkSwCgmPessoaFisica', 'efpf');
                $qb->leftJoin('efpf.fkSwCgm', 'efcgm');

                $qb->leftJoin('o.fkEconomicoCadastroEconomicoAutonomo', 'a');
                $qb->leftJoin('a.fkSwCgmPessoaFisica', 'apf');
                $qb->leftJoin('apf.fkSwCgm', 'acgm');

                $qb->leftJoin('o.fkEconomicoCadastroEconomicoEmpresaDireito', 'ed');
                $qb->leftJoin('ed.fkSwCgmPessoaJuridica', 'edpj');
                $qb->leftJoin('edpj.fkSwCgm', 'edcgm');

                $qb->where($qb->expr()->orX(
                    $qb->expr()->like('LOWER(efcgm.nomCgm)', ':nomCgm'),
                    $qb->expr()->eq('efcgm.numcgm', ':numcgm'),
                    $qb->expr()->like('LOWER(acgm.nomCgm)', ':nomCgm'),
                    $qb->expr()->eq('acgm.numcgm', ':numcgm'),
                    $qb->expr()->like('LOWER(edcgm.nomCgm)', ':nomCgm'),
                    $qb->expr()->eq('edcgm.numcgm', ':numcgm')
                ));

                $qb->andWhere('cef.inscricaoEconomica is not null');

                $qb->setParameters([
                    'nomCgm' => sprintf('%%%s%%', strtolower($term)),
                    'numcgm' => (int) $term
                ]);
                $qb->orderBy('o.inscricaoEconomica', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => true
        ];

        $tiposParcela = [
            'label.arrecadacaoEfetuarLancamento.cotasUnicas',
            'label.arrecadacaoEfetuarLancamento.parcelasNormais'
        ];

        $fieldOptions['tipoParcela'] = [
            'label' => 'label.arrecadacaoEfetuarLancamento.tipoParcela',
            'choices' => array_flip($tiposParcela),
            'mapped' => false,
            'expanded' => true,
            'required' => true,
            'data' => self::TIPO_PARCELA_UNICA,
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr' => ['class' => 'checkbox-sonata']
        ];

        $fieldOptions['desconto'] = [
            'label' => 'label.arrecadacaoEfetuarLancamento.desconto',
            'currency' => 'BRL',
            'data' => 0.00,
            'attr' => [
                'class' => 'money ',
            ],
            'mapped' => false,
            'required' => false
        ];

        $formasDesconto = [
            'label.arrecadacaoEfetuarLancamento.percentual',
            'label.arrecadacaoEfetuarLancamento.valorAbsoluto'
        ];

        $fieldOptions['formaDesconto'] = [
            'label' => 'label.arrecadacaoEfetuarLancamento.formaDesconto',
            'choices' => array_flip($formasDesconto),
            'mapped' => false,
            'expanded' => true,
            'required' => true,
            'data' => self::FORMA_DESCONTO_PERCENTUAL,
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr' => ['class' => 'checkbox-sonata']
        ];

        $fieldOptions['dtPrimeiroVencimento'] = [
            'label' => 'label.arrecadacaoEfetuarLancamento.dtPrimeiroVencimento',
            'format' => 'dd/MM/yyyy',
            'data' => new \DateTime(),
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['quantidadeParcelas'] = [
            'label' => 'label.arrecadacaoEfetuarLancamento.quantidadeParcelas',
            'data' => 1,
            'mapped' => false,
            'required' => true
        ];

        $fieldOptions['listaParcelas'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Arrecadacao/Calculo/EfetuarLancamentos/parcelas.html.twig',
            'attr' => array(
                'style' => 'display:none;'
            ),
            'data' => array(
                'parcelas' => array()
            )
        );

        $fieldOptions['codClassificacao'] = array(
            'label' => 'label.imobiliarioLote.classificacao',
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

        $fieldOptions['codAssunto'] = array(
            'label' => 'label.imobiliarioLote.assunto',
            'placeholder' => 'label.selecione',
            'choices' => array(),
            'mapped' => false,
            'required' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['codProcesso'] = array(
            'label' => 'label.imobiliarioLote.processo',
            'placeholder' => 'label.selecione',
            'choices' => array(),
            'mapped' => false,
            'required' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $opcoesEmissao = [
            'label.arrecadacaoEfetuarLancamento.naoEmitir',
            'label.arrecadacaoEfetuarLancamento.impressoraLocal'
        ];

        $fieldOptions['emissaoCarnes'] = [
            'label' => false,
            'choices' => array_flip($opcoesEmissao),
            'mapped' => false,
            'expanded' => true,
            'required' => true,
            'data' => self::EMISSAO_CARNE_NAO_EMITIR,
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr' => ['class' => 'checkbox-sonata']
        ];

        $modelosCarne = [
            'label.arrecadacaoEfetuarLancamento.carneEscrituracao',
            'label.arrecadacaoEfetuarLancamento.carneDiversos'
        ];

        $fieldOptions['modelo'] = [
            'label' => 'label.arrecadacaoEfetuarLancamento.modelo',
            'choices' => array_flip($modelosCarne),
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => true
        ];

        $formMapper
            ->with('label.arrecadacaoEfetuarLancamento.filtrosCalculo')
            ->add('filtrarPor', 'choice', $fieldOptions['filtrarPor'])
            ->add('fkSwCgm', 'autocomplete', $fieldOptions['fkSwCgm'])
            ->add('fkImobiliarioImovel', 'autocomplete', $fieldOptions['fkImobiliarioImovel'])
            ->add('fkEconomicoCadastroEconomico', 'autocomplete', $fieldOptions['fkEconomicoCadastroEconomico'])
            ->end()
            ->with('label.arrecadacaoEfetuarLancamento.dadosParcelas')
            ->add('tipoParcela', 'choice', $fieldOptions['tipoParcela'])
            ->add('desconto', 'money', $fieldOptions['desconto'])
            ->add('formaDesconto', 'choice', $fieldOptions['formaDesconto'])
            ->add('dtPrimeiroVencimento', 'sonata_type_date_picker', $fieldOptions['dtPrimeiroVencimento'])
            ->add('quantidadeParcelas', 'text', $fieldOptions['quantidadeParcelas'])
            ->add('listaParcelas', 'customField', $fieldOptions['listaParcelas'])
            ->end()
            ->with('label.arrecadacaoEfetuarLancamento.processo')
            ->add('codClassificacao', 'entity', $fieldOptions['codClassificacao'])
            ->add('codAssunto', 'choice', $fieldOptions['codAssunto'])
            ->add('codProcesso', 'choice', $fieldOptions['codProcesso'])
            ->end()
            ->with('label.arrecadacaoEfetuarLancamento.observacoesBoleto')
            ->add('observacao', 'textarea', ['label' => false, 'required' => false])
            ->end()
            ->with('label.arrecadacaoEfetuarLancamento.observacoesInternas')
            ->add('observacaoSistema', 'textarea', ['label' => false, 'required' => false])
            ->end()
            ->with('label.arrecadacaoEfetuarLancamento.emissaoCarnes')
            ->add('emissaoCarnes', 'choice', $fieldOptions['emissaoCarnes'])
            ->add('modelo', 'choice', $fieldOptions['modelo'])
            ->end()
        ;

        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin) {
                $form = $event->getForm();
                $data = $event->getData();

                if (isset($data['codClassificacao']) && $data['codClassificacao'] != "") {
                    $codAssunto = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'codAssunto',
                        'entity',
                        null,
                        array(
                            'class' => SwAssunto::class,
                            'label' => 'label.imobiliarioLote.assunto',
                            'choice_value' => 'codComposto',
                            'placeholder' => 'label.selecione',
                            'mapped' => false,
                            'auto_initialize' => false,
                            'query_builder' => function (EntityRepository $er) use ($data) {
                                return $er->createQueryBuilder('o')
                                    ->where('o.codClassificacao = :codClassificacao')
                                    ->setParameter('codClassificacao', $data['codClassificacao']);
                            },
                            'attr' => array(
                                'class' => 'select2-parameters'
                            )
                        )
                    );
                    $form->remove('codAssunto');
                    $form->add($codAssunto);
                }

                if (isset($data['codAssunto']) && $data['codAssunto'] != "") {
                    $codProcesso = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'codProcesso',
                        'entity',
                        null,
                        array(
                            'class' => SwProcesso::class,
                            'label' => 'label.imobiliarioLote.assunto',
                            'choice_value' => 'codComposto',
                            'placeholder' => 'label.selecione',
                            'mapped' => false,
                            'auto_initialize' => false,
                            'query_builder' => function (EntityRepository $er) use ($data) {
                                list($codClassificacao, $codAssunto) = explode('~', $data['codAssunto']);
                                return $er->createQueryBuilder('o')
                                    ->where('o.codClassificacao = :codClassificacao')
                                    ->andWhere('o.codAssunto = :codAssunto')
                                    ->setParameters([
                                        'codClassificacao' => $codClassificacao,
                                        'codAssunto' => $codAssunto,
                                    ]);
                            },
                            'attr' => array(
                                'class' => 'select2-parameters'
                            )
                        )
                    );
                    $form->remove('codProcesso');
                    $form->add($codProcesso);
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

        /** @var Lancamento $lancamento */
        $lancamento = $this->getSubject();

        $showMapper->with('label.arrecadacaoEfetuarLancamento.dadosLancamento');

        if ($lancamento->getFkArrecadacaoLancamentoCalculos()->count() == 1) {
            /** @var Credito $credito */
            $credito = $lancamento->getFkArrecadacaoLancamentoCalculos()->last()->getFkArrecadacaoCalculo()->getFkMonetarioCredito();

            $showMapper->add(
                'credito',
                null,
                [
                    'label' => 'label.arrecadacaoEfetuarLancamento.credito',
                    'mapped' => false,
                    'template' => 'CoreBundle:Sonata/CRUD:show_custom_html.html.twig',
                    'data' => (string) $credito
                ]
            );
        } else {
            /** @var GrupoCredito $grupoCredito */
            $grupoCredito = $lancamento->getFkArrecadacaoLancamentoCalculos()->last()->getFkArrecadacaoCalculo()->getFkArrecadacaoCalculoGrupoCredito()->getFkArrecadacaoGrupoCredito();

            $showMapper->add(
                'credito',
                null,
                [
                    'label' => 'label.arrecadacaoEfetuarLancamento.credito',
                    'mapped' => false,
                    'template' => 'CoreBundle:Sonata/CRUD:show_custom_html.html.twig',
                    'data' => (string) $grupoCredito
                ]
            );
        }

        $showMapper->add(
            'situacao',
            null,
            [
                'label' => 'label.arrecadacaoEfetuarLancamento.situacao',
                'mapped' => false,
                'template' => 'CoreBundle:Sonata/CRUD:show_custom_html.html.twig',
                'data' => (string) $this->getTranslator()->trans('label.arrecadacaoEfetuarLancamento.sucessoLancamentos')
            ]
        );

        $showMapper->end();

        $showMapper->with('label.arrecadacaoEfetuarLancamento.registrosLancamento');

        $showMapper->add(
            'registros',
            null,
            [
                'label' => 'label.arrecadacaoEfetuarLancamento.situacao',
                'mapped' => false,
                'template' => 'TributarioBundle::Arrecadacao/Calculo/EfetuarLancamentos/registros.html.twig',
                'data' => $lancamento
            ]
        );

        $showMapper->end();
    }

    /**
     * @param Lancamento $lancamento
     */
    public function prePersist($lancamento)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        (new LancamentoModel($em))->salvarLancamento($lancamento, $this->getForm(), $this->request->request);
    }

    /**
     * @param Lancamento $lancamento
     */
    public function postPersist($lancamento)
    {
        $container = $this->getConfigurationPool()->getContainer();

        $container->get('session')->getFlashBag()->clear();
        if ($lancamento->getFkArrecadacaoLancamentoCalculos()->count() == 1) {
            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.arrecadacaoEfetuarLancamento.msgSucessoCredito', array('%credito%' => $lancamento->getFkArrecadacaoLancamentoCalculos()->last()->getFkArrecadacaoCalculo()->getFkMonetarioCredito()->getCodigoComposto())));
        } else {
            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.arrecadacaoEfetuarLancamento.msgSucessoGrupo', array('%grupoCredito%' => $lancamento->getFkArrecadacaoLancamentoCalculos()->last()->getFkArrecadacaoCalculo()->getFkArrecadacaoCalculoGrupoCredito()->getFkArrecadacaoGrupoCredito()->getCodigoComposto())));
        }

        $this->forceRedirect($this->generateUrl('show', ['id' => $lancamento->getCodLancamento()]));
    }
}
