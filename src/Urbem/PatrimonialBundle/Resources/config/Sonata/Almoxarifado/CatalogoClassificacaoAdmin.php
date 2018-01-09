<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Exception;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Entity\Almoxarifado\Catalogo;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoClassificacao;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\CatalogoClassificacaoRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Helper;
use Urbem\CoreBundle\Model;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Urbem\CoreBundle\Entity;
use Urbem\CoreBundle\Entity\Almoxarifado;

use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoClassificacaoModel;

/**
 * Class CatalogoClassificacaoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class CatalogoClassificacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_catalogo_classificacao';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/catalogo-classificacao';
    protected $includeJs = [
        '/patrimonial/javascripts/almoxarifado/catalogo-classificacao-component.js',
        '/patrimonial/javascripts/almoxarifado/catalogoClassificacao.js'
    ];
    protected $model = CatalogoClassificacaoModel::class;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('get_niveis_catalogo', 'get-niveis-catalogo/' . $this->getRouterIdParameter());
        $collection->add('get_nivel_categorias', 'get-nivel-categorias/');
        $collection->add('get_nivel_categorias_with_mascara', 'get-nivel-categorias-with-mascara/');
        $collection->add('search', 'search');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codEstrutural', null, array('label' => 'label.catalogoClassificao.codEstrutural'))
            ->add('fkAlmoxarifadoCatalogo', null, array('label' => 'label.catalogoClassificao.codCatalogo'))
            ->add('descricao', null, array('label' => 'label.catalogoClassificao.descricao'));
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codEstrutural', null, array('label' => 'label.catalogoClassificao.codEstrutural'))
            ->add('fkAlmoxarifadoCatalogo', 'text', array('label' => 'label.catalogoClassificao.codCatalogo'))
            ->add('descricao', null, array('label' => 'label.catalogoClassificao.descricao'));

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['codCatalogo'] = [
            'class' => 'CoreBundle:Almoxarifado\Catalogo',
            'placeholder' => 'label.selecione',
            'query_builder' => function (EntityRepository $em) {
                $qb = $em->createQueryBuilder('c');
                $qb->where('c.permiteManutencao = true');
                return $qb;
            },
            'label' => 'label.catalogoClassificao.codCatalogo',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'mapped' => false
        ];

        $fieldOptions['codAtributo'] = [
            'class' => 'CoreBundle:Administracao\AtributoDinamico',
            'label' => 'label.catalogoItem.codAtributo',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'query_builder' => function (EntityRepository $em) {
                $qb = $em->createQueryBuilder('ad');
                $qb->andWhere('ad.codModulo = ' . Entity\Administracao\Modulo::MODULO_PATRIMONIAL_ALMOXARIFADO);
                $qb->andWhere('ad.codCadastro = ' . Entity\Administracao\Cadastro::CADASTRO_PATRIMONIAL_ALMOXARIFADO_ATRIBUTO_CATALOGO_CLASSIFICACAO_ITEM_VALOR);
                return $qb;
            },
            'mapped' => false,
            'required' => false,
            'placeholder' => 'label.selecione',
            'multiple' => true
        ];

        $fieldOptions['codNivel'] = [
            'placeholder' => 'Selecione o Catalogo',
            'class' => Almoxarifado\CatalogoNiveis::class,
            'label' => 'label.catalogoClassificao.codNivel',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['codEstrutural'] = [
            'mapped' => false,
            'required' => false,
        ];

        $fieldOptions['atributosDinamicos'] = [
            'mapped' => false,
            'required' => false
        ];

        $fieldOptions['descricao'] = [
            'label' => 'label.catalogoClassificao.descricao',
        ];

        $fieldOptions['codClassificacao'] = [];

        if ($this->id($this->getSubject())) {
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());
            /** @var CatalogoClassificacao $objClassificacao */
            $objClassificacao = $this->getSubject();

            $classificacaoNivelModel = new CatalogoClassificacaoModel($em);
            $fieldOptions['codEstrutural']['data'] =
                $classificacaoNivelModel->getMascaraReduzida(['estruturaMae' => $objClassificacao->getCodEstrutural()])[0]['fn_mascarareduzida'];
            $fieldOptions['codClassificacao']['data'] = $objClassificacao->getCodClassificacao();

            $fieldOptions['codCatalogo']['data'] = $objClassificacao->getFkAlmoxarifadoCatalogo();
            $fieldOptions['codCatalogo']['query_builder'] = function (EntityRepository $em) {
                $qb = $em->createQueryBuilder('c');
                return $qb;
            };

            if (!$this->getSubject()->getFkAlmoxarifadoCatalogo()->getPermiteManutencao()) {
                $fieldOptions['descricao'] = [
                    'disabled' => true,
                    'label' => 'label.catalogoClassificao.descricao'
                ];
            };

            // Processa Atributo Dinâmico
            $arrAtributos = [];
            /** @var Almoxarifado\AtributoCatalogoClassificacao $atributoCatalogoClassificacao */
            foreach ($objClassificacao->getFkAlmoxarifadoAtributoCatalogoClassificacoes() as $atributoCatalogoClassificacao) {
                $arrAtributos[] = $atributoCatalogoClassificacao->getFkAdministracaoAtributoDinamico();
            }
            $fieldOptions['codAtributo']['data'] = $arrAtributos;
        }

        $formMapper
            ->with('label.catalogoClassificao.dados')
            ->add(
                'codCatalogo',
                'entity',
                $fieldOptions['codCatalogo']
            )
            ->add(
                'codNivel',
                'entity',
                $fieldOptions['codNivel']
            )
            ->end()
            ->with('label.catalogoClassificao.classificao', array('class' => 'catalogoClassificacaoContainer'))
            ->add(
                'catalogoClassificacaoPlaceholder',
                'text',
                $fieldOptions['atributosDinamicos']
            )
            ->end()
            ->with('label.catalogoClassificao.dadosNivel')
            ->add(
                'descricao',
                'text',
                $fieldOptions['descricao']
            )
            ->add(
                'codAtributo',
                'entity',
                $fieldOptions['codAtributo']
            )
            ->add(
                'codEstrutural',
                'hidden',
                $fieldOptions['codEstrutural']
            )
            ->add(
                'codClassificacao',
                'hidden',
                $fieldOptions['codClassificacao']
            )
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        /** @var CatalogoClassificacao $objClassificacao */
        $objClassificacao = $this->getSubject();

        $classificacaoNivelModel = new CatalogoClassificacaoModel($em);
        $nivel = $classificacaoNivelModel->getNivelClassificacao([
            'estrutural' => $objClassificacao->getCodEstrutural(),
            'codCatalogo' => $objClassificacao->getCodCatalogo()
        ])[0];

        $arrEstrutural = explode('.', $objClassificacao->getCodEstrutural());
        $codEstrutural = '';
        $classificacoes = '<ul>';
        for ($i = 0; $i < $nivel['nivel'] - 1; $i++) {
            $codEstrutural .= ($codEstrutural == '' ? '' : '.') . $arrEstrutural[$i];
            $arrClassificacao = $classificacaoNivelModel->getNivelCategoriasWithMascara([
                'codCatalogo' => $objClassificacao->getCodCatalogo(),
                'codNivel' => $i + 1,
                'nivel' => $codEstrutural
            ]);
            /** @var Catalogo $objCodCatalogo */
            $objCatalogoNiveis = $em->getRepository(Almoxarifado\CatalogoNiveis::class)->findOneBy([
                'codCatalogo' => $objClassificacao->getCodCatalogo(),
                'nivel' => $i + 1,
            ]);

            if (count($arrClassificacao) > 0) {
                $classificacoes .= '<li>';
                $classificacoes .= $objCatalogoNiveis->getDescricao() . ': ';
                $classificacoes .= str_pad($arrClassificacao[0]['cod_nivel'], strlen($arrClassificacao[0]['mascara']), "0", STR_PAD_LEFT) . ' - ' .
                    $arrClassificacao[0]['descricao'];
                $classificacoes .= '</li>';
            }
        }
        $classificacoes .= '</ul>';

        $atributos = '<ul>';
        /** @var Almoxarifado\AtributoCatalogoClassificacao $atributoCatalogoClassificacao */
        foreach ($objClassificacao->getFkAlmoxarifadoAtributoCatalogoClassificacoes() as $atributoCatalogoClassificacao) {
            $atributos .= '<li>';
            $atributos .= $atributoCatalogoClassificacao->getFkAdministracaoAtributoDinamico()->getCodAtributo() . ' - ' .
                $atributoCatalogoClassificacao->getFkAdministracaoAtributoDinamico()->getNomAtributo();
            $atributos .= '</li>';
        }
        $atributos .= '</ul>';

        $showMapper
            ->add('codEstrutural', null, array('label' => 'label.catalogoClassificao.codEstrutural'))
            ->add('fkAlmoxarifadoCatalogo', 'text', array('label' => 'label.catalogoClassificao.codCatalogo'))
            ->add('nivel', null, [
                'label' => 'label.catalogoClassificao.nivel',
                'mapped' => false,
                'template' => 'CoreBundle:Sonata/CRUD:show_custom_html.html.twig',
                'data' => $nivel['nivel'] . ' - ' . $nivel['descricao']
            ]);
        if ($nivel['nivel'] != 1) {
            $showMapper
                ->add('classificacaoMae', null, [
                    'label' => 'label.catalogoClassificao.classificao',
                    'mapped' => false,
                    'template' => 'CoreBundle:Sonata/CRUD:show_custom_html.html.twig',
                    'data' => $classificacoes
                ]);
        }
        $showMapper->add('descricao', null, array('label' => 'label.catalogoClassificao.descricao'));
        if (count($arrEstrutural) == $nivel['nivel']) {
            $showMapper
                ->add('atributo', null, [
                    'label' => 'label.catalogoClassificao.codAtributo',
                    'mapped' => false,
                    'template' => 'CoreBundle:Sonata/CRUD:show_custom_html.html.twig',
                    'data' => $atributos
                ]);
        }
    }

    /**
     * @param CatalogoClassificacao $catalogoClassificacao
     * @param Form $form
     */
    public function saveRelationships($catalogoClassificacao, $form)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        // Setar a entity Catalogo do codCatalogo
        $codCatalogo = $form->get('codCatalogo')->getData();
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $codNivel = $formData['codNivel'];

        /** @var Catalogo $objCodCatalogo */
        $objCodCatalogo = $em->getRepository('CoreBundle:Almoxarifado\Catalogo')->findOneByCodCatalogo($codCatalogo);
        $catalogoClassificacao->setImportado(false);
        $catalogoClassificacao->setFkAlmoxarifadoCatalogo($objCodCatalogo);

        if (!$this->getAdminRequestId()) {
            // Setar o codEstrutural do item novo
            $classificacoes = $this->request->request->get('catalogoClassificacaoComponent');
            $params = [
                'codCatalogo' => $codCatalogo->getCodCatalogo(),
                'nivel' => $codNivel,
            ];


            $params['estruturaMae'] = '';
            if (!empty($classificacoes)) {
                $params['estruturaMae'] = end($classificacoes)['nivelDinamico'];
            }

            /** @var CatalogoClassificacaoRepository $catalogoClassificacaoRepository */
            $catalogoClassificacaoRepository = $em->getRepository($this->getClass());
            $baseCodEstrutural = $catalogoClassificacaoRepository->getProxEstruturalLivre($params);
            $mascaraCodEstrutural = $catalogoClassificacaoRepository->getMascaraCompleta($params);

            $arr_mascaraCodEstrutural = explode('.', $mascaraCodEstrutural[0]['mascara']);
            $codEstrutural = $params['estruturaMae'];

            for ($i = ($codNivel - 1); $i < count($arr_mascaraCodEstrutural); $i++) {
                $codEstrutural .= ($codEstrutural ? '.' : '') . str_pad(($i == ($codNivel - 1) ? $baseCodEstrutural[0]['livre'] : '0'), strlen($arr_mascaraCodEstrutural[$i]), "0", STR_PAD_LEFT);
            }

            $catalogoClassificacao->setCodEstrutural($codEstrutural);
        }
    }

    /**
     * @param CatalogoClassificacao $catalogoClassificacao
     */
    public function postPersist($catalogoClassificacao)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $classificacaoNivelModel = new CatalogoClassificacaoModel($em);

        if (!$this->getAdminRequestId()) {
            // Atributo Dinâmico
            foreach ($this->getForm()->get('codAtributo')->getData() as $atributo) {
                $atributoCatalogoClassificacao = new Almoxarifado\AtributoCatalogoClassificacao();
                $atributoCatalogoClassificacao->setFkAdministracaoAtributoDinamico($atributo);
                $atributoCatalogoClassificacao->setFkAlmoxarifadoCatalogoClassificacao($catalogoClassificacao);

                $classificacaoNivelModel->save($atributoCatalogoClassificacao);
            }

            // Inserir Classificação Nivel
            $arr_codEstrutural = explode('.', $catalogoClassificacao->getCodEstrutural());
            for ($i = 0; $i < count($arr_codEstrutural); $i++) {
                $classificacaoNivel = new Almoxarifado\ClassificacaoNivel();
                $objNivel = $em->getRepository('CoreBundle:Almoxarifado\CatalogoNiveis')->findOneBy([
                    "codCatalogo" => $catalogoClassificacao->getCodCatalogo(),
                    "nivel" => ($i + 1)
                ]);

                $classificacaoNivel->setCodNivel($arr_codEstrutural[$i]);
                $classificacaoNivel->setFkAlmoxarifadoCatalogoNiveis($objNivel);
                $classificacaoNivel->setFkAlmoxarifadoCatalogoClassificacao($catalogoClassificacao);
                $classificacaoNivelModel->save($classificacaoNivel);
            }
        }
    }

    /**
     * @param CatalogoClassificacao $catalogoClassificacao
     * @return bool
     */
    public function prePersist($catalogoClassificacao)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($catalogoClassificacao, $this->getForm());

            $catalogoClassificacaoModel = new CatalogoClassificacaoModel($em);
            $catalogoClassificacao->setCodClassificacao($catalogoClassificacaoModel
                ->getProxCodClassificacao($catalogoClassificacao->getCodCatalogo()));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect("/patrimonial/almoxarifado/catalogo-classificacao/create");
            return false;
        }
    }

    /**
     * @param CatalogoClassificacao $catalogoClassificacao
     * @return bool
     */
    public function preUpdate($catalogoClassificacao)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            foreach ($catalogoClassificacao->getFkAlmoxarifadoAtributoCatalogoClassificacoes() as $atributoCatalogoClassificacao) {
                $catalogoClassificacao->removeFkAlmoxarifadoAtributoCatalogoClassificacoes($atributoCatalogoClassificacao);
            }

            $this->saveRelationships($catalogoClassificacao, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_EDIT_DATA);
            $this->forceRedirect("/patrimonial/almoxarifado/catalogo-classificacao/{$this->getObjectKey($catalogoClassificacao)}/edit");
            return false;
        }
    }

    /**
     * @param CatalogoClassificacao $catalogoClassificacao
     */
    public function postUpdate($catalogoClassificacao)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $classificacaoNivelModel = new CatalogoClassificacaoModel($em);

        // Atributo Dinâmico
        foreach ($this->getForm()->get('codAtributo')->getData() as $atributo) {
            $atributoCatalogoClassificacao = new Almoxarifado\AtributoCatalogoClassificacao();
            $atributoCatalogoClassificacao->setFkAdministracaoAtributoDinamico($atributo);
            $atributoCatalogoClassificacao->setFkAlmoxarifadoCatalogoClassificacao($catalogoClassificacao);

            $classificacaoNivelModel->save($atributoCatalogoClassificacao);
        }
    }

    /**
     * @param CatalogoClassificacao $catalogoClassificacao
     * @return void
     */
    public function preRemove($catalogoClassificacao)
    {
        parent::preRemove($catalogoClassificacao);
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $catalogoClassificacaoModel = new CatalogoClassificacaoModel($em);
        $nivel = $catalogoClassificacaoModel->getNivelClassificacao([
            'estrutural' => $catalogoClassificacao->getCodEstrutural(),
            'codCatalogo' => $catalogoClassificacao->getCodCatalogo()
        ])[0];

        $classificacaoNivelRepository = $em->getRepository(Almoxarifado\ClassificacaoNivel::class);
        $classificacaoNivel = $classificacaoNivelRepository->findOneBy([
            'codClassificacao' => $catalogoClassificacao->getCodClassificacao(),
            'codCatalogo' => $catalogoClassificacao->getCodCatalogo(),
            'nivel' => $nivel['nivel']
        ]);

        $catalogoClassificacaoModel->remove($classificacaoNivel);
    }
}
