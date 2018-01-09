<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Contabilidade\ClassificacaoContabil;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Model;

class ClassificacaoContabilAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_contabilidade_configuracao_classificacao_contabil';
    protected $baseRoutePattern = 'financeiro/contabilidade/configuracao/classificacao-contabil';
    protected $model = Model\Contabilidade\ClassificacaoContabilModel::class;

    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $this->getExercicio());
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('codClassificacao', null, ['label' => 'label.codigo'])
            ->add('nomClassificacao', null, ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codClassificacao', null, ['label' => 'label.codigo'])
            ->add('nomClassificacao', null, ['label' => 'label.descricao'])
        ;

        $this->addActionsGrid($listMapper);
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
            $fieldOptions['codigo']['data'] = $this->getSubject()->getCodClassificacao();
        }

        $formMapper
            ->with('label.classificacaoContabil.dadosClassificacaoContabil')
                ->add(
                    'codigo',
                    'number',
                    $fieldOptions['codigo']
                )
                ->add(
                    'nomClassificacao',
                    null,
                    [
                        'label' => 'label.descricao',
                        'required' => true
                    ]
                )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $showMapper
            ->add('codClassificacao', null, ['label' => 'label.codigo'])
            ->add('nomClassificacao', null, ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $object->setCodClassificacao((integer) $this->getForm()->get('codigo')->getData());
        $object->setExercicio($this->getExercicio());
    }

    /**
     * @param \Sonata\CoreBundle\Validator\ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {
        if ($this->id($this->getSubject())) {
            return true;
        }

        $em = $this->modelManager->getEntityManager($this->getClass());
        $classificacaoContabil = $em->getRepository($this->getClass())
            ->findOneBy(['exercicio' => $this->getExercicio(), 'codClassificacao' => (integer) $this->getForm()->get('codigo')->getData()]);

        if ($classificacaoContabil) {
            $error = "Código " . $object->getCodClassificacao() . " em uso!";
            $errorElement->with('codigo')->addViolation($error)->end();
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof ClassificacaoContabil
            ? $object->getNomClassificacao()
            : 'Classificação Contábil';
    }
}
