<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Licitacao\Contrato;
use Urbem\CoreBundle\Entity\Licitacao\RescisaoContrato;
use Urbem\CoreBundle\Entity\Licitacao\RescisaoContratoResponsavelJuridico;
use Urbem\CoreBundle\Entity\Licitacao\VeiculosPublicidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\RescisaoContratoModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\RescisaoContratoResponsavelJuridicoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Symfony\Component\HttpFoundation\RedirectResponse;

class RescisaoContratoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_rescisao_contrato';

    protected $baseRoutePattern = 'patrimonial/licitacao/rescisao-contrato';
    protected $exibirBotaoIncluir = false;

    /**
     * @param ErrorElement $errorElement
     * @param RescisaoContrato $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $formData = $this->getRequest()->request->get($this->getUniqid());

        $numContrato = $formData['numContrato'];
        $exercicioEntidade = $formData['exercicioEntidade'];
        $codEntidade = $formData['codEntidade'];
        $contrato = $entityManager->getRepository(Contrato::class)->findOneBy(['exercicio' => $exercicioEntidade, 'codEntidade' => $codEntidade, 'numContrato' => $numContrato]);

        if ($object->getDtRescisao() < $contrato->getDtAssinatura()) {
            $dtRescisao = $object->getDtRescisao()->format("d/m/Y");
            $dtAssinatura = $contrato->getDtAssinatura()->format("d/m/Y");
            $mensagem = $this->trans('DataDaRescisaoNaoPodeSerAnteriorQueADatadeAssinatura', ['%dtRescisao%' => $dtRescisao, '%dtAssinatura%' => $dtAssinatura], 'messages');
            $errorElement->with('dtRescisao')->addViolation($mensagem)->end();
        }
    }



    public function prePersist($object)
    {
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $formData = $this->getRequest()->request->get($this->getUniqid());
        $numContrato = $formData['numContrato'];
        $exercicioEntidade = $formData['exercicioEntidade'];
        $codEntidade = $formData['codEntidade'];
        $motivo = $formData['motivo'];

        /** @var  Licitacao/Contrato $contrato */
        $contrato = $entityManager->getRepository(Contrato::class)->findOneBy(['exercicio' => $exercicioEntidade, 'codEntidade' => $codEntidade, 'numContrato' => $numContrato]);

        //dump($contrato);die;

        $rescisaoContratoModel = new RescisaoContratoModel($entityManager);
        $numRescisao = $rescisaoContratoModel->getProximoNumRescisao($contrato->getExercicio(), $contrato->getNumContrato());
        $object->setNumRescisao($numRescisao);
        $object->setExercicio($this->getExercicio());
        $object->setFkLicitacaoContrato($contrato);
        //$object->setMotivo($motivo);

        if ($formData['fkLicitacaoRescisaoContratoResponsavelJuridico']) {
            $cgm = $entityManager
                ->getRepository('CoreBundle:SWCgm')
                ->findOneBynumcgm($formData['fkLicitacaoRescisaoContratoResponsavelJuridico']);

            $rescisaoContratoResponsavelJuridicoModel = new RescisaoContratoResponsavelJuridicoModel($entityManager);
            $rescisao = $rescisaoContratoResponsavelJuridicoModel->buildRescisaoContratoResponsavelJuridico($object, $cgm);
            $object->setFkLicitacaoRescisaoContratoResponsavelJuridico($rescisao);
        }
    }

    public function postPersist($object)
    {
        $this->redirectShow();
    }

    public function postUpdate($object)
    {
        $this->redirectShow();
    }

    public function postRemove($object)
    {
        $this->redirectShow();
    }

    public function redirectShow()
    {
        $this->forceRedirect('/patrimonial/compras/contrato/list');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicioContrato')
            ->add('numContrato')
            ->add('exercicio')
            ->add('dtRescisao')
            ->add('vlrMulta')
            ->add('vlrIndenizacao')
            ->add('motivo');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('exercicioContrato')
            ->add('numContrato')
            ->add('exercicio')
            ->add('dtRescisao')
            ->add('vlrMulta')
            ->add('vlrIndenizacao')
            ->add('motivo')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $numContrato = $formData['numContrato'];
            $exercicioEntidade = $formData['exercicioEntidade'];
            $codEntidade = $formData['codEntidade'];
        } else {
            list($exercicioEntidade, $codEntidade, $numContrato) = explode("~", $id);
        }

        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        /** @var  Licitacao/Contrato $contrato */
        $contrato = $entityManager->getRepository(Contrato::class)->findOneBy(['exercicio' => $exercicioEntidade, 'codEntidade' => $codEntidade, 'numContrato' => $numContrato]);

        $fieldOptions['responsavel'] = [
            'label' => 'label.patrimonial.compras.contrato.cgmResponsavelJuridico',
            'multiple' => false,
            'mapped' => false,
            'required' => true,
            'class' => SwCgm::class,
            'route' => ['name' => 'carrega_sw_cgm_pessoa_juridica']
        ];

        $formMapper
            ->add('fkLicitacaoRescisaoContratoResponsavelJuridico', 'autocomplete', $fieldOptions['responsavel'])
            ->add('numContrato', 'hidden', ['data' => $numContrato, 'mapped' => false])
            ->add('codEntidade', 'hidden', ['data' => $codEntidade, 'mapped' => false])
            ->add('exercicioEntidade', 'hidden', ['data' => $exercicioEntidade, 'mapped' => false])
            ->add(
                'dtRescisao',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.patrimonial.compras.contrato.dtAnulacao',
                    'required' => true,
                    'dp_default_date' => $contrato->getDtAssinatura()->format('d/m/Y'),
                    'dp_min_date' => $contrato->getDtAssinatura()->format('d/m/Y'),
                ]
            )
            ->add('vlrMulta', 'money', ['label' => 'label.patrimonial.compras.contrato.vlrMulta', 'attr' => ['class' => 'money '], 'currency' => 'BRL'])
            ->add('vlrIndenizacao', 'money', ['label' => 'label.patrimonial.compras.contrato.vlrIndenizacao', 'attr' => ['class' => 'money '], 'currency' => 'BRL'])
            ->add('motivo', null, ['label' => 'label.patrimonial.compras.contrato.motivo']);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('exercicioContrato')
            ->add('numContrato')
            ->add('exercicio')
            ->add('dtRescisao')
            ->add('vlrMulta')
            ->add('vlrIndenizacao')
            ->add('motivo');
    }
}
