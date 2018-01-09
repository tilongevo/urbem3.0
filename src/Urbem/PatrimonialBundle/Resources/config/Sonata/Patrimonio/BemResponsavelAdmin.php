<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Patrimonio;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

use Urbem\CoreBundle\Model;

use Sonata\AdminBundle\Route\RouteCollection;

use Urbem\CoreBundle\Model\Patrimonial\Patrimonio\BemResponsavelModel;
use Urbem\CoreBundle\Entity\Patrimonio;

class BemResponsavelAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_patrimonio_bem_responsavel';

    protected $baseRoutePattern = 'patrimonial/patrimonio/bem/modificar-responsavel';

    protected $model = Model\Patrimonial\Patrimonio\BemResponsavelModel::class;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create', 'list'));
    }

    protected $includeJs = [
        '/patrimonial/javascripts/patrimonio/bem-responsavel.js'
    ];

    protected $exibirBotaoVoltar = false;

    /**
     * @param ErrorElement $errorElement
     * @param Patrimonio\BemResponsavel $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $dtInicio = $this->getForm()->get('MFdtInicio')->getData();
        $dtInicioAnterior = $this->getForm()->get('dtInicioAnterior')->getData();
        $responsavelAnterior = $this->getForm()->get('MFResponsavelAnterior')->getData();
        $responsavel = $this->getForm()->get('MFResponsavel')->getData();

        $datanova = explode('/', $dtInicioAnterior);
        $datanova = $datanova[2] . '-' . $datanova[1] . '-' . $datanova[0];
        $dtInicioAnterior = new \DateTime($datanova);
        $now = new \DateTime();
        if ($dtInicio < $dtInicioAnterior) {
            $message = $this->trans('bemResponsavel.errors.dtInicioMaiorAnterior', [], 'validators');
            $errorElement->addViolation($message)->end();
        }

        if ($dtInicio > $now) {
            $message = $this->trans('bemResponsavel.errors.dtInicioMaiorHoje', [], 'validators');
            $errorElement->addViolation($message)->end();
        }

        if ($responsavel == $responsavelAnterior) {
            $message = $this->trans('bemResponsavel.errors.responsaveisIguais', [], 'validators');
            $errorElement->with('MFResponsavel')->addViolation($message)->end();
        }
    }

    /**
     * @param Patrimonio\BemResponsavel $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $BemResponsavelModel = new BemResponsavelModel($em);

        $dtInicio = $this->getForm()->get('MFdtInicio')->getData();
        $dtFim = clone $dtInicio;
        $dtFim->modify("-1 day");

        $responsavelAnterior = $this->getForm()->get('MFResponsavelAnterior')->getData();
        $responsavel = $this->getForm()->get('MFResponsavel')->getData();

        $bemResponsaveis = $em->getRepository('CoreBundle:Patrimonio\BemResponsavel')
            ->createQueryBuilder('br')
            ->where('br.numcgm = :numcgm')
            ->andWhere('br.dtFim IS NULL')
            ->setParameter('numcgm', $responsavelAnterior)
            ->getQuery()
            ->getResult();

        $cgmModel = new Model\SwCgmModel($em);
        $cgm = $cgmModel->findOneByNumcgm($responsavel);
        /** @var Patrimonio\BemResponsavel $bemResponsavel */
        foreach ($bemResponsaveis as $bemResponsavel) {
            $bemResponsavelNew = new Patrimonio\BemResponsavel();
            $bemResponsavelNew->setFkPatrimonioBem($bemResponsavel->getFkPatrimonioBem());
            $bemResponsavelNew->setFkSwCgm($cgm);
            $bemResponsavelNew->setDtInicio($dtInicio);
            $bemResponsavelNew->setDtFim(null);
            $BemResponsavelModel->save($bemResponsavelNew);

            $bemResponsavel->setDtFim($dtFim);
            $BemResponsavelModel->save($bemResponsavel);
        }

        $container = $this->getConfigurationPool()->getContainer();
        $container->get('session')->getFlashBag()->add('success', 'Modificar Responsável concluído com sucesso!');
        $this->forceRedirect('/patrimonial/patrimonio/bem/modificar-responsavel/create');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = [];
        $fieldOptions['MFResponsavelAnterior'] = [
            'route' => [
                'name' => 'patrimonio_carrega_bem_responsavel_anterior',
            ],
            'placeholder' => 'Selecione',
            'label' => 'label.bemResponsavel.responsavelAnterior',
            'mapped' => false,
            'attr' => ['class' => 'select2-parameters '],
        ];

        $fieldOptions['MFResponsavel'] = [
            'route' => [
                'name' => 'patrimonio_carrega_bem_responsavel',
            ],
            'placeholder' => 'Selecione',
            'label' => 'label.bemResponsavel.responsavel',
            'mapped' => false,
            'attr' => ['class' => 'select2-parameters '],
        ];

        $fieldOptions['dtInicioAnterior'] = [
            'label' => 'label.bemResponsavel.dtInicio',
            'mapped' => false,
            'attr' => ['readonly' => 'readonly'],
        ];

        $formMapper
            ->with('label.bemResponsavel.modificarResponsavelBem')
            ->add('MFResponsavelAnterior', 'autocomplete', $fieldOptions['MFResponsavelAnterior'])
            ->add('dtInicioAnterior', 'text', $fieldOptions['dtInicioAnterior'])
            ->add('MFResponsavel', 'autocomplete', $fieldOptions['MFResponsavel'])
            ->add('MFdtInicio', 'sonata_type_date_picker', [
                'label' => 'label.bemResponsavel.dtInicio',
                'format' => 'dd/MM/yyyy',
                'mapped' => false
            ])
            ->add('MFTermoResponsabilidade', 'checkbox', [
                'label' => 'label.bemResponsavel.termoResponsabilidade',
                'data' => true,
                'required' => false,
                'mapped' => false
            ])
            ->add('MFDemostrarValor', 'checkbox', [
                'label' => 'label.bemResponsavel.demostrarValor',
                'data' => true,
                'required' => false,
                'mapped' => false
            ])
            ->end();
    }
}
