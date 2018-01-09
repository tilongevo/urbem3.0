<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Arrecadacao\PermissaoCancelamento;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Form\Type\AutoCompleteType;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Helper;

class PermissaoCancelamentoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_arrecadacao_definir_permissao_cancelamento';
    protected $baseRoutePattern = 'tributario/arrecadacao/baixa-debitos/definir-permissao-cancelamento';

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'fkSwCgm',
                'doctrine_orm_callback',
                [
                    'label' => 'label.arrecadacaoPermissaoCancelamento.numcgm',
                ],
                'autocomplete',
                [
                    'class' => SwCgm::class,
                    'mapped' => false,
                    'route' => [
                        'name' => 'api-search-swcgm-pessoa-fisica-numcgm-nomecgm'
                    ]
                ]
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();
        $listMapper
            ->add('numcgm', 'entity', array('label' => 'label.arrecadacaoPermissaoCancelamento.numcgm'))
            ->add('fkSwCgm.nomCgm', 'entity', array('label' => 'label.arrecadacaoPermissaoCancelamento.nome'))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                )
            ));
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $fieldOptions['numcgm'] = [
            'class' => SwCgm::class,
            'mapped' => false,
            'label' => 'label.arrecadacaoPermissaoCancelamento.numcgm',
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');
                $qb->andWhere('(o.numcgm = :numcgm OR LOWER(o.nomCgm) LIKE :nomCgm)');
                $qb->andWhere('o.numcgm <> 0');
                $qb->setParameter('numcgm', (int) $term);
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));
                $qb->orderBy('o.numcgm', 'ASC');

                return $qb;
            },
            'required' => true,
            'attr' => [
                'class' => 'select2-parameters',
            ],
        ];

        $formMapper
            ->with('label.arrecadacaoPermissaoCancelamento.dados')
            ->add('numcgm', AutoCompleteType::class, $fieldOptions['numcgm']);
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $formData = $this->getRequest()->request->get($this->getUniqid());

        $permissaoCancelamento = $em->getRepository($this->getClass())
            ->findBy([
                'numcgm' => $formData['numcgm']]);

        if (count($permissaoCancelamento)) {
            $error = sprintf('CGM já está na lista. (%d)', $formData['numcgm']);
            $errorElement->with('numcgm')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("erro_custom", $error);
        }
    }

    /**
     * @param mixed $object
     * @throws \Exception
     */
    public function prePersist($object)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $container = $this->getConfigurationPool()->getContainer();

        try {
            $object->setNumCgm($formData['numcgm']);
            $object->setTimestamp(new Helper\DateTimeMicrosecondPK());
            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('label.arrecadacaoPermissaoCancelamento.sucesso'));
        } catch (\Exception $e) {
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
            $container->get('session')->getFlashBag()->add('error', $e->getMessage());
            throw $e;
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return $object instanceof PermissaoCancelamento
            ? $object->getFkSwCgm()
            : $this->getTranslator()->trans('label.arrecadacaoPermissaoCancelamento.modulo');
    }
}
