<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Imobiliario\Licenca;
use Urbem\CoreBundle\Entity\Imobiliario\LicencaBaixa;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\TipoBaixa;
use Urbem\CoreBundle\Model\Imobiliario\LicencaModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class LicencaCancelarSuspensaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_licencas_licenca_cancelar_suspensao';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/licencas/licenca-cancelar-suspensao';
    protected $legendButtonSave = array('icon' => 'cancel', 'text' => 'Cancelar Suspensão');

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
    }

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'codLicenca' => $this->getRequest()->get('codLicenca'),
            'exercicio' => $this->getRequest()->get('exercicio')
        );
    }

    /**
     * @return null|Licenca
     */
    public function getLicenca()
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $licenca = null;
        if ($this->getPersistentParameter('codLicenca') && $this->getPersistentParameter('exercicio')) {
            /** @var Licenca $licenca */
            $licenca = $em->getRepository(Licenca::class)->findOneBy([
                'codLicenca' => $this->getPersistentParameter('codLicenca'),
                'exercicio' => $this->getPersistentParameter('exercicio')
            ]);
        }
        return $licenca;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $container = $this->getConfigurationPool()->getContainer();

        $licenca = $this->getLicenca();

        $licencaBaixa = $licenca->getFkImobiliarioLicencaBaixas()->filter(
            function ($entry) {
                if (($entry->getCodTipo() == TipoBaixa::TIPO_BAIXA_SUSPENSAO) && (!$entry->getDtTermino())) {
                    return $entry;
                }
            }
        )->first();

        if (!$licencaBaixa) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $this->forceRedirect('/tributario/cadastro-imobiliario/licencas/licenca/list');
        }

        $fieldOptions = array();

        $fieldOptions['dadosLicenca'] = [
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Imobiliario/Licencas/Licenca/dadosLicenca.html.twig',
            'data' => [
                'licenca' => $licenca
            ]
        ];

        $fieldOptions['dtInicio'] = [
            'label' => 'label.imobiliarioLicenca.dtSuspensao',
            'mapped' => false,
            'format' => 'dd/MM/yyyy',
            'data' => $licencaBaixa->getDtInicio(),
            'disabled' => true
        ];

        $fieldOptions['dtTermino'] = [
            'label' => 'label.imobiliarioLicenca.dtTermino',
            'mapped' => false,
            'required' => true,
            'format' => 'dd/MM/yyyy'
        ];

        $fieldOptions['motivo'] = [
            'label' => false,
            'mapped' => false,
            'required' => true,
            'data' => $licencaBaixa->getMotivo()
        ];

        $formMapper->with('label.imobiliarioLicenca.dados');
        $formMapper->add('dadosLicenca', 'customField', $fieldOptions['dadosLicenca']);
        $formMapper->add('dtInicio', 'sonata_type_date_picker', $fieldOptions['dtInicio']);
        $formMapper->add('dtTermino', 'sonata_type_date_picker', $fieldOptions['dtTermino']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioLicenca.motivoBaixa');
        $formMapper->add('motivo', 'textarea', $fieldOptions['motivo']);
        $formMapper->end();
    }

    /**
     * @param Lote $object
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        /** @var Licenca $licenca */
        $licenca = $this->getLicenca();

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $licencaBaixa = (new LicencaModel($em))->cancelarSuspensaoLicenca($licenca, $this->getForm()->get('dtTermino')->getData(), $this->getForm()->get('motivo')->getData());

        if ($licencaBaixa instanceof LicencaBaixa) {
            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.imobiliarioLicenca.msgSuspender', array('%licenca%' => (string) $licenca)));
            $this->forceRedirect('/tributario/cadastro-imobiliario/licencas/licenca/list');
        } else {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $licencaBaixa->getMessage());
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }
    }
}
