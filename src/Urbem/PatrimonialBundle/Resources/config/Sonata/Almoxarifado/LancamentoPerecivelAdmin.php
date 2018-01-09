<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Almoxarifado\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\AtributoEstoqueMaterialValor;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItemMarca;
use Urbem\CoreBundle\Entity\Almoxarifado\EstoqueMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoMaterial;
use Urbem\CoreBundle\Entity\Almoxarifado\LancamentoPerecivel;
use Urbem\CoreBundle\Entity\Almoxarifado\Marca;
use Urbem\CoreBundle\Entity\Almoxarifado\NaturezaLancamento;
use Urbem\CoreBundle\Entity\Almoxarifado\Perecivel;
use Urbem\CoreBundle\Repository\Patrimonio\Almoxarifado\LancamentoMaterialRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class LancamentoPerecivelAdmin extends AbstractSonataAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codLancamento')
            ->add('codCentro')
            ->add('codAlmoxarifado')
            ->add('codMarca')
            ->add('codItem')
            ->add('lote')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('codLancamento')
            ->add('codCentro')
            ->add('codAlmoxarifado')
            ->add('codMarca')
            ->add('codItem')
            ->add('lote')
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
            ->add('perecivel', 'sonata_type_admin', [], [
                'admin_code' => 'patrimonial.admin.processar_implantacao_perecivel'
            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('codLancamento')
            ->add('codCentro')
            ->add('codAlmoxarifado')
            ->add('codMarca')
            ->add('codItem')
            ->add('lote')
        ;
    }
}
