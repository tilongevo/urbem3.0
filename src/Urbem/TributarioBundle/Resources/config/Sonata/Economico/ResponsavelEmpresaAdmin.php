<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Admin\ErrorElement;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Cse\Profissao;
use Urbem\CoreBundle\Entity\Economico\EmpresaProfissao;
use Urbem\CoreBundle\Entity\Economico\Responsavel;
use Urbem\CoreBundle\Entity\Economico\ResponsavelEmpresa;
use Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\Economico\EmpresaProfissaoModel;
use Urbem\CoreBundle\Model\Economico\ResponsavelEmpresaModel;
use Urbem\CoreBundle\Model\Economico\ResponsavelTecnicoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class ResponsavelEmpresaAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Economico
 */
class ResponsavelEmpresaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_responsavel_empresa';
    protected $baseRoutePattern = 'tributario/cadastro-economico/responsavel-empresa';

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $filter = $this->getRequest()->query->get('filter');

        if ($filter['numcgm']['value'] != '') {
            $query->andWhere('o.numcgm = :numcgm');
            $query->setParameters([
                'numcgm' => $filter['numcgm']['value']
            ]);
        }

        if ($filter['numcgmRespTecnico']['value'] != '') {
            $query->andWhere('o.numcgmRespTecnico = :numcgm');
            $query->setParameters([
                'numcgm' => $filter['numcgmRespTecnico']['value']
            ]);
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
                'numcgm',
                'doctrine_orm_choice',
                [
                    'label' => 'label.economico.responsavel.cgm'
                ],
                'autocomplete',
                array(
                    'route' => array(
                        'name' => 'carrega_sw_cgm_pessoa_juridica'
                    ),
                    'class' => SwCgm::class,
                    'mapped' => false,
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
                )
            )
            ->add(
                'numcgmRespTecnico',
                'doctrine_orm_choice',
                [
                    'label' => 'label.economico.responsavel.responsavelTecnico'
                ],
                'autocomplete',
                array(
                    'route' => array(
                        'name' => 'api-search-swcgm-pessoa-fisica-numcgm-nomecgm'
                    ),
                    'class' => SwCgm::class,
                    'mapped' => false,
                    'attr' => array(
                        'class' => 'select2-parameters'
                    ),
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
                'fkEconomicoResponsavel.fkSwCgm.nomCgm',
                null,
                [
                    'label' => 'label.economico.responsavel.cgm'
                ]
            )
            ->add(
                'fkEconomicoResponsavelTecnico.fkSwCgm.nomCgm',
                null,
                [
                    'label' => 'label.economico.responsavel.responsavelTecnico'
                ]
            )
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

        $fieldOptions['responsavel'] = [
            'class' => Responsavel::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                $qb = $repo->createQueryBuilder('o');
                $qb->join(SwCgm::class, 'swcgm', 'WITH', 'o.numcgm = swcgm.numcgm');
                $qb->where($qb->expr()->orX(
                    $qb->expr()->like('LOWER(swcgm.nomCgm)', ':nomCgm'),
                    $qb->expr()->eq('o.numcgm', ':numcgm')
                ));
                $qb->setParameters([
                    'nomCgm' => sprintf('%%%s%%', strtolower($term)),
                    'numcgm' => ((int) $term) ? $term: null
                ]);
                return $qb;
            },
            'label' => 'label.cgm',
            'required' => true,
            'mapped' => false,
        ];

        $fieldOptions['codProfissao'] = [
            'class' => Profissao::class,
            'placeholder' => 'label.selecione',
            'label' => 'label.economico.responsavel.profissoes',
            'multiple' => true,
            'mapped' => false,
            'choice_label' => function ($profissao) {
                return $profissao->getNomProfissao();
            },
            'query_builder' => function ($entityManager) {
                return $entityManager
                    ->createQueryBuilder('p')
                    ->orderBy('p.nomProfissao', 'ASC');
            },
            'attr' => array(
                'class' => 'select2-parameters '
            )
        ];

        $fieldOptions['responsavelTecnico'] = [
            'class' => ResponsavelTecnico::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repo, $term, Request $request) {
                $qb = $repo->createQueryBuilder('o');
                $qb->join(SwCgm::class, 'swcgm', 'WITH', 'o.numcgm = swcgm.numcgm');
                $qb->where($qb->expr()->orX(
                    $qb->expr()->like('LOWER(swcgm.nomCgm)', ':nomCgm'),
                    $qb->expr()->eq('o.numcgm', ':numcgm')
                ));
                $qb->setParameters([
                    'nomCgm' => sprintf('%%%s%%', strtolower($term)),
                    'numcgm' => ((int) $term) ? $term: null
                ]);
                return $qb;
            },
            'label' => 'label.cgm',
            'required' => true,
            'mapped' => false,
        ];

        if ($this->id($this->getSubject())) {
            $responsavel = $this->getSubject()->getFkEconomicoResponsavel();
            $fieldOptions['responsavel']['data'] = $responsavel;
            $fieldOptions['responsavel']['required'] = false;
            $responsavelTecnico = $this->getSubject()->getFkEconomicoResponsavelTecnico();
            $fieldOptions['responsavelTecnico']['data'] = $responsavelTecnico;
            $fieldOptions['responsavelTecnico']['required'] = false;
            $em = $this->modelManager->getEntityManager($this->getClass());
            $codProfissao = $this->getSubject()->getFkEconomicoResponsavelTecnico()->getCodProfissao();
            $profissoes = $em->getRepository('CoreBundle:Cse\Profissao')
                ->findByCodProfissao($codProfissao);
            $fieldOptions['codProfissao']['choice_attr'] = function ($codProfissao, $key, $index) use ($profissoes) {
                foreach ($profissoes as $p) {
                    if ($p->getCodProfissao() == $codProfissao->getCodProfissao()) {
                        return ['selected' => 'selected'];
                    }
                }
                return ['selected' => false];
            };
        }

        $formMapper
            ->with('label.economico.responsavel.moduloEmpresa')
            ->add(
                'responsavel',
                'autocomplete',
                $fieldOptions['responsavel']
            )
            ->end()
            ->with('label.economico.responsavel.modulo')
            ->add(
                'fkEconomicoResponsavelTecnico.codProfissao',
                'entity',
                $fieldOptions['codProfissao']
            )
            ->add(
                'responsavelTecnico',
                'autocomplete',
                $fieldOptions['responsavelTecnico']
            )
            ->end()
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $this->setBreadCrumb(['id' => $this->getAdminRequestId()]);
        $em = $this->modelManager->getEntityManager($this->getClass());
        $showMapper
            ->with('label.economico.responsavel.moduloResponsavelTecnico')
            ->add(
                'fkEconomicoResponsavelTecnico.fkCseProfissao.nomProfissao',
                null,
                [
                    'label' => 'label.economico.responsavel.profissao'
                ]
            )
            ->add(
                'fkEconomicoResponsavelTecnico.fkCseProfissao',
                null,
                [
                    'class' => Profissao::class,
                    'label' => 'label.economico.responsavel.conselho',
                    'associated_property' => function ($profissao) use ($em) {
                        $respModel = new ResponsavelTecnicoModel($em);
                        $conselho = $respModel->getProfissao($profissao->getCodProfissao());
                        $conselhoClasse = $respModel->getConselhoClasse($conselho->getCodConselho());
                        return sprintf("%s", $conselhoClasse->getNomConselho());
                    }
                ]
            )
            ->add(
                'fkEconomicoResponsavelTecnico.fkSwCgm.nomCgm',
                null,
                [
                    'label' => 'label.economico.responsavel.profissional'
                ]
            )
            ->add(
                'fkEconomicoResponsavelTecnico.numRegistro',
                null,
                [
                    'label' => 'label.economico.responsavel.numIdentificacao'
                ]
            )
            ->add(
                'fkEconomicoResponsavelTecnico.fkSwCgm',
                null,
                [
                    'class' => SwCgm::class,
                    'label' => 'label.uf',
                    'associated_property' => function ($cgm) use ($em) {
                        $uf = $em->getRepository(SwUf::class)
                            ->findOneByCodUf($cgm->getCodUf());
                        return sprintf("%s - %s", $cgm->getCodUf(), $uf->getNomUf());
                    }
                ]
            )
        ;
    }

    /**
     * @param \Sonata\CoreBundle\Validator\ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(\Sonata\CoreBundle\Validator\ErrorElement $errorElement, $object)
    {
        $profissoesSelecionadas = $this->getForm()->get('fkEconomicoResponsavelTecnico__codProfissao')->getData();
        $responsavelTecnico = $this->getForm()->get('responsavelTecnico')->getData();

        $em = $this->modelManager->getEntityManager($this->getClass());

        $isResult = false;
        foreach ($profissoesSelecionadas as $profissao) {
            $codProfissao = $profissao->getCodProfissao();
            $result = (new ResponsavelTecnicoModel($em))
                ->getResponsavelTecnicoAndCodProfissao($responsavelTecnico->getNumcgm(), $codProfissao);
            if ($result) {
                $isResult = true;
            }
        }
        if (!$isResult) {
            $error =  $this->getTranslator()->trans('label.economico.responsavel.validate.naoCorrespondeProfissoes');
            $errorElement->with('fkSwCgm')->addViolation($error)->end();
        }
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $responsavel = $this->getForm()->get('responsavel')->getData();
        $object->setFkEconomicoResponsavel($responsavel);
        $responsavelTecnico = $this->getForm()->get('responsavelTecnico')->getData();
        $object->setFkEconomicoResponsavelTecnico($responsavelTecnico);

        $em = $this->modelManager->getEntityManager($this->getClass());
        $profissoesSelecionadas = $this->getForm()->get('fkEconomicoResponsavelTecnico__codProfissao')->getData();
        $empresaModel = new EmpresaProfissaoModel($em);
        foreach ($profissoesSelecionadas as $profissao) {
            $empresaProfissao = new EmpresaProfissao();
            $empresaProfissao->setFkCseProfissao($profissao);
            $empresaProfissao->setFkEconomicoResponsavel($responsavel);
            $empresaModel->save($empresaProfissao);
        }
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $responsavel = $this->getForm()->get('responsavel')->getData();
        $result = (new ResponsavelEmpresaModel($em))
            ->getResponsavelEmpresa($responsavel->getNumcgm());

        $object->setFkEconomicoResponsavel($responsavel);
        $responsavelTecnico = $this->getForm()->get('responsavelTecnico')->getData();
        $object->setFkEconomicoResponsavelTecnico($responsavelTecnico);

        $profissoesSelecionadas = $this->getForm()->get('fkEconomicoResponsavelTecnico__codProfissao')->getData();
        $empresaModel = new EmpresaProfissaoModel($em);
        foreach ($profissoesSelecionadas as $profissao) {
            $empresaProfissao = new EmpresaProfissao();
            $empresaProfissao->setFkCseProfissao($profissao);
            $empresaProfissao->setFkEconomicoResponsavel($responsavel);
            $empresaModel->save($empresaProfissao);
        }
    }

    /**
     * @param mixed $object
     * @return string
     */
    public function toString($object)
    {
        return ($object->getNumcgm())
            ? (string) $object
            : $this->getTranslator()->trans('label.economico.responsavel.moduloEmpresa');
    }
}
