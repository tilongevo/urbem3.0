<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Monetario;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\Funcao;
use Urbem\CoreBundle\Entity\Monetario\Acrescimo;
use Urbem\CoreBundle\Entity\Monetario\AcrescimoNorma;
use Urbem\CoreBundle\Entity\Monetario\FormulaAcrescimo;
use Urbem\CoreBundle\Entity\Monetario\TipoAcrescimo;
use Urbem\CoreBundle\Entity\Normas\Norma;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Monetario\AcrescimoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class AcrescimoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_monetario_acrescimo';
    protected $baseRoutePattern = 'tributario/cadastro-monetario/acrescimo';

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('definir_valor', 'definir-valor/' . $this->getRouterIdParameter());
        $collection->add('formula_calculo', 'formula-calculo/' . $this->getRouterIdParameter());
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codAcrescimo', null, array('label' => 'label.codigo'))
            ->add('descricaoAcrescimo', null, array('label' => 'label.monetarioAcrescimo.modulo'));
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codAcrescimo', null, array('label' => 'label.codigo'))
            ->add('descricaoAcrescimo', null, array('label' => 'label.monetarioAcrescimo.descricaoAcrescimos'))
            ->add('codTipo', null, array('label' => 'label.monetarioAcrescimo.tipoAcrescimo'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                    'formula_calculo' => array('template' => 'TributarioBundle:Sonata/Monetario/Acrescimo/CRUD:list__action_formula_calculo.html.twig'),
                    'definir_valor' => array('template' => 'TributarioBundle:Sonata/Monetario/Acrescimo/CRUD:list__action_definir_valor.html.twig'),
                )
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager(Acrescimo::class);

        $formOptions = array();

        $formOptions['norma'] = array(
            'label' => 'label.monetarioAcrescimo.fundamentacaoLegal',
            'class' => Norma::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                $qb = $repo->createQueryBuilder('n')
                    ->where('LOWER(n.nomNorma) LIKE :nomNorma')
                    ->andWhere('n.exercicio = :exercicio')
                    ->setParameter('nomNorma', "%" . strtolower($term) . "%")
                    ->setParameter('exercicio', $this->getExercicio());
                return $qb;
            },
            'mapped' => false,
        );

        $formOptions['funcao'] = array(
            'label' => 'label.monetarioAcrescimo.funcao',
            'class' => Funcao::class,
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'mapped' => false,
            'query_builder' => function (EntityRepository $repo) {
                $qb = $repo->createQueryBuilder('f')
                    ->where('f.codModulo = :codModulo')
                    ->andWhere('f.codBiblioteca = :codBiblioteca')
                    ->setParameter('codModulo', ConfiguracaoModel::MODULO_TRIBUTARIO_MONETARIO_ACRESCIMOS)
                    ->setParameter('codBiblioteca', AcrescimoModel::BIBLIOTECA_ORIGEM);
                return $qb;
            },
        );

        $formOptions['fkMonetarioTipoAcrescimo'] = array(
            'label' => 'label.monetarioAcrescimo.tipoAcrescimo',
            'class' => TipoAcrescimo::class,
            'choice_label' => 'nomTipo',
            'label' => 'label.monetarioAcrescimo.tipoAcrescimo',
            'attr' => [
                'class' => 'select2-parameters'
            ]
        );

        if ($this->id($this->getSubject())) {
            $acrescimoNormaObject = $em->getRepository(AcrescimoNorma::class)
                ->findOneBy(['codAcrescimo' => $this->getSubject()->getCodAcrescimo()]);
            $formOptions['norma']['data'] = $acrescimoNormaObject;

            $formulaAcrescimoObject = $em->getRepository(FormulaAcrescimo::class)
                ->findOneBy(['codAcrescimo' => $this->getSubject()->getCodAcrescimo()]);
            $formOptions['funcao']['data'] = $formulaAcrescimoObject;

            $formOptions['fkMonetarioTipoAcrescimo']['disabled'] = true;
        }

        $formMapper
            ->with('label.monetarioAcrescimo.dados')
            ->add('fkMonetarioTipoAcrescimo', 'entity', $formOptions['fkMonetarioTipoAcrescimo'])
            ->add('descricaoAcrescimo', 'text', array('label' => 'label.descricao'))
            ->add(
                'norma',
                'autocomplete',
                $formOptions['norma']
            )
            ->add(
                'funcao',
                'entity',
                $formOptions['funcao']
            )
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $em = $this->modelManager->getEntityManager(AcrescimoNorma::class);
        $acrescimoNorma = $em->getRepository(AcrescimoNorma::class)
            ->findOneBy(['codAcrescimo' => $this->getSubject()->getCodAcrescimo()]);

        $norma = ($acrescimoNorma) ? $acrescimoNorma->getFkNormasNorma() : null;

        $formulaAcrescimo = $em->getRepository(FormulaAcrescimo::class)
            ->findOneBy(['codAcrescimo' => $this->getSubject()->getCodAcrescimo()]);

        $funcao = ($formulaAcrescimo) ? $formulaAcrescimo->getFkAdministracaoFuncao() : null;

        $showMapper
            ->with('label.monetarioAcrescimo.dados')
            ->add('codAcrescimo', null, array('label' => 'label.codigo'))
            ->add('fkMonetarioTipoAcrescimo.nomTipo', null, array('label' => 'label.monetarioAcrescimo.tipoAcrescimo'))
            ->add('descricaoAcrescimo', null, array('label' => 'label.monetarioAcrescimo.descricaoAcrescimos'))
            ->add(
                'norma',
                'customField',
                array(
                    'label' => 'label.monetarioAcrescimo.descricaoAcrescimos',
                    'mapped' => false,
                    'data' => array(
                        'norma' => $norma
                    ),
                    'template' => 'TributarioBundle:Monetario\Acrescimo:norma.html.twig',
                )
            )
            ->add(
                'funcao',
                'customField',
                array(
                    'label' => 'label.monetarioAcrescimo.descricaoAcrescimos',
                    'mapped' => false,
                    'data' => array(
                        'funcao' => $funcao
                    ),
                    'template' => 'TributarioBundle:Monetario\Acrescimo:funcao.html.twig',
                )
            )
            ->end();
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        // codAcrescimo
        $em = $this->modelManager->getEntityManager(Acrescimo::class);
        $acrescimoModel = new AcrescimoModel($em);
        $codAcrescimo = $acrescimoModel->getNextVal();
        $object->setCodAcrescimo($codAcrescimo);

        // Norma - AcrescimoNorma
        $norma = $this->getForm()->get('norma')->getdata();

        $acrescimoNorma = new AcrescimoNorma();
        $acrescimoNorma->setFkMonetarioAcrescimo($object);
        $acrescimoNorma->setFkNormasNorma($norma);
        $acrescimoNorma->setCodTipo($object->getCodTipo());

        $object->addFkMonetarioAcrescimoNormas($acrescimoNorma);

        // Funcao - FormulaAcrescimo
        $funcao = $this->getForm()->get('funcao')->getdata();

        $formulaAcrescimo = new FormulaAcrescimo();
        $formulaAcrescimo->setFkMonetarioAcrescimo($object);
        $formulaAcrescimo->setFkAdministracaoFuncao($funcao);

        $object->addFkMonetarioFormulaAcrescimos($formulaAcrescimo);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager(AcrescimoNorma::class);

        // Norma - AcrescimoNorma
        $acrescimoNormaObject = $em->getRepository(AcrescimoNorma::class)
            ->findOneBy(['codAcrescimo' => $object->getCodAcrescimo()]);

        if ($acrescimoNormaObject) {
            $em->remove($acrescimoNormaObject);
        }

        $norma = $this->getForm()->get('norma')->getdata();

        $acrescimoNorma = new AcrescimoNorma();
        $acrescimoNorma->setFkMonetarioAcrescimo($object);
        $acrescimoNorma->setFkNormasNorma($norma);
        $acrescimoNorma->setCodTipo($object->getCodTipo());

        $object->addFkMonetarioAcrescimoNormas($acrescimoNorma);

        // Funcao - FormulaAcrescimo
        $formulaAcrescimoObject = $em->getRepository(FormulaAcrescimo::class)
            ->findOneBy(['codAcrescimo' => $object->getCodAcrescimo()]);

        if ($formulaAcrescimoObject) {
            $em->remove($formulaAcrescimoObject);
        }

        $funcao = $this->getForm()->get('funcao')->getdata();

        $formulaAcrescimo = new FormulaAcrescimo();
        $formulaAcrescimo->setFkMonetarioAcrescimo($object);
        $formulaAcrescimo->setFkAdministracaoFuncao($funcao);

        $object->addFkMonetarioFormulaAcrescimos($formulaAcrescimo);
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof Acrescimo
            ? $object->getDescricaoAcrescimo()
            : $this->getTranslator()->trans('label.monetarioAcrescimo.modulo');
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        if ($object->getCodAcrescimo()) {
            return;
        }

        $em = $this->modelManager->getEntityManager($this->getClass());
        $acrescimo = $em->getRepository(Acrescimo::class)
            ->findOneBy(array('descricaoAcrescimo' => $object->getDescricaoAcrescimo()));

        if ($acrescimo) {
            $error = $this->getTranslator()->trans('label.monetarioAcrescimo.erroDuplicado');
            $errorElement->with('descricaoAcrescimo')->addViolation($error)->end();
        }
    }
}
