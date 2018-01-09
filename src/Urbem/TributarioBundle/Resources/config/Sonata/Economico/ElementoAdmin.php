<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Urbem\CoreBundle\Entity\Administracao\AtributoDinamico;
use Urbem\CoreBundle\Entity\Economico\AtributoElemento;
use Urbem\CoreBundle\Entity\Economico\BaixaElemento;
use Urbem\CoreBundle\Entity\Economico\Elemento;
use Urbem\CoreBundle\Model\Administracao\AtributoDinamicoModel;
use Urbem\CoreBundle\Model\Administracao\CadastroModel;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ElementoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_elemento';
    protected $baseRoutePattern = 'tributario/cadastro-economico/elemento';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('baixar', 'baixar/' . $this->getRouterIdParameter());
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codElemento', null, array(
                'label' => 'label.codigo'
            ))
            ->add('nomElemento', null, array(
                'label' => 'label.nome'
            ))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codElemento', null, array('label' => 'label.codigo'))
            ->add('nomElemento', null, array('label' => 'label.nome'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                    'baixa' => array('template' => 'TributarioBundle:Sonata/Economico/Elemento/CRUD:list__action_baixa.html.twig'),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());
        $atributoDinamicoModel = new AtributoDinamicoModel($em);

        $params = array(
            'cod_modulo' => ConfiguracaoModel::MODULO_TRIBUTARIO_ECONOMICO,
            'cod_cadastro' => CadastroModel::CADASTRO_ELEMENTOS
        );

        // Atributos Dinamicos
        $atributos = $atributoDinamicoModel->getAtributosDinamicosPessoal($params);

        $atributosArray = array();
        foreach ($atributos as $atributo) {
            $atributosArray[$atributo->nom_atributo] = $atributo->cod_atributo;
        }

        // Atributos Dinamicos Selecionados
        $atributosSelecionados = $em->getRepository(AtributoElemento::class)
            ->findBy(['codElemento' => $id]);

        $atributosSelecionadosArray = array();
        foreach ($atributosSelecionados as $atributo) {
            $atributoDinamico = $atributo->getFkAdministracaoAtributoDinamico();
            $atributosSelecionadosArray[$atributoDinamico->getNomAtributo()] = $atributoDinamico->getCodAtributo();
        }

        $fieldOptions['codElemento'] = array(
            'label' => 'label.codigo'
        );

        $formMapper->with('label.economicoElemento.dados');

        if ($this->id($this->getSubject())) {
            $fieldOptions['codElemento']['disabled'] = true;
            $formMapper->add('codElemento', null, $fieldOptions['codElemento']);
        }

        $formMapper->add('nomElemento', null, array(
            'label' => 'label.nome',
        ));

        $formMapper->add(
            'atributos',
            ChoiceType::class,
            array(
                'label' => 'label.economicoElemento.atributos',
                'required' => true,
                'multiple' => true,
                'mapped' => false,
                'choices' => $atributosArray,
                'data' => $atributosSelecionadosArray,
                'attr' => [
                    'class' => 'select2-parameters'
                ],
            )
        );

        $formMapper->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        // Atributos Dinamicos
        $showMapper
            ->with('label.economicoElemento.dados')
            ->add('codElemento', 'string', array('label' => 'label.codigo'))
            ->add('nomElemento', 'string', array('label' => 'label.nome'))
            ->add(
                'atributos',
                'customField',
                [
                    'label' => false,
                    'mapped' => false,
                    'template' => 'TributarioBundle:Sonata\Economico\Elemento\CRUD:dados_atributos.html.twig',
                    'data' => $this->getSubject()
                ]
            )
            ->end()
        ;
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return ($object->getNomElemento())
            ? (string) $object
            : $this->getTranslator()->trans('label.economicoElemento.modulo');
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $elemento = $em->getRepository(Elemento::class)
            ->findOneBy(['nomElemento' => $object->getNomElemento()]);

        if (is_null($this->getSubject()->getCodElemento()) && $elemento) {
            $error = $this->getTranslator()->trans('label.economicoElemento.erro', array('%nome%' => $object->getNomElemento()));
            $errorElement->with('nomElemento')->addViolation($error)->end();
        }
    }

    /**
     * @param mixed $object
     * @throws \Exception
     */
    public function postPersist($object)
    {
        $container = $this->getConfigurationPool()->getContainer();
        try {
            /** @var EntityManager $em */
            $em = $this->modelManager->getEntityManager(AtributoDinamico::class);

            $childrens = $this->getForm()->all();
            $atributos = $childrens['atributos']->getViewData();

            foreach ($atributos as $atributo) {
                $params = array(
                    'codModulo' => ConfiguracaoModel::MODULO_TRIBUTARIO_ECONOMICO,
                    'codCadastro' => CadastroModel::CADASTRO_ELEMENTOS,
                    'codAtributo' => $atributo
                );

                $atributoDinamico = $em->getRepository(AtributoDinamico::class)
                    ->findOneBy($params);

                $atributoElemento = new AtributoElemento();
                $atributoElemento->setFkAdministracaoAtributoDinamico($atributoDinamico);
                $atributoElemento->setFkEconomicoElemento($object);

                $em->persist($atributoElemento);
            }

            $em->flush();
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @param mixed $object
     * @throws \Exception
     */
    public function postUpdate($object)
    {
        $container = $this->getConfigurationPool()->getContainer();

        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager(AtributoDinamico::class);

        try {
            foreach ($object->getFkEconomicoAtributoElementos() as $atributo) {
                $em->remove($atributo);
                $em->flush();
            }

            $childrens = $this->getForm()->all();
            $atributos = $childrens['atributos']->getViewData();

            foreach ($atributos as $atributo) {
                $atributoDinamico = $em->getRepository(AtributoDinamico::class)
                    ->findOneBy(['codAtributo' => $atributo]);

                $atributoElemento = new AtributoElemento();
                $atributoElemento->setFkAdministracaoAtributoDinamico($atributoDinamico);
                $atributoElemento->setFkEconomicoElemento($object);

                $em->persist($atributoElemento);
            }

            $em->flush();
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @param Elemento $object
     * @return bool
     */
    public function canBaixar($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $baixaElementoRepository = $em->getRepository(BaixaElemento::class);
        $baixaElemento = $baixaElementoRepository->findOneBy([
            'codElemento' => $object->getCodElemento()
        ]);

        if (count($baixaElemento) > 0) {
            return false;
        }
        return true;
    }
}
