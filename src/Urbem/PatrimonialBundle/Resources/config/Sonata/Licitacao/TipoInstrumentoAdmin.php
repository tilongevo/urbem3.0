<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\RedirectResponse;

class TipoInstrumentoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_tipo_instrumento';

    protected $baseRoutePattern = 'patrimonial/licitacao/tipo-instrumento';

    public function validate(ErrorElement $errorElement, $object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $tipo = $entityManager
            ->getRepository('CoreBundle:Licitacao\TipoInstrumento')
            ->findOneBy(
                [
                    'codigoTc' => $object->getCodigoTc()
                ]
            );

        if (count($tipo) > 0) {
            $mensagem = $this->trans('CodigoDeTribunalJaExisteEscolhaOutroCodigo', [], 'messages');

            $container->get('session')->getFlashBag()->add('error', $mensagem);

            $errorElement->with('codigo_tc')->addViolation($mensagem)->end();
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codTipo', null, ['label' => 'label.patrimonial.compras.contrato.codTipo'])
            ->add('descricao', null, ['label' => 'label.patrimonial.compras.contrato.descricao'])
            ->add('ativo');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $listMapper
            ->add('codTipo', null, ['label' => 'label.patrimonial.compras.contrato.codTipo'])
            ->add('descricao', null, ['label' => 'label.patrimonial.compras.contrato.descricao'])
            ->add('codigo_tc', null, ['label' => 'label.patrimonial.compras.contrato.tipoTc'])
            ->add('ativo');

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formMapper
            ->add('descricao', null, ['label' => 'label.patrimonial.compras.contrato.descricao'])
            ->add('codigo_tc', 'text', ['label' => 'label.patrimonial.compras.contrato.tipoTc'])
            ->add('ativo');
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add('codTipo', null, ['label' => 'label.patrimonial.compras.contrato.codTipo'])
            ->add('descricao', null, ['label' => 'label.patrimonial.compras.contrato.descricao'])
            ->add('codigo_tc', null, ['label' => 'label.patrimonial.compras.contrato.tipoTc'])
            ->add('ativo');
    }
}
