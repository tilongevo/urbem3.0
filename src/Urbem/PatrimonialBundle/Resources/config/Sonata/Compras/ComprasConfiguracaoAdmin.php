<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\ORM;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoEntidadeModel;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Administracao\ModuloModel;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

class ComprasConfiguracaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_configuracao';

    protected $baseRoutePattern = 'patrimonial/compras/configuracao';

    protected $exibirBotaoIncluir = false;

    protected $urlReferer = false;

    protected $exibirBotaoEditar = false;

    protected $exibirBotaoExcluir = false;

    protected $customBodyTemplate = '';

    /**
     * Lista Customizada
     *
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface|\Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery
     */
    public function createQuery($context = 'list')
    {
        $entityManager = $this->modelManager->getEntityManager(Configuracao::class);
        $configuracaoModel = new ConfiguracaoModel($entityManager);
        $exercicio = $this->getExercicio();

        $query = parent::createQuery($context);
        $campo = 'homologacao_automatica';

        if (!$this->getRequest()->query->get('filter')) {
            $query->andWhere("{$query->getRootAliases()[0]}.exercicio = :exercicio");
        }
        $query->andWhere("{$query->getRootAliases()[0]}.codModulo = :codModulo");
        $query->andWhere("{$query->getRootAliases()[0]}.parametro = :campo");
        $query->setParameters(['exercicio' => $exercicio, 'codModulo' => ConfiguracaoModel::MODULO_PATRIMONIAL_COMPRAS, 'campo' => $campo]);
        return $query;
    }


    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('edit');
        $collection->remove('delete');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio', 'doctrine_orm_callback', ['callback' => array($this, 'getSearchFilter')]);
    }

    /**
     * @param $queryBuilder
     * @param $alias
     * @param $field
     * @param $value
     * @return bool|void
     */
    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        if (!$value['value']) {
            return;
        }

        $filter = $this->getDataGrid()->getValues();

        if ($filter['exercicio']['value'] != '') {
            $queryBuilder->andWhere("{$queryBuilder->getRootAliases()[0]}.exercicio = :exercicio");
            $queryBuilder->setParameter("exercicio", $filter['exercicio']['value']);
        }

        return true;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('exercicio')
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                    'create' => ['template' => 'PatrimonialBundle:Sonata/Compras/Configuracao/CRUD:list__action_create.html.twig'],
                ]
            ]);
    }

    /**
     * @param mixed $object
     * @throws \Exception
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Configuracao');
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $childrens = $this->getForm()->all();

            $cod_modulo = (isset($childrens['cod_modulo'])) ? $childrens['cod_modulo']->getViewData() : '';

            $configuracaoModel = new ConfiguracaoModel($em);

            foreach ($childrens as $key => $children) {
                if ($key != 'cod_modulo') {
                    $info = explode('_', $key);

                    $cod_atributo = str_replace('atributo_', '', $key);

                    if (ConfiguracaoModel::MODULO_PATRIMONIAL_COMPRAS && $cod_atributo == 'numeracao_licitacao') {
                        if (is_array(($children->getViewData()))) {
                            $valor = implode('', $children->getViewData());
                        }
                    } else {
                        $valor = $children->getViewData();
                    }

                    $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Configuracao');

                    $data = new \DateTime();

                    if ($cod_atributo == 'dotacao_obrigatoria_solicitacao' || $cod_atributo == 'homologacao_automatica') {
                        $valor = $valor == 'Sim' ? 'true' : 'false';
                    }

                    $info = array(
                        'cod_modulo' => $cod_modulo,
                        'parametro' => $cod_atributo,
                        'valor' => $valor,
                        'exercicio' => $this->getExercicio()
                    );

                    $u = $configuracaoModel->updateAtributosDinamicos($info);

                    if (ConfiguracaoModel::MODULO_PATRIMONIAL_COMPRAS) {
                        preg_match('/[^_]+$/', $key, $matches, PREG_OFFSET_CAPTURE);
                        if (isset($matches[0][0]) && is_numeric($matches[0][0])) {
                            $arrayEntidade[$matches[0][0]][] = $valor;
                        }
                    }
                }
            }

            if (ConfiguracaoModel::MODULO_PATRIMONIAL_COMPRAS) {
                $infos = array();
                $infoc = array();

                foreach ($arrayEntidade as $key => $entidade) {
                    $infos[$key]['cod_modulo'] = $cod_modulo;
                    $infos[$key]['cod_entidade'] = $key;
                    $infos[$key]['valor'] = $entidade[1];
                    $infos[$key]['exercicio'] = date('Y');

                    $infoc[$key]['cod_modulo'] = $cod_modulo;
                    $infoc[$key]['cod_entidade'] = $key;
                    $infoc[$key]['valor'] = $entidade[2];
                    $infoc[$key]['exercicio'] = date('Y');

                    $configuracaoModel->selectInsertUpdateAtributosDinamicosSolicitacao($infos[$key]);
                    $configuracaoModel->selectInsertUpdateAtributosDinamicosCompras($infoc[$key]);
                }
            }

            $container->get('session')->getFlashBag()->add('success', 'Configuração alterada com sucesso!');

            (new RedirectResponse($this->generateUrl('show', array('id' => $info['exercicio'] . '~' . $info['cod_modulo'] . '~' . 'homologacao_automatica'))))->send();
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            throw $e;
        }
    }

    /**
     * @param FormMapper $formMapper
     * @return bool
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $container = $this->getConfigurationPool()->getContainer();

        if ($this->getRequest()->isMethod('GET')) {
            $codModulo = $this->getRequest()->get('id', false);

            if (!is_numeric($codModulo)) {
                $container->get('session')->getFlashBag()->add('error', 'Não existe configuração cadastrada para o modulo passado');
                $this->forceRedirect('/erro-configuracao');
                return false;
            }
        } else {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codModulo = $formData['cod_modulo'];
        }

        $this->setUrlReferer($this->request->headers->get('referer'));

        $info = array(
            'cod_modulo' => $codModulo,
            'exercicio' => $this->getExercicio(),
        );

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Configuracao');
        $configuracaoModel = new ConfiguracaoModel($em);
        $atributos = $configuracaoModel->getAtributosDinamicosPorModuloeExercicio($info);

        if (count($atributos) == 0) {
            $container->get('session')->getFlashBag()->add('error', 'Não existe configuração cadastrada');
            $this->forceRedirect('/erro-configuracao');
            return false;
        }

        $this->montaHtmlPatrimonialConfiguracaoCompras($codModulo, $formMapper, $atributos);
    }

    /**
     * @param $cod_modulo
     * @param $formMapper
     * @param $atributos
     * @return mixed
     */
    public function montaHtmlPatrimonialConfiguracaoCompras($cod_modulo, $formMapper, $atributos)
    {

        $this->setBreadCrumb($cod_modulo ? ['id' => $cod_modulo] : [], 'urbem_patrimonial_compras_configuracao');
        $formMapper->with('Configuração de Compras');
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Configuracao');
        $configuracaoModel = new ConfiguracaoModel($em);
        $exercicio = $this->getExercicio();
        $entidades = $configuracaoModel->getEntidades($exercicio);

        $atributosNegados = ['data_fixa', 'data_fixa_empenho', 'data_fixa_liquidacao', 'reserva_autorizacao', 'reserva_rigida', 'tipo_valor_referencia'];

        foreach ($atributos as $key => $atributo) {
            if ($atributo['parametro'] == 'homologacao_automatica') {
                $formMapper->add(
                    "atributo_" . $atributo['parametro'],
                    'text',
                    [
                        'label' => 'label.administracao.atributo_' . $atributo['parametro'],
                        'mapped' => false,
                        'data' => ($atributo['valor'] == 'true') ? 'Sim' : 'Não',
                        'required' => false,
                        'attr' => [
                            'readonly' => true,
                        ]
                    ]
                );
            } elseif ($atributo['parametro'] == 'dotacao_obrigatoria_solicitacao') {
                $formMapper->add(
                    "atributo_" . $atributo['parametro'],
                    'text',
                    [
                        'label' => 'label.administracao.atributo_' . $atributo['parametro'],
                        'mapped' => false,
                        'data' => ($atributo['valor'] == 'true') ? 'Sim' : 'Não',
                        'required' => false,
                        'attr' => [
                            'readonly' => true,
                        ]
                    ]
                );
            } elseif ($atributo['parametro'] == 'numeracao_licitacao') {
                $aSolicitacao = array();
                if ($atributo['valor']) {
                    $aSolicitacao[0] = (strpos($atributo['valor'], 'entidade') !== false) ? 'entidade' : '';
                    $aSolicitacao[1] = (strpos($atributo['valor'], 'modalidade') !== false) ? 'modalidade' : '';
                }

                $formMapper->add(
                    "atributo_" . $atributo['parametro'],
                    'choice',
                    [
                        'choices' => [
                            'Por Entidade' => 'entidade',
                            'Por Modalidade' => 'modalidade'
                        ],
                        'expanded' => true,
                        'multiple' => true,
                        'label' => 'label.administracao.atributo_' . $atributo['parametro'],
                        'mapped' => false,
                        'required' => true,
                        'data' => $aSolicitacao,
                        'label_attr' => [
                            'class' => 'checkbox-sonata'
                        ],
                        'attr' => [
                            'class' => 'checkbox-sonata'
                        ]
                    ]
                );
            } elseif ($atributo['parametro'] == 'atributo_tipo_valor_referencia') {
                $formMapper->add(
                    "atributo_" . $atributo['parametro'],
                    'choice',
                    [
                        'choices' => [
                            'Por Entidade' => 'entidade',
                            'Por Modalidade' => 'modalidade'
                        ],
                        'expanded' => true,
                        'multiple' => true,
                        'label' => 'label.administracao.atributo_' . $atributo['parametro'],
                        'mapped' => false,
                        'required' => true,
                        'data' => $atributo['valor'],
                        'label_attr' => [
                            'class' => 'checkbox-sonata'
                        ],
                        'attr' => [
                            'class' => 'checkbox-sonata'
                        ]
                    ]
                );
            } elseif (!in_array($atributo['parametro'], $atributosNegados)) {
                $formMapper->add(
                    "atributo_" . $atributo['parametro'],
                    'choice',
                    [
                        'choices' => [
                            'label.administracao.sim' => 'true',
                            'label.administracao.nao' => 'false'
                        ],
                        'expanded' => true,
                        'multiple' => false,
                        'label' => 'label.administracao.atributo_' . $atributo['parametro'],
                        'mapped' => false,
                        'required' => true,
                        'data' => $atributo['valor'],
                        'label_attr' => [
                            'class' => 'checkbox-sonata'
                        ],
                        'attr' => [
                            'class' => 'checkbox-sonata'
                        ]
                    ]
                );
                $valorReferencia = $configuracaoModel->pegaConfiguracao('tipo_valor_referencia', 35, $this->getExercicio(), true);
                $formMapper->add(
                    "atributo_tipo_valor_referencia",
                    'choice',
                    [
                        'choices' => [
                            'label.administracao.valorReservaSolicitado' => 'solicitado',
                            'label.administracao.valorReservaLivre' => 'livre',
                            'label.administracao.valorReserva10' => '10%'
                        ],
                        'expanded' => true,
                        'multiple' => false,
                        'label' => 'label.administracao.atributo_valor_referencia',
                        'mapped' => false,
                        'required' => true,
                        'data' => $valorReferencia,
                        'label_attr' => [
                            'class' => 'checkbox-sonata'
                        ],
                        'attr' => [
                            'class' => 'checkbox-sonata'
                        ]
                    ]
                );

                $formMapper->add(
                    "atributo_tipo_reserva",
                    'choice',
                    [
                        'choices' => [
                            'label.administracao.reservaAutorizacao' => 'true',
                            'label.administracao.reservaRigida' => 'false'
                        ],
                        'expanded' => true,
                        'multiple' => false,
                        'label' => 'label.administracao.atributo_tipo_reserva',
                        'mapped' => false,
                        'required' => true,
                        'data' => $atributo['valor'],
                        'label_attr' => [
                            'class' => 'checkbox-sonata'
                        ],
                        'attr' => [
                            'class' => 'checkbox-sonata'
                        ]
                    ]
                )
                    ->add(
                        "cod_modulo",
                        'hidden',
                        [
                            'mapped' => false,
                            'data' => $cod_modulo,
                        ]
                    );
            }
        }
        $formMapper->end();


        foreach ($entidades as $entidade) {
            $formMapper
                ->with($entidade['nom_cgm'])
                ->add(
                    "entidade__" . $entidade['cod_entidade'],
                    'text',
                    [
                        'label' => 'Entidade',
                        'mapped' => false,
                        'data' => $entidade['cod_entidade'] . ' - ' . $entidade['nom_cgm'],
                        'required' => false,
                        'attr' => [
                            'readonly' => true,
                        ]
                    ]
                );

            $info['exercicio'] = $exercicio;
            $info['cod_modulo'] = $cod_modulo;
            $info['campo'] = 'data_fixa_solicitacao_compra';
            $info['cod_entidade'] = $entidade['cod_entidade'];
            $entidadeValor = $configuracaoModel->selectAtributosDinamicosEntidade($info);

            $data = ($entidadeValor['valor']) ? explode("/", $entidadeValor['valor']) : '';

            if (isset($data[2]) && isset($data[1]) && isset($data[0])) {
                $dataValor = new \DateTime($data[2] . "-" . $data[1] . "-" . $data[0]);
            } else {
                $dataValor = new \DateTime();
            }

            $formMapper->add(
                "entidade_data_fixa_solicitacao__" . $entidade['cod_entidade'],
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.administracao.entidade_data_fixa_solicitacao',
                    'mapped' => false,
                    'required' => false,
                    'data' => $dataValor,
                ]
            );

            $infoc['exercicio'] = $exercicio;
            $infoc['cod_modulo'] = $cod_modulo;
            $infoc['campo'] = 'data_fixa_compra';
            $infoc['cod_entidade'] = $entidade['cod_entidade'];
            $entidadeValor = $configuracaoModel->selectAtributosDinamicosEntidade($infoc);

            $data = ($entidadeValor['valor']) ? explode("/", $entidadeValor['valor']) : '';
            if (isset($data[2]) && isset($data[1]) && isset($data[0])) {
                $dataValor = new \DateTime($data[2] . "-" . $data[1] . "-" . $data[0]);
            } else {
                $dataValor = new \DateTime();
            }

            $formMapper->add(
                "entidade_data_fixa_compra__" . $entidade['cod_entidade'],
                'sonata_type_date_picker',
                [
                    'label' => 'label.administracao.entidade_data_fixa_para_compra_direta',
                    'format' => 'dd/MM/yyyy',
                    'mapped' => false,
                    'required' => false,
                    'data' => $dataValor,
                ]
            )->end();
        }

        return $formMapper;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $configuracao = $this->getSubject();
        $this->setBreadCrumb(ConfiguracaoModel::MODULO_PATRIMONIAL_COMPRAS ? ['id' => ConfiguracaoModel::MODULO_PATRIMONIAL_COMPRAS] : []);
        $codModulo = ConfiguracaoModel::MODULO_PATRIMONIAL_COMPRAS;
        list($exercicio) = explode('~', $this->getRequest()->get('id', false));

        $info = array(
            'codModulo' => $codModulo,
            'exercicio' => ($exercicio) ? $exercicio : $this->getExercicio(),
        );

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Administracao\Configuracao');
        $moduloModel = new ModuloModel($em);
        $modulo = $moduloModel->findOneByCodModulo($codModulo);
        $configuracaoEntidadeModel = new ConfiguracaoEntidadeModel($em);
        $responsaveis = $configuracaoEntidadeModel->getResponsaveis($info);
        $swcgmModel = new SwCgmModel($em);
        foreach ($responsaveis as $responsavel) {
            $responsavel->swCgm = $swcgmModel->findOneByNumcgm($responsavel->getValor());
        }
        $configuracaoModel = new ConfiguracaoModel($em);
        $atributosNegados = ['data_fixa', 'data_fixa_empenho', 'data_fixa_liquidacao', 'reserva_autorizacao'];
        $infoNegada = array(
            'cod_modulo' => $codModulo,
            'exercicio' => ($exercicio) ? $exercicio : $this->getExercicio(),
            'atributos_negados' => $atributosNegados
        );

        $atributos =  $configuracaoModel->getAtributosDinamicosPorModuloeExercicioWithNotIn($infoNegada);
        $configuracao->atributos = $atributos;
        $configuracao->configuracaoEntidade = $responsaveis;
        $configuracao->atributosBooleanos = ['dotacao_obrigatoria_solicitacao', 'homologacao_automatica', 'numeracao_automatica', 'numeracao_automatica_licitacao'];

        $entidades = [];
        $getEntidades = $configuracaoModel->getEntidades($exercicio);
        foreach ($getEntidades as $entidade) {
            $info['exercicio'] = $exercicio;
            $info['cod_modulo'] = $codModulo;
            $info['campo'] = 'data_fixa_solicitacao_compra';
            $info['cod_entidade'] = $entidade['cod_entidade'];
            $valorSolicitacao = $configuracaoModel->selectAtributosDinamicosEntidade($info);

            $infoc['exercicio'] = $exercicio;
            $infoc['cod_modulo'] = $codModulo;
            $infoc['campo'] = 'data_fixa_compra';
            $infoc['cod_entidade'] = $entidade['cod_entidade'];
            $valorCompra = $configuracaoModel->selectAtributosDinamicosEntidade($infoc);

            $addEntidades = [];
            $addEntidades['valorSolicitacao'] = $valorSolicitacao;
            $addEntidades['valorCompra'] = $valorCompra;
            $addEntidades['perfil'] = $entidade;
            $entidades[] = $addEntidades;
        }
        $configuracao->entidades = $entidades;
    }
}
