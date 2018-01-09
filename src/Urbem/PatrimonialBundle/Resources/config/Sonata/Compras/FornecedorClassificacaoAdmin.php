<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoClassificacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Almoxarifado;

class FornecedorClassificacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_fornecedor_classificacao';
    protected $baseRoutePattern = 'patrimonial/compras/fornecedor/classificacao';

    protected $includeJs = [
        '/patrimonial/javascripts/almoxarifado/catalogo-classificacao-component.js',
        '/patrimonial/javascripts/almoxarifado/inventario_item.js',
    ];

    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->remove('batch');
        $routeCollection->remove('show');
        $routeCollection->remove('export');
    }


    /**
     * @param ErrorElement $errorElement
     * @param Compras\FornecedorClassificacao $fornecedorClassificacao
     */
    public function validate(ErrorElement $errorElement, $fornecedorClassificacao)
    {

        $em = $this->modelManager->getEntityManager($this->getClass());
        $catalogoClassificacaoComponent = $this->request->request->get('catalogoClassificacaoComponent');
        $codEstrutural = end($catalogoClassificacaoComponent);

        $getClassificacao = $em->getRepository(Almoxarifado\CatalogoClassificacao::class)
            ->findOneBy(
                array('codEstrutural' => $codEstrutural)
            );

        if(!is_null($getClassificacao)){

            $form = $this->getForm();
            $codClassificacao = $getClassificacao->getCodClassificacao();
            $cgmFornecedor = $form->get('cgmFornecedor')->getData();
            $codCatalogo = $form->get('codCatalogo')->getData()->getcodCatalogo();

            $getClassificacaoFornecedor = $em->getRepository(Compras\FornecedorClassificacao::class)
                ->findOneBy(
                    array(
                        'codClassificacao' => $codClassificacao,
                        'codCatalogo' => $codCatalogo,
                        'cgmFornecedor' => $cgmFornecedor
                    )
                );

            if(!is_null($getClassificacaoFornecedor)){
                $message = $this->trans('fornecedor.classificacao.errors.duplicidade',[], 'validators');
                $errorElement->with('codCatalogo')->addViolation($message)->end();
            }
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /**
         * Auxilia na execuÃ§ao das Models
         *
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $route = $this->getRequest()->get('_sonata_name');
        $id = $this->getAdminRequestId();
        $edicao = false;

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $cgmFornecedor = $formData['cgmFornecedor'];
        } else {
            $cgmFornecedor = $this->request->get('cgm_fornecedor');
        }

        /**
         * @var Compras\Fornecedor $fornecedor
         */
        $fornecedor = !is_null($route) ? $entityManager->getRepository(Compras\Fornecedor::class)->find($cgmFornecedor) : null;

        $fieldOptions = [];
        $fieldOptions['fornecedor'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'class' => Compras\Fornecedor::class,
            'choice_label' => 'fkSwCgm.nomCgm',
            'disabled' => true,
            'data' => $fornecedor,
            'label' => 'label.fornecedor.cgmFornecedor',
            'mapped' => false
        ];
        $fieldOptions['cgmFornecedor'] = [
            'data' => is_null($fornecedor) ? $cgmFornecedor : $fornecedor->getFkSwCgm()->getNumcgm()
        ];

        $fieldOptions['codCatalogo'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'class' => Almoxarifado\Catalogo::class,
            'choice_label' => 'descricao',
            'choice_value' => 'codCatalogo',
            'label' => 'label.fornecedor.catalogo',
            'required' => true,
            'mapped' => false,
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['codClassificacao'] = [
            'attr' => [
                'data-related-from' => '_codCatalogo',
                'class' => 'select2-parameters '
            ],
            'choice_label' => function (Almoxarifado\CatalogoClassificacao $codClassificacao) {
                $string = $codClassificacao->getCodEstrutural();
                $string .= " - {$codClassificacao->getDescricao()}";
                return strtoupper($string);
            },
            'label' => 'label.fornecedor.classificacao',
            'placeholder' => 'label.selecione',
            'required' => true
        ];

        $formMapper->with('label.fornecedor.dadosClassificacao');

        $dataClassificacao = null;
        if ($this->id($this->getSubject())) {
            $edicao = true;
            $dataClassificacao = $this->getObject($id)->getFkAlmoxarifadoCatalogoClassificacao()->getDescricao();
        }

        $formMapperOptions['atributosDinamicos'] = [
            'mapped' => false,
            'required' => false
        ];

        $formMapperOptions['codEstrutural'] = [
            'mapped' => false,
            'required' => false,
        ];

        $formMapperOptions['codItem'] = [
            'mapped' => false,
            'required' => false,
        ];

        if (!is_null($route)) {
            $formMapper
                ->add('fornecedor', 'entity', $fieldOptions['fornecedor'])
                ->add('cgmFornecedor', 'hidden', $fieldOptions['cgmFornecedor']);
        }

        $formMapper
            ->add('codCatalogo', 'entity', $fieldOptions['codCatalogo'])
            ->end()
            ->with(
                'label.item.tipoCadastroLoteClassificacao',
                [
                    'class' => 'catalogoClassificacaoContainer'
                ]
            )
            ->add(
                'catalogoClassificacaoPlaceholder',
                'text',
                [
                    'mapped' => false,
                    'required' => false
                ]
            )
            ->end()
            ->with('label.bem.atributo', ['class' => 'atributoDinamicoWith'])
            ->add( 'atributosDinamicos', 'text', $formMapperOptions['atributosDinamicos'])
            ->add('codEstrutural','hidden',$formMapperOptions['codEstrutural'])
            ->add('edicao', 'hidden', ['data' => $edicao, 'mapped' => false])
            ->add('codItem', 'hidden', $formMapperOptions['codItem'])
            ->end();
    }

    public function makeRelationships(Compras\FornecedorClassificacao $fornecedorClassificacao)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        /** @var Compras\Fornecedor $fornecedor */
        $fornecedor = $entityManager
            ->getRepository(Compras\Fornecedor::class)
            ->find($fornecedorClassificacao->getCgmFornecedor());

        $fornecedorClassificacao->setFkComprasFornecedor($fornecedor);

        $catalogoClassificacaoComponent = $this->request->request->get('catalogoClassificacaoComponent');
        $params = [
            'codEstrutural' => end($catalogoClassificacaoComponent),
            'codCatalogo' => $this->getForm()->get('codCatalogo')->getData()->getCodCatalogo()
        ];
        $catalogoClassificacaoModel = new CatalogoClassificacaoModel($entityManager);

        /** @var Almoxarifado\CatalogoClassificacao $catalogoClassificacao */
        $catalogoClassificacao = $catalogoClassificacaoModel->findOneBy($params);
        $fornecedorClassificacao->setFkAlmoxarifadoCatalogoClassificacao($catalogoClassificacao);
    }

    public function prePersist($object)
    {
        $this->makeRelationships($object);
    }

    public function preUpdate($object)
    {
        $this->makeRelationships($object);
    }

    public function redirect(Compras\Fornecedor $fornecedor)
    {
        $cgm = $fornecedor->getFkSwCgm()->getNumcgm();
        $this->forceRedirect("/patrimonial/compras/fornecedor/" . $cgm . "/show");
    }

    /**
     * @param Compras\FornecedorClassificacao $fornecedorClassificacao
     */
    public function postPersist($fornecedorClassificacao)
    {
        $this->redirect($fornecedorClassificacao->getFkComprasFornecedor());
    }

    /**
     * @param Compras\FornecedorClassificacao $fornecedorClassificacao
     */
    public function postUpdate($fornecedorClassificacao)
    {
        $this->redirect($fornecedorClassificacao->getFkComprasFornecedor());
    }

    /**
     * @param Compras\FornecedorClassificacao $fornecedorClassificacao
     */
    public function postRemove($fornecedorClassificacao)
    {
        $this->redirect($fornecedorClassificacao->getFkComprasFornecedor());
    }
}
