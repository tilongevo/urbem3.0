<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Monetario;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Monetario\Banco;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class BancoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_monetario_banco';
    protected $baseRoutePattern = 'tributario/cadastro-monetario/banco';

    /**
     * @param mixed $object
     */
    public function preRemove($object)
    {
        if ($object->getFkMonetarioAgencias()->isEmpty()) {
            return;
        }

        $container = $this->getConfigurationPool()->getContainer();

        $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.monetarioBanco.erroDelecao'));

        $this->modelManager->getEntityManager($this->getClass())->clear();

        $this->forceRedirect($this->generateObjectUrl('list', $object));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('numBanco', null, array('label' => 'label.monetarioBanco.numBanco'))
            ->add('nomBanco', null, array('label' => 'label.monetarioBanco.nomeBanco'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('numBanco', null, array('label' => 'label.monetarioBanco.numBanco'))
            ->add('nomBanco', null, array('label' => 'label.monetarioBanco.nomeBanco'))
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

        $banco = $this->getSubject();

        $fieldOptions['numBanco'] = array(
            'attr' => [
                'min' => 0,
                'max' => 999
            ],
            'label' => 'label.monetarioBanco.numBanco',
        );

        if ($banco->getCodBanco()) {
            $fieldOptions['numBanco']['disabled'] = true;
            $fieldOptions['numBanco']['mapped'] = false;
            $fieldOptions['numBanco']['data'] = $banco->getNumBanco();
        }

        $formMapper
            ->with('label.monetarioBanco.dados')
                ->add('numBanco', 'integer', $fieldOptions['numBanco'])
                ->add('nomBanco', null, ['label' => 'label.monetarioBanco.nomeBanco'])
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
            ->with('label.monetarioBanco.dados')
            ->add('numBanco', 'string', array('label' => 'label.monetarioBanco.numBanco'))
            ->add('nomBanco', 'string', array('label' => 'label.monetarioBanco.nomeBanco'))
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        if ($object->getCodBanco()) {
            return;
        }

        $em = $this->modelManager->getEntityManager($this->getClass());
        $numBanco = $em->getRepository(Banco::class)
            ->findOneBy(['numBanco' => $object->getNumBanco()]);

        if ($numBanco && $numBanco->getNumBanco()) {
            $error = $this->getTranslator()->trans('label.monetarioBanco.erroNumBanco');
            $errorElement->with('numBanco')->addViolation($error)->end();
        }

        $nomBanco = $em->getRepository(Banco::class)
            ->findOneBy(['nomBanco' => $object->getNomBanco()]);

        if ($nomBanco && $nomBanco->getNomBanco()) {
            $error = $this->getTranslator()->trans('label.monetarioBanco.erroNomBanco');
            $errorElement->with('nomBanco')->addViolation($error)->end();
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return ($object->getNumBanco())
            ? (string) $object
            : $this->getTranslator()->trans('label.monetarioBanco.modulo');
    }
}
