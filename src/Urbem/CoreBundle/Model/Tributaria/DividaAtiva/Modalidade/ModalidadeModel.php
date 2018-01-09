<?php

namespace Urbem\CoreBundle\Model\Tributaria\DividaAtiva\Modalidade;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Entity\Divida\FormaInscricao;
use Urbem\CoreBundle\Entity\Divida\Modalidade;
use Urbem\CoreBundle\Entity\Divida\ModalidadeAcrescimo;
use Urbem\CoreBundle\Entity\Divida\ModalidadeCredito;
use Urbem\CoreBundle\Entity\Divida\ModalidadeDocumento;
use Urbem\CoreBundle\Entity\Divida\ModalidadeVigencia;
use Urbem\CoreBundle\Entity\Divida\TipoModalidade;
use Urbem\CoreBundle\Entity\Monetario\Acrescimo;
use Urbem\CoreBundle\Entity\Monetario\Credito;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Tributaria\DividaAtiva\Autoridade\AutoridadeModel;

class ModalidadeModel extends AbstractModel
{
    protected $entityManager = null;

    /** @var AutoridadeRepository|null  */
    protected $repository = null;

    const ATIVO = true;
    const COD_ACAO = 1634;
    const COD_MODULO = 33;
    const COD_BIBLIOTECA = 2;
    const PAGAMENTOS = 'pagamentos';
    const INCIDENCIA_AMBOS = 'ambos';

    /**
     * AutoridadeModel constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(Modalidade::class);
    }

    /**
     * @return ArrayCollection
     */
    public function getTipoModalidades()
    {
        $tipos = $this->repository->findAllTipoModalidade();
        $rotas = new ArrayCollection();
        foreach ($tipos as $tipo) {
            $rotas->set($tipo['codTipoModalidade'], $tipo['descricao']);
        }
        return $rotas;
    }

    /**
     * @param $codModalidade
     * @param $descricao
     * @param $codTipoModalidade
     * @param $queryBuilder
     * @param $alias
     */
    public function findModalidadesBusca($codModalidade, $descricao, $codTipoModalidade, $queryBuilder, $alias)
    {
        $this->repository->findModalidadesBusca($codModalidade, $descricao, $codTipoModalidade, self::ATIVO, $queryBuilder, $alias);
    }

    /**
     * @return ArrayCollection
     */
    public function findModalidadeCreditos()
    {
        $creditos = $this->repository->findAllModalidadeCreditos();
        return $this->helperArray($creditos, 'descricao_credito', 'cod_credito');
    }

    /**
     * @param $codCredito
     * @return array|null
     */
    public function findModalidadeCredito($codCredito)
    {
        $creditos = $this->repository->findModalidadeCredito($codCredito);
        $retorno = null;
        if (!empty($creditos)) {
            $codigo  = str_pad($creditos['cod_credito'], 3, 0, STR_PAD_LEFT);
            $codigo .= '.' . str_pad($creditos['cod_natureza'], 3, 0, STR_PAD_LEFT);
            $codigo .= '.' . str_pad($creditos['cod_genero'], 2, 0, STR_PAD_LEFT);
            $codigo .= '.' . $creditos['cod_especie'];
            $retorno = [
                'chave' => $creditos['cod_credito'],
                'codigo' => $codigo,
                'valor' => $creditos['descricao_credito'],
                'hidden' =>  ['cod_credito' => $creditos['cod_credito']]
            ];
        }
        return $retorno;
    }

    /**
     * @return ArrayCollection
     */
    public function findDocumentos()
    {
        $documentos = $this->repository->findDocumentos(self::COD_ACAO);

        $arrayDocumento = new ArrayCollection();

        foreach ($documentos as $value) {
            $key = sprintf('%s-%s', $value['codDocumento'], $value['codTipoDocumento']);
            $arrayDocumento->add(['codDocumento' => $key, 'nomeDocumento' => $value['nomeDocumento']]);
        }
        return $this->helperArray($arrayDocumento->toArray(), 'nomeDocumento', 'codDocumento', false);
    }

    /**
     * @param $codDocumento
     * @param $codTipoDocumento
     * @return array|null
     */
    public function findOneDocumento($codDocumento, $codTipoDocumento)
    {
        $documento = $this->repository->findOneDocumento(self::COD_ACAO, $codDocumento, $codTipoDocumento);
        $retorno = null;
        if (!empty($documento)) {
            $retorno = [
                'chave' => sprintf('%s-%s', $documento['codDocumento'], $documento['codTipoDocumento']),
                'codigo' => $documento['codDocumento'],
                'valor' => $documento['nomeDocumento'],
                'hidden' =>  ['codDocumentoAndTipo' => sprintf('%s-%s', $documento['codDocumento'], $documento['codTipoDocumento'])]
            ];
        }
        return $retorno;
    }

    /**
     * @return ArrayCollection
     */
    public function findAllAcrescimos()
    {
        $acrescimos = $this->repository->findAllAcrescimos();
        $arrayAcrescimos = new ArrayCollection();
        foreach ($acrescimos as $value) {
            $key = sprintf('%s.%s', $value['cod_acrescimo'], $value['cod_tipo']);
            $arrayAcrescimos->add(['codAcrescimoTipo' => $key, 'descricao_acrescimo' => $value['descricao_acrescimo']]);
        }
        return $this->helperArray($arrayAcrescimos->toArray(), 'descricao_acrescimo', 'codAcrescimoTipo');
    }

    /**
     * @return ArrayCollection
     */
    public function findRegraUtilizacao()
    {
        $regraUtilizacao = $this->repository->findRegraUtilizacao(self::COD_MODULO, self::COD_BIBLIOTECA);
        return $this->buildSelectRegrasUtilizacao($regraUtilizacao);
    }

    /**
     * @param $regraUtilizacao
     * @return ArrayCollection
     */
    public function buildSelectRegrasUtilizacao($regraUtilizacao)
    {
        $arrayRegraUtilizacao = new ArrayCollection();
        foreach ($regraUtilizacao as $value) {
            $key = sprintf('%s.%s.%s', $value['codModulo'], $value['codBiblioteca'], str_pad($value['codFuncao'], 3, 0, STR_PAD_LEFT));
            $arrayRegraUtilizacao->add(['codModuloBibliFuncao' => $key, 'nomFuncao' => $value['nomFuncao']]);
        }
        return $this->helperArray($arrayRegraUtilizacao->toArray(), 'nomFuncao', 'codModuloBibliFuncao');
    }

    /**
     * @return array
     */
    public function getIncidencia()
    {
        return [
            'label.dividaAtivaModalidade.pagamentos'=> true,
            'label.dividaAtivaModalidade.inscricaoDividaCobrancas' => false,
            'label.dividaAtivaModalidade.ambos' => self::INCIDENCIA_AMBOS
        ];
    }

    /**
     * @return ArrayCollection
     */
    public function initAdmin()
    {
        $autoridadeModel = new AutoridadeModel($this->entityManager);
        $init = new ArrayCollection();
        $init->set('choiceDocumentos', $this->findDocumentos());
        $init->set('choiceCreditos', $this->findModalidadeCreditos());
        $init->set('choiceAcrecimos', $this->findAllAcrescimos());
        $init->set('choiceRegraUtilizacao', $this->findRegraUtilizacao());
        $init->set('choiceIncidencia', $this->getIncidencia());
        $init->set('choiceTipoNorma', $autoridadeModel->getAllTipoNormas());
        $init->set('choiceFundamentacaoLegal', $autoridadeModel->getFundamentacaoLegal(null)->toArray());

        return $init;
    }

    /**
     * @param $formMapper
     * @param $object
     * @param $translator
     * @return mixed
     */
    public function initAdminEdit($formMapper, $object, $label, $translator)
    {
        $modalidadeVigencia = $object->getFkDividaModalidadeVigencias()->current();
        $creditos = new ArrayCollection();
        foreach ($modalidadeVigencia->getFkDividaModalidadeCreditos() as $credito) {
            $retorno['data'] = $this->findModalidadeCredito($credito->getCodCredito());
            $creditos->add($retorno);
        }

        $acrescimosLegais = new ArrayCollection();
        foreach ($modalidadeVigencia->getFkDividaModalidadeAcrescimos() as $acrescimo) {
            $findAcrescimo = $this->entityManager->getRepository(Acrescimo::class)->findOneBy(['codAcrescimo' => $acrescimo->getCodAcrescimo(), 'codTipo' => $acrescimo->getCodTipo()]);
            $codigoAcrescimo = sprintf('%s.%s', $acrescimo->getCodAcrescimo(), $acrescimo->getCodTipo());
            $codigoRegraUtilizacao = sprintf('%s.%s.%s', $acrescimo->getCodModulo(), $acrescimo->getCodBiblioteca(), str_pad($acrescimo->getCodFuncao(), 3, 0, STR_PAD_LEFT));
            $chave = sprintf('%s.%s.%s', $codigoAcrescimo, $codigoRegraUtilizacao, (int) $acrescimo->getPagamento());
            $retorno['data'] = [
                'chave' => $chave,
                'codigo' => $codigoAcrescimo,
                'descricao' => $findAcrescimo->getDescricaoAcrescimo(),
                'incidencia' => ($acrescimo->getPagamento() ?
                    $translator->transChoice(array_search(true, $this->getIncidencia()), 0, [], 'messages') :
                    $translator->transChoice(array_search(false, $this->getIncidencia()), 0, [], 'messages')
                ),
                'regra' => sprintf('%s - %s', $codigoRegraUtilizacao, $acrescimo->getFkAdministracaoFuncao()->getNomFuncao()),
                'hidden' =>  ['codigo' => $chave]
            ];

            $acrescimosLegais->add($retorno);
        }

        $documentos = new ArrayCollection();
        foreach ($modalidadeVigencia->getFkDividaModalidadeDocumentos() as $documento) {
            $retorno['data'] = $this->findOneDocumento($documento->getCodDocumento(), $documento->getCodTipoDocumento());
            $documentos->add($retorno);
        }

        return $this->montaHiddeEdit([$creditos, $acrescimosLegais, $documentos], $formMapper, $label);
    }

    /**
     * @param $object
     * @return ArrayCollection
     */
    protected function initAdminEditDadosModalidade($object)
    {
        $modalidadeVigencia = $object->getFkDividaModalidadeVigencias()->current();
        $dados = new ArrayCollection();
        $dados->set('vigenciaDe', ['data' => null]);
        $dados->set('vigenciaAte', ['data' => null]);
        $dados->set('tipo', ['data' => null]);
        $dados->set('fundamentacaoLegal', ['data' => null]);
        $dados->set('formaInscricao', ['data' => null]);
        $dados->set('regraUtilizacaoModalidade', ['data' => null]);
        $dados->set('descricao', ['readonly' => false]);
        if (!empty($modalidadeVigencia)) {
            $dados->set('vigenciaDe', ['data' => $modalidadeVigencia->getVigenciaInicial()]);
            $dados->set('vigenciaAte', ['data' => $modalidadeVigencia->getVigenciaFinal()]);
            $dados->set('tipo', ['data' => $modalidadeVigencia->getFkNormasNorma()->getCodTipoNorma()]);
            $dados->set('fundamentacaoLegal', ['data' => $modalidadeVigencia->getFkNormasNorma()->getCodNorma()]);
            $dados->set('formaInscricao', ['data' => $modalidadeVigencia->getCodFormaInscricao()]);
            $dados->set('regraUtilizacaoModalidade', ['data' => sprintf('%s.%s.%s', $modalidadeVigencia->getFkAdministracaoFuncao()->getCodModulo(), $modalidadeVigencia->getFkAdministracaoFuncao()->getCodBiblioteca(), str_pad($modalidadeVigencia->getFkAdministracaoFuncao()->getCodFuncao(), 3, 0, STR_PAD_LEFT))]);
            $dados->set('descricao', ['readonly' => true]);
        }

        return $dados;
    }

    /**
     * @param $dados
     * @param $formMapper
     * @return mixed
     */
    protected function montaHiddeEdit($dados, $formMapper, $label)
    {
        list($creditos, $acrescimosLegais, $documentos) = $dados;
        $formMapper
            ->with($label)
                ->add(
                    'creditosEdit',
                    'hidden',
                    [
                        'data' => json_encode($creditos->toArray()),
                        'mapped' => false,
                    ]
                )
                ->add(
                    'incidenciaEdit',
                    'hidden',
                    [
                        'data' => json_encode($acrescimosLegais->toArray()),
                        'mapped' => false,
                    ]
                )
                ->add(
                    'documentosEdit',
                    'hidden',
                    [
                        'data' => json_encode($documentos->toArray()),
                        'mapped' => false,
                    ]
                )
            ->end()
        ;

        return $formMapper;
    }

    /**
     * @param $formMapper
     * @param $object
     * @param $label
     */
    public function formMapperDadosParaModalidade($formMapper, $object, $label)
    {
        $dados = $this->initAdminEditDadosModalidade($object);
        $formMapper
            ->with($label)
                ->add(
                    'vigenciaDe',
                    'sonata_type_date_picker',
                    [
                        'label' => 'label.dividaAtivaModalidade.vigenciaDe',
                        'format' => 'dd/MM/yyyy',
                        'required' => true,
                        'mapped' => false,
                        'data' => $dados->get('vigenciaDe')['data']
                    ]
                )
                ->add(
                    'vigenciaAte',
                    'sonata_type_date_picker',
                    [
                        'label' => 'label.dividaAtivaModalidade.vigenciaAte',
                        'format' => 'dd/MM/yyyy',
                        'required' => true,
                        'mapped' => false,
                        'data' => $dados->get('vigenciaAte')['data']
                    ]
                )
                ->add(
                    'descricao',
                    'text',
                    [
                        'label' => 'label.dividaAtivaModalidade.descricao',
                        'required' => true,
                        'attr' => [
                            'readonly' => $dados->get('descricao')['readonly']
                        ]
                    ]
                )
                ->add(
                    'tipo',
                    'choice',
                    [
                        'label' => 'label.dividaAtivaAutoridade.tipoNorma',
                        'choices' => $this->initAdmin()->get('choiceTipoNorma'),
                        'required' => true,
                        'mapped' => false,
                        'placeholder' => 'Selecione',
                        'data' => $dados->get('tipo')['data'],
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
                ->add(
                    'fundamentacaoLegal',
                    'choice',
                    [
                        'label' => 'label.dividaAtivaAutoridade.fundamentacaoLegal',
                        'choices' => $this->initAdmin()->get('choiceFundamentacaoLegal'),
                        'required' => true,
                        'mapped' => false,
                        'placeholder' => 'Selecione',
                        'data' => $dados->get('fundamentacaoLegal')['data'],
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
                ->add(
                    'regraUtilizacaoModalidade',
                    'choice',
                    [
                        'label' => 'label.dividaAtivaModalidade.regraUtilizacao',
                        'choices' => $this->initAdmin()->get('choiceRegraUtilizacao'),
                        'required' => true,
                        'mapped' => false,
                        'placeholder' => 'Selecione',
                        'data' => $dados->get('regraUtilizacaoModalidade')['data'],
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
            ->end()
        ;
    }

    /**
     * @param $formMapper
     * @param $label
     */
    public function formMapperCreditos($formMapper, $label)
    {
        $formMapper
            ->with($label)
                ->add(
                    'creditos',
                    'choice',
                    [
                        'label' => 'label.dividaAtivaModalidade.credito',
                        'choices' => $this->initAdmin()->get('choiceCreditos'),
                        'required' => false,
                        'mapped' => false,
                        'placeholder' => 'Selecione',
                        'help'=>'<a href="javascript://Incluir" class="white-text blue darken-4 btn btn-success incluir-registro" ><i class="material-icons left">input</i>Incluir</a>',
                        'data' => null,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
            ->end()
        ;
    }

    /**
     * @param $formMapper
     * @param $label
     */
    public function formMapperAcrescimosLegais($formMapper, $label)
    {
        $formMapper
            ->with($label)
                ->add(
                    'acrescimo',
                    'choice',
                    [
                        'label' => 'label.dividaAtivaModalidade.acrescimo',
                        'choices' => $this->initAdmin()->get('choiceAcrecimos'),
                        'required' => false,
                        'mapped' => false,
                        'placeholder' => 'Selecione',
                        'data' => null,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
                ->add(
                    'regraUtilizacao',
                    'choice',
                    [
                        'label' => 'label.dividaAtivaModalidade.regraUtilizacao',
                        'choices' => $this->initAdmin()->get('choiceRegraUtilizacao'),
                        'required' => false,
                        'mapped' => false,
                        'placeholder' => 'Selecione',
                        'data' => null,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
                ->add(
                    'incidencia',
                    'choice',
                    [
                        'label' => 'label.dividaAtivaModalidade.incidencia',
                        'choices' => $this->initAdmin()->get('choiceIncidencia'),
                        'required' => false,
                        'mapped' => false,
                        'placeholder' => 'Selecione',
                        'help'=>'<a href="javascript://Incluir" class="white-text blue darken-4 btn btn-success incluir-registro" ><i class="material-icons left">input</i>Incluir</a>',
                        'data' => null,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
            ->end()
        ;
    }

    /**
     * @param $formMapper
     * @param $label
     */
    public function formMapperDocumentos($formMapper, $label)
    {
        $formMapper
            ->with($label)
                ->add(
                    'documentos',
                    'choice',
                    [
                        'label' => 'label.dividaAtivaModalidade.documento',
                        'choices' => $this->initAdmin()->get('choiceDocumentos'),
                        'required' => false,
                        'mapped' => false,
                        'placeholder' => 'Selecione',
                        'help'=>'<a href="javascript://Incluir" class="white-text blue darken-4 btn btn-success incluir-registro" ><i class="material-icons left">input</i>Incluir</a>',
                        'data' => null,
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
            ->end()
        ;
    }

    /**
     * @param $object
     * @param $request
     * @param $childrens
     * @param $tipoModalidade
     */
    public function prePersistModel($object, $request, $childrens, $tipoModalidade)
    {
        if (empty($object->getCodModalidade())) {
            $object->setCodModalidade($this->repository->lastCodModalidade());
        }
        $object->setUltimoTimestamp(new DateTimeMicrosecondPK());
        $modalidadeVigencia = new ModalidadeVigencia();
        $norma = $this->entityManager->getRepository(Norma::class)->find($childrens['fundamentacaoLegal']->getViewData());
        $tipoModalidade = $this->entityManager->getRepository(TipoModalidade::class)->find($tipoModalidade);

        $explode = explode('/', $childrens['vigenciaDe']->getViewData());
        $data = new \DateTime($explode[2].'/'.$explode[1].'/'.$explode[0]);
        $explodeAte = explode('/', $childrens['vigenciaAte']->getViewData());
        $dataAte = new \DateTime($explodeAte[2].'/'.$explodeAte[1].'/'.$explodeAte[0]);
        $modalidadeVigencia->setVigenciaInicial($data);
        $modalidadeVigencia->setVigenciaFinal($dataAte);
        $modalidadeVigencia->setFkNormasNorma($norma);
        $modalidadeVigencia->setFkDividaModalidade($object);
        $modalidadeVigencia->setFkDividaTipoModalidade($tipoModalidade);
        $modalidadeVigencia->setTimestamp($object->getUltimoTimestamp());

        if (!empty($childrens['regraUtilizacaoModalidade']->getViewData())) {
            $explode = $explode = explode('.', $childrens['regraUtilizacaoModalidade']->getViewData());
            $funcao = $this->entityManager->getRepository(Funcao::class)->findOneBy(['codFuncao' => $explode[2], 'codModulo' => self::COD_MODULO, 'codBiblioteca' => self::COD_BIBLIOTECA]);
            $modalidadeVigencia->setFkAdministracaoFuncao($funcao);
        }

        if (!empty($request->get('creditos')['cod_credito'])) {
            foreach ($request->get('creditos')['cod_credito'] as $codCredito) {
                $credito = $this->entityManager->getRepository(Credito::class)->findOneByCodCredito($codCredito);
                if (!empty($credito)) {
                    $modalidadeCredito = new ModalidadeCredito();
                    $modalidadeCredito->setCodCredito($credito->getCodCredito());
                    $modalidadeCredito->setCodNatureza($credito->getCodNatureza());
                    $modalidadeCredito->setCodGenero($credito->getCodGenero());
                    $modalidadeCredito->setCodEspecie($credito->getCodEspecie());
                    $modalidadeCredito->setFkDividaModalidadeVigencia($modalidadeVigencia);
                    $modalidadeVigencia->addFkDividaModalidadeCreditos($modalidadeCredito);
                }
            }
        }

        if (!empty($request->get('incidencia')['codigo'])) {
            foreach ($request->get('incidencia')['codigo'] as $incidencia) {
                //Os valores estão concatenados, será retornado um array com 6 posições
                //Por posição - cod_acrescimo, tipo_acrescimo, cod_modulo, cod_biblioteca, cod_funcao, paramento (1 true, 0 false)
                $explode = explode('.', $incidencia);
                $modalidadeAcrescimo = new ModalidadeAcrescimo();

                $funcao = $this->entityManager->getRepository(Funcao::class)->findOneBy(['codFuncao' => $explode[4], 'codModulo' => self::COD_MODULO, 'codBiblioteca' => self::COD_BIBLIOTECA]);
                if (!empty($funcao)) {
                    $modalidadeAcrescimo->setFkAdministracaoFuncao($funcao);
                }
                $modalidadeAcrescimo->setCodTipo($explode[1]);
                $modalidadeAcrescimo->setCodAcrescimo($explode[0]);
                $modalidadeAcrescimo->setPagamento((bool) $explode[5]);
                $modalidadeAcrescimo->setFkDividaModalidadeVigencia($modalidadeVigencia);
                $modalidadeVigencia->addFkDividaModalidadeAcrescimos($modalidadeAcrescimo);
            }
        }

        if (!empty($request->get('documentos')['codDocumentoAndTipo'])) {
            foreach ($request->get('documentos')['codDocumentoAndTipo'] as $documentoTipo) {
                $explode = explode('-', $documentoTipo);
                $modeloDocumento = $this->entityManager->getRepository(ModeloDocumento::class)->findOneBy(['codDocumento' => $explode[0], 'codTipoDocumento' => $explode[1]]);

                if (!empty($modeloDocumento)) {
                    $modalidadeDocumento = new ModalidadeDocumento();
                    $modalidadeDocumento->setFkAdministracaoModeloDocumento($modeloDocumento);
                    $modalidadeDocumento->setFkDividaModalidadeVigencia($modalidadeVigencia);
                    $modalidadeVigencia->addFkDividaModalidadeDocumentos($modalidadeDocumento);
                }
            }
        }

        $object->addFkDividaModalidadeVigencias($modalidadeVigencia);
    }

    /**
     * @param $showMapper
     * @param $object
     * @param $label
     */
    public function showFieldsModalidade($showMapper, $object, $label)
    {
        $modalidadeVigencia = $object->getFkDividaModalidadeVigencias()->current();
        $showMapper
            ->with($label)
                ->add(
                    'codModalidade',
                    null,
                    [
                        'label' => 'label.dividaAtivaModalidade.codigo'
                    ]
                )
                ->add(
                    'vigenciaInicial',
                    null,
                    [
                        'label' => 'label.dividaAtivaModalidade.vigenciaDe',
                        'mapped' => false,
                        'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                        'data' => $modalidadeVigencia->getVigenciaInicial()->format('d/m/Y')
                    ]
                )
                ->add(
                    'vigenciaFinal',
                    null,
                    [
                        'label' => 'label.dividaAtivaModalidade.vigenciaAte',
                        'mapped' => false,
                        'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                        'data' => $modalidadeVigencia->getVigenciaFinal()->format('d/m/Y')
                    ]
                )
                ->add(
                    'descricao',
                    null,
                    [
                        'label' => 'descricao'
                    ]
                )
                ->add(
                    'fundamentacaoLegal',
                    null,
                    [
                        'label' => 'label.dividaAtivaModalidade.fundamentacaoLegal',
                        'mapped' => false,
                        'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                        'data' =>
                            sprintf(
                                '%s %s/%s - %s',
                                $modalidadeVigencia->getFkNormasNorma()->getFkNormasTipoNorma()->getNomTipoNorma(),
                                str_pad($modalidadeVigencia->getFkNormasNorma()->getNumNorma(), 6, 0, STR_PAD_LEFT),
                                $modalidadeVigencia->getFkNormasNorma()->getExercicio(),
                                $modalidadeVigencia->getFkNormasNorma()->getNomNorma()
                            )
                    ]
                )
                ->add(
                    'regraUtilizacao',
                    null,
                    [
                        'label' => 'label.dividaAtivaModalidade.regraUtilizacao',
                        'mapped' => false,
                        'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                        'data' => sprintf('%s.%s.%s - %s', $modalidadeVigencia->getFkAdministracaoFuncao()->getCodModulo(), $modalidadeVigencia->getFkAdministracaoFuncao()->getCodBiblioteca(), str_pad($modalidadeVigencia->getFkAdministracaoFuncao()->getCodFuncao(), 3, 0, STR_PAD_LEFT), $modalidadeVigencia->getFkAdministracaoFuncao()->getNomFuncao())
                    ]
                )
            ->end()
        ;
    }

    /**
     * @param $showMapper
     * @param $object
     * @param $label
     * @param $translator
     * @return bool
     */
    public function showFieldsCreditos($showMapper, $object, $label, $translator, $title)
    {
        $modalidadeVigencia = $object->getFkDividaModalidadeVigencias()->current();
        if (!empty($modalidadeVigencia)) {
            if ($modalidadeVigencia->getFkDividaModalidadeCreditos()->isEmpty()) {
                return false;
            }

            $creditos = new ArrayCollection();
            foreach ($modalidadeVigencia->getFkDividaModalidadeCreditos() as $credito) {
                $creditoFormatado = $this->findModalidadeCredito($credito->getCodCredito());
                $creditos->add([$creditoFormatado['codigo'], $creditoFormatado['valor']]);
            }

            $this->buildShowFieldsTable(
                $showMapper,
                'creditos',
                $label,
                [
                    $translator->transChoice('label.dividaAtivaModalidade.codigo', 0, [], 'messages'),
                    $translator->transChoice('label.dividaAtivaModalidade.descricao', 0, [], 'messages')
                ],
                $creditos,
                $translator->transChoice($title, 0, [], 'messages')
            );
        }
    }

    /**
     * @param $showMapper
     * @param $object
     * @param $label
     * @param $translator
     * @return bool
     */
    public function showFieldsAcrescimosLegais($showMapper, $object, $label, $translator, $title)
    {
        $acrescimosLegais = new ArrayCollection();
        $modalidadeVigencia = $object->getFkDividaModalidadeVigencias()->current();

        if (!empty($modalidadeVigencia)) {
            if ($modalidadeVigencia->getFkDividaModalidadeAcrescimos()->isEmpty()) {
                return false;
            }

            foreach ($modalidadeVigencia->getFkDividaModalidadeAcrescimos() as $acrescimo) {
                $findAcrescimo = $this->entityManager->getRepository(Acrescimo::class)->findOneBy(['codAcrescimo' => $acrescimo->getCodAcrescimo(), 'codTipo' => $acrescimo->getCodTipo()]);
                $codigoAcrescimo = sprintf('%s.%s', $acrescimo->getCodAcrescimo(), $acrescimo->getCodTipo());
                $codigoRegraUtilizacao = sprintf('%s.%s.%s', $acrescimo->getCodModulo(), $acrescimo->getCodBiblioteca(), str_pad($acrescimo->getCodFuncao(), 3, 0, STR_PAD_LEFT));
                $retorno = [
                    'codigo' => $codigoAcrescimo,
                    'descricao' => $findAcrescimo->getDescricaoAcrescimo(),
                    'incidencia' => ($acrescimo->getPagamento() ?
                        $translator->transChoice(array_search(true, $this->getIncidencia()), 0, [], 'messages') :
                        $translator->transChoice(array_search(false, $this->getIncidencia()), 0, [], 'messages')
                    ),
                    'regra' => sprintf('%s - %s', $codigoRegraUtilizacao, $acrescimo->getFkAdministracaoFuncao()->getNomFuncao()),
                ];

                $acrescimosLegais->add($retorno);
            }

            $this->buildShowFieldsTable(
                $showMapper,
                'acrescimosLegais',
                $label,
                [
                    $translator->transChoice('label.dividaAtivaModalidade.codigo', 0, [], 'messages'),
                    $translator->transChoice('label.dividaAtivaModalidade.descricao', 0, [], 'messages'),
                    $translator->transChoice('label.dividaAtivaModalidade.incidencia', 0, [], 'messages'),
                    $translator->transChoice('label.dividaAtivaModalidade.regraUtilizacao', 0, [], 'messages')
                ],
                $acrescimosLegais,
                $translator->transChoice($title, 0, [], 'messages')
            );
        }
    }

    /**
     * @param $showMapper
     * @param $object
     * @param $label
     * @param $translator
     * @return bool
     */
    public function showFieldsDocumentos($showMapper, $object, $label, $translator, $title)
    {
        $modalidadeVigencia = $object->getFkDividaModalidadeVigencias()->current();
        if (!empty($modalidadeVigencia)) {
            if ($modalidadeVigencia->getFkDividaModalidadeDocumentos()->isEmpty()) {
                return false;
            }

            $documentos = new ArrayCollection();
            foreach ($modalidadeVigencia->getFkDividaModalidadeDocumentos() as $documento) {
                $documentoFormatado = $this->findOneDocumento($documento->getCodDocumento(), $documento->getCodTipoDocumento());
                $documentos->add([$documentoFormatado['codigo'], $documentoFormatado['valor']]);
            }
            $this->buildShowFieldsTable(
                $showMapper,
                'documentos',
                $label,
                [
                    $translator->transChoice('label.dividaAtivaModalidade.codigo', 0, [], 'messages'),
                    $translator->transChoice('label.dividaAtivaModalidade.nome', 0, [], 'messages')
                ],
                $documentos,
                $translator->transChoice($title, 0, [], 'messages')
            );
        }
    }

    /**
     * @param $showMapper
     * @param $name
     * @param $label
     * @param $header
     * @param $body
     */
    protected function buildShowFieldsTable($showMapper, $name, $label, $header, $body, $title)
    {
        $dados = new ArrayCollection();
        $dados->set('title', $title);
        $dados->set('header', $header);
        $dados->set('body', $body);

        $showMapper
            ->with($label)
            ->add(
                $name,
                null,
                [
                    'mapped' => false,
                    'template' => 'TributarioBundle:DividaAtiva/Modalidade:template_custom_table.html.twig',
                    'data' => $dados
                ]
            )
            ->end()
        ;
    }

    /**
     * @param $array
     * @param $value
     * @param $key
     * @return ArrayCollection
     */
    protected function helperArray($array, $value, $key, $exibirKey = true)
    {
        $collection = new ArrayCollection();
        if (!empty($array)) {
            foreach ($array as $values) {
                if ($exibirKey) {
                    $string = sprintf('%s - %s', $values[$key], $values[$value]);
                    $collection->set($string, $values[$key]);
                } else {
                    $collection->set($values[$value], $values[$key]);
                }
            }
        }
        return $collection;
    }
}
