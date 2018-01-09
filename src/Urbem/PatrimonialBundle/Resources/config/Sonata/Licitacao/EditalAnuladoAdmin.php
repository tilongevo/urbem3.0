<?php
namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Urbem\CoreBundle\Entity\Licitacao\Edital;
use Urbem\CoreBundle\Entity\Licitacao\EditalAnulado;
use Urbem\CoreBundle\Entity\Licitacao\Licitacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class EditalAnuladoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_edital_anulado';
    protected $baseRoutePattern = 'patrimonial/licitacao/edital-anulado';
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $this->forceRedirect('/patrimonial/licitacao/edital/list');
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->forceRedirect('/patrimonial/licitacao/edital/list');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $ids = explode('~', $this->getAdminRequestId());

        $id = $ids[0];

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $id = $formData['numEdital'];
            $exercicio = $formData['hexercicio'];
        } else {
            $id = $ids[0];
            $exercicio = $ids[1];
        }

        /**
         * @var EntityManager $entityManager
         */
        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Licitacao\Licitacao');
        /** @var Edital $edital */
        $edital = $entityManager
            ->getRepository(Edital::class)
            ->findOneBy([
                'numEdital' => $id,
                'exercicio' => $exercicio
            ]);
        /** @var SwProcesso $processo */
        $processo = $edital->getFkLicitacaoLicitacao()->getFkSwProcesso();

        $formMapper
            ->with('Dados do Edital')
            ->add(
                'numEdital',
                'hidden',
                ['data' => $id, 'mapped' => false]
            )
            ->add(
                'hexercicio',
                'hidden',
                ['data' => $exercicio, 'mapped' => false]
            )
            ->add(
                'edital',
                'text',
                [
                    'data' => $id . '/' . $exercicio,
                    'mapped' => false,
                    'attr' => [
                        'disabled' => 'true'
                    ],
                ]
            )
            ->add(
                'codLicitacao',
                'text',
                [
                    'label' => 'label.patrimonial.licitacao.codLicitacao',
                    'data' => $edital->getFkLicitacaoLicitacao(),
                    'mapped' => false,
                    'attr' => [
                        'disabled' => 'true'
                    ],
                ]
            )
            ->add(
                'exercicio',
                'text',
                [
                    'label' => 'label.patrimonial.licitacao.edital.exercicio',
                    'data' => $edital->getExercicioLicitacao(),
                    'mapped' => false,
                    'attr' => [
                        'disabled' => 'true'
                    ],
                ]
            )
            ->add(
                'codEntidade',
                'text',
                [
                    'label' => 'label.comprasDireta.codEntidade',
                    'data' => $edital->getFkLicitacaoLicitacao()->getFkOrcamentoEntidade(),
                    'mapped' => false,
                    'attr' => [
                        'disabled' => 'true'
                    ],
                ]
            )
            ->add(
                'codModalidade',
                'text',
                [
                    'label' => 'label.comprasDireta.codModalidade',
                    'data' => $edital->getFkLicitacaoLicitacao()->getFkComprasModalidade(),
                    'mapped' => false,
                    'attr' => [
                        'disabled' => 'true'
                    ],
                ]
            )
            ->add(
                'processo',
                'text',
                [
                    'label' => 'label.comprasDireta.codProcesso',
                    'data' => $processo->getCodProcesso() . '/' . $edital->getExercicio(),
                    'mapped' => false,
                    'attr' => [
                        'disabled' => 'true'
                    ],
                ]
            )
            ->add('justificativa')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->forceRedirect('/patrimonial/licitacao/edital/list');
    }

    /**
     * @param EditalAnulado $editalAnulado
     */
    public function prePersist($editalAnulado)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());

        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Licitacao\Licitacao');
        $edital = $entityManager
            ->getRepository(Edital::class)
            ->findOneBy([
                'numEdital' => $formData['numEdital'],
                'exercicio' => $formData['hexercicio']
            ]);

        $editalAnulado->setFkLicitacaoEdital($edital);
        $editalAnulado->setDtAnulacao(new \DateTime());
    }

    /**
     * @param EditalAnulado $editalAnulado
     */
    public function postPersist($editalAnulado)
    {
        $this->redirect($editalAnulado);
    }

    /**
     * @param EditalAnulado $editalAnulado
     */
    public function redirect($editalAnulado)
    {
        $this->forceRedirect("/patrimonial/licitacao/edital/{$this->getObjectKey($editalAnulado->getFkLicitacaoEdital())}/show");
    }
}
