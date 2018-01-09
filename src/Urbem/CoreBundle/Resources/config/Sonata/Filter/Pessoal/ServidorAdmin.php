<?php

namespace Urbem\CoreBundle\Resources\config\Sonata\Filter\Pessoal;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ServidorAdmin extends AbstractSonataAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('fkSwCgmPessoaFisica.fkSwCgm.nomCgm');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->add('fkSwCgmPessoaFisica.fkSwCgm.nomCgm');
    }
}
