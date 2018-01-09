<?php

namespace Urbem\AdministrativoBundle\Resources\config\Sonata\Protocolo;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\SwAtributoProtocolo;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Model;

class AtributoProtocoloAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_administrativo_protocolo_atributo_assunto';
    protected $baseRoutePattern = 'administrativo/protocolo/atributo-assunto';
    protected $model = Model\SwAtributoProtocoloModel::class;

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('nomAtributo', null, ['label' => 'label.descricao'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('nomAtributo', 'text', ['label' => 'label.descricao', 'sortable' => false])
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
                'nomAtributo',
                null,
                [
                    'label' => 'label.descricao'
                ]
            )
            ->add('tipo')
            ->add(
                'tipo',
                'choice',
                [
                    'choices' => [
                        'label.texto' => 't',
                        'label.numero' => 'n',
                        'label.lista' => 'l',
                    ],
                    'label' => 'label.tipo',
                    'attr' => [
                        'class' => 'select2-parameters'
                    ]
                ]
            )
            ->add(
                'valorPadrao',
                null,
                [
                    'label' => 'label.atributoDinamico.valorPadrao.padrao',
                    'required' => false
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
        $this->setBreadCrumb(['id' => $id]);

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\SwAtributoProtocolo');
        $assunto = $em->getRepository('CoreBundle:SwAtributoProtocolo')->findOneByCodAtributo($id);

        $assuntoData = 'Texto';
        if ($assunto->getTipo() == 't') {
            $assuntoData = 'Texto';
        }
        if ($assunto->getTipo() == 'n') {
            $assuntoData = 'Número';
        }
        if ($assunto->getTipo() == 'l') {
            $assuntoData = 'Lista';
        }

        $fieldOptions = array();
        $fieldOptions['tipo1'] = array(
            'label' => 'label.tipo',
            'mapped' => false,
            'template' => 'CoreBundle:Sonata/CRUD:show_custom_value.html.twig',
            'data' => $assuntoData
        );

        $showMapper
            ->add('codAtributo', 'number', ['label' => 'label.codigo'])
            ->add('nomAtributo', 'text', ['label' => 'label.descricao'])
            ->add('tipo1', null, $fieldOptions['tipo1'])
            ->add('valorPadrao', 'text', ['label' => 'label.atributoDinamico.valorPadrao.padrao'])
        ;
    }

    public function toString($object)
    {
        return $object instanceof SwAtributoProtocolo
            ? $object->getNomAtributo()
            : 'Atributo de Assunto';
    }

    public function validate(ErrorElement $errorElement, $object)
    {
        $qb = $this->modelManager->getEntityManager($this->getClass())
            ->getRepository($this->getClass())
            ->createQueryBuilder('sap');

        $qb->select('COUNT(sap.codAtributo)');
        $qb->andWhere('sap.nomAtributo = :nomAtributo');
        $qb->setParameter('nomAtributo', $object->getNomAtributo());

        if (null !== $object->getCodAtributo()) {
            $qb->andWhere('sap.codAtributo != :codAtributo');
            $qb->setParameter('codAtributo', $object->getCodAtributo());
        }

        if (0 < $qb->getQuery()->getSingleScalarResult()) {
            $error = "Descrição " . $object->getNomAtributo() . " em uso!";
            $errorElement->with('nomAtributo')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
        }
    }
}
