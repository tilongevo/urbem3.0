<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Imobiliario\BaixaLote;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Imobiliario\LoteProcesso;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class LoteReativacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_lote_reativacao';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/lote-reativacao';
    protected $legendButtonSave = array('icon' => 'arrow_upward', 'text' => 'Reativar');
    protected $includeJs = array(
        '/tributario/javascripts/imobiliario/lote-baixa.js'
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

        $fieldOptions['fkSwClassificacao'] = array(
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

        $fieldOptions['fkSwAssunto'] = array(
            'label' => 'label.imobiliarioLote.assunto',
            'class' => SwAssunto::class,
            'choice_value' => 'codAssunto',
            'placeholder' => 'label.selecione',
            'mapped' => false,
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->orderBy('o.codAssunto', 'ASC');
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['fkSwProcesso'] = array(
            'label' => 'label.imobiliarioLote.processo',
            'class' => SwProcesso::class,
            'req_params' => [
                'codClassificacao' => 'varJsCodClassificacao',
                'codAssunto' => 'varJsCodAssunto'
            ],
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                $qb->innerJoin('o.fkAdministracaoUsuario', 'u');
                $qb->innerJoin('u.fkSwCgm', 'cgm');
                if ($request->get('codClassificacao') != '') {
                    $qb->andWhere('o.codClassificacao = :codClassificacao');
                    $qb->setParameter('codClassificacao', (int) $request->get('codClassificacao'));
                }
                if ($request->get('codAssunto') != '') {
                    $qb->andWhere('o.codAssunto = :codAssunto');
                    $qb->setParameter('codAssunto', (int) $request->get('codAssunto'));
                }
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->eq('o.codProcesso', ':codProcesso'),
                    $qb->expr()->eq('cgm.numcgm', ':numCgm'),
                    $qb->expr()->like('LOWER(cgm.nomCgm)', $qb->expr()->literal('%' . strtolower($term) . '%'))
                ));
                $qb->setParameter('numCgm', (int) $term);
                $qb->setParameter('codProcesso', (int) $term);
                $qb->orderBy('o.codProcesso', 'ASC');
                return $qb;
            },
            'mapped' => false,
            'required' => false,
        );

        $fieldOptions['justificativaTermino'] = array(
            'label' => false,
            'mapped' => false,
            'required' => true
        );

        $formMapper->with('label.imobiliarioLote.dadosLote');
        $formMapper->add('dadosLote', 'customField', $fieldOptions['dadosLote']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioLote.processo');
        $formMapper->add('fkSwClassificacao', 'entity', $fieldOptions['fkSwClassificacao']);
        $formMapper->add('fkSwAssunto', 'entity', $fieldOptions['fkSwAssunto']);
        $formMapper->add('fkSwProcesso', 'autocomplete', $fieldOptions['fkSwProcesso']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioLote.reativar.motivo');
        $formMapper->add('justificativaTermino', 'textarea', $fieldOptions['justificativaTermino']);
        $formMapper->end();
    }

    /**
     * @param Lote $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        try {
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());

            /** @var Lote $lote */
            $lote = $this->getLote();

            if ($this->getForm()->get('fkSwProcesso')->getData()) {
                $loteProcesso = new LoteProcesso();
                $loteProcesso->setFkSwProcesso($this->getForm()->get('fkSwProcesso')->getData());
                $lote->addFkImobiliarioLoteProcessos($loteProcesso);
            }

            /** @var BaixaLote $baixaLote */
            $baixaLote = $lote->getFkImobiliarioBaixaLotes()->last();
            $baixaLote->setJustificativaTermino($this->getForm()->get('justificativaTermino')->getData());
            $baixaLote->setDtTermino(new \DateTime());
            $lote->addFkImobiliarioBaixaLotes($baixaLote);

            $em->persist($lote);
            $em->flush();

            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.imobiliarioLote.reativar.msgReativar'));
            $this->forceRedirect('/tributario/cadastro-imobiliario/lote/list');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $this->forceRedirect('/tributario/cadastro-imobiliario/lote/list');
        }
    }
}
