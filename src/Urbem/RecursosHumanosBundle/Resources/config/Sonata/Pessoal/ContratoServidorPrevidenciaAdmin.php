<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\Pessoal;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPrevidencia;
use Urbem\CoreBundle\Model\Pessoal\ContratoServidorPrevidenciaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sonata\AdminBundle\Route\RouteCollection;

class ContratoServidorPrevidenciaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_pessoal_contrato_servidor_previdencia';

    protected $baseRoutePattern = 'recursos-humanos/pessoal/contrato-servidor-previdencia';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
    }

    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $codContrato = $this->getForm()->get('codContrato')->getData();
            $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Pessoal\Contrato');
            $contrato = $em->getRepository('Urbem\CoreBundle\Entity\Pessoal\ContratoServidor')->findOneBy(array('codContrato' => $codContrato));

            if ($object->getPrevidencias() != null) {
                $this->deleteContratoServidorPrevidencia($contrato);
                $this->salvaContratoServidorPrevidencia($contrato, $object->getPrevidencias());
            }

            $container->get('session')->getFlashBag()->add('success', 'Contrato previdência adicionado com sucesso');
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            throw $e;
        }
        $this->forceRedirect();
    }

    public function preUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Pessoal\Contrato');
            $contrato = $em->getRepository('Urbem\CoreBundle\Entity\Pessoal\ContratoServidor')->findOneBy(array('codContrato' => 43));

            if ($object->getPrevidencias() != null) {
                $this->deleteContratoServidorPrevidencia($contrato);
                $this->salvaContratoServidorPrevidencia($contrato, $object->getPrevidencias());
            }

            $container->get('session')->getFlashBag()->add('success', 'Contrato previdência adicionado com sucesso');
        } catch (Exception $e) {
            $em->getConnection()->rollback();
            $container->get('session')->getFlashBag()->add('error', self::ERROR_REMOVE_DATA);
            throw $e;
        }
        $this->forceRedirect();
    }

    private function salvaContratoServidorPrevidencia($contrato, $previdencia)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPrevidencia');

        $contratoServidorPrevidenciaModel = new ContratoServidorPrevidenciaModel($em);

        $emp = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\Previdencia');

        foreach ($previdencia as $prev) {
            $contratoServidor = new ContratoServidorPrevidencia();
            $contratoServidor->setCodContrato($contrato);
            $previdencia = $emp->getRepository('Urbem\CoreBundle\Entity\Folhapagamento\Previdencia')->findOneBy(array('codPrevidencia' => $prev));
            $contratoServidor->setCodPrevidencia($previdencia);
            $contratoServidor->setTimestamp(new \DateTime());
            $contratoServidor->setBoExcluido(false);
            $contratoServidorPrevidenciaModel->save($contratoServidor);
        }
    }

    private function deleteContratoServidorPrevidencia($contrato)
    {
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPrevidencia');

        $contratoServidorPrevidenciaModel = new ContratoServidorPrevidenciaModel($em);

        $contratoServidorPrevidenciaModel->deleteContratoServidorPrevidencia($contrato);
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('timestamp')
            ->add('boExcluido');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('timestamp')
            ->add('boExcluido');
        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Pessoal\ContratoServidorPrevidencia');
        $contratoprevidenciaModel = new ContratoServidorPrevidenciaModel($em);
        $listaPrevidencia = $contratoprevidenciaModel->getListaPrevidencia();

        $data = array();

        if($this->getAdminRequestId()) {
            $contratos = $em->getRepository('CoreBundle:Pessoal\ContratoServidorPrevidencia')->findById($this->getAdminRequestId());

            if(count($contratos) > 0) {
                $data = $contratoprevidenciaModel->getListaPrevidenciaSelecionados($contratos[0]->getCodContrato()->getCodContrato()->getCodContrato());
            }
        }

        $formMapper
            ->add(
                'previdencias',
                'choice',
                [
                    'label' => 'Registros',
                    'multiple' => true,
                    'choices' => $listaPrevidencia,
                    'attr' => array(
                        'data-sonata-select2' => 'false',
                    ),
                    'mapped' => true,
                    'required' => false,
                    'data' => $data
                ]
            )
            ->add(
                'codContrato',
                'hidden',
                [
                    'data' => $this->getAdminRequestId(),
                    'mapped' => false
                ]
            );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('timestamp')
            ->add('boExcluido');
    }
}
