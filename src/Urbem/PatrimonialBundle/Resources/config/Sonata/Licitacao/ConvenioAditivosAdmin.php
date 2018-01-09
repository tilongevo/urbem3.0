<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;

use Urbem\CoreBundle\Entity\Licitacao\Convenio;
use Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos;
use Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivosPublicacao;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ConvenioAditivosModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class ConvenioAditivosAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao
 */
class ConvenioAditivosAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_convenio_aditivos';
    protected $baseRoutePattern = 'patrimonial/licitacao/convenio/aditivos';

    protected $includeJs = [
        'patrimonial/javascripts/patrimonio/convenio/aditivo.js',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create', 'edit', 'list']);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->modelManager;

        /** @var Request $request */
        $request = $this->request;

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var ConvenioAditivos $convenioAditivo */
        $convenioAditivo = $this->getSubject();

        if ($request->get('_sonata_name') != ($this->baseRouteName . '_edit')) {
            $convenioObjectKey = $request->get('convenio');

            $uniqid = $request->get('uniqid');
            $adminCode = $request->get('admin_code');
            if (!is_null($uniqid) && is_null($adminCode)) {
                $formData = $request->get($uniqid);
                $convenioObjectKey = $formData['convenio'];
            }
            /** @var Convenio $convenio */
            $convenio = $modelManager->find(Convenio::class, $convenioObjectKey);
        } else {
            $convenio = $convenioAditivo->getFkLicitacaoConvenio();
        }

        /** Previne caso um convenio nao seja encontrado. */
        if (is_null($convenio)) {
            $container = $this->getConfigurationPool()->getContainer();
            $container
                ->get('session')
                ->getFlashBag()
                ->add('error', $this->trans('ConvenioNaoEncontrado'));

            $this->redirectByRoute('urbem_patrimonial_licitacao_convenio_list');
        }

        $fieldOptions = [];
        $fieldOptions['convenioInfo'] = [
            'label' => false,
            'mapped' => false,
            'template' => 'PatrimonialBundle:Sonata/Licitacao/ParticipanteConvenio/CRUD:field_convenioInfo.html.twig',
            'data' => [
                'convenio' => $convenio
            ]
        ];

        $fieldOptions['convenio'] = [
            'data' => $this->id($convenio),
            'mapped' => false
        ];

        $fieldOptions['fkSwCgm'] = [
            'property' => 'nomCgm',
            'container_css_class' => 'select2-v4-parameters ',
            'placeholder' => $this->trans('label.selecione'),
            'route' => [
                'name' => 'sonata_admin_retrieve_autocomplete_items',
                'parameters' => [
                    'convenio' => $this->id($convenio)
                ],
            ],
            'label' => 'label.convenioAdmin.cgmResponsavel'
        ];

        $fieldOptions['dtAssinatura'] = [
            'format' => 'dd/MM/yyyy',
            'required' => true,
            'label' => 'label.convenioAdmin.dtAssinatura'
        ];

        $fieldOptions['inicioExecucao'] = [
            'format' => 'dd/MM/yyyy',
            'required' => true,
            'label' => 'label.convenioAdmin.inicioExecucao'
        ];

        $fieldOptions['dtVigencia'] = [
            'format' => 'dd/MM/yyyy',
            'required' => true,
            'label' => 'label.convenioAdmin.dtVigencia'
        ];

        $fieldOptions['objeto'] = [
            'label' => 'label.convenioAdmin.codObjeto',
        ];

        $fieldOptions['fkNormasNorma'] = [
            'property' => 'nomNorma',
            'container_css_class' => 'select2-v4-parameters ',
            'placeholder' => $this->trans('label.selecione'),
            'label' => 'label.convenioAdmin.fundamentacao',
            'route' => [
                'name' => 'sonata_admin_retrieve_autocomplete_items',
                'parameters' => [
                    'convenio' => $this->id($convenio)
                ],
            ]
        ];

        $fieldOptions['dataNorma'] = [
            'data' => null,
            'label' => false,
            'mapped' => false,
            'template' => 'PatrimonialBundle:Sonata/Licitacao/Convenio/CRUD:field__dataNorma.html.twig'
        ];

        $fieldOptions['observacao'] = [
            'attr' => ['maxlength' => 200],
            'label' => 'label.convenioAdmin.observacao'
        ];

        $fieldOptions['valorConvenio'] = [
            'attr' => ['class' => 'money '],
            'currency' => 'BRL',
            'label' => 'label.convenioAditivoAdmin.valorConvenio'
        ];

        $formMapper
            ->with('label.convenioAdmin.convenio')
            ->add('convenioInfo', 'customField', $fieldOptions['convenioInfo'])
            ->end()
            ->with('label.convenioAdmin.aditivos.dados')
            ->add('convenio', 'hidden', $fieldOptions['convenio'])
            ->add('fkSwCgm', 'sonata_type_model_autocomplete', $fieldOptions['fkSwCgm'], [
                'admin_code' => 'core.admin.filter.sw_cgm'
            ])
            /** Datas */
            ->add('dtAssinatura', 'sonata_type_date_picker', $fieldOptions['dtAssinatura'])
            ->add('inicioExecucao', 'sonata_type_date_picker', $fieldOptions['inicioExecucao'])
            ->add('dtVigencia', 'sonata_type_date_picker', $fieldOptions['dtVigencia'])
            ->add('objeto', 'text', $fieldOptions['objeto'])
            ->add('fkNormasNorma', 'sonata_type_model_autocomplete', $fieldOptions['fkNormasNorma'], [
                'admin_code' => 'administrativo.admin.norma'
            ])
            ->add('dataNorma', 'customField', $fieldOptions['dataNorma'])
            ->add('observacao', 'textarea', $fieldOptions['observacao'])
            ->add('valorConvenio', 'money', $fieldOptions['valorConvenio'])
            ->end()
            ->with('label.convenioAdmin.veiculoPublicacao')
            ->add('fkLicitacaoConvenioAditivosPublicacoes', 'sonata_type_collection', [
                'label' => false,
                'required' => true,
            ], [
                'edit' => 'inline',
                'inline' => 'table',
                'delete' => true
            ])
            ->end();

        $admin = $this;
        $formMapper
            ->getFormBuilder()
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($admin) {
                $data = $event->getData();

                /** @var ConvenioAditivos $convenioAditivos */
                $convenioAditivos = $admin->getSubject();

                if (isset($data['convenio']) && !empty($data['convenio'])) {
                    /** @var Convenio $convenio */
                    $convenio = $admin->modelManager->find(Convenio::class, $data['convenio']);
                    $convenioAditivos->setFkLicitacaoConvenio($convenio);
                }
            });
    }

    /**
     * @param ErrorElement $errorElement
     * @param ConvenioAditivos $convenioAditivos
     */
    public function validate(ErrorElement $errorElement, $convenioAditivos)
    {
        $convenio = $convenioAditivos->getFkLicitacaoConvenio();

        /** A data de assinatura do aditivo não pode ser anterior que a data de assinatura do convênio. */
        if ($convenioAditivos->getDtAssinatura() < $convenio->getDtAssinatura()) {
            $message = $this->trans('convenio.aditivos.errors.dtAssinaturaAditivoBeforeDtAssinaturaConvenio', [], 'validators');
            $errorElement->with('dtAssinatura')->addViolation($message)->end();
        }

        /** A data de início de execução não pode ser anterior que a data de assinatura do contrato. */
        if ($convenioAditivos->getInicioExecucao() < $convenioAditivos->getDtAssinatura()) {
            $message = $this->trans('convenio.aditivos.errors.dtExecucaoBeforeDtAssinaturaConvenio', [], 'validators');
            $errorElement->with('inicioExecucao')->addViolation($message)->end();
        }

        /** A data de final de vigência não pode ser anterior que a data de início de execução.  */
        if ($convenioAditivos->getDtVigencia() < $convenioAditivos->getInicioExecucao()) {
            $message = $this->trans('convenio.aditivos.errors.dtVigenciaBeforeDtExecucao', [], 'validators');
            $errorElement->with('dtVigencia')->addViolation($message)->end();
        }
    }

    /**
     * @param ConvenioAditivos $convenioAditivos
     */
    public function prePersist($convenioAditivos)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $fundamentacao = $convenioAditivos->getFkNormasNorma()->getNomNorma();

        $convenioAditivos->setExercicio($this->getExercicio());
        $convenioAditivos->setFundamentacao($fundamentacao);

        (new ConvenioAditivosModel($entityManager))->setNumAditivo($convenioAditivos);

        $this->checkSelectedDeleteInListCollecion(
            $convenioAditivos,
            'fkLicitacaoConvenioAditivosPublicacoes',
            'setFkLicitacaoConvenioAditivos'
        );

        /** @var ConvenioAditivosPublicacao $publicacoes */
        foreach ($convenioAditivos->getFkLicitacaoConvenioAditivosPublicacoes() as $publicacoes) {
            $publicacoes->setFkLicitacaoConvenioAditivos($convenioAditivos);
        }
    }

    /**
     * @param ConvenioAditivos $convenioAditivos
     */
    public function postPersist($convenioAditivos)
    {
        $convenio = $convenioAditivos->getFkLicitacaoConvenio();

        $this->redirectByRoute('urbem_patrimonial_licitacao_convenio_show', [
            'id' => $this->id($convenio)
        ]);
    }

    /**
     * @param ConvenioAditivos $convenioAditivos
     */
    public function preUpdate($convenioAditivos)
    {
        $fundamentacao = $convenioAditivos->getFkNormasNorma()->getNomNorma();

        $convenioAditivos->setFundamentacao($fundamentacao);

        $this->checkSelectedDeleteInListCollecion(
            $convenioAditivos,
            'fkLicitacaoConvenioAditivosPublicacoes',
            'setFkLicitacaoConvenioAditivos'
        );

        /** @var ConvenioAditivosPublicacao $publicacoes */
        foreach ($convenioAditivos->getFkLicitacaoConvenioAditivosPublicacoes() as $publicacoes) {
            $publicacoes->setFkLicitacaoConvenioAditivos($convenioAditivos);
        }
    }

    /**
     * @param ConvenioAditivos $convenioAditivos
     */
    public function postUpdate($convenioAditivos)
    {
        $convenio = $convenioAditivos->getFkLicitacaoConvenio();

        $this->redirectByRoute('urbem_patrimonial_licitacao_convenio_show', [
            'id' => $this->id($convenio)
        ]);
    }
}
