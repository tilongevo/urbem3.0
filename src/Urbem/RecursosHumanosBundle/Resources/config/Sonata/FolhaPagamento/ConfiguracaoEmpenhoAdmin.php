<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model\Folhapagamento\ConfigEmpenhoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ConfiguracaoEmpenhoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_configuracao_empenho';

    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/configuracao/empenho';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        // Busca o tipo_opcao e redireciona
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\ConfigEmpenho');
        $configEmpenhoModel = new ConfigEmpenhoModel($em);
        $configEmpenho = $configEmpenhoModel->findOneByCodConfigEmpenho($id);
        $tipoOpcao = $configEmpenho->getTipoOpcao();

        if ($tipoOpcao == 1) { // lotacao
            $this->forceRedirect('/recursos-humanos/folha-pagamento/configuracao/empenho-evento-lotacao/list?id=' . $id);
        } elseif ($tipoOpcao == 2) { // local
            $this->forceRedirect('/recursos-humanos/folha-pagamento/configuracao/empenho-evento-local/list?id=' . $id);
        } elseif ($tipoOpcao == 3) { // atributo
            $this->forceRedirect('/recursos-humanos/folha-pagamento/configuracao/empenho-evento-atributo/list?id=' . $id);
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('id')
            ->add('exercicioPao')
            ->add('exercicioDespesa')
            ->add('codDespesa')
            ->add('numPao')
            ->add('exercicio')
            ->add('sequencia')
            ->add('vigencia')
        ;
    }
}
