<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Imobiliario\TipoLicencaDocumento;
use Urbem\CoreBundle\Model\Imobiliario\TipoLicencaDocumentoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class TipoLicencaDocumentoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_licencas_tipo_licenca';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/licencas/tipo-licenca';
    protected $includeJs = array(
        '/tributario/javascripts/imobiliario/tipo-licenca-documento.js'
    );

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('create'));
        $collection->add('consultar_modelos_documento', 'consultar-modelos-documento');
        $collection->add('consultar_atributos_dinamicos', 'consultar-atributos-dinamicos');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = array();

        $fieldOptions['fkImobiliarioTipoLicenca'] = [
            'label' => 'label.imobiliarioTipoLicencaDocumento.tipoLicenca',
            'placeholder' => 'label.selecione',
            'required' => false
        ];

        $fieldOptions['fkAdministracaoAtributoDinamico'] = [
            'label' => 'label.imobiliarioTipoLicencaDocumento.atributosDinamicos',
            'class' => AtributoDinamico::class,
            'choice_value' => 'codAtributo',
            'multiple' => true,
            'mapped' => false,
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->where('o.codModulo = :codModulo')
                    ->andWhere('o.codCadastro = :codCadastro')
                    ->setParameters(
                        array(
                            'codModulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO,
                            'codCadastro' => Cadastro::CADASTRO_TRIBUTARIO_LICENCAS
                        )
                    )
                    ->orderBy('o.nomAtributo');
            }
        ];

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $tipoLicencaDocumentoModel = new TipoLicencaDocumentoModel($em);

        $choices = $tipoLicencaDocumentoModel->recuperarModelosDocumento();

        $fieldOptions['fkAdministracaoModeloDocumento'] = [
            'label' => 'label.imobiliarioTipoLicencaDocumento.modelosDocumento',
            'multiple' => true,
            'mapped' => false,
            'required' => false,
            'choices' => array_flip($choices)
        ];

        $formMapper
            ->with('label.imobiliarioTipoLicencaDocumento.dados')
            ->add('fkImobiliarioTipoLicenca', null, $fieldOptions['fkImobiliarioTipoLicenca'])
            ->add('fkAdministracaoAtributoDinamico', 'entity', $fieldOptions['fkAdministracaoAtributoDinamico'])
            ->add('fkAdministracaoModeloDocumento', 'choice', $fieldOptions['fkAdministracaoModeloDocumento'])
            ->end()
        ;
    }

    /**
     * @param TipoLicencaDocumento $tipoLicencaDocumento
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function prePersist($tipoLicencaDocumento)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $tipoLicencaDocumentoModel = new TipoLicencaDocumentoModel($em);

        $modelosDocumentos = (count($this->getForm()->get('fkAdministracaoModeloDocumento')->getData())) ? $this->getForm()->get('fkAdministracaoModeloDocumento')->getData() : array();
        $atributosDinamicos = ($this->getForm()->get('fkAdministracaoAtributoDinamico')->getData()->count()) ? $this->getForm()->get('fkAdministracaoAtributoDinamico')->getData()->getValues() : array();

        $status = $tipoLicencaDocumentoModel->salvarTipoLicencaDocumento($tipoLicencaDocumento->getFkImobiliarioTipoLicenca(), $modelosDocumentos, $atributosDinamicos);

        $container = $this->getConfigurationPool()->getContainer();
        if ($status !== true) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $status->getMessage());
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        } else {
            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.imobiliarioTipoLicencaDocumento.msgSucesso'));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->generateUrl('create'));
        }
    }
}
