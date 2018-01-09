<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Imobiliario\BaixaLote;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\LoteProcesso;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Model\Imobiliario\LoteModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class LoteBaixaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_lote_baixa';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/lote-baixa';
    protected $legendButtonSave = array('icon' => 'arrow_downward', 'text' => 'Baixar');
    protected $includeJs = array(
        '/core/javascripts/sw-processo.js'
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

        $lote = $this->getLote();

        $fieldOptions = array();

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

        $fieldOptions['justificativa'] = array(
            'label' => false,
            'mapped' => false,
            'required' => true
        );

        $formMapper->with('label.imobiliarioLote.dadosLote');
        $formMapper->add('dadosLote', 'customField', $fieldOptions['dadosLote']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioLote.processo');
        $formMapper->add('codClassificacao', 'entity', $fieldOptions['codClassificacao']);
        $formMapper->add('codAssunto', 'choice', $fieldOptions['codAssunto']);
        $formMapper->add('codProcesso', 'choice', $fieldOptions['codProcesso']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioLote.baixar.motivo');
        $formMapper->add('justificativa', 'textarea', $fieldOptions['justificativa']);
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        /** @var Lote $lote */
        $lote = $this->getLote();

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $imovelConfrontacao = (new LoteModel($em))->verificaDependentes($lote);

        if ($imovelConfrontacao) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.imobiliarioLote.baixar.error', array('%codConfrontacao%' => $imovelConfrontacao->getFkImobiliarioConfrontacaoTrecho()->getFkImobiliarioTrecho()->getCodigoComposto(), '%inscricaoMunicipal%' => $imovelConfrontacao->getInscricaoMunicipal())));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }

        try {
            if ($this->getForm()->get('codProcesso')->getData()) {
                $loteProcesso = new LoteProcesso();
                $loteProcesso->setFkSwProcesso($this->getForm()->get('codProcesso')->getData());
                $lote->addFkImobiliarioLoteProcessos($loteProcesso);
            }

            $baixaLote = new BaixaLote();
            $baixaLote->setJustificativa($this->getForm()->get('justificativa')->getData());
            $baixaLote->setDtInicio(new \DateTime());
            $lote->addFkImobiliarioBaixaLotes($baixaLote);

            $em->persist($lote);
            $em->flush();

            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.imobiliarioLote.baixar.msgBaixar'));
            $this->forceRedirect('/tributario/cadastro-imobiliario/lote/list');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $this->forceRedirect('/tributario/cadastro-imobiliario/lote/list');
        }
    }
}
