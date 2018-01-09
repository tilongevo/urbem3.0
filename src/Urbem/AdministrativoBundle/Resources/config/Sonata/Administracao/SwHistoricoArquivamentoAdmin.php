<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Administracao;

use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\SwHistoricoArquivamento;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class SwHistoricoArquivamentoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_motivo_arquivamento';
    protected $baseRoutePattern = 'administrativo/motivo_arquivamento';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nomHistorico', null, array('label' => 'label.descricao'))
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('nomHistorico', null, array('label' => 'label.descricao', 'sortable' => false))
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

        $formMapper
            ->add(
                'nomHistorico',
                'textarea',
                [
                    'label' => 'label.descricao',
                    'required' => true,
                    'attr' => [
                        'class' => 'mensagem-inicial '
                    ]
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
            ->add('codHistorico', null, ['label' => 'label.codigo'])
            ->add('nomHistorico', null, ['label' => 'label.descricao'])
        ;
    }

    public function toString($object)
    {
        return $object instanceof SwHistoricoArquivamento
            ? $object->getNomHistorico()
            : 'Motivo do Arquivamento';
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        /** @var \Doctrine\ORM\QueryBuilder $qb */
        $qb = $this->modelManager->getEntityManager($this->getClass())
            ->getRepository('CoreBundle:SwHistoricoArquivamento')
            ->createQueryBuilder('swa');

        $qb->select('COUNT(swa.codHistorico)');
        $qb->andWhere('swa.nomHistorico = :nomHistorico');
        $qb->setParameter('nomHistorico', $object->getNomHistorico());

        if (null !== $object->getCodHistorico()) {
            $qb->andWhere('swa.codHistorico != :codHistorico');
            $qb->setParameter('codHistorico', $object->getCodHistorico());
        }

        if (0 < $qb->getQuery()->getSingleScalarResult()) {
            $error = "Descrição " . $object->getNomHistorico() . " em uso!";
            $errorElement->with('nomHistorico')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
        }
    }
}
