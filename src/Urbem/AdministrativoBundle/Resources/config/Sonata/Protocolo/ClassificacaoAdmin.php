<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Protocolo;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Model;

class ClassificacaoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_protocolo_classificacao';
    protected $baseRoutePattern = 'administrativo/protocolo/classificacao';
    protected $model = Model\SwClassificacaoModel::class;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
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
            ->add('codClassificacao', 'number', ['label' => 'label.codigo', 'sortable' => false])
            ->add('nomClassificacao', 'text', ['label' => 'label.descricao', 'sortable' => false])
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
                'nomClassificacao',
                null,
                [
                    'label' => 'label.descricao'
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
            ->add('codClassificacao', 'number', ['label' => 'label.codigo'])
            ->add('nomClassificacao', 'text', ['label' => 'label.descricao'])
        ;
    }

    public function toString($object)
    {
        return $object instanceof SwClassificacao
            ? $object->getNomClassificacao()
            : 'Classificação de Assunto';
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $qb = $this->modelManager->getEntityManager($this->getClass())
            ->getRepository($this->getClass())
            ->createQueryBuilder('c');

        $qb->select('COUNT(c.codClassificacao)');
        $qb->andWhere('c.nomClassificacao = :nomClassificacao');
        $qb->setParameter('nomClassificacao', $object->getNomClassificacao());

        if (null !== $object->getCodClassificacao()) {
            $qb->andWhere('c.codClassificacao != :codClassificacao');
            $qb->setParameter('codClassificacao', $object->getCodClassificacao());
        }

        if (0 < $qb->getQuery()->getSingleScalarResult()) {
            $error = "Descrição " . $object->getNomClassificacao() . " em uso!";
            $errorElement->with('nomClassificacao')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
        }
    }
}
