<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpKernel\Exception\HttpException;

use Urbem\CoreBundle\Entity\Frota;

use Urbem\CoreBundle\Model\Patrimonial\Frota\UtilizacaoModel;
use Urbem\CoreBundle\Model\Patrimonial\Frota\UtilizacaoRetornoModel;

use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class UtilizacaoRetornoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Frota
 */
class UtilizacaoRetornoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_veiculo_retornar_veiculo';
    protected $baseRoutePattern = 'patrimonial/frota/veiculo/retornar-veiculo';
    protected $includeJs = [
        '/patrimonial/javascripts/frota/retornarVeiculo.js',
    ];

    protected $customHeader = 'PatrimonialBundle:Frota\Veiculo:ultilizacao_retorno__header.html.twig';
    protected $exibirBotaoExcluir = false;
    protected $customMessageDelete = "Deseja excluir o retorno de utilização?";
    public $utilizacao;

    /**
     * @param RouteCollection $routeCollection
     */
    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->add(
            'retornar',
            '{id}/retornar',
            ['_controller' => 'SonataAdminBundle:CRUD:create']
        );
        $routeCollection->remove('batch');
        $routeCollection->remove('show');
        $routeCollection->remove('export');
    }

    /**
     * @param ErrorElement $errorElement
     * @param Frota\UtilizacaoRetorno $utilizacaoRetorno
     */
    public function validate(ErrorElement $errorElement, $utilizacaoRetorno)
    {
        /**
         * @var ORM\EntityManager $entityManager
         */
        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Frota\Veiculo');

        $utilizacao = [];
        $utilizacao['codVeiculo'] = $this->getForm()->get('codVeiculo')->getData();
        $utilizacao['dtSaida'] = $this->getForm()->get('dtSaida')->getData();
        $utilizacao['hrSaida'] = $this->getForm()->get('hrSaida')->getData();

        $utilizacaoUtilizacaoModel = new UtilizacaoModel($entityManager);
        $utilizacaoObject = $utilizacaoUtilizacaoModel->getUtilizacao($utilizacao);

        if (null !== $utilizacaoObject) {
            $dtTimeSaida = $utilizacaoObject->getDtSaida()->format("Y-m-d") . " " . $utilizacaoRetorno->getHrSaida()->format('H:m');
            $dtTimeRetorno = $utilizacaoRetorno->getDtRetorno()->format("Y-m-d") . " " . $this->getForm()->get('hrRetorno')->getData()->format('H:i');

            if (strtotime($dtTimeSaida) > strtotime($dtTimeRetorno)) {
                $message = $this->trans("frotaRetorno.dtRetorno", ['%data1%'=>$utilizacaoRetorno->getDtRetorno()->format("d/m/Y"), '%data2%'=>$utilizacaoRetorno->getHrRetorno()->format('H:i')], "validators");
                $errorElement->with('dtRetorno')->addViolation($message)->end();
            }
            if ($utilizacaoObject->getKmSaida() > $utilizacaoRetorno->getKmRetorno() && false === $utilizacaoRetorno->getViradaOdometro()) {
                $message = $this->trans("frotaRetorno.kmRetorno", [], "validators");
                $errorElement->with('kmRetorno')->addViolation($message)->end();
            }
        }
        list($hora, $minuto) = explode(':', $this->getForm()->get('hrRetorno')->getData()->format('H:m'));

        if ($hora >= 24 && $minuto > 0) {
            $message = $this->trans("frotaRetorno.hrRetorno", [], "validators");
            $errorElement->with('hrRetorno')->addViolation($message)->end();
        }
    }


    /**
     * @param Frota\UtilizacaoRetorno $utilizacaoRetorno
     */
    public function prePersist($utilizacaoRetorno)
    {
        /**
         * @var ORM\EntityManager $entityManager
         */
        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Frota\Veiculo');

        $utilizacao = [];
        $utilizacao['codVeiculo'] = $this->getForm()->get('codVeiculo')->getData();
        $utilizacao['dtSaida'] = $this->getForm()->get('dtSaida')->getData();
        $utilizacao['hrSaida'] = $this->getForm()->get('hrSaida')->getData();

        $utilizacaoUtilizacaoModel = new UtilizacaoRetornoModel($entityManager);
        $utilizacaoUtilizacaoModel->populateUtilizacaoData($utilizacaoRetorno, $utilizacao, $this->getForm());
    }

    /**
     * @param Frota\UtilizacaoRetorno $utilizacaoRetorno
     */
    public function postPersist($utilizacaoRetorno)
    {
        $this->forceRedirect("/patrimonial/frota/veiculo/{$this->getObjectKey($utilizacaoRetorno->getFkFrotaUtilizacao()->getFkFrotaVeiculo())}/show");
    }

    /**
     * @param Frota\UtilizacaoRetorno $utilizacaoRetorno
     */
    public function postRemove($utilizacaoRetorno)
    {
        $this->forceRedirect("/patrimonial/frota/veiculo/{$this->getObjectKey($utilizacaoRetorno->getFkFrotaUtilizacao()->getFkFrotaVeiculo())}/show");
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $codUtilizacao = $this->request->get('id');

        if (is_null($codUtilizacao) && $this->getRequest()->isMethod('GET')) {
            throw new HttpException(404, 'Page not found.');
        }

        if ($this->getRequest()->isMethod('POST')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codVeiculo = $formData['codVeiculo'];
            $dtSaida = $formData['dtSaida'];
            $hrSaida = $formData['hrSaida'];

            $id = $codVeiculo.'~'.$dtSaida.'~'.$hrSaida;
        } else {
            list($codVeiculo, $dtSaida, $hrSaida) = explode('~', urldecode($codUtilizacao));
            $id = $this->getAdminRequestId();
        }
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /**
         * @var ORM\EntityManager $entityManager
         */
        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Frota\Veiculo');

        $utilizacaoModel = new UtilizacaoModel($entityManager);
        /** @var Frota\Utilizacao utilizacao */
        $this->utilizacao = $utilizacaoModel->getUtilizacao([
            'codVeiculo' => $codVeiculo,
            'dtSaida' => $dtSaida,
            'hrSaida' => $hrSaida
        ]);

        $fieldOptions = [];
        $fieldOptions['codMotorista'] = [
            'class' => Frota\Motorista::class,
            'attr' => ['class' => 'select2-parameters '],
            'data' => $this->utilizacao->getFkFrotaMotorista(),
            'label' => 'label.retirarVeiculo.codMotorista',
            'placeholder' => 'label.selecione',
            'required' => true
        ];

        $fieldOptions['dtRetorno'] = [
            'label' => 'label.retornarVeiculo.dtRetorno',
            'format' => 'dd/MM/yyyy',
            'data' => new \DateTime()
        ];

        $fieldOptions['hrRetorno'] = [
            'attr' => ['class' => 'fixed-time ', 'step' => '60'],
            'data' => new \DateTime(),
            'label' => 'label.retornarVeiculo.hrRetorno',
            'model_timezone' => 'America/Sao_Paulo',
            'view_timezone' => 'America/Sao_Paulo',
            'widget' => 'single_text',
            'with_seconds'  => true,
        ];

        $fieldOptions['kmRetorno'] = [
            'label' => 'label.retornarVeiculo.kmRetorno',
            'attr' => [
                'class' => 'km '
            ]
        ];

        $fieldOptions['observacao'] = [
            'label' => 'label.observacao'
        ];

        $fieldOptions['viradaOdometro'] = [
            'label' => 'label.retornarVeiculo.viradaOdometro'
        ];

        $formMapper
            ->with('Dados do Retorno')
            ->add('codVeiculo', 'hidden', ['data' => $this->utilizacao->getCodVeiculo(), 'mapped' => false])
            ->add('dtSaida', 'hidden', ['data' => $this->utilizacao->getDtSaida(), 'mapped' => false])
            ->add('hrSaida', 'hidden', ['data' => $this->utilizacao->getHrSaida(), 'mapped' => false])
            ->add('cgmMotorista', 'entity', $fieldOptions['codMotorista'])
            ->add('dtRetorno', 'sonata_type_date_picker', $fieldOptions['dtRetorno'])
            ->add('hrRetorno', 'time', $fieldOptions['hrRetorno'])
            ->add('kmRetorno', 'number', $fieldOptions['kmRetorno'])
            ->add('observacao', null, $fieldOptions['observacao'])
            ->add('viradaOdometro', null, $fieldOptions['viradaOdometro'])
            ->end();
    }
}
