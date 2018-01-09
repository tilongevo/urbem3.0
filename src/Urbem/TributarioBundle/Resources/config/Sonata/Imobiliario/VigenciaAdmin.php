<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Imobiliario\Vigencia;
use Urbem\CoreBundle\Model\Imobiliario\VigenciaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class VigenciaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_vigencia';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/hierarquia/vigencia';
    protected $model = VigenciaModel::class;
    protected $datagridValues = array(
        '_page' => 1,
        '_sort_order' => "DESC",
        '_sort_by' => 'codVigencia'
    );

    /**
     * @param DatagridMapper $datagridMapper
     */
    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codVigencia', null, array(
                'label' => 'label.imobiliarioVigencia.codVigencia'
            ))
            ->add('dtInicio', 'doctrine_orm_date', array(
                'label' => 'label.imobiliarioVigencia.dtInicio',
                'field_type' => 'sonata_type_date_picker',
                'field_options' => array(
                    'format' => 'dd/MM/yyyy',
                )
            ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codVigencia', 'string', array('label' => 'label.imobiliarioVigencia.codVigencia'))
            ->add('dtInicio', null, array('label' => 'label.imobiliarioVigencia.dtInicio'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig')
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formMapper->with('label.imobiliarioVigencia.dados');

        if ($this->id($this->getSubject())) {
            $formMapper->add('codVigencia', null, array(
                'label' => 'label.imobiliarioVigencia.codVigencia',
                'disabled' => true
            ));
        }

        $formMapper->add('dtInicio', 'sonata_type_date_picker', array(
            'label' => 'label.imobiliarioVigencia.dtInicio',
            'format' => 'dd/MM/yyyy'
        ));

        $formMapper->end();
    }

    /**
     * @param ErrorElement $errorElement
     * @param Vigencia $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        if ($this->id($this->getSubject())) {
            if ($object->getFkImobiliarioNiveis()->count()) {
                $error = $this->getTranslator()->trans('label.imobiliarioVigencia.erroAlterar');
                $errorElement->with('dtInicio')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
            } else {
                $lastDtInicio = (new VigenciaModel($em))->lastDtVigencia($object);
                if ($object->getDtInicio() <= $lastDtInicio) {
                    $error = $this->getTranslator()->trans('label.imobiliarioVigencia.erroDtInicio', ['%dtInicio%' => $lastDtInicio->format('d/m/Y')]);
                    $errorElement->with('dtInicio')->addViolation($error)->end();
                    $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
                }
            }
        } else {
            $lastDtInicio = (new VigenciaModel($em))->lastDtVigencia();
            if ($object->getDtInicio() <= $lastDtInicio) {
                $error = $this->getTranslator()->trans('label.imobiliarioVigencia.erroDtInicio', ['%dtInicio%' => $lastDtInicio->format('d/m/Y')]);
                $errorElement->with('dtInicio')->addViolation($error)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
            }
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return ($object->getCodVigencia())
            ? (string) $object
            : $this->getTranslator()->trans('label.imobiliarioVigencia.modulo');
    }

    /**
     * @param mixed $object
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function preRemove($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $container = $this->getConfigurationPool()->getContainer();

        if (!(new VigenciaModel($em))->canRemove($object)) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.imobiliarioVigencia.msgExclusao'));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }
    }
}
