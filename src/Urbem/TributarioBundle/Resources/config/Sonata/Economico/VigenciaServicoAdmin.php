<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Model\Economico\VigenciaServicoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class VigenciaServicoAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Economico
 */
class VigenciaServicoAdmin extends AbstractSonataAdmin
{

    protected $baseRouteName = 'urbem_tributario_economico_vigencia_servico';
    protected $baseRoutePattern = 'tributario/hierarquia-servico/cadastro-economico/vigencia-servico';
    protected $exibirBotaoExcluir = false;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codVigencia', null, ['label' => 'label.economico.vigenciaServico.codVigencia'])
            ->add('dtInicio', null, ['label' => 'label.economico.vigenciaServico.dtInicio'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codVigencia', null, ['label' => 'label.economico.vigenciaServico.codVigencia'])
            ->add('dtInicio', null, ['label' => 'label.economico.vigenciaServico.dtInicio'])
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

        $formMapper
            ->with('label.economico.vigenciaServico.dadosVigencia')
            ->add(
                'dtInicio',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.economico.vigenciaServico.dtInicio'
                ]
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with('label.economico.vigenciaServico.dadosVigencia')
            ->add('codVigencia', null, ['label' => 'label.economico.vigenciaServico.codVigencia'])
            ->add('dtInicio', null, ['label' => 'label.economico.vigenciaServico.dtInicio'])
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $vigenciaServicoModel = new VigenciaServicoModel($em);
        if (!$vigenciaServicoModel->isDataInicioMaior($object->getDtInicio()->format('Y-m-d'))) {
            $error = $this->getTranslator()->trans('label.economico.vigenciaServico.validate.dtInicioMaior');
            $errorElement->with('dtInicio')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
        }
    }
}
