<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Imobiliario\Construcao;
use Urbem\CoreBundle\Entity\Imobiliario\ConstrucaoProcesso;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Imobiliario\ConstrucaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class ConstrucaoOutrosCaracteristicasAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_construcao_caracteristicas';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/construcao-caracteristicas';
    protected $legendButtonSave = array('icon' => 'settings', 'text' => 'Alterar');
    protected $includeJs = array(
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/tributario/javascripts/imobiliario/processo.js',
        '/tributario/javascripts/imobiliario/construcao-caracteristicas.js'
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

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $construcaoModel = new ConstrucaoModel($em);

        $construcao = $this->getConstrucao();

        $fieldOptions = array();

        $fieldOptions['codConstrucao'] = array(
            'mapped' => false
        );

        $fieldOptions['codTipo'] = array(
            'mapped' => false
        );

        $fieldOptions['dadosConstrucao'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Imobiliario/Construcao/dadosConstrucao.html.twig',
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

        $listaProcessos = array();
        if ($construcao) {
            $fieldOptions['codConstrucao']['data'] = $construcao->getCodConstrucao();

            /** @var ConstrucaoProcesso $construcaoProcesso */
            foreach ($construcao->getFkImobiliarioConstrucaoProcessos() as $construcaoProcesso) {
                $listaProcessos[] = array(
                    'processo' => $construcaoProcesso,
                    'atributoDinamico' => $construcaoModel->getNomAtributoValorByConstrucaoOutros($construcao->getFkImobiliarioConstrucaoOutros(), $construcaoProcesso->getTimestamp())
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

        $formMapper->tab('label.imobiliarioConstrucao.caracteristicas');
        $formMapper->with('label.imobiliarioConstrucao.dadosConstrucao');
        $formMapper->add('codConstrucao', 'hidden', $fieldOptions['codConstrucao']);
        $formMapper->add('codTipo', 'hidden', $fieldOptions['codTipo']);
        $formMapper->add('dadosConstrucao', 'customField', $fieldOptions['dadosConstrucao']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioConstrucao.processo');
        $formMapper->add('fkSwClassificacao', 'entity', $fieldOptions['fkSwClassificacao']);
        $formMapper->add('fkSwAssunto', 'entity', $fieldOptions['fkSwAssunto']);
        $formMapper->add('fkSwProcesso', 'autocomplete', $fieldOptions['fkSwProcesso']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioLote.atributos', array('class' => 'atributoDinamicoWith'));
        $formMapper->add('atributosDinamicos', 'text', array('mapped' => false, 'required' => false));
        $formMapper->end();
        $formMapper->end();

        $formMapper->tab('label.imobiliarioLote.processos');
        $formMapper->with('label.imobiliarioConstrucao.dadosConstrucao');
        $formMapper->add('dadosConstrucao', 'customField', $fieldOptions['dadosConstrucao']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioConstrucao.listaProcessos');
        $formMapper->add('listaProcessos', 'customField', $fieldOptions['listaProcessos']);
        $formMapper->end();
        $formMapper->end();
    }

    /**
     * @param Construcao $construcao
     */
    public function prePersist($construcao)
    {
        $container = $this->getConfigurationPool()->getContainer();

        try {
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());

            $dtAtual = new DateTimeMicrosecondPK();
            $url = '/tributario/cadastro-imobiliario/construcao/imovel/list';

            $construcaoModel = new ConstrucaoModel($em);

            /** @var Construcao $construcao */
            $construcao = $this->getConstrucao();

            if ($this->getForm()->get('fkSwProcesso')->getData()) {
                $construcaoProcesso = new ConstrucaoProcesso();
                $construcaoProcesso->setFkSwProcesso($this->getForm()->get('fkSwProcesso')->getData());
                $construcaoProcesso->setTimestamp($dtAtual);
                $construcao->addFkImobiliarioConstrucaoProcessos($construcaoProcesso);
            }

            if ($this->request->request->get('atributoDinamico')) {
                $construcaoModel->atributoDinamicoOutros($construcao->getFkImobiliarioConstrucaoOutros(), $this->request->request->get('atributoDinamico'), $dtAtual);
            }

            if ($construcao->getFkImobiliarioConstrucaoCondominios()->count()) {
                $url = '/tributario/cadastro-imobiliario/construcao/condominio/list';
            }

            $em->persist($construcao);
            $em->flush();

            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.imobiliarioConstrucao.msgCaracteristicasOutros', ['%codConstrucao%' => $construcao->getCodConstrucao()]));
            $this->forceRedirect($url);
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            $this->forceRedirect($url);
        }
    }
}
