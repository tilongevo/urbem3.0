<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\DividaAtiva;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Model\Tributaria\DividaAtiva\Inscricao\InscricaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class DividaCanceladaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_divida_ativa_inscricao_cancelada';
    protected $baseRoutePattern = 'tributario/divida-ativa/inscricao/cancelar';

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->includeJs[] = '/tributario/javascripts/dividaAtiva/inscricao/config.js';
        $this->includeJs[] = '/tributario/javascripts/dividaAtiva/inscricao/inscricao.js';

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $model = new InscricaoModel($this->getDoctrine(), $this->getExercicio());
        $init = $model->initAdmin($this->getSubject());
        $formMapper
            ->with('label.dividaAtivaInscricao.cancelarDividaAtiva')
                ->add(
                    'inscricaoAno',
                    'choice',
                    [
                        'label' => 'label.dividaAtivaInscricao.inscricaoAno',
                        'choices' => $init->get('inscricaoAno'),
                        'required' => false,
                        'mapped' => false,
                        'placeholder' => 'Selecione',
                        'data' => '',
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
                ->add('motivo', 'textarea')
                ->add(
                    'emitirDocumento',
                    'choice',
                    [
                        'label' => 'label.dividaAtivaInscricao.emitirComprovante',
                        'choices' => $init->get('emitirDocumento'),
                        'required' => false,
                        'mapped' => false,
                        'placeholder' => 'Selecione',
                        'data' => '',
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
            ->end()
            ->with('label.dividaAtivaInscricao.processo')
                ->add(
                    'processoClassificacao',
                    'choice',
                    [
                        'label' => 'label.dividaAtivaInscricao.processoClassificacao',
                        'choices' => $init->get('processoClassificacao'),
                        'required' => false,
                        'mapped' => false,
                        'placeholder' => 'Selecione',
                        'data' => '',
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                    ]
                )
            ->add(
                'processoAssunto',
                'choice',
                [
                    'label' => 'label.dividaAtivaInscricao.processoAssunto',
                    'choices' => $init->get('processoAssunto'),
                    'required' => false,
                    'mapped' => false,
                    'placeholder' => 'Selecione',
                    'data' => '',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'processo',
                'choice',
                [
                    'label' => 'label.dividaAtivaInscricao.processo',
                    'choices' => $init->get('processo'),
                    'required' => false,
                    'mapped' => false,
                    'placeholder' => 'Selecione',
                    'data' => '',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ]
            )
            ->add(
                'hiddenProcesso',
                'hidden',
                [
                    'mapped' => false,
                ]
            )
            ->end()
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $model = new InscricaoModel($this->getDoctrine(), $this->getExercicio());
        $childrens = $this->getForm()->all();
        if (!empty($model->validaDividaAtiva($object, $childrens))) {
            $this->validateMessage(
                $errorElement,
                $this->getContainer()->get('translator')->transChoice('label.dividaAtivaInscricao.message.dividaAtivaCancelada', 0, [], 'messages'),
                'inscricaoAno'
            );
        }
    }

    /**
     * @param ErrorElement $errorElement
     * @param $error
     */
    public function validateMessage(ErrorElement $errorElement, $error, $field)
    {
        $errorElement->with($field)->addViolation($error)->end();
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $model = $this->inscricaoModel();
        $model->prePersist($object, $this->getForm()->all(), $this->getContainer());
    }

    /**
     * @param mixed $object
     */
    public function postPersist($object)
    {
        $childrens = $this->getForm()->all();
        if (!empty($childrens['emitirDocumento']->getViewData())) {
            $this->redirectByRoute('tributario_divida_ativa_inscricao_cancelar_registros', ['_id' => sprintf('%s-%s', $object->getCodInscricao(), $object->getExercicio())]);
        }
        $this->redirectByRoute(sprintf('%s_%s', $this->baseRouteName, 'create'));
    }

    /**
     * @return InscricaoModel
     */
    protected function inscricaoModel()
    {
        return new InscricaoModel($this->getDoctrine(), $this->getExercicio());
    }
}
