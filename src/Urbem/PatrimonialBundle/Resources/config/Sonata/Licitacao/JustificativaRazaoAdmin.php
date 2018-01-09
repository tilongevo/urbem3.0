<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Licitacao\CotacaoLicitacao;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\Administracao\TipoDocumento;
use Urbem\CoreBundle\Entity\Administracao\ModeloDocumento;
use Urbem\CoreBundle\Model\Patrimonial\Compras\CotacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\FornecedorModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\AdjudicacaoAnuladaModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\AdjudicacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\LicitacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Urbem\CoreBundle\Entity\Compras;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class JustificativaRazaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_justificativa_razao';
    protected $baseRoutePattern = 'patrimonial/licitacao/justificativa-razao';

    protected $exibirBotaoExcluir = false;
    protected $exibirBotaoIncluir = false;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
        $collection->remove('edit');
        $collection->remove('list');
    }
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('justificativa')
            ->add('razao')
            ->add('fundamentacaoLegal')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codLicitacao')
            ->add('codModalidade')
            ->add('codEntidade')
            ->add('exercicio')
            ->add('justificativa')
            ->add('razao')
            ->add('fundamentacaoLegal')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('justificativa', null, ['label' => 'label.patrimonial.licitacao.justificativaRazao.justificativa'])
            ->add('razao', null, ['label' => 'label.patrimonial.licitacao.justificativaRazao.razao'])
            ->add('fundamentacaoLegal', null, ['label' => 'label.patrimonial.licitacao.justificativaRazao.fundamentacaoLegal'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codLicitacao')
            ->add('codModalidade')
            ->add('codEntidade')
            ->add('exercicio')
            ->add('justificativa')
            ->add('razao')
            ->add('fundamentacaoLegal')
        ;
    }
}
