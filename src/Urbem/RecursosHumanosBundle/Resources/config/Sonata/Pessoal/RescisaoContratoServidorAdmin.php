<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal\GeneralFilterAdmin;

class RescisaoContratoServidorAdmin extends GeneralFilterAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_rescisao_contrato_servidor';
    protected $baseRoutePattern = 'recursos-humanos/pessoal/rescisao-contrato-servidor';
    protected $exibirMensagemFiltro = true;
    protected $exibirBotaoIncluir = false;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        parent::configureGridFilters($datagridMapper, GeneralFilterAdmin::RECURSOSHUMANOS_PESSOAL_RESCISAO_CONTRATO_SERVIDOR);
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        if (!$this->getRequest()->query->get('filter')) {
            $query->andWhere("{$query->getRootAliases()[0]}.codContrato = :codContrato")->setParameters(['codContrato' => 0]);
        }
        return $query;
    }

    public function getSearchFilter($queryBuilder, $alias, $field, $value)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $filter = $this->getDataGrid()->getValues();

        if (!$value['value']) {
            return;
        }

        // FILTRO POR MATRICULA
        if (isset($filter['codContrato']['value'])) {
            $contratos = $filter['codContrato']['value'];

            $queryBuilder->resetDQLPart('where');
            $queryBuilder->andWhere(
                $queryBuilder->expr()->in('o.codContrato', $contratos)
            );
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('registro', null, [
                'label' => 'label.registro'
            ])
            ->add('dtNomeacao', null, [
                'label' => 'label.dtNomeacao'
            ])
            ->add('dtPosse', null, [
                'label' => 'label.dtPosse'
            ])
            ->add('dtAdmissao', null, [
                'label' => 'label.dtAdmissao'
            ])
            ->add('orgao', null, [
                'label' => 'label.ppa.numOrgao'
            ])
            ->add('descricao', null, [
                'label' => 'label.norma.descricao'
            ])
            ->add('numcgm', null, [
                'label' => 'label.usuario.numcgm'
            ])
            ->add('nomCgm', null, [
                'label' => 'label.usuario.nomCgm'
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => ['template' => 'RecursosHumanosBundle:Sonata/Pessoal/RescisaoContrato:action_button_rescisao_contrato.html.twig']
                ],
            ])
        ;
    }
}
