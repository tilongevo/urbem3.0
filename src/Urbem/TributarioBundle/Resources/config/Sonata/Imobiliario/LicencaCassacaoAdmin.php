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

class LicencaCassacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_licencas_licenca_cassacao';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/licencas/licenca-cassacao';
    protected $legendButtonSave = array('icon' => 'gavel', 'text' => 'Cassar');

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

        $licenca = $this->getLicenca();

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
            'label' => 'label.imobiliarioLicenca.dtCassacao',
            'mapped' => false,
            'format' => 'dd/MM/yyyy'
        ];

        $fieldOptions['motivo'] = [
            'label' => false,
            'mapped' => false,
            'required' => true
        ];

        $formMapper->with('label.imobiliarioLicenca.dados');
        $formMapper->add('dadosLicenca', 'customField', $fieldOptions['dadosLicenca']);
        $formMapper->add('dtInicio', 'sonata_type_date_picker', $fieldOptions['dtInicio']);
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

        $licencaBaixa = (new LicencaModel($em))->cassarLicenca($licenca, $this->getForm()->get('dtInicio')->getData(), $this->getForm()->get('motivo')->getData());

        if ($licencaBaixa instanceof LicencaBaixa) {
            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.imobiliarioLicenca.msgCassar', array('%licenca%' => (string) $licenca)));
            $this->forceRedirect('/tributario/cadastro-imobiliario/licencas/licenca/list');
        } else {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $licencaBaixa->getMessage());
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }
    }
}
