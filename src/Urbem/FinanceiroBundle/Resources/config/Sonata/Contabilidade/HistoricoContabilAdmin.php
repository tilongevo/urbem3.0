<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Contabilidade;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Contabilidade\HistoricoContabil;
use Urbem\CoreBundle\Model\Contabilidade\HistoricoContabilModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class HistoricoContabilAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_financeiro_contabilidade_historico_contabil';
    protected $baseRoutePattern = 'financeiro/contabilidade/historico-contabil';

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
            ->add('codHistorico', null, ['label' => 'label.codigo'])
            ->add('nomHistorico', null, ['label' => 'label.descricao'])
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
            ->add('complemento', null, ['label' => 'label.complemento'])
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

        $em = $this->modelManager->getEntityManager($this->getClass());
        $histModel = new HistoricoContabilModel($em);
        $lastCodHistorico = $histModel->getLastCodHistorico($this->getExercicio());

        $fieldOptions = [];
        $fieldOptions['codHistorico'] = [
            'label' => 'label.codigo',
            'required' => 'true',
            'data' => $lastCodHistorico,
            'attr' => ['min' => 1, 'max' => 999]
        ];

        if ($this->id($this->getSubject())) {
            $fieldOptions['codHistorico']['disabled'] = true;
        }

        $formMapper
            ->with('label.historicoContabil.historicoPadrao')
            ->add(
                'codHistorico',
                null,
                $fieldOptions['codHistorico']
            )
            ->add(
                'nomHistorico',
                'text',
                [
                    'label' => 'label.descricao',
                    'required' => 'true'
                ]
            )
            ->add(
                'complemento',
                'choice',
                ['choices' => [
                    'sim' => 1,
                    'nao' => 0,
                ],
                    'label' => 'label.complemento',
                    'attr' => ['class' => 'select2-parameters']
                ]
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $showMapper
            ->add('codHistorico', null, ['label' => 'label.historicoContabil.codHistorico'])
            ->add('exercicio', null, ['label' => 'label.historicoContabil.exercicio'])
            ->add('nomHistorico', null, ['label' => 'label.historicoContabil.nomHistorico'])
            ->add('complemento', null, ['label' => 'label.historicoContabil.complemento'])
            ->add('historicoInterno', null, ['label' => 'label.historicoContabil.historicoInterno'])
        ;
    }

    public function prePersist($object)
    {
        $object->setExercicio($this->getExercicio());
    }

    public function preValidate($object)
    {
        $codHistorico = $object->getCodHistorico();

        $em = $this->modelManager->getEntityManager($this->getClass());
        $result = (new HistoricoContabilModel($em))
            ->getCodHistorico($this->getExercicio());
        if ($result) {
            $list = array();
            for ($i = 0; $i < count($result); $i++) {
                $list[$i] = $result[$i]->getCodHistorico();
            }
            if (in_array($object->getCodHistorico(), $list)) {
                $error = $this->getTranslator()->trans('label.historicoContabil.validate.historicoExistente');
                $this->getConfigurationPool()->getContainer()->get('session')
                    ->getFlashBag()->add('error', $error);
            }
        }

        if ($codHistorico >= 800 && $codHistorico <= 899) {
            $mensagem = $this->trans('financeiro.historicoContabil.avisoIntervalo1', [], 'flashes');
            $this->redirect($mensagem);
        }

        if ($codHistorico >= 900 && $codHistorico <= 999) {
            $mensagem = $this->trans('financeiro.historicoContabil.avisoIntervalo2', [], 'flashes');
            $this->redirect($mensagem);
        }
    }

    protected function redirect($mensagem)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $container->get('session')->getFlashBag()->add('error', $mensagem);
        (new RedirectResponse($this->request->headers->get('referer')))->send();
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof HistoricoContabil
            ? $object->getNomHistorico()
            : 'Histórico Padrão';
    }
}
