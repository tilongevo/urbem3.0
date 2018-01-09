<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\ImovelProcesso;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
use Urbem\CoreBundle\Model\Imobiliario\ImovelModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;

class ImovelCaracteristicasAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_imovel_caracteristicas';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/imovel-caracteristicas';
    protected $legendButtonSave = array('icon' => 'settings', 'text' => 'Alterar');
    protected $includeJs = array(
        '/administrativo/javascripts/administracao/atributo-dinamico-component.js',
        '/tributario/javascripts/imobiliario/processo.js',
        '/tributario/javascripts/imobiliario/imovel-caracteristicas.js'
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

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());

        $imovelModel = new ImovelModel($em);

        $imovel = $this->getImovel();

        $fieldOptions = array();

        $fieldOptions['inscricaoMunicipal'] = array(
            'mapped' => false
        );

        $fieldOptions['dadosImovel'] = array(
            'label' => false,
            'mapped' => false,
            'template' => 'TributarioBundle::Imobiliario/Imovel/dadosImovel.html.twig',
            'data' => array(
                'imovel' => $imovel
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

        $listaProcessos = array();
        if ($imovel) {
            $fieldOptions['inscricaoMunicipal']['data'] = $imovel->getInscricaoMunicipal();
            $fieldOptions['codCadastro']['data'] = Cadastro::CADASTRO_TRIBUTARIO_IMOVEL;

            /** @var ImovelProcesso $imovelProcesso */
            foreach ($imovel->getFkImobiliarioImovelProcessos() as $imovelProcesso) {
                $listaProcessos[] = array(
                    'processo' => $imovelProcesso,
                    'atributoDinamico' => $imovelModel->getNomAtributoValorByImovel($imovel, $imovelProcesso->getTimestamp())
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
        $formMapper->with('label.imobiliarioImovel.dados');
        $formMapper->add('inscricaoMunicipal', 'hidden', $fieldOptions['inscricaoMunicipal']);
        $formMapper->add('dadosImovel', 'customField', $fieldOptions['dadosImovel']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioLote.processo');
        $formMapper->add('fkSwClassificacao', 'entity', $fieldOptions['fkSwClassificacao']);
        $formMapper->add('fkSwAssunto', 'entity', $fieldOptions['fkSwAssunto']);
        $formMapper->add('fkSwProcesso', 'autocomplete', $fieldOptions['fkSwProcesso']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioLote.atributos', array('class' => 'atributoDinamicoWith'));
        $formMapper->add('atributosDinamicos', 'text', array('mapped' => false, 'required' => false));
        $formMapper->end();
        $formMapper->end();
        $formMapper->tab('label.imobiliarioLote.processos');
        $formMapper->with('label.imobiliarioLote.dadosLote');
        $formMapper->add('dadosImovel', 'customField', $fieldOptions['dadosImovel']);
        $formMapper->end();
        $formMapper->with('label.imobiliarioLote.listaProcessos');
        $formMapper->add('listaProcessos', 'customField', $fieldOptions['listaProcessos']);
        $formMapper->end();
        $formMapper->end();
    }

    /**
     * @param Imovel $object
     */
    public function prePersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        $dtAtual = new DateTimeMicrosecondPK();

        try {
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager($this->getClass());

            $imovelModel = new ImovelModel($em);

            /** @var Imovel $imovel */
            $imovel = $this->getImovel();


            if ($this->getForm()->get('fkSwProcesso')->getData()) {
                $imovelProcesso = new ImovelProcesso();
                $imovelProcesso->setFkSwProcesso($this->getForm()->get('fkSwProcesso')->getData());
                $imovelProcesso->setTimestamp($dtAtual);
                $imovel->addFkImobiliarioImovelProcessos($imovelProcesso);
            }

            $imovelModel->atributoDinamico($imovel, $this->request->request->get('atributoDinamico'), $dtAtual);

            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.imobiliarioImovelCaracteristicas.msgSucesso', array('%inscricaoMunicipal%' => $imovel->getInscricaoMunicipal())));
            $this->forceRedirect('/tributario/cadastro-imobiliario/imovel/list');
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $this->forceRedirect('/tributario/cadastro-imobiliario/imovel/list');
        }
    }
}
