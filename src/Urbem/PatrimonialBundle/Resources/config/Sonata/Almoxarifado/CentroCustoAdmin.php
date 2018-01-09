<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado;

use Doctrine\ORM;

use Doctrine\ORM\EntityRepository;
use Urbem\CoreBundle\Entity\Almoxarifado;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCusto;
use Urbem\CoreBundle\Entity\Orcamento;
use Urbem\CoreBundle\Entity\Almoxarifado\CentroCustoEntidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Orcamento\EntidadeModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CentroCustoEntidadeModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CentroCustoPermissaoModel;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class CentroCustoAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Almoxarifado
 */
class CentroCustoAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_almoxarifado_centro_custo';
    protected $baseRoutePattern = 'patrimonial/almoxarifado/centro-custo';

    /**
     * @param RouteCollection $routeCollection
     */
    protected function configureRoutes(RouteCollection $routeCollection)
    {
        $routeCollection->add('autocomplete');
    }

    /**
     * @param Almoxarifado\CentroCusto $centroCusto
     */
    public function redirect($centroCusto)
    {
        $this->forceRedirect("/patrimonial/almoxarifado/centro-custo/{$this->getObjectKey($centroCusto)}/show");
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('descricao', null, ['label' => 'label.patrimonial.almoxarifado.centrodecusto.descricao'])
            ->add('dtVigencia', null, [
                'label' => 'label.patrimonial.almoxarifado.centrodecusto.dtVigencia'
            ], 'sonata_type_date_picker', [
                'format' => 'dd/MM/yyyy',
            ]);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $profilePermissaoTemplateAction =
            'PatrimonialBundle:Sonata/CentroCustoPermissao/CRUD:edit__action_profile.html.twig';
        $profileTemplateAction = 'PatrimonialBundle:Sonata/CentroCusto/CRUD:list__action_profile.html.twig';
        $deleteTemplateAction = 'CoreBundle:Sonata/CRUD:list__action_delete.html.twig';

        $listMapper
            ->add('descricao', null, ['label' => 'label.patrimonial.almoxarifado.centrodecusto.descricao'])
            ->add('dtVigencia', null, ['label' => 'label.patrimonial.almoxarifado.centrodecusto.dtVigencia'])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => ['template' => $profileTemplateAction],
                    // 'responsavel' => ['template' => $profilePermissaoTemplateAction],
                    'delete' => ['template' => $deleteTemplateAction],
                ]
            ]);
    }

    /**
     * @param Almoxarifado\CentroCusto $centroCusto
     * @return void
     */
    public function getResponsavel(Almoxarifado\CentroCusto $centroCusto)
    {
        $centroCusto->responsavel = null;

        /** @var Almoxarifado\CentroCustoPermissao $centroCustoPermissao */
        foreach ($centroCusto->getFkAlmoxarifadoCentroCustoPermissoes() as $centroCustoPermissao) {
            if (true == $centroCustoPermissao->getResponsavel()) {
                $centroCusto->responsavel = $centroCustoPermissao;
                break;
            }
        }
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $objectId = $this->getAdminRequestId();
        $exercicio = $this->getExercicio();

        $this->setBreadCrumb($objectId ? ['id' => $objectId] : []);

        $fieldOptions['descricao']['label'] = 'label.patrimonial.almoxarifado.centrodecusto.descricao';

        $entidadeModel = new EntidadeModel($entityManager);
        $fieldOptions['entidade'] = [
            'attr' => ['class' => 'select2-parameters '],
            'choice_label' => 'fkSwCgm.nomCgm',
            'class' => Orcamento\Entidade::class,
            'label' => 'label.patrimonial.compras.contrato.codEntidade',
            'mapped' => false,
            'query_builder' => $entidadeModel->findByExercicioQuery($exercicio),
            'required' => true
        ];

        $fieldOptions['responsavel'] = [
            'attr' => ['class' => 'select2-parameters '],
            'label' => 'label.patrimonial.almoxarifado.centrodecusto.responsavel',
            'class' => SwCgm::class,
            'mapped' => false,
            'multiple' => false,
            'placeholder' => 'Selecione um Responsavel',
            'route' => ['name' => 'urbem_core_filter_swcgm_autocomplete'],
        ];

        $fieldOptions['dtVigencia'] = [
            'format' => 'dd/MM/yyyy',
            'label' => 'label.patrimonial.almoxarifado.centrodecusto.dtVigencia',
            'required' => true,
        ];

        if ($objectId) {
            /** @var Almoxarifado\CentroCusto $centroCusto */
            $centroCusto = $this->getSubject();

            /** @var Almoxarifado\CentroCustoEntidade $centroCustoEntidade */
            $centroCustoEntidade = $centroCusto->getFkAlmoxarifadoCentroCustoEntidades()->last();

            $fieldOptions['entidade']['query_builder'] = function (EntityRepository $entityManager) use ($exercicio, $centroCustoEntidade) {
                $qb = $entityManager->createQueryBuilder('entidade');
                $result = $qb->where('entidade.exercicio = :exercicio')->andWhere('entidade.codEntidade = :codEntidade')
                    ->setParameter(':codEntidade', $centroCustoEntidade->getFkOrcamentoEntidade()->getCodEntidade())
                    ->setParameter(':exercicio', $exercicio);

                return $result;
            };



            $fieldOptions['entidade']['disabled'] = true;
            $fieldOptions['entidade']['data'] = $centroCustoEntidade->getFkOrcamentoEntidade();
            $this->getResponsavel($this->getSubject());
            $fieldOptions['responsavel']['data'] = $this->getSubject()->responsavel->getFkSwCgm();
        }

        $formMapper
            ->with('Dados do Centro de Custo')
            ->add('descricao', null, $fieldOptions['descricao'])
            ->add('entidade', 'entity', $fieldOptions['entidade'])
            ->add('responsavel', 'autocomplete', $fieldOptions['responsavel'])
            ->add('dtVigencia', 'sonata_type_date_picker', $fieldOptions['dtVigencia'])
            ->end();
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $objectId = $this->getAdminRequestId();
        $this->setBreadCrumb(['id' => $objectId]);

        /** @var Almoxarifado\CentroCusto $centroCusto */
        $centroCusto = $this->getSubject();

        $this->getResponsavel($centroCusto);
    }

    /**
     * @param Almoxarifado\CentroCusto $centroCusto
     * @param CentroCustoEntidade|null $centroCustoEntidade
     */
    private function saveCentroCustoEntidade(Almoxarifado\CentroCusto $centroCusto, Almoxarifado\CentroCustoEntidade $centroCustoEntidade = null)
    {
        /** @var ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        /** @var Orcamento\Entidade $entidade */
        $entidade = $this->getForm()->get('entidade')->getData();

        $centroCustoEntidadeModel = new CentroCustoEntidadeModel($entityManager);
        $centroCustoEntidade = $centroCustoEntidadeModel
            ->createOrUpdateWithCentroCusto($centroCusto, $entidade, $centroCustoEntidade);

        if (is_null($centroCustoEntidade)) {
            $centroCusto->addFkAlmoxarifadoCentroCustoEntidades($centroCustoEntidade);
        }

        $centroCustoEntidadeModel->save($centroCustoEntidade);
    }

    /**
     * @param Almoxarifado\CentroCusto $centroCusto
     * @param Almoxarifado\CentroCustoPermissao|null $centroCustoPermissao
     */
    private function saveCentroCustoResponsavel(Almoxarifado\CentroCusto $centroCusto, Almoxarifado\CentroCustoPermissao $centroCustoPermissao = null)
    {
        /** @var ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $numcgm = $this->getForm()->get('responsavel')->getData();

        $swCgmModel = new SwCgmModel($entityManager);
        $swCgm = $swCgmModel->findOneByNumcgm($numcgm);

        $centroCustoPermissaoModel = new CentroCustoPermissaoModel($entityManager);
        $centroCustoPermissao = $centroCustoPermissaoModel
            ->buildOrUpdateWithCentroCusto($centroCusto, $swCgm, $centroCustoPermissao);

        if (is_null($centroCustoPermissao)) {
            $centroCusto->addFkAlmoxarifadoCentroCustoPermissoes($centroCustoPermissao);
        }

        $centroCustoPermissao->setResponsavel(true);

        $centroCustoPermissaoModel->save($centroCustoPermissao);
    }

    /**
     * @param Almoxarifado\CentroCusto $centroCusto
     */
    public function postPersist($centroCusto)
    {
        $this->saveCentroCustoResponsavel($centroCusto);
        $this->saveCentroCustoEntidade($centroCusto);
        $this->redirect($centroCusto);
    }

    /**
     * @param Almoxarifado\CentroCusto $centroCusto
     */
    public function postUpdate($centroCusto)
    {
        /** @var ORM\EntityManager $entityManager */
        $entityManager = $this->modelManager
            ->getEntityManager($this->getClass());

        $centroCustoPermissaoModel = new CentroCustoPermissaoModel($entityManager);
        $centroCustoPermissao = $centroCustoPermissaoModel->findResponsavelCentroCusto($centroCusto);

        $this->saveCentroCustoResponsavel($centroCusto, $centroCustoPermissao);
        $this->redirect($centroCusto);
    }
}
