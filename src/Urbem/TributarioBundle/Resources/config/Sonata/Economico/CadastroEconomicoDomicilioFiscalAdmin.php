<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Exception;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\DomicilioFiscal;
use Urbem\CoreBundle\Entity\Economico\DomicilioInformado;
use Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioFiscal;
use Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioInformado;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwBairroLogradouro;
use Urbem\CoreBundle\Entity\SwBairro;
use Urbem\CoreBundle\Entity\SwCep;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwLogradouro;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class CadastroEconomicoDomicilioFiscalAdmin extends AbstractSonataAdmin
{
    const TIPO_DOMICILIO_IMOVEL_CADASTRADO = 'cadastrado';
    const TIPO_DOMICILIO_ENDERECO_INFORMADO = 'informado';
    const TIPO_DOMICILIOS = [
        self::TIPO_DOMICILIO_IMOVEL_CADASTRADO => 'Imóvel Cadastrado',
        self::TIPO_DOMICILIO_ENDERECO_INFORMADO => 'Endereço Informado',
    ];

    protected $baseRouteName = 'urbem_tributario_economico_cadastro_economico_domicilio_fiscal';
    protected $baseRoutePattern = 'tributario/cadastro-economico/inscricao-economica/alterar-domicilio-fiscal';
    protected $includeJs = ['/tributario/javascripts/economico/cadastro-economico-domicilio-fiscal.js'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add(
            'alterar',
            sprintf(
                '%s',
                $this->getRouterIdParameter()
            )
        );

        $routes->clearExcept(['edit', 'alterar']);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $this->populateObject($object);
        $this->saveObject($object, 'label.CadastroEconomicoDomicilioFiscalAdmin.msgSucesso');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $cadastroEconomico = $this->getSubject() ?: new CadastroEconomico();

        $fieldOptions = [];
        $fieldOptions['fkSwClassificacao'] = array(
            'class' => SwClassificacao::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                return $em->createQueryBuilder('o')
                    ->orderBy('o.codClassificacao', 'ASC');
            },
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters js-select-processo-classificacao'
            ),
            'label' => 'label.economicoCadastroEconomico.processoClassificacao',
        );

        $fieldOptions['fkSwAssunto'] = array(
            'class' => SwAssunto::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                return $em->createQueryBuilder('o')
                    ->orderBy('o.codAssunto', 'ASC');
            },
            'choice_value' => 'codAssunto',
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters js-select-processo-assunto'
            ),
            'label' => 'label.economicoCadastroEconomico.processoAssunto',
        );

        $fieldOptions['fkSwProcesso'] = [
            'class' => SwProcesso::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');
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
            'required' => false,
            'req_params' => [
                'inscricaoEconomica' => 'varJsInscricaoEconomica',
                'codClassificacao' => 'varJsCodClassificacao',
                'codAssunto' => 'varJsCodAssunto',
            ],
            'attr' => [
                'class' => 'select2-parameters js-processo',
            ],
            'label' => 'label.economicoCadastroEconomico.processo',
        ];

        $fieldOptions['tipoDomicilio'] = [
            'mapped' => false,
            'choices' => array_flip($this::TIPO_DOMICILIOS),
            'expanded' => true,
            'multiple' => false,
            'data' => $this::TIPO_DOMICILIO_IMOVEL_CADASTRADO,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata js-tipo-domicilio ',
            ],
            'label' => 'label.economicoCadastroEconomico.tipoDomicilio',
        ];

        $fieldOptions['fkImobiliarioLote'] = [
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
            'attr' => [
                'class' => 'select2-parameters js-imovel-cadastrado ',
            ],
            'label' => 'label.economicoCadastroEconomico.domicilio',
        ];

        $fieldOptions['fkSwLogradouro'] = [
            'class' => SwLogradouro::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->join('o.fkSwNomeLogradouros', 'nome_logradouro');
                $qb->where('LOWER(nome_logradouro.nomLogradouro) LIKE :nomLogradouro');
                $qb->setParameter('nomLogradouro', sprintf('%%%s%%', strtolower($term)));
                $qb->orderBy('nome_logradouro.nomLogradouro', 'ASC');

                return $qb;
            },
            'json_choice_label' => function (SwLogradouro $logradouro) {
                return $logradouro->getFkSwNomeLogradouros()->first()->getNomLogradouro();
            },
            'attr' => [
                'class' => 'select2-parameters js-endereco-informado ',
            ],
            'label' => 'label.economicoCadastroEconomico.logradouro',
        ];

        $fieldOptions['numero'] = [
            'mapped' => false,
            'attr' => [
                'class' => 'js-endereco-informado ',
            ],
            'label' => 'label.economicoCadastroEconomico.numero',
        ];

        $fieldOptions['complemento'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'js-endereco-informado ',
            ],
            'label' => 'label.economicoCadastroEconomico.complemento',
        ];

        $fieldOptions['bairro'] = [
            'class' =>  SwBairro::class,
            'mapped' => false,
            'attr' => [
                'class' => 'select2-parameters js-endereco-informado js-select-endereco-informado-bairro ',
            ],
            'label' => 'label.economicoCadastroEconomico.bairro',
        ];

        $fieldOptions['cep'] = [
            'class' =>  SwCep::class,
            'mapped' => false,
            'choice_label' => 'cep',
            'attr' => [
                'class' => 'select2-parameters js-endereco-informado js-select-endereco-informado-cep ',
            ],
            'label' => 'label.economicoCadastroEconomico.cep',
        ];

        $fieldOptions['caixaPostal'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'js-endereco-informado '
            ],
            'label' => 'label.economicoCadastroEconomico.caixaPostal',
        ];

        $fieldOptions['municipio'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'js-endereco-informado js-select-endereco-informado-municipio js-endereco-informado-disabled ',
            ],
            'label' => 'label.economicoCadastroEconomico.municipio',
        ];

        $fieldOptions['uf'] = [
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'js-endereco-informado js-select-endereco-informado-uf js-endereco-informado-disabled ',
            ],
            'label' => 'label.economicoCadastroEconomico.uf',
        ];

        if ($id) {
            $domicilioFiscal = $cadastroEconomico->getFkEconomicoDomicilioFiscais()->last();
            $domicilioInformado = $cadastroEconomico->getFkEconomicoDomicilioInformados()->last();
            if ($domicilioFiscal && $domicilioInformado) {
                $domicilioFiscal = $domicilioFiscal->getTimestamp() > $domicilioInformado->getTimestamp() ? $domicilioFiscal : false;
                $domicilioInformado = $domicilioInformado->getTimestamp() > $domicilioFiscal->getTimestamp() ? $domicilioInformado : false;
            }

            if ($domicilioFiscal) {
                $fieldOptions['tipoDomicilio']['data'] = $this::TIPO_DOMICILIO_IMOVEL_CADASTRADO;
                $fieldOptions['fkImobiliarioLote']['data'] = $domicilioFiscal->getFkImobiliarioImovel()->getfkImobiliarioImovelLotes()->last()->getFkImobiliarioLote();
            }

            if ($domicilioInformado) {
                $fieldOptions['tipoDomicilio']['data'] = $this::TIPO_DOMICILIO_ENDERECO_INFORMADO;
                $fieldOptions['fkSwLogradouro']['data'] = $domicilioInformado->getFkSwLogradouro();
                $fieldOptions['numero']['data'] = $domicilioInformado->getNumero();
                $fieldOptions['complemento']['data'] = $domicilioInformado->getComplemento();
                $fieldOptions['bairro']['data'] = $domicilioInformado->getFkSwBairroLogradouro()->getFkSwBairro();
                $fieldOptions['cep']['data'] = $domicilioInformado->getFkSwLogradouro()->getFkSwCepLogradouros()->last()->getFkSwCep()->getCep();
                $fieldOptions['caixaPostal']['data'] = $domicilioInformado->getCaixaPostal();

                $municipio = $domicilioInformado->getFkSwLogradouro()->getFkSwBairroLogradouros()->last()->getFkSwBairro()->getFkSwMunicipio();
                $fieldOptions['municipio']['data'] = sprintf('%s - %s', $municipio->getCodMunicipio(), $municipio->getNomMunicipio());

                $uf = $municipio->getFkSwUf();
                $fieldOptions['uf']['data'] = sprintf('%s - %s', $uf->getCodUf(), $uf->getNomUf());
            }

            if ($domicilioFiscal
                && $processoDomicilioFiscal = $domicilioFiscal->getFkEconomicoProcessoDomicilioFiscais()->first()) {
                $processo = $processoDomicilioFiscal->getFkSwProcesso();
                $fieldOptions['fkSwClassificacao']['data'] = $processo->getFkSwAssunto()->getFkSwClassificacao();
                $fieldOptions['fkSwAssunto']['data'] = $processo->getFkSwAssunto();
                $fieldOptions['fkSwProcesso']['data'] = $processo;
            }


            if ($domicilioInformado
                && $processoDomicilioInformado = $domicilioInformado->getFkEconomicoProcessoDomicilioInformados()->first()) {
                $processo = $processoDomicilioInformado->getFkSwProcesso();
                $fieldOptions['fkSwClassificacao']['data'] = $processo->getFkSwAssunto()->getFkSwClassificacao();
                $fieldOptions['fkSwAssunto']['data'] = $processo->getFkSwAssunto();
                $fieldOptions['fkSwProcesso']['data'] = $processo;
            }
        }

        $formMapper
            ->with('label.CadastroEconomicoDomicilioFiscalAdmin.cabecalhoCadastroEconomico')
                ->add(
                    'inscricaoEconomica',
                    null,
                    [
                        'disabled' => true,
                        'data' => $cadastroEconomico->getInscricaoEconomica(),
                        'attr' => [
                            'class' => 'js-inscricao-economica ',
                        ],
                        'label' => 'label.economicoCadastroEconomico.codInscricao',
                    ]
                )
                ->add(
                    'fkSwCgm',
                    'text',
                    [
                        'mapped' => false,
                        'disabled' => true,
                        'data' => $this->getCgm($cadastroEconomico),
                        'label' => 'label.economicoBaixaCadastroEconomico.cgm',
                    ]
                )
            ->end()
            ->with('label.CadastroEconomicoDomicilioFiscalAdmin.cabecalhoDomicilio')
                ->add('tipoDomicilio', 'choice', $fieldOptions['tipoDomicilio'])
                ->add(
                    'fkImobiliarioLote',
                    'autocomplete',
                    $fieldOptions['fkImobiliarioLote'],
                    [
                        'admin_code' => 'tributario.admin.lote'
                    ]
                )
                ->add(
                    'fkSwLogradouro',
                    'autocomplete',
                    $fieldOptions['fkSwLogradouro'],
                    [
                        'admin_code' => 'administrativo.admin.sw_logradouro'
                    ]
                )
                ->add('numero', 'text', $fieldOptions['numero'])
                ->add('complemento', 'text', $fieldOptions['complemento'])
                ->add('bairro', 'entity', $fieldOptions['bairro'])
                ->add('cep', 'entity', $fieldOptions['cep'])
                ->add('caixaPostal', 'text', $fieldOptions['caixaPostal'])
                ->add('municipio', 'text', $fieldOptions['municipio'])
                ->add('uf', 'text', $fieldOptions['uf'])
            ->end()
            ->with('label.CadastroEconomicoDomicilioFiscalAdmin.cabecalhoProcesso')
                ->add('fkSwClassificacao', 'entity', $fieldOptions['fkSwClassificacao'])
                ->add('fkSwAssunto', 'entity', $fieldOptions['fkSwAssunto'])
                ->add(
                    'fkSwProcesso',
                    'autocomplete',
                    $fieldOptions['fkSwProcesso'],
                    [
                        'admin_code' => 'administrativo.admin.processo'
                    ]
                )
            ->end();
    }

    /**
    * @param CadastroEconomico $cadastroEconomico
    * @return Urbem\CoreBundle\Entity\SwCgm
    */
    protected function getCgm(CadastroEconomico $cadastroEconomico)
    {
        if ($empresaFato = $cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaFato()) {
            return $empresaFato->getFkSwCgmPessoaFisica()->getFkSwCgm();
        }

        if ($autonomo = $cadastroEconomico->getFkEconomicoCadastroEconomicoAutonomo()) {
            return $autonomo->getFkSwCgmPessoaFisica()->getFkSwCgm();
        }

        if ($empresaDireito = $cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaDireito()) {
            return $empresaDireito->getFkSwCgmPessoaJuridica()->getFkSwCgm();
        }
    }

    /**
    * @param CadastroEconomico $object
    */
    protected function populateObject(CadastroEconomico $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();

        $cadastroEconomico = $this->getSubject() ?: new CadastroEconomico();

        $tipoDomicilio = $form->get('tipoDomicilio')->getData();
        if ($tipoDomicilio == $this::TIPO_DOMICILIO_IMOVEL_CADASTRADO) {
            $lote = $form->get('fkImobiliarioLote')->getData();
            $imovel = $lote->getFkImobiliarioImovelLotes()->first()->getFkImobiliarioImovel();
            $domicilioFiscal = (new DomicilioFiscal())->setFkImobiliarioImovel($imovel);

            $object->addFkEconomicoDomicilioFiscais($domicilioFiscal);
        }

        if ($tipoDomicilio == $this::TIPO_DOMICILIO_ENDERECO_INFORMADO) {
            $domicilioInformado = new DomicilioInformado();
            $domicilioInformado->setFkSwLogradouro($form->get('fkSwLogradouro')->getData());
            $domicilioInformado->setNumero($form->get('numero')->getData());
            $domicilioInformado->setComplemento($form->get('complemento')->getData());

            $bairroLogradouro = $em->getRepository(SwBairroLogradouro::class)->findOneBy(
                [
                    'codLogradouro' => $form->get('fkSwLogradouro')->getData()->getCodLogradouro(),
                    'codBairro' => $form->get('bairro')->getData()->getCodBairro(),
                ]
            );
            if (!$bairroLogradouro) {
                $bairroLogradouro = (new SwBairroLogradouro())
                    ->setFkSwLogradouro($form->get('fkSwLogradouro')->getData())
                    ->setFkSwBairro($form->get('bairro')->getData());
                $em->persist($bairroLogradouro);
            }

            $domicilioInformado->setFkSwBairroLogradouro($bairroLogradouro);
            $domicilioInformado->setCep($form->get('cep')->getViewData());
            $domicilioInformado->setCaixaPostal($form->get('caixaPostal')->getData());

            $object->addFkEconomicoDomicilioInformados($domicilioInformado);
        }

        $processo = $this->getForm()->get('fkSwProcesso')->getData();
        if ($processo && !empty($domicilioFiscal)) {
            $processoDomicilioFiscal = new ProcessoDomicilioFiscal();
            $processoDomicilioFiscal->setFkEconomicoDomicilioFiscal($domicilioFiscal);
            $processoDomicilioFiscal->setFkSwProcesso($processo);

            $domicilioFiscal->addFkEconomicoProcessoDomicilioFiscais($processoDomicilioFiscal);
        }

        if ($processo && !empty($domicilioInformado)) {
            $processoDomicilioInformado = new ProcessoDomicilioInformado();
            $processoDomicilioInformado->setFkEconomicoDomicilioInformado($domicilioInformado);
            $processoDomicilioInformado->setFkSwProcesso($processo);

            $domicilioInformado->addFkEconomicoProcessoDomicilioInformados($processoDomicilioInformado);
        }
    }

    /**
    * @param CadastroEconomico $object
    * @param string $label
    */
    protected function saveObject(CadastroEconomico $object, $label = '')
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $container = $this->getConfigurationPool()->getContainer();
        $em->getConnection()->beginTransaction();

        try {
            $em->persist($object);
            $em->flush();
            $em->getConnection()->commit();

            $container->get('session')
                ->getFlashBag()
                ->add(
                    'success',
                    $this->getTranslator()->trans($label)
                );
        } catch (Exception $e) {
            $em->getConnection()->rollBack();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
        } finally {
            $this->forceRedirect('/tributario/cadastro-economico/inscricao-economica/empresa-direito/list');
        }
    }
}
