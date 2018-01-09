<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivos;
use Urbem\CoreBundle\Entity\Licitacao\ConvenioAditivosAnulacao;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ConvenioAditivosAnulacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_convenio_aditivos_anulacao';
    protected $baseRoutePattern = 'patrimonial/licitacao/convenio/aditivos-anulacao';

    /**
     * @param ConvenioAditivosAnulacao $convenioAditivoAnulacao
     */
    public function prePersist($convenioAditivoAnulacao)
    {
        $form = $this->getForm();
        $convenioAditivoObjectKey = $form->get('convenio')->getData();
        /** @var ModelManager $modelManager */
        $modelManager = $this->modelManager;
        /** @var ConvenioAditivos $convenioAditivo */
        $convenioAditivo = $modelManager->find(ConvenioAditivos::class, $convenioAditivoObjectKey);
        $convenioAditivo->setFkLicitacaoConvenioAditivosAnulacao($convenioAditivoAnulacao);
        $convenioAditivoAnulacao->setFkLicitacaoConvenioAditivos($convenioAditivo);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var ModelManager $modelManager */
        $modelManager = $this->modelManager;

        /** @var Request $request */
        $request = $this->request;

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var ConvenioAditivosAnulacao $convenioAditivoAnulacao */
        $convenioAditivoAnulacao = $this->getSubject();

        if ($request->get('_sonata_name') != ($this->baseRouteName . '_edit')) {
            $convenioAditivoObjectKey = $request->get('convenio');

            $uniqid = $request->get('uniqid');
            $adminCode = $request->get('admin_code');
            if (!is_null($uniqid) && is_null($adminCode)) {
                $formData = $request->get($uniqid);
                $convenioAditivoObjectKey = $formData['convenio'];
            }

            /** @var ConvenioAditivos $convenioAditivo */
            $convenioAditivo = $modelManager->find(ConvenioAditivos::class, $convenioAditivoObjectKey);
        }


        /** Previne caso um convenio nao seja encontrado. */
        if (is_null($convenioAditivo)) {
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
                'convenio' => $convenioAditivo->getFkLicitacaoConvenio()
            ]
        ];

        $fieldOptions['convenio'] = [
            'data' => $this->id($convenioAditivo),
            'mapped' => false
        ];

        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $formMapperOptions = [];

        $now = new \DateTime();
        $formMapperOptions['dtAnulacao'] = [
            'dp_default_date' => $now->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'pk_class' => DatePK::class,
            'label' => 'label.convenioAdmin.rescisaoAditivo.dtRescisao',
            'required' => true,
        ];

        $formMapperOptions['motivo']['label'] = 'label.convenioAdmin.rescisaoAditivo.motivo';

        $formMapper
            ->with('label.convenioAdmin.convenio')
            ->add('convenioInfo', 'customField', $fieldOptions['convenioInfo'])
            ->end()
            ->with('label.convenioAdmin.aditivos.dados')
            ->add('convenio', 'hidden', $fieldOptions['convenio'])
            ->add('dtAnulacao', 'datepkpicker', $formMapperOptions['dtAnulacao'])
            ->add('motivo', null, $formMapperOptions['motivo'])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('exercicioConvenio')
            ->add('numConvenio')
            ->add('exercicio')
            ->add('numAditivo')
            ->add('dtAnulacao')
            ->add('motivo')
        ;
    }

    /**
     * @param ConvenioAditivosAnulacao $convenioAditivosAnulacao
     */
    public function postPersist($convenioAditivosAnulacao)
    {
        $convenio = $convenioAditivosAnulacao->getFkLicitacaoConvenioAditivos()->getFkLicitacaoConvenio();

        $this->redirectByRoute('urbem_patrimonial_licitacao_convenio_show', [
            'id' => $this->id($convenio)
        ]);
    }
}
