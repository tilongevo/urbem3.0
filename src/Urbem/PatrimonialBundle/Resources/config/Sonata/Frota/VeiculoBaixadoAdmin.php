<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Frota;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Form;
use Urbem\CoreBundle\Exception\Error;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Form\FormMapper;

use Urbem\CoreBundle\Entity\Frota;

/**
 * Class VeiculoBaixadoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Frota
 */
class VeiculoBaixadoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_frota_excluir_baixa_veiculo';
    protected $baseRoutePattern = 'patrimonial/frota/baixa-veiculo';
    protected $exibirBotaoIncluir = false;
    protected $customMessageDelete = "Você tem certeza que deseja excluir a baixa do veículo \"%object%\" selecionado?";

    /**
     * @param Frota\VeiculoBaixado $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            $this->saveRelationships($object, $this->getForm());
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', Error::ERROR_PERSIST_DATA);
            $this->forceRedirect("/patrimonial/frota/baixa-veiculo/create?id={$object->getCodVeiculo()}");
        }
    }

    /**
     * @param Frota\VeiculoBaixado $object
     * @param Form $form
     */
    public function saveRelationships($object, $form)
    {
        $id = $object->getCodVeiculo();

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $veiculo = $entityManager
            ->getRepository(Frota\Veiculo::class)
            ->find($id);

        $object->setFkFrotaVeiculo($veiculo);

        $object->setFkFrotaTipoBaixa($form->get('codTipoBaixa')->getData());
    }

    /**
     * @param Frota\VeiculoBaixado $object
     */
    public function postPersist($object)
    {
        $this->redirect($object);

        $container = $this->getConfigurationPool()->getContainer();
        $container->get('session')->getFlashBag()->clear();
        $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.veiculoBaixa.msgBaixa'));
        $this->forceRedirect("/patrimonial/frota/baixa-veiculo/create?id={$object->getCodVeiculo()}");
    }

    /**
     * @param Frota\VeiculoBaixado $object
     * @param $message
     */
    public function redirect($object)
    {
        $this->forceRedirect("/patrimonial/frota/veiculo/{$this->getObjectKey($object->getFkFrotaVeiculo())}/show");
    }

    /**
     * @param Frota\VeiculoBaixado $object
     */
    public function postRemove($object)
    {
        $this->redirect($object);
    }

    /**
     * @return Frota\Veiculo
     */
    public function getVeiculo($id)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $veiculo = $entityManager
            ->getRepository(Frota\Veiculo::class)
            ->find($id);

        return $veiculo;
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
            $id = $formData['codVeiculo'];
        }

        $veiculo = $this->getVeiculo($id);

        $fieldOptions['codVeiculo'] = [
            'data' => $id
        ];

        $fieldOptions['dadosVeiculo'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'PatrimonialBundle::Frota/Veiculo/baixa_veiculo.html.twig',
            'data' => array(
                'veiculo' => $veiculo
            )
        );

        $fieldOptions['dtBaixa'] = array(
            'format' => 'dd/MM/yyyy',
            'label' => 'label.veiculoBaixa.dtBaixa',
            'data' => new \DateTime('now')
        );

        $formMapper
            ->with('label.veiculoBaixa.dadosVeiculo')
                ->add(
                    'dadosVeiculo',
                    'customField',
                    $fieldOptions['dadosVeiculo']
                )
            ->end()
            ->with('label.veiculoBaixa.dadosBaixa')
                ->add(
                    'codVeiculo',
                    'hidden',
                    $fieldOptions['codVeiculo']
                )
                ->add(
                    'dtBaixa',
                    'sonata_type_date_picker',
                    $fieldOptions['dtBaixa']
                )
                ->add(
                    'codTipoBaixa',
                    'entity',
                    [
                        'class' => 'CoreBundle:Frota\TipoBaixa',
                        'choice_label' => function ($codTipoBaixa) {
                            return $codTipoBaixa->getCodTipo() . ' - ' . $codTipoBaixa->getDescricao();
                        },
                        'label' => 'label.veiculoBaixa.codTipoBaixa',
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                        'placeholder' => 'Selecione...'
                    ]
                )
                ->add(
                    'motivo',
                    'textarea',
                    [
                        'label' => 'label.veiculoBaixa.motivo',
                    ]
                )
            ->end();
    }
}
