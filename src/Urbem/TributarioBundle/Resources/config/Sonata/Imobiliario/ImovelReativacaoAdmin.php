<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Imobiliario\BaixaImovel;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelProcesso;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class ImovelReativacaoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_imovel_reativacao';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/imovel-reativacao';
    protected $legendButtonSave = array('icon' => 'arrow_upward', 'text' => 'Reativar');
    protected $includeJs = array(
        '/tributario/javascripts/imobiliario/processo.js'
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
            'inscricaoMunicipal' => $this->getRequest()->get('inscricaoMunicipal'),
        );
    }

    /**
     * @return null|Imovel
     */
    public function getImovel()
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $imovel = null;
        if ($this->getPersistentParameter('inscricaoMunicipal')) {
            /** @var Imovel $imovel */
            $imovel = $em->getRepository(Imovel::class)->find($this->getPersistentParameter('inscricaoMunicipal'));
        }
        return $imovel;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $imovel = $this->getImovel();

        $fieldOptions = array();

        $fieldOptions['dadosImovel'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Imobiliario/Imovel/dadosImovel.html.twig',
            'data' => array(
                'imovel' => $imovel
            )
        );

        $fieldOptions['fkSwClassificacao'] = array(
            'label' => 'label.imobiliarioImovel.classificacao',
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
            'label' => 'label.imobiliarioImovel.assunto',
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
            'label' => 'label.imobiliarioImovel.processo',
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

        $formMapper->with('label.imobiliarioImovel.dados');
        $formMapper->add('dadosImovel', 'customField', $fieldOptions['dadosImovel']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioImovel.processo');
        $formMapper->add('fkSwClassificacao', 'entity', $fieldOptions['fkSwClassificacao']);
        $formMapper->add('fkSwAssunto', 'entity', $fieldOptions['fkSwAssunto']);
        $formMapper->add('fkSwProcesso', 'autocomplete', $fieldOptions['fkSwProcesso']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioImovelReativacao.motivoReativacao');
        $formMapper->add('justificativaTermino', 'textarea', $fieldOptions['justificativaTermino']);
        $formMapper->end();
    }

    /**
     * @param Imovel $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        try {
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());

            /** @var Imovel $lote */
            $imovel = $this->getImovel();

            if ($this->getForm()->get('fkSwProcesso')->getData()) {
                $imovelProcesso = new ImovelProcesso();
                $imovelProcesso->setFkSwProcesso($this->getForm()->get('fkSwProcesso')->getData());
                $imovel->addFkImobiliarioImovelProcessos($imovelProcesso);
            }

            /** @var BaixaImovel $baixaImovel */
            $baixaImovel = $imovel->getFkImobiliarioBaixaImoveis()->last();
            $baixaImovel->setJustificativaTermino($this->getForm()->get('justificativaTermino')->getData());
            $baixaImovel->setDtTermino(new \DateTime());
            $imovel->addFkImobiliarioBaixaImoveis($baixaImovel);

            $em->persist($imovel);
            $em->flush();

            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.imobiliarioImovelReativacao.msgSucesso', array('%inscricaoMunicipal%' => $imovel->getInscricaoMunicipal())));
            $this->forceRedirect('/tributario/cadastro-imobiliario/imovel/list');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $this->forceRedirect('/tributario/cadastro-imobiliario/imovel/list');
        }
    }
}
