<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Empenho;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Empenho\Historico;
use Urbem\CoreBundle\Model\Empenho\HistoricoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class HistoricoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_empenho_configuracao_historico';
    protected $baseRoutePattern = 'financeiro/empenho/configuracao/historico';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'codHistorico',
                null,
                [
                    'label' => 'label.codigo'
                ]
            )
            ->add(
                'nomHistorico',
                null,
                [
                    'label' => 'label.descricao'
                ]
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codHistorico', null, ['label' => 'label.codigo'])
            ->add('nomHistorico', null, ['label' => 'label.descricao'])
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $this->getExercicio());
        return $query;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formOptions = array();

        $formOptions['codHistorico'] = [
            'label' => 'label.codigo',
            'required' => true,
            'mapped' => false,
            'data' => (new HistoricoModel($em))->getMaxByExercicio($this->getExercicio()),
            'attr' => [
                'min' => 1
            ]
        ];

        if ($this->id($this->getSubject())) {
            $formOptions['codHistorico']['data'] = $this->getSubject()
                ->getCodHistorico();
            $formOptions['codHistorico']['disabled'] = true;
        }

        $formMapper
            ->with('label.configuracaoEmpenho.dadosHistoricoEmpenho')
            ->add(
                'codHistorico',
                'number',
                $formOptions['codHistorico']
            )
            ->add(
                'nomHistorico',
                'text',
                [
                    'label' => 'label.descricao',
                    'required' => true,
                ]
            )
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->with('label.configuracaoEmpenho.dadosHistoricoEmpenho')
            ->add('codHistorico', null, ['label' => 'label.codigo'])
            ->add('nomHistorico', null, ['label' => 'label.descricao'])
            ->end()
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        if ($object->getCodHistorico() < 0) {
            $error = $this->getTranslator()->trans('label.preEmpenho.erroCodHistorico');
            $errorElement->with('codHistorico')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
        }

        $historico = $em->getRepository($this->getClass())
            ->findBy([
                'codHistorico' => $this->getForm()->get('codHistorico')->getData(),
                'exercicio' => $this->getExercicio()
            ]);

        if (count($historico)) {
            $error = "Código " . $object->getCodHistorico() . " em uso!";
            $errorElement->with('codHistorico')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
        }
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $codHistorico = $this->getForm()->get('codHistorico')->getData();
        $object->setExercicio($this->getExercicio());
        $object->setCodHistorico($codHistorico);
    }
}
