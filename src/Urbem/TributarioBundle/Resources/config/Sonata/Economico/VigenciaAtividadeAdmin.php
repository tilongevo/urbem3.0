<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use DateTime;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Economico\VigenciaAtividade;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class VigenciaAtividadeAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_vigencia_atividade';
    protected $baseRoutePattern = 'tributario/cadastro-economico/hierarquia-atividade/vigencia';

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $vigencia = $em->getRepository(VigenciaAtividade::class)->findOneBy([], ['dtInicio' => 'DESC']);
        if (!$vigencia) {
            return;
        }

        $em->refresh($vigencia);

        $oldObject = $em->getUnitOfWork()->getOriginalEntityData($object);
        if (!empty($oldObject) && $oldObject['dtInicio'] == $this->getForm()->get('dtInicio')->getData()) {
            return;
        }

        if ($object->getDtInicio() <= $vigencia->getDtInicio()) {
            $error = str_replace('{minDtInicio}', $vigencia->getDtInicio()->format('d/m/Y'), $this->getTranslator()->trans('label.economicoVigenciaAtividade.erroVigenciaAtividade'));
            $errorElement->with('dtInicio')->addViolation($error)->end();
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codVigencia', null, ['label' => 'label.economicoVigenciaAtividade.codVigencia'])
            ->add(
                'dtInicio',
                'doctrine_orm_date',
                [
                    'field_type' => 'sonata_type_date_picker',
                    'field_options' => [
                        'format' => 'dd/MM/yyyy'
                    ],
                    'label' => 'label.economicoVigenciaAtividade.dtInicio'
                ]
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codVigencia', null, ['label' => 'label.economicoVigenciaAtividade.codVigencia'])
            ->add('dtInicio', null, ['label' => 'label.economicoVigenciaAtividade.dtInicio']);

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formMapper->with('label.economicoVigenciaAtividade.cabecalho');

        if ($id) {
            $formMapper->add(
                'codVigencia',
                'text',
                [
                    'disabled' => true,
                    'label' => 'label.economicoVigenciaAtividade.codVigencia',
                ]
            );
        }

        $formMapper->add(
            'dtInicio',
            'datepkpicker',
            [
                'pk_class' => DatePK::class,
                'dp_default_date' => (new DateTime())->format('d/m/Y'),
                'format' => 'dd/MM/yyyy',
                'required' => true,
                'label' => 'label.economicoVigenciaAtividade.dtInicio',
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
            ->with('label.economicoVigenciaAtividade.cabecalho')
            ->add('codVigencia', null, ['label' => 'label.economicoVigenciaAtividade.codVigencia'])
            ->add('dtInicio', null, ['label' => 'label.economicoVigenciaAtividade.dtInicio']);
    }
}
