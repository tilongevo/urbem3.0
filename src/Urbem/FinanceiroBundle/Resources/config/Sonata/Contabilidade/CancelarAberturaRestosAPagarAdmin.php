<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CancelarAberturaRestosAPagarAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_financeiro_contabilidade_cancelar_abertura_restos_a_pagar';
    protected $baseRoutePattern = 'financeiro/contabilidade/lancamento-contabil/cancelar-abertura-restos-a-pagar';
    protected $exibirBotaoExcluir = false;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('processar','list'));
        $collection->add('processar', 'processar', [
            '_controller' => 'FinanceiroBundle:Contabilidade/LoteAdmin:processarCancelarAberturaRestosAPagar'
        ]);
    }

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (! $this->getRequest()->query->get('filter')) {
            $query->andWhere('1 = 0');
        }
        return $query;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codLote')
            ->add('exercicio')
            ->add('tipo')
            ->add('nomLote')
            ->add('dtLote')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }
}
