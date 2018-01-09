<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Ppa;

use Urbem\CoreBundle\Model\Ppa\ProdutoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProdutoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_plano_plurianual_produto';
    protected $baseRoutePattern = 'financeiro/plano-plurianual/produto';
    protected $model = ProdutoModel::class;
    protected $codigo;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codProduto',
                null,
                array(
                    'label' => 'label.codigo'
                )
            )
            ->add(
                'descricao',
                null,
                array(
                    'label' => 'label.produto.descricao'
                )
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add(
                'codProduto',
                null,
                array(
                    'label' => 'label.produto.codProduto'
                )
            )
            ->add(
                'descricao',
                null,
                array(
                    'label' => 'label.produto.descricao'
                )
            )
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager
            ->getEntityManager($this->getClass());

        $formMapper
            ->with('label.produto.dadosCadastroProdutosPpa');

        $this->codigo = $id;
        if (!$id) {
            $produtoModel = new ProdutoModel($em);
            $this->codigo = $produtoModel->getProximoCodProduto();
        }

        $formMapper
            ->add(
                'codProduto',
                null,
                array(
                    'label' => 'label.produto.codProduto',
                    'disabled' => true,
                    'data' => $this->codigo
                )
            );

        $formMapper
            ->add(
                'descricao',
                null,
                array(
                    'label' => 'label.produto.descricao'
                )
            )
            ->add(
                'especificacao',
                null,
                array(
                    'label' => 'label.produto.especificacao'
                )
            )
        ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with('label.produto.dadosCadastroProdutosPpa')
                ->add(
                    'produto',
                    'text',
                    array(
                        'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
                        'data' => $this->getSubject()->getCodProduto(). ' - '. $this->getSubject()->getDescricao(),
                        'label' => 'label.produto.descricao'
                    )
                )
                ->add(
                    'especificacao',
                    null,
                    array(
                        'label' => 'label.produto.especificacao'
                    )
                )
            ->end()
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $object->setCodProduto($this->codigo);
    }
}
