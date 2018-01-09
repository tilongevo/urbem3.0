<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\LoteProcesso;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Imobiliario\LoteModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class LoteCaracteristicasAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_lote_caracteristicas';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/lote-caracteristicas';
    protected $legendButtonSave = array('icon' => 'settings', 'text' => 'Alterar');
    protected $includeJs = array(
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/core/javascripts/sw-processo.js',
        '/tributario/javascripts/imobiliario/lote-caracteristicas.js'
    );

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
            'codLote' => $this->getRequest()->get('codLote'),
        );
    }

    /**
     * @return null|Lote
     */
    public function getLote()
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $lote = null;
        if ($this->getPersistentParameter('codLote')) {
            /** @var Lote $lote */
            $lote = $em->getRepository(Lote::class)->find($this->getPersistentParameter('codLote'));
        }
        return $lote;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $loteModel = new LoteModel($em);

        $lote = $this->getLote();

        $fieldOptions = array();

        $fieldOptions['codLote'] = array(
            'mapped' => false
        );

        $fieldOptions['codCadastro'] = array(
            'mapped' => false
        );

        $fieldOptions['dadosLote'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Imobiliario/Lote/dadosLote.html.twig',
            'data' => array(
                'lote' => $lote
            )
        );

        $fieldOptions['codClassificacao'] = array(
            'label' => 'label.imobiliarioLote.classificacao',
            'class' => SwClassificacao::class,
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->orderBy('o.codClassificacao', 'ASC');
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['codAssunto'] = array(
            'label' => 'label.imobiliarioLote.assunto',
            'placeholder' => 'label.selecione',
            'choices' => array(),
            'mapped' => false,
            'required' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['codProcesso'] = array(
            'label' => 'label.imobiliarioLote.processo',
            'placeholder' => 'label.selecione',
            'choices' => array(),
            'mapped' => false,
            'required' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $listaProcessos = array();
        if ($lote) {
            $fieldOptions['codLote']['data'] = $lote->getCodLote();
            $fieldOptions['codCadastro']['data'] = ($lote->getFkImobiliarioLoteUrbano())
                ? Cadastro::CADASTRO_TRIBUTARIO_LOTE_URBANO
                : Cadastro::CADASTRO_TRIBUTARIO_LOTE_RURAL;

            /** @var LoteProcesso $loteProcesso */
            foreach ($lote->getFkImobiliarioLoteProcessos() as $loteProcesso) {
                $listaProcessos[] = array(
                    'processo' => $loteProcesso,
                    'atributoDinamico' => $loteModel->getNomAtributoValorByLote($lote, $loteProcesso->getTimestamp())
                );
            }
        }

        $fieldOptions['listaProcessos'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Imobiliario/Lote/listaProcessos.html.twig',
            'data' => array(
                'lista' => $listaProcessos
            )
        );

        $formMapper->tab('label.imobiliarioLote.caracteristicas');
        $formMapper->with('label.imobiliarioLote.dadosLote');
        $formMapper->add('codLote', 'hidden', $fieldOptions['codLote']);
        $formMapper->add('codCadastro', 'hidden', $fieldOptions['codCadastro']);
        $formMapper->add('dadosLote', 'customField', $fieldOptions['dadosLote']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioLote.processo');
        $formMapper->add('codClassificacao', 'entity', $fieldOptions['codClassificacao']);
        $formMapper->add('codAssunto', 'choice', $fieldOptions['codAssunto']);
        $formMapper->add('codProcesso', 'choice', $fieldOptions['codProcesso']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioLote.atributos', array('class' => 'atributoDinamicoWith'));
        $formMapper->add('atributosDinamicos', 'text', array('mapped' => false, 'required' => false));
        $formMapper->end();
        $formMapper->end();
        $formMapper->tab('label.imobiliarioLote.processos');
        $formMapper->with('label.imobiliarioLote.dadosLote');
        $formMapper->add('dadosLote', 'customField', $fieldOptions['dadosLote']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioLote.listaProcessos');
        $formMapper->add('listaProcessos', 'customField', $fieldOptions['listaProcessos']);
        $formMapper->end();
        $formMapper->end();

        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin) {
                $form = $event->getForm();
                $data = $event->getData();

                if ($form->has('codAssunto')) {
                    $form->remove('codAssunto');
                }

                if (isset($data['codClassificacao']) && $data['codClassificacao'] != "") {
                    $codAssunto = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'codAssunto',
                        'entity',
                        null,
                        array(
                            'class' => SwAssunto::class,
                            'label' => 'label.imobiliarioLote.assunto',
                            'choice_value' => 'codComposto',
                            'placeholder' => 'label.selecione',
                            'mapped' => false,
                            'auto_initialize' => false,
                            'query_builder' => function (EntityRepository $er) use ($data) {
                                return $er->createQueryBuilder('o')
                                    ->where('o.codClassificacao = :codClassificacao')
                                    ->setParameter('codClassificacao', $data['codClassificacao']);
                            },
                            'attr' => array(
                                'class' => 'select2-parameters'
                            )
                        )
                    );

                    $form->add($codAssunto);
                }

                if ($form->has('codProcesso')) {
                    $form->remove('codProcesso');
                }

                if (isset($data['codAssunto']) && $data['codAssunto'] != "") {
                    $codProcesso = $formMapper->getFormBuilder()->getFormFactory()->createNamed(
                        'codProcesso',
                        'entity',
                        null,
                        array(
                            'class' => SwProcesso::class,
                            'label' => 'label.imobiliarioLote.assunto',
                            'choice_value' => 'codComposto',
                            'placeholder' => 'label.selecione',
                            'mapped' => false,
                            'auto_initialize' => false,
                            'query_builder' => function (EntityRepository $er) use ($data) {
                                list($codClassificacao, $codAssunto) = explode('~', $data['codAssunto']);
                                return $er->createQueryBuilder('o')
                                    ->where('o.codClassificacao = :codClassificacao')
                                    ->andWhere('o.codAssunto = :codAssunto')
                                    ->setParameters([
                                        'codClassificacao' => $codClassificacao,
                                        'codAssunto' => $codAssunto,
                                    ]);
                            },
                            'attr' => array(
                                'class' => 'select2-parameters'
                            )
                        )
                    );

                    $form->add($codProcesso);
                }
            }
        );
    }

    /**
     * @param Lote $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        $dtAtual = new DateTimeMicrosecondPK();

        try {
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());

            $loteModel = new LoteModel($em);

            /** @var Lote $lote */
            $lote = $this->getLote();


            if ($this->getForm()->get('codProcesso')->getData()) {
                $loteProcesso = new LoteProcesso();
                $loteProcesso->setFkSwProcesso($this->getForm()->get('codProcesso')->getData());
                $loteProcesso->setTimestamp($dtAtual);
                $lote->addFkImobiliarioLoteProcessos($loteProcesso);
            }

            $loteModel->atributoDinamico($lote, $this->request->request->get('atributoDinamico'), $dtAtual);

            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.imobiliarioLote.msgCaracteristicas'));
            $this->forceRedirect('/tributario/cadastro-imobiliario/lote/list');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $this->forceRedirect('/tributario/cadastro-imobiliario/lote/list');
        }
    }
}
