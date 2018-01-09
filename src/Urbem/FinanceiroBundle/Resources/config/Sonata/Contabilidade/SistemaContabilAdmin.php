<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Contabilidade\SistemaContabil;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class SistemaContabilAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_contabilidade_configuracao_sistema_contabil';
    protected $baseRoutePattern = 'financeiro/contabilidade/configuracao/sistema-contabil';

    public function createQuery($context = 'list')
    {
        $exercicio = $this->getExercicio();

        $query = parent::createQuery($context);

        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $exercicio);

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codSistema', null, ['label' => 'label.codigo'])
            ->add('nomSistema', null, ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add('codSistema', null, ['label' => 'label.codigo'])
            ->add('nomSistema', null, ['label' => 'label.descricao'])
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
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

        $fieldOptions = [];

        $fieldOptions['codigo'] = [
            'label' => 'label.codigo',
            'attr' => ['min' => 1, 'max' => 99999],
            'mapped' => false,
        ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['codigo']['disabled'] = true;
            $fieldOptions['codigo']['data'] = $this->getSubject()->getCodSistema();
        }

        $formMapper
            ->with('label.sistemaContabil.dadosSistemaContabil')
            ->add(
                'codigo',
                'number',
                $fieldOptions['codigo']
            )
            ->add(
                'nomSistema',
                null,
                [
                    'label' => 'label.descricao',
                    'required' => true
                ]
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('codSistema', null, ['label' => 'label.codigo'])
            ->add('nomSistema', null, ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $object->setCodSistema((integer) $this->getForm()->get('codigo')->getData());
        $object->setExercicio($this->getExercicio());
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        if ($this->id($this->getSubject())) {
            return true;
        }

        $em = $this->modelManager->getEntityManager($this->getClass());
        $sistemaContabil = $em->getRepository($this->getClass())
            ->findOneBy([
                'exercicio' => $this->getExercicio(),
                'codSistema' => (integer) $this->getForm()->get('codigo')->getData()
            ]);

        if ($sistemaContabil) {
            $error = "Código " . $object->getCodSistema() . " em uso!";
            $errorElement->with('codigo')->addViolation($error)->end();
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof SistemaContabil
            ? $object->getNomSistema()
            : 'Sistema Contábil';
    }
}
