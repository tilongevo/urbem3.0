<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Model\Orcamento\EntidadeModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class EntidadeAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_configuracao_replicar_entidade';
    protected $baseRoutePattern = 'financeiro/orcamento/configuracao/replicar-entidade';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'create'));
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'exercicio',
                null,
                array(
                    'label' => 'label.orcamento.entidade.exercicio',
                )
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
            ->add(
                'exercicio',
                null,
                array(
                    'label' => 'label.orcamento.entidade.exercicio',
                )
            )
        ;

        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $em = $this
            ->getConfigurationPool()
            ->getContainer()
            ->get('doctrine.orm.default_entity_manager')
        ;

        $entityManager = $em->getRepository(Entidade::class);

        $exerciciosExistentes = $entityManager->getDistinctExercicios();

        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $formMapper
            ->with('label.replicarEntidade.dadosReplicarEntidade')
                ->add(
                    'ano',
                    'choice',
                    array(
                        'attr' => [
                            'class' => 'select2-parameters '
                        ],
                        'label' => 'label.replicarEntidade.ano',
                        'mapped' => false,
                        'choices' => count($exerciciosExistentes)
                            ? $exerciciosExistentes
                            : array(),
                    )
                )
                ->add(
                    'exercicio',
                    'number',
                    array(
                        'label' => 'label.replicarEntidade.exercicio',
                        'data' => $this->getExercicio()
                    )
                )
            ->end()
        ;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {

        $entityManager = $this->modelManager->getEntityManager($this->getClass());

        $yearSource = $this->getRequest()->get($this->getUniqid())['ano'];

        $yearTarget = $this->getForm()->get('exercicio')->getData();

        $session = $this
            ->getRequest()
            ->getSession()
            ->getFlashBag()
        ;

        try {
            (new EntidadeModel($entityManager))
                ->replicaEntidade($yearSource, $yearTarget, $this->getTranslator());

            $session->add(
                'success',
                $this->getTranslator()->trans('label.orcamento.entidade.msgSucesso', ['%exercicio%' => $yearTarget])
            );
        } catch (\Exception $e) {
            $session->add('error', $e->getMessage());
        }

        $this->redirectToUrl($this->generateUrl('create'));
    }
}
