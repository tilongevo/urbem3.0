<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Cse;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Entity\Organograma\Nivel;
use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Entity\Organograma\OrgaoNivel;
use Urbem\CoreBundle\Entity\Organograma\VwOrgaoNivelView;
use Urbem\CoreBundle\Entity\Pessoal\Cid;
use Urbem\CoreBundle\Entity\Pessoal\Contrato;
use Urbem\CoreBundle\Entity\Pessoal\ContratoPensionista;
use Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaOrgao;
use Urbem\CoreBundle\Entity\Pessoal\ContratoPensionistaPrevidencia;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidor;
use Urbem\CoreBundle\Entity\Pessoal\Pensionista;
use Urbem\CoreBundle\Entity\Pessoal\TipoDependencia;
use Urbem\CoreBundle\Entity\Pessoal\AtributoContratoPensionista;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Model\Organograma\NivelModel;
use Urbem\CoreBundle\Model\Pessoal\PensionistaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractOrganogramaSonata as AbstractAdmin;
use Urbem\RecursosHumanosBundle\Helper\Constants\Pessoal\Pensionista as PensionistaConstants;

class PensionistaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_pensionista';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/pensionista';
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'fkSwCgmPessoaFisica.fkSwCgm.nomCgm',
    );

    /**
     * @var array
     */
    protected $orgaosSelecionados = [];

    /**
     * @var string
     */
    protected $model = PensionistaModel::class;

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->add('consultar_data_inclusao_processo', 'consultar-data-inclusao-processo', [], [], [], '', [], ['POST'])
            ->add('previdencia', 'previdencia', [], [], [], '', [], ['POST']);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(array('codContratoCedente'));

        /** @var EntityManager $entityManager */
        $entityManager = $this->getConfigurationPool()
            ->getContainer()
            ->get('doctrine')
            ->getManager();

        $formGridOptions['fkPessoalContratoServidor'] = [
            'label' => 'CGM do Servidor',
            'callback' => [
                $this,
                'getSearchFilter'
            ],
        ];

        $formGridOptions['fkPessoalContratoServidorChoices'] = [
            'class' => Contrato::class,
            'route' => [
                'name' => 'carrega_contrato_servidor_pensionista'
            ],
            'attr' => ['class' => 'select2-parameters '],
            'multiple' => false,
        ];

        $formGridOptions['codContratoPensionista'] = [
            'label' => 'CGM do Pensionista',
            'callback' => [
                $this,
                'getSearchFilter'
            ],
        ];

        $formGridOptions['codContratoPensionistaChoices'] = [
            'route' => [
                'name' => 'carrega_contrato_cgm_pensionista'
            ],
            'json_choice_label' => function ($numcgm) use ($entityManager) {
                list($registro,$num, $nomCgm) = explode("-", $numcgm);

                return sprintf('%s - %s - %s', $registro, $num, $nomCgm);
            },
            'attr' => ['class' => 'select2-parameters '],
            'multiple' => false,
        ];

        $datagridMapper
            ->add(
                'numcgm',
                'doctrine_orm_callback',
                $formGridOptions['codContratoPensionista'],
                'autocomplete',
                $formGridOptions['codContratoPensionistaChoices']
            )
            ->add(
                'codContratoCedente',
                'doctrine_orm_callback',
                $formGridOptions['fkPessoalContratoServidor'],
                'autocomplete',
                $formGridOptions['fkPessoalContratoServidorChoices']
            );
    }

    /**
     * @param string $context
     *
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->join("o.fkPessoalContratoPensionistas", "cp");
        $query->join("cp.fkPessoalContrato", "c");
        $query->leftJoin("o.fkPessoalContratoServidor", "cs");
        $query->leftJoin("cs.fkPessoalServidorContratoServidores", "scs");
        $query->leftJoin("scs.fkPessoalServidor", "s");

        return $query;
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     *
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();
        $queryBuilder->resetDQLPart('where');

        $parameters = [];

        if (isset($filter['numcgm']) && $filter['numcgm']['value'] != '') {
            list($registro, $numcgm, $nomCgm) = explode("-", $filter['numcgm']['value']);
            $queryBuilder->andWhere("{$queryBuilder->getRootAliases()[0]}.numcgm = :numcgm");
            $queryBuilder->andWhere('c.registro = :registro');
            $parameters['numcgm'] = trim($numcgm);
            $parameters['registro'] = trim($registro);
        }

        if (isset($filter['codContratoCedente']) && $filter['codContratoCedente']['value'] != '') {
            $queryBuilder->andWhere("{$queryBuilder->getRootAliases()[0]}.codContratoCedente = :codContratoCedente");
            $parameters['codContratoCedente'] = trim($filter['codContratoCedente']['value']);
        }

        if (count($parameters)) {
            $queryBuilder->setParameters($parameters);
        }

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/recursoshumanos/javascripts/pessoal/pensionista/pensionista--filtro.js',
        ]));

        $this->setBreadCrumb();

        $listMapper
            ->add(
                'matriculaPensionista',
                null,
                [
                    'label' => 'label.pensionista.matriculaPensionista'
                ]
            )
            ->add(
                'pensionista',
                null,
                [
                    'label' => 'label.pensionista.modulo'
                ]
            )
            ->add(
                'matriculaServidor',
                null,
                [
                    'label' => 'label.pensionista.matriculaServidor'
                ]
            )
            ->add(
                'servidor',
                null,
                [
                    'label' => 'label.pensionista.servidor'
                ]
            );

        $this->addActionsGrid($listMapper);
    }

    /**
     * Adiciona os atributos dinamicos ao formulario
     *
     * @param $formMapper
     */
    public function carregaAtributosDinamicos($formMapper)
    {
        $atributosDinamicos = $this->getEntityManager()->getRepository(AtributoDinamico::class)
            ->findBy([
                'codModulo' => PensionistaConstants::COD_MODULO,
                'codCadastro' => PensionistaConstants::COD_CADASTRO
            ]);

        foreach ($atributosDinamicos as $atributo) {
            $data = null;
            if ($this->id($this->getSubject())) {
                $atributoContratoPensionista = $this->getEntityManager()->getRepository(AtributoContratoPensionista::class)
                    ->findOneBy([
                        'codContrato' => $this->getSubject()->getFkPessoalContratoPensionistas()->last()->getCodContrato(),
                        'codAtributo' => $atributo->getCodAtributo(),
                        'codCadastro' => $atributo->getCodCadastro(),
                        'codModulo' => $atributo->getCodModulo()
                    ]);
                if ($atributoContratoPensionista) {
                    $data = $atributoContratoPensionista->getValor();
                }
            }

            $fieldName = 'Atributo_' . $atributo->getCodAtributo() . '_' . $atributo->getCodCadastro();
            switch ($atributo->getCodTipo()) {
                case 5:
                    $formMapper
                        ->add(
                            $fieldName,
                            'sonata_type_date_picker',
                            [
                                'label' => $atributo->getNomAtributo(),
                                'format' => 'dd/MM/yyyy',
                                'mapped' => false,
                                'required' => false,
                                'data' => ($data ? \DateTime::createFromFormat('d/m/Y', $data) : null)
                            ]
                        );
                    break;
                default:
                    $formMapper
                        ->add(
                            $fieldName,
                            'text',
                            [
                                'label' => $atributo->getNomAtributo(),
                                'mapped' => false,
                                'required' => false,
                                'data' => $data
                            ]
                        );
                    break;
            }
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setIncludeJs(array_merge(parent::getIncludeJs(), [
            '/recursoshumanos/javascripts/pessoal/pensionista/pensionista--form.js',
        ]));

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];

        $entityManager = $this->getConfigurationPool()
            ->getContainer()
            ->get('doctrine')
            ->getManager();

        $fieldOptions['fkSwCgmPessoaFisica'] = [
            'class' => SwCgmPessoaFisica::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                if (is_numeric($term)) {
                    return $repo->createQueryBuilder('o')
                        ->join('o.fkSwCgm', 's')
                        ->where('s.numcgm = :numcgm')
                        ->setParameter('numcgm', $term);
                } else {
                    return $repo->createQueryBuilder('o')
                        ->join('o.fkSwCgm', 's')
                        ->where('LOWER(s.nomCgm) LIKE :nomCgm')
                        ->setParameter('nomCgm', "%" . strtolower($term) . "%");
                }
            },
            'label' => 'label.pensionista.gerador_beneficio',
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['informacoesPensionista'] = [
            'label' => false,
            'mapped' => false,
            'data' => '',
            'template' => 'RecursosHumanosBundle:Pessoal\Pensionista:informacoesPensionista.html.twig',
        ];

        $fieldOptions['fkCseProfissao'] = [
            'class' => Cse\Profissao::class,
            'choice_label' => 'nom_profissao',
            'label' => 'label.pensionista.ocupacao',
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['codCid'] = [
            'class' => Cid::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                return $repo->createQueryBuilder('c')
                    ->where('LOWER(c.sigla) LIKE :term')
                    ->orWhere('LOWER(c.descricao) LIKE :term')
                    ->setParameter('term', "%" . strtolower($term) . "%");
            },
            'json_choice_label' => function (Cid $cid) {
                return $cid->getSigla() . " - " . $cid->getDescricao();
            },
            'label' => 'label.pensionista.cid',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['dtLaudo'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.pensionista.dtLaudo',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['fkCseGrauParentesco'] = [
            'class' => Cse\GrauParentesco::class,
            'choice_label' => 'nom_grau',
            'label' => 'label.pensionista.grau_parentesco',
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['codBanco'] = [
            'class' => Banco::class,
            'choice_label' => function ($banco) {
                return $banco->getNumBanco() . " - " . $banco->getNomBanco();
            },
            'placeholder' => 'label.selecione',
            'label' => 'label.pensionista.banco',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
        ];

        $fieldOptions['codAgencia'] = [
            'choices' => [],
            'placeholder' => 'label.selecione',
            'label' => 'label.pensionista.agencia',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'mapped' => false,
        ];

        $fieldOptions['nrConta'] = [
            'label' => 'label.pensionista.conta_corrente',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'maxlength' => 11,
                'class' => 'numero '
            ]
        ];

        $fieldOptions['codContratoCedente'] = [
            'label' => 'label.gerarAssentamento.inContrato',
            'route' => array(
                'name' => 'carrega_contrato'
            ),
            'class' => Contrato::class,
            'json_choice_label' => function ($contrato) {
                return $contrato->getRegistro()
                    . " - "
                    . $contrato->getCodContrato()
                    . " - "
                    . $contrato->getFkPessoalContratoServidor()
                        ->getFkPessoalServidorContratoServidores()->last()
                        ->getFkPessoalServidor()
                        ->getFkSwCgmPessoaFisica()
                        ->getFkSwCgm()
                        ->getNomcgm();
            },
            'mapped' => false,
            'attr' => array(
                'class' => 'select2-parameters'
            ),
        ];

        $fieldOptions['matriculaPensionista'] = [
            'label' => 'label.pensionista.matriculaPensionista',
            'mapped' => false,
            'disabled' => true,
            'data' => $entityManager->getRepository(Contrato::class)
                ->getNextRegistro(),
        ];

        $fieldOptions['numBeneficio'] = [
            'label' => 'label.pensionista.numero_beneficio',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'maxlength' => 15,
                'class' => 'numero '
            ]
        ];

        $fieldOptions['codProcesso'] = [
            'label' => 'label.pensionista.processo',
            'multiple' => false,
            'mapped' => false,
            'required' => false,
            'route' => ['name' => 'carrega_sw_processo'],
            'placeholder' => 'Selecione'
        ];

        $fieldOptions['dtInclusaoProcesso'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.pensionista.dtInclusaoProcesso',
            'mapped' => false,
            'disabled' => true,
            'required' => false,
        ];

        $fieldOptions['fkPessoalTipoDependencia'] = [
            'class' => TipoDependencia::class,
            'choice_label' => 'descricao',
            'label' => 'label.pensionista.tipo_dependencia',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
            'mapped' => false,
        ];

        $fieldOptions['percentualPagamento'] = [
            'label' => 'Percentual de Pagamento da Pensão',
            'currency' => 'BRL',
            'attr' => array(
                'class' => 'money ',
            ),
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['dtInicioBeneficio'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.pensionista.data_inicio_beneficio',
            'mapped' => false,
        ];

        $fieldOptions['dtEncerramento'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.pensionista.data_encerramento_beneficio',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['motivoEncerramento'] = [
            'label' => 'label.pensionista.motivo_encerramento',
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['codPrevidencia'] = [
            'choices' => [],
            'label' => false,
            'mapped' => false,
            'required' => false,
            'multiple' => true,
        ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['fkSwCgmPessoaFisica']['disabled'] = true;
            $fieldOptions['codContratoCedente']['disabled'] = true;
            if ($this->getSubject()->getFkPessoalPensionistaCid()) {
                $fieldOptions['codCid']['data'] = $this->getSubject()->getFkPessoalPensionistaCid()->getFkPessoalCid();
                $fieldOptions['dtLaudo']['data'] = $this->getSubject()->getFkPessoalPensionistaCid()->getDataLaudo();
            }
            $fieldOptions['codBanco']['data'] = $this->getSubject()->getFkPessoalContratoPensionistas()
                ->last()->getFkPessoalContratoPensionistaContaSalarios()
                ->last()->getFkMonetarioAgencia()->getFkMonetarioBanco();
            $fieldOptions['nrConta']['data'] = $this->getSubject()->getFkPessoalContratoPensionistas()
                ->last()->getFkPessoalContratoPensionistaContaSalarios()
                ->last()->getNrConta();
            $fieldOptions['codContratoCedente']['data'] = $this->getSubject()
                ->getFkPessoalContratoServidor()->getFkPessoalContrato();
            $fieldOptions['matriculaPensionista']['data'] = $this->getSubject()->getMatriculaPensionista();
            $fieldOptions['numBeneficio']['data'] = (int) $this->getSubject()->getFkPessoalContratoPensionistas()
                ->last()->getNumBeneficio();

            $fieldOptions['percentualPagamento']['data'] = $this->getSubject()->getFkPessoalContratoPensionistas()
                ->last()->getPercentualPagamento();

            if ($this->getSubject()->getFkPessoalContratoPensionistas()->last()->getFkPessoalContratoPensionistaProcesso()) {
                $fieldOptions['codProcesso']['data'] = $this->getSubject()->getFkPessoalContratoPensionistas()
                    ->last()->getFkPessoalContratoPensionistaProcesso()->getFkSwProcesso();
                $fieldOptions['dtInclusaoProcesso']['data'] = $this->getSubject()->getFkPessoalContratoPensionistas()
                    ->last()->getFkPessoalContratoPensionistaProcesso()->getFkSwProcesso()->getTimestamp();
            }

            $fieldOptions['fkPessoalTipoDependencia']['data'] = $this->getSubject()->getFkPessoalContratoPensionistas()
                ->last()->getFkPessoalTipoDependencia();
            $fieldOptions['dtInicioBeneficio']['data'] = $this->getSubject()->getFkPessoalContratoPensionistas()
                ->last()->getDtInicioBeneficio();
            $fieldOptions['dtEncerramento']['data'] = $this->getSubject()->getFkPessoalContratoPensionistas()
                ->last()->getDtEncerramento();
            $fieldOptions['motivoEncerramento']['data'] = $this->getSubject()->getFkPessoalContratoPensionistas()
                ->last()->getMotivoEncerramento();

            $this->executeScriptLoadData(
                $this->getOrgaoNivelByCodOrgao(
                    $this->getSubject()->getFkPessoalContratoPensionistas()
                        ->last()->getFkPessoalContratoPensionistaOrgoes()
                        ->last()->getCodOrgao()
                )
            );
        }

        $formMapper
            ->with('label.pensionista.informacoesPensionista')
            ->add(
                'fkSwCgmPessoaFisica',
                'autocomplete',
                $fieldOptions['fkSwCgmPessoaFisica'],
                [
                    'admin_code' => 'core.admin.filter.sw_cgm_pessoa_fisica'
                ]
            )
            ->add(
                'informacoesPensionista',
                'customField',
                $fieldOptions['informacoesPensionista']
            )
            ->add(
                'fkCseProfissao',
                'entity',
                $fieldOptions['fkCseProfissao']
            )
            ->add(
                'codCid',
                'autocomplete',
                $fieldOptions['codCid']
            )
            ->add(
                'dtLaudo',
                'sonata_type_date_picker',
                $fieldOptions['dtLaudo']
            )
            ->add(
                'fkCseGrauParentesco',
                'entity',
                $fieldOptions['fkCseGrauParentesco']
            )
            ->end()
            ->with('label.pensionista.informacoesBancarias')
            ->add(
                'codBanco',
                'entity',
                $fieldOptions['codBanco']
            )
            ->add(
                'codAgencia',
                'choice',
                $fieldOptions['codAgencia']
            )
            ->add(
                'nrConta',
                'text',
                $fieldOptions['nrConta']
            )
            ->end()
            ->with('label.pensionista.dadosMatri­culaGeradorBeneficio')
            ->add(
                'codContratoCedente',
                'autocomplete',
                $fieldOptions['codContratoCedente']
            )
            ->end()
            ->with('label.pensionista.dadosMatriculaPensionista')
            ->add(
                'matriculaPensionista',
                'number',
                $fieldOptions['matriculaPensionista']
            )
            ->add(
                'numBeneficio',
                'text',
                $fieldOptions['numBeneficio']
            )
            ->add(
                'codProcesso',
                'autocomplete',
                $fieldOptions['codProcesso']
            )
            ->add(
                'dtInclusaoProcesso',
                'sonata_type_date_picker',
                $fieldOptions['dtInclusaoProcesso']
            )
            ->add(
                'fkPessoalTipoDependencia',
                'entity',
                $fieldOptions['fkPessoalTipoDependencia']
            )
            ->add(
                'percentualPagamento',
                'money',
                $fieldOptions['percentualPagamento']
            )
            ->add(
                'dtInicioBeneficio',
                'sonata_type_date_picker',
                $fieldOptions['dtInicioBeneficio']
            )
            ->add(
                'dtEncerramento',
                'sonata_type_date_picker',
                $fieldOptions['dtEncerramento']
            )
            ->add(
                'motivoEncerramento',
                'textarea',
                $fieldOptions['motivoEncerramento']
            );

        $this->createFormOrganograma($formMapper, true);

        $formMapper
            ->end()
            ->with('label.previdencia')
            ->add(
                'codPrevidencia',
                'choice',
                $fieldOptions['codPrevidencia']
            )
            ->end()
            ->with('label.atributos');

        $this->carregaAtributosDinamicos($formMapper);

        $formMapper
            ->end();

        $admin = $this;
        $formMapper->getFormBuilder()
            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                function (FormEvent $event) use ($formMapper, $admin, $entityManager, $fieldOptions) {
                    $form = $event->getForm();
                    $data = $event->getData();

                    if (isset($data['codBanco']) && $data['codBanco'] != "") {
                        $fieldOptions['codAgencia']['auto_initialize'] = false;
                        $fieldOptions['codAgencia']['choices'] = (new PensionistaModel($entityManager))
                            ->getAgenciasByCodBanco($data['codBanco'], true);

                        $codAgencia = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                            'codAgencia',
                            'choice',
                            null,
                            $fieldOptions['codAgencia']
                        );

                        $form->add($codAgencia);
                    }

                    if (isset($data['fkSwCgmPessoaFisica']) && $data['fkSwCgmPessoaFisica'] != "") {
                        $contratoServidor = $entityManager->getRepository(ContratoServidor::class)
                            ->findOneByNumcgm($data['fkSwCgmPessoaFisica']);

                        $codContrato = null;
                        if ($contratoServidor) {
                            $codContrato = $contratoServidor->getCodContrato();
                        }

                        $fieldOptions['codPrevidencia']['auto_initialize'] = false;
                        $fieldOptions['codPrevidencia']['choices'] = (new PensionistaModel($entityManager))
                            ->getPrevidencias($codContrato, true);

                        $codPrevidencia = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                            'codPrevidencia',
                            'choice',
                            null,
                            $fieldOptions['codPrevidencia']
                        );

                        $form->add($codPrevidencia);
                    }
                }
            )
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event) use ($formMapper, $admin, $entityManager, $fieldOptions) {
                    $form = $event->getForm();
                    $data = $event->getData();

                    if ($this->id($this->getSubject())) {
                        $codBanco = $this->getSubject()->getFkPessoalContratoPensionistas()
                            ->last()->getFkPessoalContratoPensionistaContaSalarios()
                            ->last()->getFkMonetarioAgencia()->getFkMonetarioBanco()
                            ->getCodBanco();

                        $fieldOptions['codAgencia']['auto_initialize'] = false;
                        $fieldOptions['codAgencia']['choices'] = (new PensionistaModel($entityManager))
                            ->getAgenciasByCodBanco($codBanco, true);
                        $fieldOptions['codAgencia']['data'] = $this->getSubject()->getFkPessoalContratoPensionistas()
                            ->last()->getFkPessoalContratoPensionistaContaSalarios()
                            ->last()->getFkMonetarioAgencia()
                            ->getCodAgencia();

                        $codAgencia = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                            'codAgencia',
                            'choice',
                            null,
                            $fieldOptions['codAgencia']
                        );

                        $form->add($codAgencia);

                        $contratoServidor = $entityManager->getRepository(ContratoServidor::class)
                            ->findOneByNumcgm($this->getSubject()->getNumcgm());

                        $codContrato = null;
                        if ($contratoServidor) {
                            $codContrato = $contratoServidor->getCodContrato();
                        }

                        $fieldOptions['codPrevidencia']['auto_initialize'] = false;
                        $fieldOptions['codPrevidencia']['choices'] = (new PensionistaModel($entityManager))
                            ->getPrevidencias($codContrato, true);

                        /**
                         * @TODO Verificar se existe mais de uma previdencia.
                         */
                        if (!$this->getSubject()->getFkPessoalContratoPensionistas()->last()->getFkPessoalContratoPensionistaPrevidencias()->isEmpty()) {
                            $fieldOptions['codPrevidencia']['data'] = [
                                $this->getSubject()->getFkPessoalContratoPensionistas()->last()->getFkPessoalContratoPensionistaPrevidencias()->last()->getCodPrevidencia()
                            ];
                        }

                        $codPrevidencia = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                            'codPrevidencia',
                            'choice',
                            null,
                            $fieldOptions['codPrevidencia']
                        );

                        $form->add($codPrevidencia);
                    }
                }
            );
    }

    /**
     * @param ShowMapper $showMapper
     */
    public function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $template = 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig';

        $fieldOptions = [];

        $entityManager = $this->getConfigurationPool()
            ->getContainer()
            ->get('doctrine')
            ->getManager();

        $fieldOptions['fkSwCgmPessoaFisica'] = [
            'label' => 'label.pensionista.gerador_beneficio',
            'template' => $template,
            'mapped' => false,
        ];

        $fieldOptions['informacoesPensionista'] = [
            'label' => false,
            'mapped' => false,
            'data' => '',
            'template' => 'RecursosHumanosBundle:Pessoal\Pensionista:informacoesPensionista.html.twig',
        ];

        $fieldOptions['fkCseProfissao'] = [
            'class' => Cse\Profissao::class,
            'choice_label' => 'nom_profissao',
            'label' => 'label.pensionista.ocupacao',
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['codCid'] = [
            'label' => 'label.pensionista.cid',
        ];

        $fieldOptions['dtLaudo'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.pensionista.dtLaudo',
            'mapped' => false,
        ];

        $fieldOptions['fkCseGrauParentesco'] = [
            'label' => 'label.pensionista.grau_parentesco',
        ];

        $fieldOptions['codBanco'] = [
            'label' => 'label.pensionista.banco',
            'mapped' => false,
            'template' => $template
        ];

        $fieldOptions['codAgencia'] = [
            'label' => 'label.pensionista.agencia',
            'mapped' => false,
            'template' => $template
        ];

        $fieldOptions['nrConta'] = [
            'label' => 'label.pensionista.conta_corrente',
            'mapped' => false,
            'template' => $template
        ];

        $fieldOptions['codContratoCedente'] = [
            'label' => 'label.gerarAssentamento.inContrato',
            'mapped' => false,
            'template' => $template
        ];

        $fieldOptions['matriculaPensionista'] = [
            'label' => 'label.pensionista.matriculaPensionista',
            'mapped' => false,
            'template' => $template
        ];

        $fieldOptions['numBeneficio'] = [
            'label' => 'label.pensionista.numero_beneficio',
            'mapped' => false,
            'required' => false,
            'template' => $template
        ];

        $fieldOptions['codProcesso'] = [
            'label' => 'label.pensionista.processo',
            'mapped' => false,
            'template' => $template
        ];

        $fieldOptions['dtInclusaoProcesso'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.pensionista.dtInclusaoProcesso',
            'mapped' => false,
            'template' => $template
        ];

        $fieldOptions['fkPessoalTipoDependencia'] = [
            'template' => $template,
            'label' => 'label.pensionista.tipo_dependencia',
            'mapped' => false,
        ];

        $fieldOptions['percentualPagamento'] = [
            'label' => 'Percentual de Pagamento da Pensão',
            'template' => $template,
            'mapped' => false,
        ];

        $fieldOptions['dtInicioBeneficio'] = [
            'label' => 'label.pensionista.data_inicio_beneficio',
            'mapped' => false,
            'template' => $template
        ];

        $fieldOptions['dtEncerramento'] = [
            'label' => 'label.pensionista.data_encerramento_beneficio',
            'mapped' => false,
            'template' => $template
        ];

        $fieldOptions['motivoEncerramento'] = [
            'label' => 'label.pensionista.motivo_encerramento',
            'mapped' => false,
            'template' => $template
        ];

        $fieldOptions['codPrevidencia'] = [
            'label' => 'Previdência',
            'mapped' => false,
            'template' => $template
        ];

        /** @var Pensionista $pensionista */
        $pensionista = $this->getSubject();
        /** @var SwCgmPessoaFisica $cgmPf */
        $cgmPf = $pensionista->getFkSwCgmPessoaFisica();
        $cgm = $cgmPf->getNumcgm() . ' - ' . $cgmPf->getFkSwCgm()->getNomCgm();
        $fieldOptions['fkSwCgmPessoaFisica']['data'] = $cgm;

        $fieldOptions['dtNascimento'] = [
            'label' => 'label.servidor.datanascimento',
            'mapped' => false,
            'data' => $cgmPf->getDtNascimento()->format('d/m/Y'),
            'template' => $template
        ];

        $fieldOptions['sexo'] = [
            'label' => 'label.servidor.sexo',
            'mapped' => false,
            'data' => (strtoupper($cgmPf->getSexo()) == 'M') ? 'Masculino' : 'Feminino',
            'template' => $template
        ];

        $fieldOptions['rg'] = [
            'label' => 'label.servidor.rg',
            'mapped' => false,
            'data' => $cgmPf->getRg(),
            'template' => $template
        ];

        $fieldOptions['cpf'] = [
            'label' => 'label.servidor.cpf',
            'mapped' => false,
            'data' => $cgmPf->getCpf(),
            'template' => $template
        ];

        $fieldOptions['endereco'] = [
            'label' => 'label.servidor.endereco',
            'mapped' => false,
            'data' => $cgmPf->getFkSwCgm()->getLogradouroCompleto(),
            'template' => $template
        ];

        $fieldOptions['telResidencial'] = [
            'label' => 'label.telefone_residencial',
            'mapped' => false,
            'data' => $cgmPf->getFkSwCgm()->getFoneResidencial(),
            'template' => $template
        ];

        $fieldOptions['telCelular'] = [
            'label' => 'label.telefone_celular',
            'mapped' => false,
            'data' => $cgmPf->getFkSwCgm()->getFoneCelular(),
            'template' => $template
        ];

        $fieldOptions['codBanco']['data'] = $pensionista->getFkPessoalContratoPensionistas()
            ->last()->getFkPessoalContratoPensionistaContaSalarios()
            ->last()->getFkMonetarioAgencia()->getFkMonetarioBanco();
        $fieldOptions['nrConta']['data'] = $pensionista->getFkPessoalContratoPensionistas()
            ->last()->getFkPessoalContratoPensionistaContaSalarios()
            ->last()->getNrConta();
        $fieldOptions['codAgencia']['data'] = $pensionista->getFkPessoalContratoPensionistas()
            ->last()->getFkPessoalContratoPensionistaContaSalarios()
            ->last()->getFkMonetarioAgencia();

        $numCgm = $pensionista
            ->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getNumCgm();
        $nomCgm = $pensionista
            ->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()->getFkPessoalServidor()->getFkSwCgmPessoaFisica()->getFkSwCgm()->getNomCgm();
        $fieldOptions['codContratoCedente']['data'] = $numCgm . " - " . $nomCgm;

        $fieldOptions['matriculaPensionista']['data'] = $pensionista->getMatriculaPensionista();
        $fieldOptions['numBeneficio']['data'] = (int) $pensionista->getFkPessoalContratoPensionistas()
            ->last()->getNumBeneficio();

        $fieldOptions['percentualPagamento']['data'] = $pensionista->getFkPessoalContratoPensionistas()
            ->last()->getPercentualPagamento();

        if ($pensionista->getFkPessoalContratoPensionistas()->last()->getFkPessoalContratoPensionistaProcesso()) {
            $fieldOptions['codProcesso']['data'] = $pensionista->getFkPessoalContratoPensionistas()
                ->last()->getFkPessoalContratoPensionistaProcesso()->getFkSwProcesso();
            $fieldOptions['dtInclusaoProcesso']['data'] = $pensionista->getFkPessoalContratoPensionistas()
                ->last()->getFkPessoalContratoPensionistaProcesso()->getFkSwProcesso()->getTimestamp()->format('d/m/Y');
        }

        $fieldOptions['fkPessoalTipoDependencia']['data'] = $pensionista->getFkPessoalContratoPensionistas()
            ->last()->getFkPessoalTipoDependencia()->getDescricao();
        $fieldOptions['dtInicioBeneficio']['data'] = $pensionista->getFkPessoalContratoPensionistas()
            ->last()->getDtInicioBeneficio()->format('d/m/Y');
        $fieldOptions['dtEncerramento']['data'] =
            !empty($pensionista->getFkPessoalContratoPensionistas()
                ->last()->getDtEncerramento()) ? $pensionista->getFkPessoalContratoPensionistas()
                ->last()->getDtEncerramento()->format('d/m/Y') : '';
        $fieldOptions['motivoEncerramento']['data'] = $pensionista->getFkPessoalContratoPensionistas()
            ->last()->getMotivoEncerramento();

        /** @var ContratoPensionista $contratoPensionista */
        $contratoPensionista = $pensionista->getFkPessoalContratoPensionistas()->last();
        /** @var ContratoPensionistaOrgao $contratoPensionistaOrgao */
        $contratoPensionistaOrgao = $contratoPensionista->getFkPessoalContratoPensionistaOrgoes()->last();
        $fieldOptions['orgao']['data'] = 'aa';

        $orgao = $contratoPensionistaOrgao->getFkOrganogramaOrgao();

        /** @var OrgaoNivel $orgaoNivel */
        $orgaoNivel = $orgao->getFkOrganogramaOrgaoNiveis()->first();

        $organograma = $orgaoNivel->getFkOrganogramaNivel()->getFkOrganogramaOrganograma();

        $niveis = (new NivelModel($entityManager))->findByOrganograma($organograma);

        /** @var VwOrgaoNivelView $vwOrgaoNivelView */
        $vwOrgaoNivelView = $entityManager->find(VwOrgaoNivelView::class, $orgao->getCodOrgao());

        $niveis = $niveis->filter(function (Nivel $nivel) use ($vwOrgaoNivelView) {
            return $nivel->getCodNivel() <= $vwOrgaoNivelView->getNivel();
        });

        $orgaosAtrelados = $entityManager->getRepository(Orgao::class)
            ->getOrgaosSuperiores(
                $orgao->getCodOrgao(),
                $organograma->getCodOrganograma(),
                $vwOrgaoNivelView->getNivel()
            );
        $orgaosAtrelados = new ArrayCollection($orgaosAtrelados);

        /** @var Nivel $nivel */
        foreach ($niveis as $index => $nivel) {
            $vwOrgaoNivelViewAtrelado = $orgaosAtrelados->filter(function ($nivelArray) use ($nivel) {
                return $nivel->getCodNivel() == $nivelArray->nivel;
            });
            $vwOrgaoNivelViewAtrelado = $vwOrgaoNivelViewAtrelado->toArray();
            $vwOrgaoNivelViewAtrelado = reset($vwOrgaoNivelViewAtrelado);

            $niveis[$index]->fkOrganogramaOrgao =
                $entityManager->find(Orgao::class, $vwOrgaoNivelViewAtrelado->cod_orgao);
        }

        $pensionista->vwOrgaoNivelView = $vwOrgaoNivelView;
        $pensionista->niveis = $niveis;

        $fieldOptions['orgaos'] = [
            'template' => 'RecursosHumanosBundle:Sonata\Pessoal\Pensionista\CRUD:informacoes_adicionais.html.twig',
            'data' => $pensionista
        ];
        /** @var ContratoPensionistaPrevidencia $previdencia */
        $previdencia = $pensionista->getFkPessoalContratoPensionistas()->last()->getFkPessoalContratoPensionistaPrevidencias()->last();
        $arrayPrevidencia = [];
        if (!empty($previdencia)) {
            $previdencia = $previdencia->getFkFolhapagamentoPrevidencia()->getCodPrevidencia() . " - " . $previdencia->getFkFolhapagamentoPrevidencia()->getFkFolhapagamentoPrevidenciaPrevidencias()->last()->getDescricao();
        }
        $fieldOptions['codPrevidencia']['data'] = $previdencia;

        $atributosDinamicos = $this->getEntityManager()->getRepository(AtributoDinamico::class)
            ->findBy([
                'codModulo' => PensionistaConstants::COD_MODULO,
                'codCadastro' => PensionistaConstants::COD_CADASTRO
            ]);
        $atributoArray = [];
        foreach ($atributosDinamicos as $atributo) {
            $data = null;
            if ($this->id($this->getSubject())) {
                $atributoContratoPensionista = $this->getEntityManager()->getRepository(AtributoContratoPensionista::class)
                    ->findOneBy([
                        'codContrato' => $this->getSubject()->getFkPessoalContratoPensionistas()->last()->getCodContrato(),
                        'codAtributo' => $atributo->getCodAtributo(),
                        'codCadastro' => $atributo->getCodCadastro(),
                        'codModulo' => $atributo->getCodModulo()
                    ]);
                if ($atributoContratoPensionista) {
                    $data = $atributoContratoPensionista->getValor();
                }
            }

            $atributoArray[] = [
                'nome' => $atributo->getNomAtributo(),
                'valor' => $data,
            ];
        }

        $pensionista->atributos = $atributoArray;

        $fieldOptions['atributos'] = [
            'template' => 'RecursosHumanosBundle:Sonata\Pessoal\Pensionista\CRUD:atributos_dinamicos.html.twig',
            'data' => $atributoArray
        ];
        $showMapper->with('label.pensionista.informacoesPensionista')
            ->add('nomCgm', null, $fieldOptions['fkSwCgmPessoaFisica'])
            ->add('dtNascimento', null, $fieldOptions['dtNascimento'])
            ->add('sexo', null, $fieldOptions['sexo'])
            ->add('rg', null, $fieldOptions['rg'])
            ->add('cpf', null, $fieldOptions['cpf'])
            ->add('endereco', null, $fieldOptions['endereco'])
            ->add('telResidencial', null, $fieldOptions['telResidencial'])
            ->add('telCelular', null, $fieldOptions['telCelular'])
            ->add('fkCseProfissao.nomProfissao', null, $fieldOptions['fkCseProfissao'])
            ->add('fkPessoalPensionistaCid.fkPessoalCid.descricao', null, $fieldOptions['codCid'])
            ->add('fkPessoalPensionistaCid.fkPessoalCid.dataLaudo', null, $fieldOptions['dtLaudo'])
            ->add('fkCseGrauParentesco.nomGrau', null, $fieldOptions['fkCseGrauParentesco'])
            ->end()
            ->with('label.pensionista.informacoesBancarias')
            ->add('fkPessoalContratoPensionistas.fkPessoalContratoPensionistaContaSalarios.fkMonetarioAgencia.fkMonetarioBanco', null, $fieldOptions['codBanco'])
            ->add('codAgencia', 'choice', $fieldOptions['codAgencia'])
            ->add('nrConta', 'text', $fieldOptions['nrConta'])
            ->end()
            ->with('label.pensionista.dadosMatri­culaGeradorBeneficio')
            ->add('nomeContratoCedente', null, $fieldOptions['codContratoCedente'])
            ->end()
            ->with('label.pensionista.dadosMatriculaPensionista')
            ->add('matriculaPensionista', null, $fieldOptions['matriculaPensionista'])
            ->add('fkPessoalContratoPensionistas.numBeneficio', null, $fieldOptions['numBeneficio'])
            ->add('codProcesso', 'autocomplete', $fieldOptions['codProcesso'])
            ->add('dtInclusaoProcesso', 'sonata_type_date_picker', $fieldOptions['dtInclusaoProcesso'])
            ->add('fkPessoalContratoPensionistas.fkPessoalTipoDependencia', null, $fieldOptions['fkPessoalTipoDependencia'])
            ->add('fkPessoalContratoPensionistas.percentualPagamento', null, $fieldOptions['percentualPagamento'])
            ->add('dtInicioBeneficio', 'sonata_type_date_picker', $fieldOptions['dtInicioBeneficio'])
            ->add('dtEncerramento', 'sonata_type_date_picker', $fieldOptions['dtEncerramento'])
            ->add('motivoEncerramento', 'textarea', $fieldOptions['motivoEncerramento'])
            ->end()
            ->with('label.pensionista.dadosOrgaos')
            ->add('orgaos', null, $fieldOptions['orgaos'])
            ->end()
            ->with('label.previdencia')
            ->add('codPrevidencia', null, $fieldOptions['codPrevidencia'])
            ->end()
            ->with('label.atributos')
            ->add('atributos', null, $fieldOptions['atributos'])
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist($object)
    {
        $entityManager = $this->getEntityManager();

        $fkPessoalContratoServidor = $this->getForm()->get('codContratoCedente')->getData()
            ->getFkPessoalContratoServidor();

        $codPensionista = $entityManager->getRepository(Pensionista::class)
            ->getNextCodPensionista($fkPessoalContratoServidor->getCodContrato());
        $object->setCodPensionista($codPensionista);
        $object->setFkPessoalContratoServidor($fkPessoalContratoServidor);
    }

    /**
     * {@inheritdoc}
     */
    public function postPersist($object)
    {
        $entityManager = $this->getEntityManager();

        (new PensionistaModel($entityManager))
            ->manualPersist($object, $this->getForm(), $this->getOrgaoSelected());
    }

    /**
     * {@inheritdoc}
     */
    public function postUpdate($object)
    {
        $entityManager = $this->getEntityManager();

        (new PensionistaModel($entityManager))
            ->manualUpdate($object, $this->getForm(), $this->getOrgaoSelected());
    }

    /**
     * @param ErrorElement $errorElement
     * @param Pensionista  $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        /** @var ContratoServidor $fkPessoalContratoServidor */
        $fkPessoalContratoServidor = $this->getForm()->get('codContratoCedente')->getData()
            ->getFkPessoalContratoServidor();
        /** @var EntityManager $entityManager */
        $entityManager = $this->getEntityManager();
        /** @var Pensionista $pensionista */
        $pensionista = $entityManager->getRepository(Pensionista::class)->findOneBy(
            [
                'codContratoCedente' => $fkPessoalContratoServidor->getCodContrato(),
                'numcgm' => $object->getNumcgm()
            ]
        );

        if (is_object($pensionista)) {
            $message = $this->getTranslator()->trans(
                'pensionista.errors.cgmJaCadastrado',
                [
                    '%cgm%' => $pensionista->getFkPessoalContratoServidor()->getFkPessoalServidorContratoServidores()->last()->getFkPessoalServidor()->getFkSwCgmPessoaFisica()
                        ->getFkSwCgm(),
                    '%pensionista%' => $pensionista->getFkSwCgmPessoaFisica()->getFkSwCgm()
                ],
                'validators'
            );
            $errorElement->with('codContratoCedente')->addViolation($message)->end();
        }
    }
}
