<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Contabilidade;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Entity;

/**
 * Admin genérico criado para utilização no sonata_type_model_autocomplete
 *
 * Class PlanoAnaliticaAdmin
 * @package Urbem\CoreBundle\Resources\config\Sonata\Contabilidade
 */
class PlanoAnaliticaAdmin extends AbstractSonataAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('fkPlanoConta')
            ->add('exercicio')
            ->add('naturezaSaldo')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
    }
}
