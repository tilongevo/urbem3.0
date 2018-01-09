<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Imobiliario\Condominio;
use Urbem\CoreBundle\Entity\Imobiliario\CondominioProcesso;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Imobiliario\CondominioModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class CondominioCaracteristicasAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_condominio_caracteristicas';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/condominio-caracteristicas';
    protected $includeJs = array(
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/tributario/javascripts/imobiliario/processo.js',
        '/tributario/javascripts/imobiliario/condominio-caracteristicas.js'
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
            'codCondominio' => $this->getRequest()->get('codCondominio'),
        );
    }

    /**
     * @return null|Condominio
     */
    public function getCondominio()
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $condominio = null;
        if ($this->getPersistentParameter('codCondominio')) {
            /** @var Condominio $condominio */
            $condominio = $em->getRepository(Condominio::class)->find($this->getPersistentParameter('codCondominio'));
        }
        return $condominio;
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

        $condominioModel = new CondominioModel($em);

        $condominio = $this->getCondominio();

        $fieldOptions = array();

        $fieldOptions['codCondominio'] = array(
            'mapped' => false
        );

        $fieldOptions['dadosCondominio'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Imobiliario/Condominio/dadosCondominio.html.twig',
            'data' => array(
                'condominio' => $condominio
            )
        );

        $fieldOptions['fkSwClassificacao'] = array(
            'label' => 'label.imobiliarioCondominio.classificacao',
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
            'label' => 'label.imobiliarioCondominio.assunto',
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
            'label' => 'label.imobiliarioCondominio.processo',
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
        if ($condominio) {
            $fieldOptions['codCondominio']['data'] = $condominio->getCodCondominio();
            $fieldOptions['areaTotalComum']['data'] = number_format($condominio->getFkImobiliarioCondominioAreaComuns()->last()->getAreaTotalComum(), 2, ',', '.');
            if ($condominio->getFkImobiliarioCondominioProcessos()->count()) {
                $fieldOptions['fkSwClassificacao']['data'] = $condominio->getFkImobiliarioCondominioProcessos()->last()->getFkSwProcesso()->getFkSwAssunto()->getFkSwClassificacao();
                $fieldOptions['fkSwAssunto']['data'] = $condominio->getFkImobiliarioCondominioProcessos()->last()->getFkSwProcesso()->getFkSwAssunto();
                $fieldOptions['fkSwProcesso']['data'] = $condominio->getFkImobiliarioCondominioProcessos()->last()->getFkSwProcesso();
            }

            /** @var CondominioProcesso $condominioProcesso */
            foreach ($condominio->getFkImobiliarioCondominioProcessos() as $condominioProcesso) {
                $listaProcessos[] = array(
                    'processo' => $condominioProcesso,
                    'atributoDinamico' => $condominioModel->getNomAtributoValorByCondominio($condominio, $condominioProcesso->getTimestamp())
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

        $formMapper->tab('label.imobiliarioCondominio.caracteristicas');
        $formMapper->with('label.imobiliarioCondominio.dados');
        $formMapper->add('codCondominio', 'hidden', $fieldOptions['codCondominio']);
        $formMapper->add('dadosCondominio', 'customField', $fieldOptions['dadosCondominio']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioCondominio.processo');
        $formMapper->add('fkSwClassificacao', 'entity', $fieldOptions['fkSwClassificacao']);
        $formMapper->add('fkSwAssunto', 'entity', $fieldOptions['fkSwAssunto']);
        $formMapper->add('fkSwProcesso', 'autocomplete', $fieldOptions['fkSwProcesso']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioLote.atributos', array('class' => 'atributoDinamicoWith'));
        $formMapper->add('atributosDinamicos', 'text', array('mapped' => false, 'required' => false));
        $formMapper->end();
        $formMapper->end();
        $formMapper->tab('label.imobiliarioCondominio.processos');
        $formMapper->with('label.imobiliarioCondominio.dados');
        $formMapper->add('dadosCondominio', 'customField', $fieldOptions['dadosCondominio']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioCondominio.listaProcessos');
        $formMapper->add('listaProcessos', 'customField', $fieldOptions['listaProcessos']);
        $formMapper->end();
        $formMapper->end();
    }

    /**
     * @param Condominio $condominio
     */
    public function prePersist($condominio)
    {
        $container = $this->getConfigurationPool()->getContainer();

        try {
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());

            /** @var Condominio $condominio */
            $condominio = $this->getCondominio();

            $dtAtual = new DateTimeMicrosecondPK();

            if ($this->getForm()->get('fkSwProcesso')->getData()) {
                $condominioProcesso = new CondominioProcesso();
                $condominioProcesso->setFkSwProcesso($this->getForm()->get('fkSwProcesso')->getData());
                $condominioProcesso->setTimestamp($dtAtual);
                $condominio->addFkImobiliarioCondominioProcessos($condominioProcesso);
            }

            (new CondominioModel($em))->atributoDinamico($condominio, $this->request->request->get('atributoDinamico'), $dtAtual);

            $em->persist($condominio);
            $em->flush();

            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.imobiliarioCondominio.msgCaracteristicasSucesso', array('%condominio%' => (string) $condominio)));
            $this->forceRedirect('/tributario/cadastro-imobiliario/condominio/list');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            $this->forceRedirect('/tributario/cadastro-imobiliario/condominio/list');
        }
    }
}
