<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

use Urbem\CoreBundle\Entity\Compras;

class FornecedorSocioAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_fornecedor_socio';
    protected $baseRoutePattern = 'patrimonial/compras/fornecedor/socio';

    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->remove('batch');
        $routeCollection->remove('show');
        $routeCollection->remove('export');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /**
         * Auxilia na execuÃ§ao das Models
         *
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $route = $this->getRequest()->get('_sonata_name');
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $cgmFornecedor = $formData['cgmFornecedor'];
        } else {
            $cgmFornecedor = $this->request->get('cgm_fornecedor');
        }

        /**
         * @var Compras\Fornecedor $fornecedor
         */
        $fornecedor = !is_null($route) ? $entityManager->getRepository(Compras\Fornecedor::class)->find($cgmFornecedor) : null;

        $fieldOptions = [];
        $fieldOptions['fornecedor'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'class' => Compras\Fornecedor::class,
            'choice_label' => 'fkSwCgm.nomCgm',
            'disabled' => true,
            'data' => is_null($fornecedor) ? null : $fornecedor,
            'label' => 'label.fornecedor.cgmFornecedor',
            'mapped' => false
        ];

        $fieldOptions['cgmFornecedor'] = [
            'data' => is_null($fornecedor) ? $cgmFornecedor : $fornecedor->getFkSwCgm()->getNumcgm()
        ];

        $fieldOptions['cgmSocio'] = [
            'label' => 'label.fornecedor.cgmSocio',
            'property' => 'nomCgm',
            'to_string_callback' => function (SwCgm $swCgm, $property) {
                return $swCgm->getNomCgm();
            },
            'placeholder' => $this->trans('label.selecione'),
            'required' => true
        ];

        if (!is_null($id)) {
            $fieldOptions['cgmSocio']['disabled'] = true;
        }

        $fieldOptions['codTipo'] = [
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'class' => Compras\TipoSocio::class,
            'choice_label' => 'descricao',
            'label' => 'label.item.codTipo',
            'placeholder' => 'label.selecione',
            'required' => true
        ];

        $formMapper->with('label.fornecedor.socios');

        if (!is_null($route)) {
            $formMapper
                ->add('fornecedor', 'entity', $fieldOptions['fornecedor'])
                ->add('cgmFornecedor', 'hidden', $fieldOptions['cgmFornecedor']);
        }

        $formMapper
            ->add('fkSwCgm', 'sonata_type_model_autocomplete', $fieldOptions['cgmSocio'], ['admin_code' => 'core.admin.filter.sw_cgm'])
            ->add('fkComprasTipoSocio', 'entity', $fieldOptions['codTipo'])
            ->add('ativo');

        $formMapper->end();
    }

    /**
     * @param Compras\FornecedorSocio $fornecedorSocio
     */
    public function makeRelationships(Compras\FornecedorSocio $fornecedorSocio)
    {
        /**
         * Auxilia na execuÃ§ao das Models
         *
         * @var \Doctrine\ORM\EntityManager $entityManager
         */
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());

        $fornecedor = $entityManager
            ->getRepository(Compras\Fornecedor::class)
            ->find($fornecedorSocio->getCgmFornecedor());

        $fornecedorSocio->setFkComprasFornecedor($fornecedor);
    }

    /**
     * @param Compras\FornecedorSocio $fornecedorSocio
     */
    public function prePersist($fornecedorSocio)
    {
        $this->makeRelationships($fornecedorSocio);
    }

    /**
     * @param Compras\FornecedorSocio $fornecedorSocio
     */
    public function preUpdate($fornecedorSocio)
    {
        $this->makeRelationships($fornecedorSocio);
    }

    public function redirect(Compras\Fornecedor $fornecedor)
    {
        $cgm = $fornecedor->getFkSwCgm()->getNumcgm();
        $this->forceRedirect("/patrimonial/compras/fornecedor/" . $cgm . "/show");
    }

    public function postPersist($object)
    {
        $this->redirect($object->getFkComprasFornecedor());
    }

    public function postUpdate($object)
    {
        $this->redirect($object->getFkComprasFornecedor());
    }

    public function postRemove($object)
    {
        $this->redirect($object->getFkComprasFornecedor());
    }
}
