<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Protocolo;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\SwDocumento;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Model;

class DocumentoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_protocolo_documento_processo';
    protected $baseRoutePattern = 'administrativo/protocolo/documento-processo';
    protected $model = Model\SwDocumentoModel::class;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nomDocumento', null, ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('nomDocumento', 'text', ['label' => 'label.descricao', 'sortable' => false])
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
                'nomDocumento',
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
            ->add('codDocumento', 'number', ['label' => 'label.codigo'])
            ->add('nomDocumento', 'text', ['label' => 'label.descricao'])
        ;
    }

    public function toString($object)
    {
        return $object instanceof SwDocumento
            ? $object->getNomDocumento()
            : 'Documento de Processo';
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $qb = $this->modelManager->getEntityManager($this->getClass())
            ->getRepository($this->getClass())
            ->createQueryBuilder('sw');

        $qb->select('COUNT(sw.codDocumento)');
        $qb->andWhere('sw.nomDocumento = :nomDocumento');
        $qb->setParameter('nomDocumento', $object->getNomDocumento());

        if (null !== $object->getCodDocumento()) {
            $qb->andWhere('sw.codDocumento != :codDocumento');
            $qb->setParameter('codDocumento', $object->getCodDocumento());
        }

        if (0 < $qb->getQuery()->getSingleScalarResult()) {
            $error = "Descrição " . $object->getNomDocumento() . " em uso!";
            $errorElement->with('nomDocumento')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
        }
    }
}
