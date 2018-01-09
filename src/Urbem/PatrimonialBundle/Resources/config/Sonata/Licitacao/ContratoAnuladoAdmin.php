<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Licitacao\Contrato;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ContratoAnuladoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_contrato_anulado';

    protected $baseRoutePattern = 'patrimonial/licitacao/contrato-anulado';
    protected $exibirBotaoIncluir = false;

    public function validate(ErrorElement $errorElement, $object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        $formData = $this->getRequest()->request->get($this->getUniqid());
        $numContrato = $formData['numContrato'];
        $exercicioEntidade = $formData['exercicioEntidade'];
        $codEntidade = $formData['codEntidade'];

        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        /** @var  Licitacao/Contrato $contrato */
        $contrato = $entityManager->getRepository(Contrato::class)->findOneBy(['exercicio' => $exercicioEntidade, 'codEntidade' => $codEntidade, 'numContrato' => $numContrato]);

        if ($contrato->getDtAssinatura() > $object->getDtAnulacao()) {

            $dtAnulacao = $object->getDtAnulacao()->format("d/m/Y");
            $dtAssinatura = $contrato->getDtAssinatura()->format("d/m/Y");
            $mensagem = $this->trans('DatadeAnulacaoDeveSerMaiorOuIgualADataDaAssinatura', ['%dtAnulacao%' => $dtAnulacao, '%dtAssinatura%' => $dtAssinatura], 'messages');
            $errorElement->with('dtAnulacao')->addViolation($mensagem)->end();
        }
        if ($contrato->getValorContratado() < $object->getValorAnulacao()) {

            $valorContratado = number_format($contrato->getValorContratado(), 2, ',', ' ');
            $valorAnulacao = number_format($object->getValorAnulacao(), 2, ',', ' ');

            $mensagem = $this->trans('OValorDaAnulacaoNaoPodeSerMaiorQueOValorDoContrato', ['%valorContratado%' => $valorContratado, '%valorAnulacao%' => $valorAnulacao], 'messages');
            $errorElement->with('valorAnulacao')->addViolation($mensagem)->end();
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

        /** @var  Licitacao/Contrato $contrato */
        $contrato = $entityManager->getRepository(Contrato::class)->findOneBy(['exercicio' => $exercicioEntidade, 'codEntidade' => $codEntidade, 'numContrato' => $numContrato]);

        $object->setFkLicitacaoContrato($contrato);
    }

    public function postPersist($object)
    {
        $this->forceRedirect('/patrimonial/compras/contrato/list');
    }

    public function postUpdate($object)
    {
        $this->forceRedirect('/patrimonial/compras/contrato/list');
    }

    public function postRemove($object)
    {
        $this->forceRedirect('/patrimonial/compras/contrato/list');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('exercicio')
            ->add('dtAnulacao')
            ->add('motivo')
            ->add('valorAnulacao');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('exercicio')
            ->add('dtAnulacao')
            ->add('motivo')
            ->add('valorAnulacao')
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

        $formMapper
            ->add('numContrato', 'hidden', ['data' => $numContrato, 'mapped' => false])
            ->add('codEntidade', 'hidden', ['data' => $codEntidade, 'mapped' => false])
            ->add('exercicioEntidade', 'hidden', ['data' => $exercicioEntidade, 'mapped' => false])
            ->add(
                'dtAnulacao',
                'sonata_type_date_picker',
                [
                    'format' => 'dd/MM/yyyy',
                    'label' => 'label.patrimonial.compras.contrato.dtAnulacao',
                    'required' => true,
                    'dp_default_date' => $contrato->getDtAssinatura()->format('d/m/Y'),
                    'dp_min_date' => $contrato->getDtAssinatura()->format('d/m/Y'),
                ]
            )
            ->add('valorAnulacao', 'money', ['data' => $contrato->getValorContratado(), 'attr' => ['class' => 'money '], 'currency' => 'BRL'])
            ->add('motivo', null, ['required' => true]);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('exercicio')
            ->add('dtAnulacao')
            ->add('motivo')
            ->add('valorAnulacao');
    }
}
