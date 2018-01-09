<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Economico\NivelAtividade;
use Urbem\CoreBundle\Entity\Economico\VigenciaAtividade;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class NivelAtividadeAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_nivel_atividade';
    protected $baseRoutePattern = 'tributario/cadastro-economico/hierarquia-atividade/nivel';

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return [];
        }

        return [
            'codVigencia' => $this->getRequest()->get('codVigencia'),
        ];
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $codVigencia = $this->getRequest()->get('codVigencia');

        $query = parent::createQuery($context);
        if (!$codVigencia) {
            $query->where('1 = 0');
        } else {
            $query->where('o.codVigencia = :codVigencia');
            $query->setParameter('codVigencia', $codVigencia);
        }

        return $query;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $lastNivelAtividade = $em->getRepository(NivelAtividade::class)
            ->findOneBy(
                [],
                [
                    'codNivel' => 'DESC'
                ]
            );

        $object->setCodNivel($lastNivelAtividade ? $lastNivelAtividade->getCodNivel() + 1 : 1);
    }

    /**
     * @param ErrorElement $errorElement
     * @param mixed $object
     * @return bool
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $oldObject = $em->getUnitOfWork()->getOriginalEntityData($object);

        if (!empty($oldObject['codNivel'])
            && $oldObject['nomNivel'] == $object->getNomNivel()) {
            return;
        }

        $nivelAtividade = $em->getRepository(NivelAtividade::class)
            ->findOneBy(
                [
                    'nomNivel' => $object->getNomNivel(),
                ]
            );

        if ($nivelAtividade) {
            $error = $this->getTranslator()->trans('label.economicoNivelAtividade.erroNivelAtividade');
            $errorElement->with('nomNivel')->addViolation($error)->end();
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $nivelAtividade = $em->getRepository(VigenciaAtividade::class)->findOneBy(['codVigencia' => $this->getRequest()->get('codVigencia')]);

        $datagridMapper->add('nomNivel', null, ['label' => 'label.economicoNivelAtividade.nomNivel']);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codNivel', null, ['label' => 'label.economicoNivelAtividade.codNivel'])
            ->add('nomNivel', null, ['label' => 'label.economicoNivelAtividade.nomNivel']);

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

        $nivelAtividade = $this->getSubject();

        $fieldOptions = [];
        $fieldOptions['fkEconomicoVigenciaAtividade'] = [
            'class' => VigenciaAtividade::class,
            'choice_label' => function ($vigenciaAtividade) {
                return sprintf('%d - %s', $vigenciaAtividade->getCodVigencia(), $vigenciaAtividade->getDtInicio()->format('d/m/Y'));
            },
            'required' => true,
            'disabled' => (bool) $id ?: false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters'
            ],
            'label' => 'label.economicoNivelAtividade.codVigencia',
        ];

        $codVigencia = $nivelAtividade->getCodVigencia();
        if (!$id) {
            $vigencia = $em->getRepository(VigenciaAtividade::class)->findOneBy(['codVigencia' => $this->getRequest()->get('codVigencia')]);
            $codVigencia = $vigencia->getCodVigencia();
            $fieldOptions['fkEconomicoVigenciaAtividade']['data'] = $vigencia;
        }

        $fieldOptions['nivelSuperior'] = [
            'mapped' => false,
            'disabled' => true,
            'data' => $this->getNivelSuperior($nivelAtividade, $codVigencia),
            'label' => 'label.economicoNivelAtividade.nivelSuperior',
        ];

        $formMapper
            ->with('label.economicoNivelAtividade.cabecalho')
            ->add('fkEconomicoVigenciaAtividade', 'entity', $fieldOptions['fkEconomicoVigenciaAtividade']);


        if ($id) {
            $formMapper->add(
                'codNivel',
                'text',
                [
                    'disabled' => true,
                    'label' => 'label.economicoNivelAtividade.codNivel'
                ]
            );
        }

        $formMapper
            ->add('nomNivel', 'text', ['label' => 'label.economicoNivelAtividade.nomNivel'])
            ->add('nivelSuperior', 'text', $fieldOptions['nivelSuperior'])
            ->add('mascara', 'text', ['label' => 'label.economicoNivelAtividade.mascara']);
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);

        $nivelAtividade = $this->getSubject();

        $this->nivelSuperior = $this->getNivelSuperior($nivelAtividade, $nivelAtividade->getCodVigencia());

        $showMapper
            ->with('label.economicoNivelAtividade.cabecalho')
            ->add('fkEconomicoVigenciaAtividade', null, ['label' => 'label.economicoNivelAtividade.codVigencia'])
            ->add('codNivel', null, ['label' => 'label.economicoNivelAtividade.codNivel'])
            ->add('nomNivel', null, ['label' => 'label.economicoNivelAtividade.nomNivel'])
            ->add(
                'nivelSuperior',
                'customField',
                [
                    'mapped' => false,
                    'label' => false,
                    'template' => 'TributarioBundle::Economico/NivelAtividade/nivel_atividade_show.html.twig',
                ]
            )
            ->add('mascara', null, ['label' => 'label.economicoNivelAtividade.mascara']);
    }

    /**
    * @param NivelAtividade $object
    * @return string
    */
    protected function getNivelSuperior(NivelAtividade $object = null, $codVigencia)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $qb = $em->getRepository(NivelAtividade::class)->createQueryBuilder('o');

        if ($object && $object->getCodNivel()) {
            $qb->where('o.codNivel < :codNivel');
            $qb->setParameter('codNivel', $object->getCodNivel());
        }

        $qb->andWhere('o.codVigencia = :codVigencia');
        $qb->setParameter('codVigencia', $codVigencia);

        $qb->orderBy('o.codNivel', 'DESC');

        $nivelAtividades = $qb->getQuery()->getResult();
        $nivelAtividade = array_shift($nivelAtividades);
        if (!$nivelAtividade) {
            return '';
        }

        return (string) $nivelAtividade;
    }
}
