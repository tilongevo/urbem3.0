<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Monetario;

use Doctrine\Common\Collections\Collection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Monetario\Moeda;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class MoedaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_monetario_moeda';
    protected $baseRoutePattern = 'tributario/cadastro-monetario/moeda';

    /**
     * @param mixed $object
     */
    public function preRemove($object)
    {
        if ($this->canRemove($object)) {
            return;
        }

        $container = $this->getConfigurationPool()->getContainer();

        $errorMessage = sprintf($this->getTranslator()->trans('label.monetarioMoeda.erroDelecao'), $object->getDescricaoSingular());
        $container->get('session')->getFlashBag()->add('error', $errorMessage);

        $this->modelManager->getEntityManager($this->getClass())->clear();

        return $this->forceRedirect($this->generateObjectUrl('list', $object));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codMoeda', null, ['label' => 'label.monetarioMoeda.codigoMoeda'])
            ->add('descricaoSingular', null, ['label' => 'label.monetarioMoeda.descricaoSingular'])
            ->add('fracaoSingular', null, ['label' => 'label.monetarioMoeda.fracaoSingular'])
            ->add('simbolo', null, ['label' => 'label.monetarioMoeda.simboloMoeda']);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codMoeda', null, ['label' => 'label.codigo'])
            ->add('descricaoSingular', null, ['label' => 'label.descricao'])
            ->add('fracaoSingular', null, ['label' => 'label.monetarioMoeda.fracao'])
            ->add('simbolo');

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
            ->with('label.monetarioMoeda.dados')
                ->add('descricaoSingular', null, ['label' => 'label.monetarioMoeda.descricaoSingular'])
                ->add('descricaoPlural', null, ['label' => 'label.monetarioMoeda.descricaoPlural'])
                ->add('fracaoSingular', null, ['label' => 'label.monetarioMoeda.fracaoSingular'])
                ->add('fracaoPlural', null, ['label' => 'label.monetarioMoeda.fracaoPlural'])
                ->add('simbolo', null, ['label' => 'label.monetarioMoeda.simboloMoeda'])
                ->add('inicioVigencia', 'sonata_type_date_picker', [
                    'label' => 'label.monetarioMoeda.inicioVigencia',
                    'format' => 'dd/MM/yyyy'
                ])
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
            ->with('label.monetarioMoeda.dados')
            ->add('descricaoSingular', null, ['label' => 'label.monetarioMoeda.descricaoSingular'])
            ->add('descricaoPlural', null, ['label' => 'label.monetarioMoeda.descricaoPlural'])
            ->add('fracaoSingular', null, ['label' => 'label.monetarioMoeda.fracaoSingular'])
            ->add('fracaoPlural', null, ['label' => 'label.monetarioMoeda.fracaoSingular'])
            ->add('simbolo', null, ['label' => 'label.monetarioMoeda.simboloMoeda'])
            ->add('inicioVigencia', null, ['label' => 'label.monetarioMoeda.inicioVigencia']);
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        if ($object->getCodMoeda()) {
            return;
        }

        $em = $this->modelManager->getEntityManager($this->getClass());
        $moeda = $em->getRepository(Moeda::class)
            ->findOneBy(
                [
                    'descricaoSingular' => $object->getDescricaoSingular()
                ]
            );

        if ($moeda) {
            $error = $this->getTranslator()->trans('label.monetarioMoeda.erroMoeda');
            $errorElement->with('descricaoSingular')->addViolation($error)->end();
        }
    }

    /**
    * @param mixed $object
    * @return string
    */
    public function toString($object)
    {
        return ($object->getCodMoeda())
            ? (string) $object
            : $this->getTranslator()->trans('label.monetarioMoeda.modulo');
    }
}
