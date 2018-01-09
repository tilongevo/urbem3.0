<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Imobiliario\BaixaConstrucao;
use Urbem\CoreBundle\Entity\Imobiliario\BaixaUnidadeAutonoma;
use Urbem\CoreBundle\Entity\Imobiliario\BaixaUnidadeDependente;
use Urbem\CoreBundle\Entity\Imobiliario\Construcao;
use Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoProcesso;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Model\Imobiliario\ConstrucaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class ConstrucaoBaixaAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_edificacao_baixa';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/edificacao-baixa';
    protected $legendButtonSave = array('icon' => 'arrow_downward', 'text' => 'Baixar');
    protected $includeJs = array(
        '/tributario/javascripts/imobiliario/processo.js'
    );

    /**
     * @param Construcao $construcao
     * @return boolean
     */
    public function verificaBaixa(Construcao $construcao)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        return (new ConstrucaoModel($em))->verificaBaixa($construcao);
    }

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
            'codConstrucao' => $this->getRequest()->get('codConstrucao'),
        );
    }

    /**
     * @return null|Construcao
     */
    public function getConstrucao()
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $construcao = null;
        if ($this->getPersistentParameter('codConstrucao')) {
            /** @var Construcao $construcao */
            $construcao = $em->getRepository(Construcao::class)->find($this->getPersistentParameter('codConstrucao'));
        }
        return $construcao;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $construcao = $this->getConstrucao();

        $fieldOptions = array();

        $fieldOptions['dadosEdificacao'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Imobiliario/Edificacao/dadosEdificacao.html.twig',
            'data' => array(
                'construcao' => $construcao
            )
        );

        $fieldOptions['fkSwClassificacao'] = array(
            'label' => 'label.imobiliarioConstrucao.classificacao',
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
            'label' => 'label.imobiliarioConstrucao.assunto',
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
            'label' => 'label.imobiliarioConstrucao.processo',
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

        $fieldOptions['justificativa'] = array(
            'label' => false,
            'mapped' => false,
            'required' => true
        );

        $formMapper->with('label.imobiliarioConstrucao.dados');
        $formMapper->add('dadosEdificacao', 'customField', $fieldOptions['dadosEdificacao']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioConstrucao.processo');
        $formMapper->add('fkSwClassificacao', 'entity', $fieldOptions['fkSwClassificacao']);
        $formMapper->add('fkSwAssunto', 'entity', $fieldOptions['fkSwAssunto']);
        $formMapper->add('fkSwProcesso', 'autocomplete', $fieldOptions['fkSwProcesso']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioConstrucao.motivoBaixa');
        $formMapper->add('justificativa', 'textarea', $fieldOptions['justificativa']);
        $formMapper->end();
    }

    /**
     * @param mixed $object
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        /** @var Construcao $construcao */
        $construcao = $this->getConstrucao();

        $construcaoModel = new ConstrucaoModel($em);

        $dependentes = $construcaoModel->verificaDependentes($construcao);

        if ($dependentes) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.imobiliarioConstrucao.erroBaixar'));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }

        try {
            $dtAtual = new \DateTime();
            $url = '/tributario/cadastro-imobiliario/edificacao/imovel/list';

            if ($this->getForm()->get('fkSwProcesso')->getData()) {
                $construcaoProcesso = new ConstrucaoProcesso();
                $construcaoProcesso->setFkSwProcesso($this->getForm()->get('fkSwProcesso')->getData());
                $construcao->addFkImobiliarioConstrucaoProcessos($construcaoProcesso);
            }

            $baixaConstrucao = new BaixaConstrucao();
            $baixaConstrucao->setJustificativa($this->getForm()->get('justificativa')->getData());
            $baixaConstrucao->setDtInicio($dtAtual);
            $construcao->addFkImobiliarioBaixaConstrucoes($baixaConstrucao);

            if ($construcao->getFkImobiliarioUnidadeDependentes()->count()) {
                $baixaUnidadeDependente = new BaixaUnidadeDependente();
                $baixaUnidadeDependente->setJustificativa($this->getForm()->get('justificativa')->getData());
                $baixaUnidadeDependente->setDtInicio($dtAtual);
                $construcao->getFkImobiliarioUnidadeDependentes()->last()->addFkImobiliarioBaixaUnidadeDependentes($baixaUnidadeDependente);
            } elseif ($construcao->getFkImobiliarioConstrucaoEdificacoes()->last()->getFkImobiliarioUnidadeAutonomas()->count()) {
                $baixaUnidadeAutonoma = new BaixaUnidadeAutonoma();
                $baixaUnidadeAutonoma->setJustificativa($this->getForm()->get('justificativa')->getData());
                $baixaUnidadeAutonoma->setDtInicio($dtAtual);
                $construcao->getFkImobiliarioConstrucaoEdificacoes()->last()->getFkImobiliarioUnidadeAutonomas()->last()->addFkImobiliarioBaixaUnidadeAutonomas($baixaUnidadeAutonoma);
            } else {
                $url = '/tributario/cadastro-imobiliario/edificacao/condominio/list';
            }

            $em->persist($construcao);
            $em->flush();

            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.imobiliarioConstrucao.msgBaixar', ['%codConstrucao%' => $construcao->getCodConstrucao()]));
            $this->forceRedirect($url);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            $this->forceRedirect($url);
        }
    }
}
