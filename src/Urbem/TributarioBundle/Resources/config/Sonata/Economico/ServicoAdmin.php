<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Economico\AliquotaServico;
use Urbem\CoreBundle\Entity\Economico\NivelServico;
use Urbem\CoreBundle\Entity\Economico\NivelServicoValor;
use Urbem\CoreBundle\Entity\Economico\VigenciaServico;
use Urbem\CoreBundle\Model\Economico\AliquotaServicoModel;
use Urbem\CoreBundle\Model\Economico\NivelServicoModel;
use Urbem\CoreBundle\Model\Economico\NivelServicoValorModel;
use Urbem\CoreBundle\Model\Economico\ServicoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class ServicoAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Economico
 */
class ServicoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_servico';
    protected $baseRoutePattern = 'tributario/cadastro-economico/servico';
    protected $includeJs = ['/tributario/javascripts/economico/servico.js'];
    protected $isEdit = false;

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('aliquota', 'aliquota/'.$this->getRouterIdParameter());
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $filter = $this->getRequest()->query->get('filter');
        if ($filter && array_key_exists('fkEconomicoNivelServicoValores__fkEconomicoNivelServico__codNivel', $filter)) {
            $value = $filter['fkEconomicoNivelServicoValores__fkEconomicoNivelServico__codNivel']['value'];
            if ($value != '') {
                $query->join(NivelServicoValor::class, 'nivel', 'WITH', 'o.codServico = nivel.codServico');
                $query->andWhere('nivel.codNivel = :nivel');
                $query->setParameters([
                    'nivel' => $value
                ]);
            }
        }

        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'fkEconomicoNivelServicoValores.fkEconomicoNivelServico.codNivel',
                null,
                [
                    'label' => 'label.economico.servico.nivel'
                ],
                'entity',
                [
                    'class' => NivelServico::class,
                    'choice_value' => 'codNivel',
                    'attr' => [
                        'class' => 'select2-parameters '
                    ]
                ]
            )
            ->add(
                'nomServico',
                null,
                [
                    'label' => 'label.economico.servico.nome'
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
            ->add(
                'codEstrutural',
                null,
                [
                    'label' => 'label.economico.servico.codigo'
                ]
            )
            ->add(
                'fkEconomicoNivelServicoValores',
                null,
                [
                    'label' => 'label.economico.servico.nivel'
                ]
            )
            ->add(
                'nomServico',
                null,
                [
                    'label' => 'label.economico.servico.nome'
                ]
            )
            ->add(
                'fkEconomicoAliquotaServicos',
                'number',
                [
                    'label' => 'label.economico.servico.aliquota',
                    'attr' => [
                        'class' => 'percent '
                    ]
                ]
            )
        ;

        $listMapper
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'),
                    'edit' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_edit.html.twig'),
                    'delete' => array('template' => 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig'),
                    'aliquota' => array('template' => 'TributarioBundle:Sonata/Economico/CRUD:list__action_aliquota.html.twig'),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());
        $vigenciaAtual = $em->getRepository(VigenciaServico::class)
            ->getVigenciaAtual();

        $fieldOptions['fkEconomicoNivelServicoValores_fkEconomicoNivelServico'] = [
            'class' => NivelServico::class,
            'placeholder' => 'label.selecione',
            'label' => 'label.economico.servico.nivelSuperior',
            'mapped' => false,
            'disabled' => false,
            'choice_value' => function ($nivelServico) {
                return $nivelServico;
            },
            'query_builder' => function (EntityRepository $repository) use ($vigenciaAtual) {
                return $repository->createQueryBuilder('o')
                    ->where('o.codVigencia = :vigencia')
                    ->setParameter('vigencia', $vigenciaAtual);
            },
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['fkEconomicoAliquotaServicos'] = [
            'label' => 'label.economico.servico.aliquota',
            'mapped' => false,
            'attr' => [
                'class' => 'percent '
            ]
        ];

        $fieldOptions['codEstrutural'] = [
            'label' => 'label.economico.servico.codigo',
            'attr' => [
                'min' => 1, 'max' => 99999
            ]
        ];

        if ($this->id($this->getSubject())) {
            $this->isEdit = true;
            $em = $this->modelManager->getEntityManager($this->getClass());
            $nivelServicoValor = (new NivelServicoValorModel($em))
                ->getNivelServicoValorByCodServico($this->getSubject()->getCodServico());
            if ($nivelServicoValor) {
                $nivelServico = $em->getRepository(NivelServico::class)
                    ->findOneBy(['codVigencia' => $nivelServicoValor->getCodVigencia(), 'codNivel' => $nivelServicoValor->getCodNivel()]);
                $fieldOptions['fkEconomicoNivelServicoValores_fkEconomicoNivelServico']['disabled'] = true;
                $fieldOptions['fkEconomicoNivelServicoValores_fkEconomicoNivelServico']['attr'] = array('class' => 'select-nivel-is-edit ');
                $fieldOptions['fkEconomicoNivelServicoValores_fkEconomicoNivelServico']['data'] = $nivelServico;
            }
            $aliquotaServico = $em->getRepository(AliquotaServico::class)
                ->findOneByCodServico($this->getSubject()->getCodServico());
            if ($aliquotaServico) {
                $fieldOptions['fkEconomicoAliquotaServicos']['data'] = $aliquotaServico->getValor();
            }
        }

        $formMapper
            ->with('label.economico.servico.dadosNivel')
            ->add(
                'fkEconomicoNivelServicoValores.fkEconomicoNivelServico',
                'entity',
                $fieldOptions['fkEconomicoNivelServicoValores_fkEconomicoNivelServico']
            )
            ->end()
            ->with('label.economico.servico.dadosServico')
            ->add(
                'codEstrutural',
                'number',
                $fieldOptions['codEstrutural']
            )
            ->add(
                'nomServico',
                null,
                [
                    'label' => 'label.economico.servico.nome'
                ]
            )
            ->add(
                'fkEconomicoAliquotaServicos',
                'text',
                $fieldOptions['fkEconomicoAliquotaServicos']
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
            ->with('label.economico.servico.dadosServico')
            ->add(
                'codServico',
                null,
                [
                    'label' => 'label.economico.servico.codigo'
                ]
            )
            ->add(
                'fkEconomicoNivelServicoValores',
                null,
                [
                    'label' => 'label.economico.servico.nivel'
                ]
            )
            ->add(
                'nomServico',
                null,
                [
                    'label' => 'label.economico.servico.nome'
                ]
            )
            ->add(
                'fkEconomicoAliquotaServicos',
                'number',
                [
                    'label' => 'label.economico.servico.aliquota',
                    'attr' => [
                        'class' => 'percent '
                    ]
                ]
            )
        ;
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $result = (new ServicoModel($em))
            ->getServicoByCodEstrutural($object->getCodEstrutural());
        if ($result && !$this->isEdit) {
            $error = $this->getTranslator()->trans('label.economico.servico.validate.servicoExistente');
            $errorElement->with('codEstrutural')->addViolation($error)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $error);
        }
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $servico = (new ServicoModel($em))
            ->getServicoByCodServico($object->getCodServico());

        $nivelServicoModel = new NivelServicoValorModel($em);
        $nivelServico = $nivelServicoModel->getNivelServicoValorByCodServico($object->getCodServico());
        $nivelServico->setValor($object->getCodEstrutural());
        $nivelServicoModel->save($nivelServico);

        $servico->setCodEstrutural($object->getCodEstrutural());
        $servico->setNomServico($object->getNomServico());
    }

    /**
     * @param mixed $object
     */
    public function postUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $valAliquota = $this->getForm()->get('fkEconomicoAliquotaServicos')->getData();
        $valAliquota = str_replace(',', '.', $valAliquota);
        if ($valAliquota) {
            $aliquotaServicoModel = new AliquotaServicoModel($em);
            $aliquotaServico = $em->getRepository(AliquotaServico::class)
                ->findOneByCodServico($object->getCodServico());
            $aliquotaServico->setValor($valAliquota);
            $aliquotaServicoModel->update($aliquotaServico);
        }
    }

    /**
     * @param mixed $object
     */
    public function postPersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $valAliquota = $this->getForm()->get('fkEconomicoAliquotaServicos')->getData();
        $valAliquota = str_replace(',', '.', $valAliquota);
        if ($valAliquota) {
            $aliquotaServicoModel = new AliquotaServicoModel($em);
            $aliquotaServico = new AliquotaServico();
            $aliquotaServico->setValor($valAliquota);
            $aliquotaServico->setFkEconomicoServico($object);
            $aliquotaServicoModel->save($aliquotaServico);
        }

        $nivelServico = $this->getForm()
            ->get('fkEconomicoNivelServicoValores__fkEconomicoNivelServico')->getData();
        $nivelServicoValorModel = new NivelServicoValorModel($em);
        $nivelServicoValorModel->saveNivelServicoValor($object, $nivelServico);
    }
}
