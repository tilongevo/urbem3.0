<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Organograma;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Entity\Organograma\Nivel;
use Urbem\CoreBundle\Entity\Organograma\Organograma;
use Urbem\CoreBundle\Entity\Organograma\Orgao;
use Urbem\CoreBundle\Entity\Organograma\OrgaoCgm;
use Urbem\CoreBundle\Entity\Organograma\OrgaoDescricao;
use Urbem\CoreBundle\Entity\Organograma\OrgaoNivel;
use Urbem\CoreBundle\Entity\Organograma\VwOrgaoNivelView;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Model\Organograma\OrgaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class OrgaoAdmin
 *
 * @package Urbem\AdministrativoBundle\Resources\config\Sonata\Organograma
 */
class OrgaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_administrativo_organograma_orgao';
    protected $baseRoutePattern = 'administrativo/organograma/orgao';

    protected $exibirBotaoExcluir = true;

    protected $model = OrgaoModel::class;

    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'orgao'
    ];

    protected $errorData = [];

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consultar_nivel', 'consultar-nivel', [], [], [], '', [], ['POST']);
        $collection->add('consultar_superior', 'consultar-superior', [], [], [], '', [], ['POST']);
        $collection->add('consultar_orgaos', 'consultar-orgaos', [], [], [], '', [], ['POST']);
        $collection->add('consultar_sub_orgaos', 'consultar-sub-orgaos', [], [], [], '', [], ['POST']);
        $collection->add('consultar_valor_nivel', 'consultar-valor-nivel', [], [], [], '', [], ['POST']);
        $collection->add('busca_sw_cgm_pessoa_juridica', 'busca-sw-cgm-pessoa-juridica');
    }

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $subselect = clone $query;

        $subselect->resetDQLPart('select');
        $subselect->resetDQLPart('from');
        $subselect->resetDQLPart('orderBy');
        $subselect->select('o');
        $subselect->from(VwOrgaoNivelView::class, 'o');

        $subselect->orderBy('o.orgao', 'ASC');
        $subselect->setSortBy([], ['fieldName' => 'orgao']);
        $subselect->setSortOrder('ASC');

        return $subselect;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDatagrid()->getPager();
        $pager->setCountColumn(['orgao']);

        $em = $this->getModelManager()->getEntityManager($this->getClass());
        $organogramas = $em->getRepository('CoreBundle:Organograma\Organograma')->findAll();

        $organogramaList = [];
        foreach ($organogramas as $organograma) {
            $dataImplantacao = is_a($organograma->getImplantacao(), 'DateTime') ? $organograma->getImplantacao()->format('d/m/Y') : "Data de implantação não informada";

            $organogramaList[$dataImplantacao] = $organograma->getCodOrganograma();
        }

        $datagridMapper
            ->add(
                'full_text',
                'doctrine_orm_callback',
                [
                    'callback' => [
                        $this, 'getOrganogramaFilter'
                    ],
                    'field_type' => 'choice',
                    'field_options' => [
                        'choices'=> $organogramaList
                    ],
                    'operator_type' => 'sonata_type_equal',
                    'label' => 'label.orgao.codOrganograma',
                    'attr' => [
                        'class' => 'busca-orgaonograma '
                    ],
                ]
            );
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     *
     * @return bool|void
     */
    public function getOrganogramaFilter($queryBuilder, $alias, $field, $value)
    {
        $search = $this->getRequest()->query->get("filter");

        if (!$this->getRequest()->query->get('filter') || !isset($search['full_text'])) {
            $em = $this->getModelManager()->getEntityManager($this->getClass());
            $organograma = $em->getRepository('CoreBundle:Organograma\Organograma')->findOneByAtivo(true);

            $value['value'] = $organograma->getCodOrganograma();
        }

        if (!$value['value']) {
            return;
        }
        $valorBusca = (int) $value['value'];
        $ors[] = $queryBuilder->expr()->orx($alias . '.codOrganograma = ' . $queryBuilder->expr()->literal($valorBusca));
        $queryBuilder->andWhere(join(' OR ', $ors));

        return true;
    }

    /**
     * @param VwOrgaoNivelView $vwOrgaoNivelView
     *
     * @return string
     */
    public function getDescricao(VwOrgaoNivelView $vwOrgaoNivelView)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();

        /** @var Orgao $orgao */
        $orgao = $modelManager->find(Orgao::class, $vwOrgaoNivelView->getCodOrgao());

        return $orgao->getFkOrganogramaOrgaoDescricoes()->current()->getDescricao();

        return $orgao->getDescricao();
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $descricaoTemplate = '@Administrativo/Sonata/Orgao/CRUD/list__descricao.html.twig';

        $listMapper
            ->add('valor', null, ['label' => 'label.orgao.codigoComposto', 'template' => 'AdministrativoBundle::Organograma/orgaoValor.html.twig',])
            ->add('siglaOrgao', null, ['label' => 'label.orgao.siglaOrgao'])
            ->add('getDescricao', 'text', [
                'label'    => 'label.descricao',
                'template' => $descricaoTemplate
            ])
            ->add('situacao', 'boolean', ['label' => 'label.orgao.situacao'])
            ->add('_action', 'actions', [
                'actions' => [
                    'show'   => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                    'edit'   => ['template' => 'AdministrativoBundle:Sonata/Orgao/CRUD:list__action_profile.html.twig'],
                    'delete' => ['template' => 'AdministrativoBundle:Sonata/Orgao/CRUD:list__action_delete.html.twig'],
                ]
            ]);

        $search = $this->getRequest()->query->get("filter");
        if (!$this->getRequest()->query->get('filter') || !isset($search['full_text'])) {
            $em = $this->getModelManager()->getEntityManager($this->getClass());
            $organograma = $em->getRepository('CoreBundle:Organograma\Organograma')->findOneByAtivo(true);

            $this->setScriptDynamicBlock(
                $this->getScriptDynamicBlock() . "$('#filter_full_text_value').val({$organograma->getCodOrganograma()});"
            );
        }
    }

    /**
     * @param $orgao
     * @return mixed
     */
    public function getOrgaoNivelValor(VwOrgaoNivelView $orgao)
    {
        $em = $this->getModelManager()->getEntityManager($this->getClass());

        $orgaoNiveis = $em->getRepository(OrgaoNivel::class)->findByCodOrgao($orgao->getCodOrgao());

        if (!$orgaoNiveis) {
            return $orgao->getOrgao();
        }

        $orgaoNivelValor = [];

        foreach ($orgaoNiveis as $orgaoNivel) {
            $orgaoNivelValor[] = str_pad($orgaoNivel->getValor(), strlen($orgaoNivel->getFkOrganogramaNivel()->getMascaraCodigo()), '0', STR_PAD_LEFT);
        }

        return implode('.', $orgaoNivelValor);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->addToIncludeJs('/administrativo/javascripts/organograma/orgao.js');

        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $dtNow = new \DateTime();

        $fieldOptions = [];

        $fieldOptions['siglaOrgao'] = [
            'label' => 'label.orgao.siglaOrgao'
        ];

        $fieldOptions['descricao'] = [
            'label'  => 'label.descricao',
            'mapped' => false
        ];

        $fieldOptions['codOrganograma'] = [
            'label'       => 'label.orgao.codOrganograma',
            'class'       => 'CoreBundle:Organograma\Organograma',
            'placeholder' => 'label.selecione',
            'mapped'      => false,
            'attr'        => ['class' => 'select2-parameters']
        ];

        $fieldOptions['codNivel'] = [
            'label'        => 'label.orgao.codNivel',
            'class'        => 'CoreBundle:Organograma\Nivel',
            'choice_label' => 'descricao',
            'placeholder'  => 'label.selecione',
            'mapped'       => false,
            'attr'         => ['class' => 'select2-parameters']
        ];

        $fieldOptions['codOrgaoSuperior'] = [
            'label'        => 'label.orgao.codOrgaoSuperior',
            'class'        => 'CoreBundle:Organograma\Orgao',
            'choice_label' => function (Orgao $codOrgaoSuperior) {
                return $codOrgaoSuperior->getFkOrganogramaOrgaoDescricoes()->last();
            },
            'placeholder'  => 'label.selecione',
            'mapped'       => false,
            'attr'         => ['class' => 'select2-parameters']
        ];

        $fieldOptions['criacao'] = [
            'label'  => 'label.orgao.criacao',
            'format' => 'dd/MM/yyyy',
            'data'   => $dtNow
        ];

        $fieldOptions['fkCalendarioCalendarioCadastro'] = [
            'label'        => 'label.orgao.codCalendar',
            'choice_label' => 'descricao',
            'required'     => true,
            'placeholder'  => 'label.selecione',
            'attr'         => ['class' => 'select2-parameters']
        ];

        $fieldOptions['tipoNorma'] = [
            'label'        => 'label.orgao.codTipoNorma',
            'class'        => 'CoreBundle:Normas\TipoNorma',
            'placeholder'  => 'label.selecione',
            'mapped'       => false,
            'attr'         => ['class' => 'select2-parameters']
        ];

        $fieldOptions['editNorma'] = [
            'mapped' => false
        ];

        $fieldOptions['editNivel'] = [
            'mapped' => false
        ];

        $fieldOptions['fkNormasNorma'] = [
            'label'       => 'label.orgao.codNorma',
            'attr'        => ['class' => 'select2-parameters'],
            'placeholder' => 'label.selecione',
            'required'    => true,
        ];

        $fieldOptions['fkSwCgmPessoaFisica'] = [
            'label'              => 'label.orgao.numCgmPf',
            'required'           => true,
            'attr'               => ['class' => 'select2-parameters'],
            'container_css_class' => 'select2-v4-parameters ',
            'callback'           => function ($admin, $property, $value) {
                /** @var AbstractAdmin $admin */
                $datagrid = $admin->getDatagrid();

                /** @var QueryBuilder|ProxyQuery $query */
                $query = $datagrid->getQuery();

                $fkSwCgm = sprintf('%s.fkSwCgm', $query->getRootAlias());
                $query
                    ->join($fkSwCgm, 'cgm')
                    ->andWhere('LOWER(cgm.nomCgm) LIKE :nomCgm')
                    ->setParameter('nomCgm', sprintf('%%%s%%', strtolower($value)));

                $datagrid->setValue($property, null, $value);
            },
            'property'           => 'fkSwCgm.nomCgm',
            'to_string_callback' => function (SwCgmPessoaFisica $pessoaFisica, $property) {
                return sprintf('%s - %s', $pessoaFisica->getFkSwCgm()->getNumcgm(), strtoupper($pessoaFisica->getFkSwCgm()->getNomCgm()));
            }
        ];

        $fieldOptions['numCgm'] = [
            'label'    => 'label.orgao.numCgm',
            'multiple' => false,
            'required' => false,
            'mapped'   => false,
            'route'    => ['name' => 'urbem_administrativo_organograma_orgao_busca_sw_cgm_pessoa_juridica']
        ];

        $fieldOptions['desativar'] = [
            'choices'    => ['label_type_yes' => true, 'label_type_no' => false],
            'label'      => 'label.orgao.desativar',
            'data'       => false,
            'mapped'     => false,
            'expanded'   => true,
            'label_attr' => ['class' => 'checkbox-sonata'],
            'attr'       => ['class' => 'checkbox-sonata']
        ];

        $fieldOptions['inativacao'] = [
            'label'    => 'label.orgao.inativacao',
            'format'   => 'dd/MM/yyyy',
            'data'     => $dtNow,
            'required' => true
        ];

        if ($this->id($this->getSubject())) {
            /** @var EntityManager $entityManager */
            $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

            $orgao = $this->getSubject();
            $descricao = $orgao->getFkOrganogramaOrgaoDescricoes()->last();

            $orgaoModel = new OrgaoModel($entityManager);
            $info = $orgaoModel->getInfoByCodOrgao($orgao->getCodOrgao());

            foreach ($orgao->getFkOrganogramaOrgaoCgns() as $numcgm) {
                $cgmpj = $entityManager->getRepository('CoreBundle:SwCgmPessoaJuridica')->find($numcgm->getNumcgm());
                $fieldOptions['numCgm']['data'] = $cgmpj;
                break;
            }
            $nivel = $info['nivel'];

            $fieldOptions['codOrganograma']['disabled'] = true;
            $fieldOptions['codOrganograma']['data'] = $info['organograma'];
            $fieldOptions['codNivel']['disabled'] = true;
            $fieldOptions['codNivel']['data'] = $nivel;
            $fieldOptions['editNivel']['data'] = $nivel->getCodNivel();

            $fieldOptions['codOrgaoSuperior']['disabled'] = true;
            if ((isset($info['orgaoSuperior'])) && ($orgao->getCodOrgao() != $info['orgaoSuperior']->getCodOrgao())) {
                $fieldOptions['codOrgaoSuperior']['data'] = $info['orgaoSuperior'];
            }

            $fieldOptions['descricao']['data'] = $descricao->getDescricao();

            $norma = $orgao->getFkNormasNorma();
            $tipoNorma = $norma->getFkNormasTipoNorma();

            $fieldOptions['tipoNorma']['data'] = $tipoNorma;
            $fieldOptions['editNorma']['data'] = $norma->getCodNorma();
        }

        $formMapper->with('label.orgao.dadosOrgao');
        $formMapper->add('siglaOrgao', null, $fieldOptions['siglaOrgao']);
        $formMapper->add('descricao', 'text', $fieldOptions['descricao']);
        $formMapper->add('codOrganograma', 'entity', $fieldOptions['codOrganograma']);

        $formMapper->add('codNivel', 'entity', $fieldOptions['codNivel']);
        $formMapper->add('editNivel', 'hidden', $fieldOptions['editNivel']);
        $formMapper->add('codOrgaoSuperior', 'entity', $fieldOptions['codOrgaoSuperior']);

        if (!$this->id($this->getSubject())) {
            $formMapper->add(
                'nivelMode',
                'choice',
                [
                    'label' => 'label.orgao.nivelMode',
                    'mapped' => false,
                    'choices'    => ['label.orgao.automatico' => 1, 'label.orgao.manual' => 2],
                    'attr' => [
                        'class' => 'js-nivelMode '
                    ]
                ]
            );
        }

        $formMapper->add('criacao', 'sonata_type_date_picker', $fieldOptions['criacao']);
        $formMapper->add('fkCalendarioCalendarioCadastro', null, $fieldOptions['fkCalendarioCalendarioCadastro']);
        $formMapper->add('tipoNorma', 'entity', $fieldOptions['tipoNorma']);
        $formMapper->add('fkNormasNorma', null, $fieldOptions['fkNormasNorma']);
        $formMapper->add('editNorma', 'hidden', $fieldOptions['editNorma']);
        $formMapper->end();
        $formMapper->with('label.orgao.responsavelOrgao');
        $formMapper->add('fkSwCgmPessoaFisica', 'sonata_type_model_autocomplete', $fieldOptions['fkSwCgmPessoaFisica'], ['admin_code' => 'administrativo.admin.sw_cgm_pessoa_fisica']);
        $formMapper->end();
        $formMapper->with('label.orgao.dadosCgm');
        $formMapper->add('numCgm', 'autocomplete', $fieldOptions['numCgm']);
        $formMapper->end();

        if ($this->id($this->getSubject())) {
            if ($orgao->getInativacao()) {
                $container = $this->getConfigurationPool()->getContainer();
                $container->get('session')->getFlashBag()->add('error', 'Não é possível editar um órgão inativo.');
                $this->forceRedirect('/administrativo/organograma/orgao/list');
            }
            $formMapper->with('label.orgao.dadosSituacao');
            $formMapper->add('desativar', 'choice', $fieldOptions['desativar']);
            $formMapper->add('inativacao', 'sonata_type_date_picker', $fieldOptions['inativacao']);
            $formMapper->end();
        }
    }

    /**
     * @param Orgao $orgao
     */
    public function prePersist($orgao)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();

        $entityManager = $modelManager->getEntityManager($this->getClass());

        $container = $this->getConfigurationPool()->getContainer();

        $orgaoModel = new OrgaoModel($entityManager);

        $codOrgao = $orgaoModel->getProximoCodOrgao();
        $orgao->setCodOrgao($codOrgao);

        $usarValorManual = ($this->getForm()->get('nivelMode')->getData() == 2);
        $nivelManual = (int) $this->getForm()->get('editNivel')->getData();

        $numcgm = $this->getForm()->get('numCgm')->getData();
        if (!is_null($numcgm)) {
            /** @var SwCgm $swCgm */
            $swCgm = $modelManager->find(SwCgm::class, $numcgm);
            $orgaoCgm = new OrgaoCgm();
            $orgaoCgm->setFkSwCgm($swCgm);
            $orgao->addFkOrganogramaOrgaoCgns($orgaoCgm);
        }

        $descricao = $this->getForm()->get('descricao')->getData();

        $orgaoDescricao = new OrgaoDescricao();
        $orgaoDescricao->setDescricao($descricao);
        $orgao->addFkOrganogramaOrgaoDescricoes($orgaoDescricao);

        $codNivel = $this->getForm()->get('editNivel')->getData();
        $codOrganograma = $this->getForm()->get('codOrganograma')->getData();
        $codOrgaoSuperior = $this->getForm()->get('codOrgaoSuperior')->getData();

        if ($codOrgaoSuperior) {
            $codOrgaoSuperior = $codOrgaoSuperior->getCodOrgao();
        }

        /** @var Nivel $codNivel */
        $codNivel = $modelManager->findOneBy(Nivel::class, [
            'codNivel'       => $codNivel,
            'codOrganograma' => $codOrganograma
        ]);

        $niveis = $entityManager->getRepository(Nivel::class)
            ->findBy([
                'codOrganograma' => $codOrganograma->getCodOrganograma()
            ], [
                'codNivel' => 'DESC'
            ]);

        $orgaoNivelExistente = [];

        /** @var Nivel $nivel */

        foreach ($niveis as $nivel) {
            $valor = '0';
            if ($nivel->getCodNivel() == $codNivel->getCodNivel()) {
                if ($codOrgaoSuperior) {
                    $valor = $orgaoModel->getProximoValorByCodOrgao(
                        $codOrganograma->getCodOrganograma(),
                        $codOrgaoSuperior,
                        $nivel->getCodNivel()
                    );
                } else {
                    $parameters = array(
                        'codNivel' => $nivel->getCodNivel(),
                        'codOrganograma' => $codOrganograma
                    );
                    $order = $entityManager->getRepository(OrgaoNivel::class)
                        ->findBy($parameters, array('valor' => 'DESC'));

                    $orderParsed = [];
                    foreach ($order as $curOrder) {
                        $orderParsed[$curOrder->getValor()] = $curOrder->getCodOrgao();
                    }

                    ksort($orderParsed);
                    end($orderParsed);

                    $order = key($orderParsed);

                    if ($order == null) {
                        $valor = 1;
                    } else {
                        $valor = (string) ((int) $order + 1);
                    }
                }
            } elseif ($nivel->getCodNivel() <= $codNivel->getCodNivel()) {
                if ($codOrgaoSuperior) {
                    $parameters = array(
                        'codNivel' => $nivel->getCodNivel(),
                        'codOrganograma' => $codOrganograma,
                        'codOrgao' => $codOrgaoSuperior
                    );
                    $order = $entityManager->getRepository(OrgaoNivel::class)
                        ->findOneBy($parameters);

                    $valor = (string) $order->getValor();
                } else {
                    $valor = '0';
                }
            }

            if ($usarValorManual && $nivel->getCodNivel() == $nivelManual) {
                $inputName = sprintf('codNivel%d', $nivelManual);
                $valor = (int) $_REQUEST[$inputName];
            }

            $orgaoNivel = new OrgaoNivel();
            $orgaoNivel->setFkOrganogramaNivel($nivel);
            $orgaoNivel->setValor($valor);

            $orgao->addFkOrganogramaOrgaoNiveis($orgaoNivel);
        }

        $entityManager->getConnection()->beginTransaction();

        try {
            $entityManager->persist($orgao);
            if (! is_null($numcgm)) {
                $entityManager->persist($orgaoCgm);
            }
            $entityManager->persist($orgaoDescricao);
            $entityManager->persist($orgaoNivel);

            $entityManager->flush();
            $entityManager->getConnection()->commit();
        } catch (\Exception $e) {
            $entityManager->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $this->forceRedirect($this->generateUrl('list'));
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {
        $usarValorManual = ($this->getForm()->get('nivelMode')->getData() == 2);

        if ($usarValorManual) {
            $codNivel = $this->getForm()->get('editNivel')->getData();
            $codOrgaoSuperior = $this->getForm()->get('codOrgaoSuperior')->getData();
            $Organograma = $this->getForm()->get('codOrganograma')->getData();
            $inputValue = sprintf('codNivel%d', $codNivel);
            if ($this->existsOrgaoValues($codNivel, $codOrgaoSuperior, $Organograma->getCodOrganograma(), $_REQUEST[$inputValue])) {
                $error = $this->trans('label.orgao.orgaoNivelExist');
                $errorElement->with($inputValue)->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
            }
        }
    }

    /**
     * @param $codNivel
     * @param $codOrgaoSuperior
     * @param $valorManual
     * @return bool
     */
    protected function existsOrgaoValues($codNivel, $codOrgaoSuperior, $codOrganograma, $valorManual)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();

        $em = $modelManager->getEntityManager($this->getClass());

        $isOrgao = ($codNivel == 1);
        $orgaoValues = [];
        if (! $isOrgao) {
            $orgaoSuperiorValues = $em->getRepository(OrgaoNivel::class)->findByCodOrgao($codOrgaoSuperior);

            foreach ((array) $orgaoSuperiorValues as $key => $orgaoSuperiorValue) {
                $mascara = strlen($orgaoSuperiorValue->getFkOrganogramaNivel()->getMascaraCodigo());

                if ($codNivel == ($key+1)) {
                    $orgaoValues[] = str_pad($valorManual, $mascara, '0', STR_PAD_LEFT);
                    continue;
                }

                $orgaoValues[] = str_pad($orgaoSuperiorValue->getValor(), $mascara, '0', STR_PAD_LEFT);
            }
        } else {
            $orgaoValues = [$valorManual,'0','0'] ;
        }

        $codOrgao = $em->getRepository(Orgao::class)->getCodOrgao($orgaoValues, $codOrganograma);

        return (bool) $codOrgao;
    }



    /**
     * @param orgaoNivel
     * @return bool
     */
    protected function existsOrgaoNivel(OrgaoNivel $orgaoNivel)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->getModelManager();

        $em = $modelManager->getEntityManager($this->getClass());

        $nivelExist = $em->getRepository(OrgaoNivel::class)
            ->findOneBy([
                'codNivel' => $orgaoNivel->getCodNivel() ,
                'codOrganograma' => $orgaoNivel->getCodOrganograma(),
                'valor' => $orgaoNivel->getValor()
            ]);

        return (bool) $nivelExist;
    }

    /**
     * @param Orgao $orgao
     */
    public function preUpdate($orgao)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $desativar = $this->getForm()->get('desativar')->getData();
        if ($desativar) {
            $orgaoModel = new OrgaoModel($em);
            $filhos = $orgaoModel->getFilhoByCodOrgao($orgao->getCodOrgao());
            if ($filhos) {
                $container = $this->getConfigurationPool()->getContainer();
                $container->get('session')->getFlashBag()->add('error', 'Não Foi possível inativar o órgão. ' . $orgao->getDescricao()->getDescricao() . ' possui órgãos inferiores.');
                $this->forceRedirect('/administrativo/organograma/orgao/' . $orgao->getCodOrgao() . '/edit');
            }
        } else {
            $orgao->setInativacao(null);
        }

        $numcgm = $this->getForm()->get('numCgm')->getData();
        /** @var OrgaoCgm $orgaoCgm */
        $orgaoCgm = $orgao->getFkOrganogramaOrgaoCgns()->last();
        if (($numcgm != null) && (!is_object($numcgm))) {
            $add = true;
            if ($orgaoCgm) {
                $cgmAtual = $orgaoCgm->getFkSwCgm();
                if ($cgmAtual->getNumcgm() == $numcgm) {
                    $add = false;
                }
            }
            if ($add) {
                $swCgm = $em->getRepository('CoreBundle:SwCgm')->find($numcgm);
                $orgaoCgm = new OrgaoCgm();
                $orgaoCgm->setFkSwCgm($swCgm);
                $orgao->addFkOrganogramaOrgaoCgns($orgaoCgm);
            }
        } elseif ($orgaoCgm) {
            $em->remove($orgaoCgm);
            $em->flush();
        }

        $descricao = $this->getForm()->get('descricao')->getData();

        $descricaoAtual = $orgao->getFkOrganogramaOrgaoDescricoes()->last();
        if ($descricaoAtual != $descricao) {
            $orgaoDescricao = $em->getRepository(OrgaoDescricao::class)
            ->findOneBy(
                ['codOrgao' => $orgao->getCodOrgao()],
                ['timestamp' => 'DESC']
            );
            $orgaoDescricao->setDescricao($descricao);
            $em->merge($orgaoDescricao);
            $em->flush();
        }
    }

    /**
     * @param Orgao $orgao
     */
    public function postUpdate($orgao)
    {
        if ($orgao->getInativacao()) {
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('success', 'O item foi desativado com sucesso.');
            $this->forceRedirect('/administrativo/organograma/orgao/list');
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        /** @var Orgao $orgao */
        $orgao = $this->getSubject();

        if ($orgao->getInativacao()) {
            $this->exibirBotaoExcluir = false;
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $orgaoInfo = (new OrgaoModel($entityManager))->getInfoByCodOrgao($orgao->getCodOrgao());

        /** @var Organograma $organograma */
        $organograma = $orgaoInfo['organograma'];

        /** @var Nivel $nivel */
        $nivel = $orgaoInfo['nivel'];

        /** @var Orgao $orgaoSuperior */
        $orgaoSuperior = $orgaoInfo['orgaoSuperior'];

        if ($orgaoSuperior->getCodOrgao() != $this->getAdminRequestId()) {
            $orgaoSuperior = $orgaoSuperior->getFkOrganogramaOrgaoDescricoes()->last();
        } else {
            $orgaoSuperior = '';
        }

        $customValue = [
            'mapped'   => false,
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
        ];

        $showMapper
            ->with('label.orgao.dadosOrgao')
            ->add('codOrgao', null, ['label' => 'label.codigo'])
            ->add('descricao', null, ['label' => 'label.descricao'])
            ->add('organograma', null, array_merge($customValue, [
                'data'  => $organograma,
                'label' => 'label.orgao.codOrganograma',
            ]))
            ->add('codNivel', null, array_merge($customValue, [
                'data'  => $nivel,
                'label' => 'label.orgao.codNivel',
            ]))
            ->add('orgaoSuperior', null, array_merge($customValue, [
                'data'  => $orgaoSuperior,
                'label' => 'label.orgao.codOrgaoSuperior',
            ]))
            ->add('criacao', null, ['label' => 'label.orgao.criacao'])
            ->add('fkCalendarioCalendarioCadastro', 'text', ['label' => 'label.orgao.codCalendar'])
            ->add('fkNormasNorma.fkNormasTipoNorma', 'text', ['label' => 'label.orgao.codTipoNorma'])
            ->add('fkNormasNorma', 'text', ['label' => 'label.orgao.codNorma'])
            ->add('inativacao', null, ['label' => 'label.orgao.inativacao'])
            ->end();

        $showMapper
            ->with('label.orgao.responsavelOrgao')
            ->add('fkSwCgmPessoaFisica', 'text', [
                'admin_code' => 'administrativo.admin.sw_cgm_pessoa_fisica',
                'label' => 'label.orgao.numCgmPf'
            ])
            ->add('fkSwCgmPessoaFisica.fkSwCgm.foneComercial', 'text', ['label' => 'label.telefone_comercial'])
            ->add('fkSwCgmPessoaFisica.fkSwCgm.ramalComercial', 'text', ['label' => 'label.ramal'])
            ->add('fkSwCgmPessoaFisica.fkSwCgm.foneCelular', 'text', ['label' => 'label.telefone_celular'])
            ->add('fkSwCgmPessoaFisica.fkSwCgm.eMail', 'text', ['label' => 'email'])
            ->end();

        /** @var OrgaoCgm $orgaoCgm */
        $orgaoCgm = $orgao->getFkOrganogramaOrgaoCgns()->current();

        if ($orgaoCgm instanceof OrgaoCgm) {
            $swCgm = $orgaoCgm->getFkSwCgm();

            $showMapper
                ->with('label.orgao.dadosCgm')
                ->add('swCgmOrgao', null, array_merge($customValue, [
                    'data'  => $swCgm,
                    'label' => 'label.orgao.numCgm'
                ]))
                ->add('swCgmOrgao.foneResidencial', null, array_merge($customValue, [
                    'data'  => $swCgm->getFoneResidencial(),
                    'label' => 'label.telefone'
                ]))
                ->add('swCgmOrgao.ramalResidencial', null, array_merge($customValue, [
                    'data'  => $swCgm->getRamalResidencial(),
                    'label' => 'label.ramal'
                ]))
                ->add('swCgmOrgao.logradouro', null, array_merge($customValue, [
                    'data'  => $swCgm->getLogradouro(),
                    'label' => 'label.logradouro'
                ]))
                ->add('swCgmOrgao.numero', null, array_merge($customValue, [
                    'data'  => $swCgm->getNumero(),
                    'label' => 'label.numero'
                ]))
                ->add('swCgmOrgao.email', null, array_merge($customValue, [
                    'data'  => $swCgm->getEMail(),
                    'label' => 'email'
                ]))
                ->end();
        }
    }
}
