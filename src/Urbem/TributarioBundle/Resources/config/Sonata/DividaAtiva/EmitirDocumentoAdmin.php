<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\DividaAtiva;

use DateTime;
use Exception;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Entity\Administracao\TipoDocumento;
use Urbem\CoreBundle\Entity\Divida\Documento;
use Urbem\CoreBundle\Entity\Divida\EmissaoDocumento;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class EmitirDocumentoAdmin extends AbstractSonataAdmin
{
    public $filtro = [];

    protected $baseRouteName = 'urbem_tributario_divida_ativa_emitir_documento';
    protected $baseRoutePattern = 'tributario/divida-ativa/emissao-documentos/emitir-documento';
    protected $includeJs = ['/tributario/javascripts/dividaAtiva/emitir-documento/emitir-documento.js'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add('filtro', 'filtro');
        $routes->add('api_documento', 'api/documento');
        $routes->add(
            'download_documento',
            sprintf(
                'documento/{id}',
                $this->getRouterIdParameter()
            )
        );

        $routes->clearExcept(['create', 'filtro', 'api_documento', 'download_documento']);
    }

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return [];
        }

        return [
            'filtro' => $this->getRequest()->get('filtro'),
        ];
    }

    /**
    * @return void
    */
    public function getLegendButtonSave()
    {
        if ($this->getRequest()->get('filtro')) {
            return ['icon' => 'search', 'text' => 'Pesquisar'];
        }

        return ['icon' => 'save', 'text' => 'Emitir Documento(s)'];
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb();

        if ($this->getRequest()->get('filtro')) {
            $this->createFiltro($formMapper);

            return;
        }

        $this->createDocumento($formMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    public function createFiltro(FormMapper $formMapper)
    {
        $fieldOptions = [];
        $fieldOptions['tipo'] = [
            'choices' => [
                'Emissão' => 'emissao',
                'Reemissão' => 'reemissao',
            ],
            'mapped' => false,
            'attr' => [
                'class' => 'js-filtro-select-tipo ',
            ],
            'label' => 'label.dividaAtivaEmitirDocumento.tipo',
        ];

        $fieldOptions['tipoDocumento'] = [
            'class' => TipoDocumento::class,
            'mapped' => false,
            'choice_label' => 'descricao',
            'required' => false,
            'label' => 'label.dividaAtivaEmitirDocumento.tipoDocumento',
        ];

        $fieldOptions['documento'] = [
            'class' => Documento::class,
            'mapped' => false,
            'required' => false,
            'route' => [
                'name' => 'urbem_tributario_divida_ativa_emitir_documento_api_documento',
            ],
            'req_params' => [
                'filtro' => 1,
                'codTipoDocumento' => 'varJsCodTipoDocumento',
            ],
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.dividaAtivaEmitirDocumento.documento',
        ];

        $fieldOptions['cgmInicial'] = [
            'class' => SwCgm::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->andWhere('(o.numcgm = :numcgm OR LOWER(o.nomCgm) LIKE :nomCgm)');
                $qb->setParameter('numcgm', (int) $term);
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));

                $qb->orderBy('o.numcgm', 'ASC');

                return $qb;
            },
            'required' => false,
            'req_params' => [
                'filtro' => 1,
            ],
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.dividaAtivaEmitirDocumento.cgmInicial',
        ];

        $fieldOptions['cgmFinal'] = [
            'class' => SwCgm::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->andWhere('(o.numcgm = :numcgm OR LOWER(o.nomCgm) LIKE :nomCgm)');
                $qb->setParameter('numcgm', (int) $term);
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));

                $qb->orderBy('o.numcgm', 'ASC');

                return $qb;
            },
            'required' => false,
            'req_params' => [
                'filtro' => 1,
            ],
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.dividaAtivaEmitirDocumento.cgmFinal',
        ];

        $fieldOptions['inscricaoMunicipalInicial'] = [
            'class' => Lote::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->join('o.fkImobiliarioImovelLotes', 'il');

                $qb->where('o.codLote >= :codLote');
                $qb->setParameter('codLote', (int) $term);

                $qb->orderBy('o.codLote', 'ASC');

                return $qb;
            },
            'json_choice_value' => function (Lote $lote) {
                return (int) $lote->getFkImobiliarioImovelLotes()->last()->getInscricaoMunicipal();
            },
            'required' => false,
            'req_params' => [
                'filtro' => 1,
            ],
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.dividaAtivaEmitirDocumento.loteInicial',
        ];

        $fieldOptions['inscricaoMunicipalFinal'] = [
            'class' => Lote::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->join('o.fkImobiliarioImovelLotes', 'il');

                $qb->where('o.codLote >= :codLote');
                $qb->setParameter('codLote', (int) $term);

                $qb->orderBy('o.codLote', 'ASC');

                return $qb;
            },
            'json_choice_value' => function (Lote $lote) {
                return (int) $lote->getFkImobiliarioImovelLotes()->last()->getInscricaoMunicipal();
            },
            'required' => false,
            'req_params' => [
                'filtro' => 1,
            ],
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.dividaAtivaEmitirDocumento.loteFinal',
        ];

        $fieldOptions['cadastroEconomicoInicial'] = [
            'class' => CadastroEconomico::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->leftJoin('o.fkEconomicoCadastroEconomicoAutonomo', 'cea');
                $qb->leftJoin('o.fkEconomicoCadastroEconomicoEmpresaFato', 'ceef');
                $qb->leftJoin('o.fkEconomicoCadastroEconomicoEmpresaDireito', 'ceed');
                $qb->join(Swcgm::class, 'cgm', 'WITH', 'COALESCE(cea.numcgm, ceef.numcgm, ceed.numcgm) = cgm.numcgm');

                $qb->andWhere('(o.inscricaoEconomica = :inscricaoEconomica OR cgm.numcgm = :numcgm OR LOWER(cgm.nomCgm) LIKE :nomCgm)');
                $qb->setParameter('inscricaoEconomica', (int) $term);
                $qb->setParameter('numcgm', (int) $term);
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));

                $qb->orderBy('cgm.numcgm', 'ASC');

                return $qb;
            },
            'required' => false,
            'req_params' => [
                'filtro' => 1,
            ],
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.dividaAtivaEmitirDocumento.cadastroEconomicoInicial',
        ];

        $fieldOptions['cadastroEconomicoFinal'] = [
            'class' => CadastroEconomico::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->leftJoin('o.fkEconomicoCadastroEconomicoAutonomo', 'cea');
                $qb->leftJoin('o.fkEconomicoCadastroEconomicoEmpresaFato', 'ceef');
                $qb->leftJoin('o.fkEconomicoCadastroEconomicoEmpresaDireito', 'ceed');
                $qb->join(Swcgm::class, 'cgm', 'WITH', 'COALESCE(cea.numcgm, ceef.numcgm, ceed.numcgm) = cgm.numcgm');

                $qb->andWhere('(o.inscricaoEconomica = :inscricaoEconomica OR cgm.numcgm = :numcgm OR LOWER(cgm.nomCgm) LIKE :nomCgm)');
                $qb->setParameter('inscricaoEconomica', (int) $term);
                $qb->setParameter('numcgm', (int) $term);
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));

                $qb->orderBy('cgm.numcgm', 'ASC');

                return $qb;
            },
            'required' => false,
            'req_params' => [
                'filtro' => 1,
            ],
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.dividaAtivaEmitirDocumento.cadastroEconomicoFinal',
        ];

        $fieldOptions['inscricaoAnoInicial'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.dividaAtivaEmitirDocumento.inscricaoAnoInicial'
        ];

        $fieldOptions['inscricaoAnoFinal'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.dividaAtivaEmitirDocumento.inscricaoAnoFinal'
        ];

        $fieldOptions['numDocumento'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'js-filtro-num-documento ',
            ],
            'label' => 'label.dividaAtivaEmitirDocumento.numDocumento'
        ];

        $formMapper
            ->with('label.dividaAtivaEmitirCarne.cabecalhoFiltro')
                ->add('tipo', 'choice', $fieldOptions['tipo'])
                ->add('tipoDocumento', 'entity', $fieldOptions['tipoDocumento'])
                ->add(
                    'documento',
                    'autocomplete',
                    $fieldOptions['documento']
                )
                ->add(
                    'cgmInicial',
                    'autocomplete',
                    $fieldOptions['cgmInicial'],
                    [
                        'admin_code' => 'core.admin.filter.sw_cgm',
                    ]
                )
                ->add(
                    'cgmFinal',
                    'autocomplete',
                    $fieldOptions['cgmFinal'],
                    [
                        'admin_code' => 'core.admin.filter.sw_cgm',
                    ]
                )
                ->add(
                    'inscricaoMunicipalInicial',
                    'autocomplete',
                    $fieldOptions['inscricaoMunicipalInicial'],
                    [
                        'admin_code' => 'tributario.admin.lote',
                    ]
                )
                ->add(
                    'inscricaoMunicipalFinal',
                    'autocomplete',
                    $fieldOptions['inscricaoMunicipalFinal'],
                    [
                        'admin_code' => 'tributario.admin.lote',
                    ]
                )
                ->add(
                    'cadastroEconomicoInicial',
                    'autocomplete',
                    $fieldOptions['cadastroEconomicoInicial'],
                    [
                        'admin_code' => 'tributario.admin.economico_cadastro_economico_empresa_fato',
                    ]
                )
                ->add(
                    'cadastroEconomicoFinal',
                    'autocomplete',
                    $fieldOptions['cadastroEconomicoFinal'],
                    [
                        'admin_code' => 'tributario.admin.economico_cadastro_economico_empresa_fato',
                    ]
                )
                ->add('inscricaoAnoInicial', 'text', $fieldOptions['inscricaoAnoInicial'])
                ->add('inscricaoAnoFinal', 'text', $fieldOptions['inscricaoAnoFinal'])
                ->add('numDocumento', 'number', $fieldOptions['numDocumento'])
            ->end();
    }

    /**
     * @param FormMapper $formMapper
     */
    public function createDocumento(FormMapper $formMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $documentos = [];
        $modelosDocumento = [];
        $tipo = !empty($this->filtro['tipo']) ? $this->filtro['tipo'] : '';
        if ($tipo == 'emissao') {
            $documentos = $em->getRepository(Documento::class)->getDocumentos($this->filtro);
            $modelosDocumento = $em->getRepository(Documento::class)->getModelosDocumento();
        }

        if ($tipo == 'reemissao') {
            $documentos = $em->getRepository(Documento::class)->getDocumentosEmitidos($this->filtro);
            $modelosDocumento = array_combine(array_column($documentos, 'nome_documento'), array_column($documentos, 'nome_arquivo_agt'));
        }

        $fieldOptions = [];
        $fieldOptions['listaDocumentos'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::DividaAtiva/EmitirDocumento/lista_documentos.html.twig',
            'data' => [
                'tipo' => $tipo,
                'documentos' => $documentos,
            ],
        ];

        $fieldOptions['modeloDocumento'] = [
            'choices' => $modelosDocumento,
            'mapped' => false,
            'label' => 'label.dividaAtivaEmitirDocumento.modelo',
        ];

        $formMapper
            ->with('label.dividaAtivaEmitirDocumento.cabecalhoRegistro')
                ->add('listaDocumentos', 'customField', $fieldOptions['listaDocumentos'])
                ->add('modeloDocumento', 'choice', $fieldOptions['modeloDocumento'])
            ->end();
    }

    public function emitirDocumentos()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $container = $this->getConfigurationPool()->getContainer();

        $em->getConnection()->beginTransaction();

        $documentos = [];
        foreach ((array) $this->getRequest()->get('documentos') as $documento) {
            if (empty($documento['emitir'])) {
                continue;
            }

            $documentos[] = $this->populateObject($documento);
        }

        $errors = array_column($documentos, 'error');
        if ($errors) {
            $container->get('session')
                ->getFlashBag()
                ->add(
                    'error',
                    sprintf(
                        '%s %s',
                        $this->getTranslator()->trans('label.dividaAtivaEmitirDocumento.erroInscricao'),
                        implode(',', $errors)
                    )
                );

            $em->getConnection()->rollback();

            return [];
        }

        $this->saveObject();

        return $documentos;
    }

    /**
    * @param array $documento
    * @return Documento
    */
    protected function populateObject(array $documento)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $container = $this->getConfigurationPool()->getContainer();

        $form = $this->getForm();

        $modeloDocumento = $em->getRepository(ModeloDocumento::class)->findOneByNomeArquivoAgt($form->get('modeloDocumento')->getViewData());

        $object = $em->getRepository(Documento::class)->findOneBy([
            'numParcelamento' => $documento['numParcelamento'],
            'codTipoDocumento' => $modeloDocumento->getCodTipoDocumento(),
            'codDocumento' => $modeloDocumento->getCodDocumento(),
        ]);

        if (!$object && $documento['tipo'] == 'reemissao') {
            return ['error' => sprintf('%d/%d', $documento['codInscricao'], $documento['exercicio'])];
        }

        if (!$object) {
            $object = new Documento();
            $object->setNumParcelamento($documento['numParcelamento']);
            $object->setCodTipoDocumento($modeloDocumento->getCodTipoDocumento());
            $object->setCodDocumento($modeloDocumento->getCodDocumento());
        }

        $emissaoDocumento = new EmissaoDocumento();
        $emissaoDocumento->setFkDividaDocumento($object);
        $emissaoDocumento->setFkAdministracaoUsuario($this->getCurrentUser());
        $emissaoDocumento->setExercicio($documento['exercicio']);

        $ultimoEmissaoDocumento = $em->getRepository(EmissaoDocumento::class)->findOneBy([], ['numDocumento' => 'DESC']);
        $ultimoNumDocumento = $ultimoEmissaoDocumento->getNumDocumento();
        $emissaoDocumento->setNumDocumento(++$ultimoNumDocumento);
        if ($documento['tipo'] == 'reemissao') {
            $emissaoDocumento->setNumDocumento($documento['numDocumento']);
        }

        $emissaoDocumento->setNumEmissao(1);
        if ($documento['tipo'] == 'reemissao') {
            $emissaoDocumentoAnterior = $em->getRepository(EmissaoDocumento::class)->findOneBy(
                [
                    'numParcelamento' => $documento['numParcelamento'],
                    'codTipoDocumento' => $documento['codTipoDocumento'],
                    'codDocumento' => $documento['codDocumento'],
                    'numDocumento' => $documento['numDocumento'],
                    'exercicio' => $documento['exercicio'],
                ],
                [
                    'numEmissao' => 'DESC',
                ]
            );

            $numEmissao = $emissaoDocumentoAnterior ? $emissaoDocumentoAnterior->getNumEmissao() : 0;
            $emissaoDocumento->setNumEmissao(++$numEmissao);
        }

        $object->addFkDividaEmissaoDocumentos($emissaoDocumento);

        $em->persist($object);

        return [
            'contribuinte' => $documento['contribuinte'],
            'documento' => $object,
            'modeloDocumento' => $modeloDocumento->getNomeArquivoAgt(),
        ];
    }

    /**
    * @return void
    */
    protected function saveObject()
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $container = $this->getConfigurationPool()->getContainer();

        try {
            $em->flush();
            $em->getConnection()->commit();

            $container->get('session')
                ->getFlashBag()
                ->add(
                    'success',
                    $this->getTranslator()->trans('label.dividaAtivaEmitirDocumento.sucesso')
                );
        } catch (Exception $e) {
            $em->getConnection()->rollBack();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.dividaAtivaEmitirDocumento.erro'));
        }
    }
}
