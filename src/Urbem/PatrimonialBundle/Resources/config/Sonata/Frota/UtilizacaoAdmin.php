<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\EntityManager;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Helper\TimePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Model;
use Urbem\CoreBundle\Exception;
use Urbem\CoreBundle\Exception\Error;

use Urbem\CoreBundle\Model\Patrimonial\Frota\VeiculoModel;

use Urbem\CoreBundle\Entity\Frota;

use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class UtilizacaoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Frota
 */
class UtilizacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_veiculo_retirar_veiculo';
    protected $baseRoutePattern = 'patrimonial/frota/veiculo/retirar-veiculo';
    protected $includeJs = [
        '/patrimonial/javascripts/frota/retirarVeiculo.js',
    ];

    protected $exibirBotaoIncluir = false;
    protected $exibirBotaoExcluir = false;
    protected $customMessageDelete = "Deseja excluir a retirada do veículo?";

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('consultar_veiculo', 'consultar-veiculo/' . $this->getRouterIdParameter());
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $dtNow = new \DateTime();

        $route = $this->getRequest()->get('_sonata_name');

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $id = $formData['codVeiculo'];
        }

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $veiculo = null;
        if (!is_null($route)) {
            /** @var Frota\Veiculo $veiculo */
            $veiculo = $entityManager
                ->getRepository(Frota\Veiculo::class)
                ->find($id);
        }

        $fieldOptions = [];

        $fieldOptions['veiculo'] = [
            'class' => 'CoreBundle:Frota\Veiculo',
            'choice_label' => function (Frota\Veiculo $veiculo) {
                return $veiculo->getCodVeiculo() . ' - ' .
                    $veiculo->getPlaca() . ' - ' .
                    $veiculo->getFkFrotaMarca()->getNomMarca() . ' - ' .
                    $veiculo->getFkFrotaModelo()->getNomModelo();
            },
            'label' => 'label.veiculoCessao.codVeiculo',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'data' => is_null($veiculo) ? null : $veiculo,
            'mapped' => false,
            'disabled' => true,
        ];

        $fieldOptions['codVeiculo'] = [
            'data' => is_null($veiculo) ? null : $veiculo->getCodVeiculo()
        ];

        $fieldOptions['cgmMotorista'] = [
            'class' => 'CoreBundle:Frota\Motorista',
            'choice_label' => function (Frota\Motorista $cgmMotorista) {
                $return = $cgmMotorista->getFkSwCgm()->getNumcgm();
                $return .= ' - ' . $cgmMotorista->getFkSwCgm()->getNomCgm();
                return $return;
            },
            'label' => 'label.retirarVeiculo.cgmMotorista',
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters '
            ),
            'required' => true
        ];

        $fieldOptions['dtSaida'] = [
            'label' => 'label.retirarVeiculo.dtSaida',
            'pk_class' => DatePK::class,
            'pk_force_default' => true,
            'format' => 'd/M/yyyy'
        ];

        $fieldOptions['hrRetorno'] = [
            'label' => 'label.retornarVeiculo.hrRetorno',
            'widget' => 'single_text',
            'attr' => array('class' => 'fixed-time'),
            'data' => new \DateTime(),
            'with_seconds'  => true,
        ];

        $fieldOptions['hrSaida'] = [
            'attr' => ['class' => 'fixed-time ', 'step' => '60'],
            'data' => new \DateTime(),
            'label' => 'label.retirarVeiculo.hrSaida',
            'model_timezone' => 'America/Sao_Paulo',
            'view_timezone' => 'America/Sao_Paulo',
            'widget' => 'single_text',
            'mapped' => false,
            'with_seconds'  => true,
        ];


        $fieldOptions['kmSaida'] = [
            'label' => 'label.retirarVeiculo.kmSaida',
            'attr' => array(
                'class' => 'km  '
            ),
        ];

        $fieldOptions['destino'] = [
            'label' => 'label.retirarVeiculo.destino',
            'attr' => array(
                'class' => 'money  '
            ),
        ];

        $formMapper
            ->with('label.retirarVeiculo.dadosRetirada')
            ->add('veiculo', 'entity', $fieldOptions['veiculo'])
            ->add('codVeiculo', 'hidden', $fieldOptions['codVeiculo'])
            ->add('cgmMotorista', 'entity', $fieldOptions['cgmMotorista'])
            ->add('dtSaida', 'datepkpicker', $fieldOptions['dtSaida'])
            ->add('hrSaidas', 'time', $fieldOptions['hrSaida'])
            ->add('kmSaida', 'number', $fieldOptions['kmSaida'])
            ->add('destino', null, $fieldOptions['destino'])
            ->end();
    }

    /**
     * @param Frota\Utilizacao $object
     * @param Form $form
     */
    public function saveRelationships($object, $form)
    {
        $em = $this->modelManager->getEntityManager('CoreBundle:Frota\Veiculo');
        $veiculoModel = new VeiculoModel($em);

        $veiculo = $veiculoModel
            ->getVeiculo($object->getCodVeiculo());

        $object->setFkFrotaVeiculo($veiculo);
        $hrSaida = new TimePK($form->get('hrSaidas')->getData()->format('H:i:s'));
        $object->setHrSaida($hrSaida);

        $object->setFkFrotaMotorista($form->get('cgmMotorista')->getData());
    }

    /**
     * @param Frota\Utilizacao $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            throw $e;
            $container->get('sonata_flash_success')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect('/patrimonial/frota/veiculo/retirar-veiculo/create?id=' . $object->getCodVeiculo());
        }
    }

    /**
     * @param Frota\Utilizacao $object
     */
    public function postPersist($object)
    {
        $this->forceRedirect("/patrimonial/frota/veiculo/{$this->getObjectKey($object->getFkFrotaVeiculo())}/show");
    }

    /**
     * @param Frota\Utilizacao $object
     */
    public function postRemove($object)
    {
        $this->forceRedirect("/patrimonial/frota/veiculo/{$this->getObjectKey($object->getFkFrotaVeiculo())}/show");
    }
}
