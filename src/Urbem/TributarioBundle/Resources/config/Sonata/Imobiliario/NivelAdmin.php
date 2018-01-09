<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Imobiliario;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Administracao\Cadastro;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Imobiliario\AtributoNivel;
use Urbem\CoreBundle\Entity\Imobiliario\Nivel;
use Urbem\CoreBundle\Entity\Imobiliario\Vigencia;
use Urbem\CoreBundle\Model\Imobiliario\NivelModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class NivelAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_tributario_imobiliario_nivel';
    protected $baseRoutePattern = 'tributario/cadastro-imobiliario/hierarquia/nivel';
    protected $includeJs = array('/tributario/javascripts/imobiliario/nivel.js');
    protected $customHeader = null;
    protected $model = NivelModel::class;

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return array();
        }

        return array(
            'codVigencia' => $this->getRequest()->get('codVigencia'),
        );
    }

    /**
     * @param string $name
     * @return mixed|null|string
     */
    public function getTemplate($name)
    {
        switch ($name) {
            case 'list':
                return 'TributarioBundle:Imobiliario\Nivel:list.html.twig';
                break;
            default:
                return parent::getTemplate($name);
                break;
        }
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        if (!$this->getPersistentParameter('codVigencia')) {
            $query->andWhere('1 = 0');
        } else {
            $query->andWhere('o.codVigencia = :codVigencia');
            $query->setParameter('codVigencia', $this->getPersistentParameter('codVigencia'));
        }
        return $query;
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('nivel_superior', 'nivel-superior');
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDatagrid()->getPager();
        $pager->setCountColumn(array('codNivel'));
    }

    /**
     * @return null|string
     */
    public function getVigencia()
    {
        if ($this->getPersistentParameter('codVigencia')) {
            $em = $this->modelManager->getEntityManager($this->getClass());
            $vigencia = $em->getRepository(Vigencia::class)
                ->find($this->getPersistentParameter('codVigencia'));
            return (string) $vigencia;
        } else {
            return null;
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->customHeader = 'TributarioBundle:Sonata\Imobiliario\Nivel\CRUD:header.html.twig';

        $this->setBreadCrumb();

        $listMapper
            ->add('codNivel', 'string', array('label' => 'label.imobiliarioNivel.codNivel'))
            ->add('nomNivel', 'string', array('label' => 'label.imobiliarioNivel.nomNivel'))
            ->add('mascara', 'string', array('label' => 'label.imobiliarioNivel.mascara'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig')
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->customHeader = 'TributarioBundle:Sonata\Imobiliario\Nivel\CRUD:header.html.twig';

        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions = array();

        $fieldOptions['vigencia'] = array(
            'data' => $this->getPersistentParameter('codVigencia'),
            'mapped' => false
        );

        $fieldOptions['nivelSuperior'] = array(
            'label' => 'label.imobiliarioNivel.nivelSuperior',
            'class' => Nivel::class,
            'choice_value' => 'codNivel',
            'mapped' => false,
            'required' => false,
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        $fieldOptions['atributoDinamico'] = array(
            'label' => 'label.imobiliarioNivel.atributos',
            'class' => AtributoDinamico::class,
            'mapped' => false,
            'multiple' => true,
            'required' => false,
            'query_builder' => function (EntityRepository $er) {
                return $er
                    ->createQueryBuilder('o')
                    ->where('o.codModulo = :codModulo')
                    ->andWhere('o.codCadastro = :codCadastro')
                    ->andWhere('o.ativo = true')
                    ->setParameters(
                        array(
                            'codModulo' => Modulo::MODULO_CADASTRO_IMOBILIARIO,
                            'codCadastro' => Cadastro::CADASTRO_TRIBUTARIO_HIERARQUIA
                        )
                    );
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        );

        if ($this->id($this->getSubject())) {
            $em = $this->modelManager->getEntityManager($this->getClass());

            $fieldOptions['vigencia']['disabled'] = true;

            $nivelSuperior = null;
            if ($this->getSubject()->getCodNivel() > 1) {
                $nivelSuperior = $em->getRepository(Nivel::class)
                    ->findOneBy(
                        array(
                            'codNivel' => $this->getSubject()->getCodNivel() - 1,
                            'codVigencia' => $this->getSubject()->getCodVigencia()
                        )
                    );
            }
            $fieldOptions['nivelSuperior']['attr'] = array(
                'form-status' => 'edit',
                'class' => 'select2-parameters ');
            $fieldOptions['nivelSuperior']['query_builder'] = function (EntityRepository $er) {
                return $er->createQueryBuilder('o')
                    ->where('o.codVigencia = :codVigencia')
                    ->setParameter('codVigencia', $this->getSubject()->getCodVigencia());
            };
            $fieldOptions['nivelSuperior']['data'] = $nivelSuperior;

            $atributos = array();
            if ($this->getSubject()->getFkImobiliarioAtributoNiveis()->count()) {
                foreach ($this->getSubject()->getFkImobiliarioAtributoNiveis() as $atributoNivel) {
                    $atributos[] = $atributoNivel->getFkAdministracaoAtributoDinamico();
                }
                $fieldOptions['atributoDinamico']['data'] = $atributos;
            }
        }

        $formMapper->with('label.imobiliarioNivel.dados');
        $formMapper->add('fkImobiliarioVigencia', 'hidden', $fieldOptions['vigencia']);
        $formMapper->add('nomNivel', null, array('label' => 'label.imobiliarioNivel.nomNivel'));
        $formMapper->add('nivelSuperior', 'entity', $fieldOptions['nivelSuperior']);
        $formMapper->add('mascara', null, array('label' => 'label.imobiliarioNivel.mascara'));
        $formMapper->add('fkAdministracaoAtributoDinamico', 'entity', $fieldOptions['atributoDinamico']);
        $formMapper->end();
    }

    /**
     * @param Nivel $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $vigencia = $em->getRepository(Vigencia::class)
            ->find($this->getForm()->get('fkImobiliarioVigencia')->getData());

        $object->setFkImobiliarioVigencia($vigencia);
        $object->setCodNivel((new NivelModel($em))->getProximoCodNivel($object->getFkImobiliarioVigencia()));

        $atributos = $this->getForm()->get('fkAdministracaoAtributoDinamico')->getData();
        if ($atributos->count()) {
            foreach ($atributos as $atributo) {
                $atributoNivel = new AtributoNivel();
                $atributoNivel->setFkAdministracaoAtributoDinamico($atributo);
                $object->addFkImobiliarioAtributoNiveis($atributoNivel);
            }
        }
    }

    /**
     * @param Nivel $object
     */
    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $atributos = $this->getForm()->get('fkAdministracaoAtributoDinamico')->getData();
        foreach ($object->getFkImobiliarioAtributoNiveis() as $atributoNivel) {
            if (($key = array_search($atributoNivel->getFkAdministracaoAtributoDinamico(), $atributos)) !== false) {
                unset($atributos[$key]);
            } else {
                $em->remove($atributoNivel);
            }
        }

        foreach ($atributos as $atributo) {
            $atributoNivel = new AtributoNivel();
            $atributoNivel->setFkAdministracaoAtributoDinamico($atributo);
            $object->addFkImobiliarioAtributoNiveis($atributoNivel);
        }

        $em->flush();
    }

    /**
     * @param Nivel $object
     * @return bool|void
     */
    public function preRemove($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        if (!(new NivelModel($em))->isUltimoNivelHierarquia($object)) {
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.imobiliarioNivel.erroNivelHierarquia', array('%codNivel%' => $object->getCodNivel())));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }

        if ($object->getFkImobiliarioLocalizacaoNiveis()->count()) {
            $container = $this->getConfigurationPool()->getContainer();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('label.imobiliarioNivel.erroReferencias', array('%codNivel%' => $object->getCodNivel())));
            $this->getDoctrine()->clear();
            return $this->redirectToUrl($this->request->headers->get('referer'));
        }
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->customHeader = 'TributarioBundle:Sonata\Imobiliario\Nivel\CRUD:header.html.twig';

        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with('label.imobiliarioNivel.modulo')
            ->add('codNivel', 'string', array('label' => 'label.imobiliarioNivel.codNivel'))
            ->add('nomNivel', 'string', array('label' => 'label.imobiliarioNivel.nomNivel'))
            ->add('mascara', 'string', array('label' => 'label.imobiliarioNivel.mascara'))
            ->add('fkImobiliarioAtributoNiveis', null, array('label' => 'label.imobiliarioNivel.atributos'))
            ->end()
        ;
    }
}
