<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Urbem\CoreBundle\Entity\Licitacao\ConvenioAnulado;
use Urbem\CoreBundle\Entity\Licitacao\Convenio;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

/**
 * Class ConvenioAnuladoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao
 */
class ConvenioAnuladoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_convenio_anulacao';
    protected $baseRoutePattern = 'patrimonial/licitacao/convenio/anulacao';

    public $convenio;

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->clearExcept(['create']);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $convenioObjectKey = $this->request->get('convenio');

        if (!$this->request->isMethod('GET')) {
            $formData = $this->request->get($this->getUniqid());
            $convenioObjectKey = $formData['convenio'];
        }

        /** @var Convenio $convenio */
        $convenio = $this->modelManager->find(Convenio::class, $convenioObjectKey);

        $formMapperOptions = [];
        $formMapperOptions['convenioInfo'] = [
            'label' => false,
            'mapped' => false,
            'template' => 'PatrimonialBundle::Sonata/Licitacao/ParticipanteConvenio/CRUD/field_convenioInfo.html.twig',
            'data' => [
                'convenio' => $convenio
            ]
        ];

        $formMapperOptions['convenio'] = [
            'data' => $convenioObjectKey,
            'mapped' => false
        ];

        $formMapperOptions['justificativa'] = [
            'label' => 'label.convenioAdmin.anulado.justificativa'
        ];

        $formMapperOptions['dtAnulacao'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.convenioAdmin.anulado.dtAnulacao',
            'required' => true,
            'widget' => 'single_text'
        ];

        $formMapper
            ->with('label.convenioAdmin.convenio')
                ->add('convenioInfo', 'customField', $formMapperOptions['convenioInfo'])
            ->end()
            ->with('label.convenioAdmin.anulado.anulacao')
                ->add('convenio', 'hidden', $formMapperOptions['convenio'])
                ->add('justificativa', null, $formMapperOptions['justificativa'])
                ->add('dtAnulacao', 'sonata_type_date_picker', $formMapperOptions['dtAnulacao'])
            ->end()
        ;

        $admin = $this;
        $formMapper
            ->getFormBuilder()
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $formEvent) use ($admin) {
                $data = $formEvent->getData();

                /** @var ConvenioAnulado $convenio */
                $convenioAnulado = $admin->getSubject();

                if (isset($data['convenio'])
                    && !empty($data['convenio'])) {

                    /** @var Convenio $convenio */
                    $convenio = $admin->modelManager->find(Convenio::class, $data['convenio']);
                    $convenioAnulado->setFkLicitacaoConvenio($convenio);
                }
            });
    }

    /**
     * Validações em Convenio Anulado:
     *     - A data da anulação (dtAnulacao) não pode ser menor que a
     *       data da assinatura do convenio (dtAssinatura)
     *
     * @param ErrorElement $errorElement
     * @param ConvenioAnulado $convenioAnulado
     */
    public function validate(ErrorElement $errorElement, $convenioAnulado)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->modelManager;

        $convenioObjectKey = $this->getForm()->get('convenio')->getData();

        /** @var Convenio $convenio */
        $convenio = $modelManager->find(Convenio::class, $convenioObjectKey);

        if (!$convenioAnulado->getDtAnulacao() > $convenio->getDtAssinatura()) {
            $message =
                $this->trans('anulacao_convenio.errors.whenDtAssinaturaIsGreaterThanDtAnulacao', [], 'validators');

            $errorElement->with('dtAnulacao')->addViolation($message)->end();
        }
    }

    /**
     * Usado apenas para chamar o método $this->redirect() após salvar o ConvenioAnulado
     *
     * @param ConvenioAnulado $convenioAnulado
     */
    public function postPersist($convenioAnulado)
    {
        $convenio = $convenioAnulado->getFkLicitacaoConvenio();
        $this->redirectByRoute('urbem_patrimonial_licitacao_convenio_show', [
            'id' => $this->id($convenio)
        ]);
    }
}
