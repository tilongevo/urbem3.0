<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Urbem\CoreBundle\Entity\Cse\Profissao;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Entity\SwUf;
use Urbem\CoreBundle\Model\Economico\ResponsavelTecnicoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class ResponsavelTecnicoAdmin
 * @package Urbem\TributarioBundle\Resources\config\Sonata\Economico
 */
class ResponsavelTecnicoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_responsavel_tecnico';
    protected $baseRoutePattern = 'tributario/cadastro-economico/responsavel-tecnico';
    protected $includeJs = array('/tributario/javascripts/economico/responsavel-tecnico.js');
    protected $isEdit = false;


    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $filter = $this->getRequest()->query->get('filter');

        if (isset($filter['fkSwCgm']) && $filter['fkSwCgm']['value'] != '') {
            $query->andWhere('o.fkSwCgm = :fkSwCgm');
            $query->setParameters([
                'fkSwCgm' => $filter['fkSwCgm']['value']
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
                'fkCseProfissao',
                null,
                [
                    'label' => 'label.economico.responsavel.profissao'
                ],
                'entity',
                [
                    'class' => Profissao::class,
                    'placeholder' => 'label.selecione',
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
                    ),
                ]
            )
            ->add(
                'fkSwCgm',
                'doctrine_orm_choice',
                array(
                    'label' => 'cgm',
                ),
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
            ->add(
                'numRegistro',
                null,
                [
                    'label' => 'label.economico.responsavel.registro'
                ]
            )
            ->add(
                'fkSwUf',
                null,
                [
                    'label' => 'label.uf'
                ],
                'entity',
                [
                    'class' => SwUf::class,
                    'placeholder' => 'label.selecione',
                    'choice_label' => function ($uf) {
                        return $uf->getNomUf();
                    },
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
                'fkSwCgm.nomCgm',
                null,
                [
                    'label' => 'label.economico.responsavel.responsavelTecnico'
                ]
            )
            ->add(
                'fkCseProfissao.nomProfissao',
                null,
                [
                    'label' => 'label.economico.responsavel.profissao'
                ]
            )
            ->add(
                'numRegistro',
                null,
                [
                    'label' => 'label.economico.responsavel.registro'
                ]
            )
            ->add(
                'fkSwUf.nomUf',
                null,
                [
                    'label' => 'label.uf'
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

        $fieldOptions['profissao'] = [
            'class' => Profissao::class,
            'placeholder' => 'label.selecione',
            'label' => 'label.economico.responsavel.profissao',
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

        $fieldOptions['codUf'] = [
            'class' => SwUf::class,
            'mapped' => false,
            'label' => 'label.uf',
            'choice_label' => function ($codUf) {
                return $codUf->getNomUf();
            },
            'placeholder' => 'label.selecione',
            'attr' => [
                'class' => 'select2-parameters '
            ]
        ];

        $fieldOptions['responsavelTecnico'] = [
            'label' => 'label.economico.responsavel.responsavelTecnico',
            'class' => 'CoreBundle:SwCgmPessoaFisica',
            'mapped' => false,
            'route' => ['name' => 'filtra_sw_cgm_pessoa_fisica'],
            'attr' => [
                'class' => 'select2-parameters'
            ]
        ];

        $fieldOptions['numRegistro'] = [
            'label' => 'label.economico.responsavel.numIdentificacao',
            'required' => true
        ];

        if ($this->id($this->getSubject())) {
            $this->isEdit = true;
            $em = $this->modelManager->getEntityManager($this->getClass());

            $profissao = $this->getSubject()->getFkCseProfissao();
            $fieldOptions['profissao']['data'] = $profissao;
            $fieldOptions['profissao']['disabled'] = true;

            $responsavelTecnico = $em->getRepository(SwCgmPessoaFisica::class)
                ->findOneByNumcgm($this->getSubject()->getNumcgm());
            $fieldOptions['responsavelTecnico']['data'] = $responsavelTecnico;
            $fieldOptions['responsavelTecnico']['disabled'] = true;

            $uf = $this->getSubject()->getFkSwUf();
            $fieldOptions['codUf']['data'] = $uf;
        }


        $formMapper
            ->with('label.economico.responsavel.modulo')
            ->add(
                'codProfissao',
                'entity',
                $fieldOptions['profissao']
            )
            ->add(
                'conselhoClasse',
                'text',
                [
                    'mapped' => false,
                    'label' => 'label.economico.responsavel.conselhoClasse',
                    'required' => false,
                    'attr' => [
                        'readonly' => true
                    ]
                ]
            )
            ->add(
                'fkSwCgm.fkSwCgmPessoaFisica',
                'autocomplete',
                $fieldOptions['responsavelTecnico'],
                [
                    'admin_code' => 'administrativo.admin.sw_cgm_pessoa_fisica',
                ]
            )
            ->add(
                'numRegistro',
                null,
                $fieldOptions['numRegistro']
            )
            ->add(
                'codUf',
                'entity',
                $fieldOptions['codUf']
            )
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
                'fkCseProfissao.nomProfissao',
                null,
                [
                    'label' => 'label.economico.responsavel.profissao'
                ]
            )
            ->add(
                'fkCseProfissao',
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
                'fkSwCgm.nomCgm',
                null,
                [
                    'label' => 'label.economico.responsavel.profissional'
                ]
            )
            ->add(
                'numRegistro',
                null,
                [
                    'label' => 'label.economico.responsavel.numIdentificacao'
                ]
            )
            ->add(
                'fkSwCgm',
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
     * @param ErrorElement $errorElement
     * @param mixed $object
     */
    public function validate(ErrorElement $errorElement, $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $swCgmPessoaFisica = $this->getForm()->get('fkSwCgm__fkSwCgmPessoaFisica')->getData();
        $respTecnicoResult = (new ResponsavelTecnicoModel($em))
            ->getResponsavelTecnico($swCgmPessoaFisica->getNumCgm());
        if ($respTecnicoResult && !$this->isEdit) {
            $mensagem =  $this->getTranslator()->trans('label.economico.responsavel.validate.responsavelTecnicoExistente');
            $errorElement->with('fkSwCgm')->addViolation($mensagem)->end();
            $this->getRequest()->getSession()->getFlashBag()->add("error", $mensagem);
        }
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $swCgmPessoaFisica = $this->getForm()->get('fkSwCgm__fkSwCgmPessoaFisica')->getData();
        $swCgm = $em->getRepository(SwCgm::class)
            ->findOneByNumcgm($swCgmPessoaFisica->getNumCgm());
        $object->setFkSwCgm($swCgm);

        $respModel = new ResponsavelTecnicoModel($em);
        $codProfissao =  $this->getForm()->get('codProfissao')->getData();
        $codUf =  $this->getForm()->get('codUf')->getData();

        $profissao = $respModel->getProfissao($codProfissao);
        $object->setFkCseProfissao($profissao);

        $uf = $respModel->getUf($codUf);
        $object->setFkSwUf($uf);
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $swCgmPessoaFisica = $this->getForm()->get('fkSwCgm__fkSwCgmPessoaFisica')->getData();
        $swCgm = $em->getRepository(SwCgm::class)
            ->findOneByNumcgm($swCgmPessoaFisica->getNumCgm());
        $object->setFkSwCgm($swCgm);

        $respModel = new ResponsavelTecnicoModel($em);

        $codProfissao =  $this->getForm()->get('codProfissao')->getData();
        $codUf =  $this->getForm()->get('codUf')->getData();

        $profissao = $respModel->getProfissao($codProfissao);
        $object->setFkCseProfissao($profissao);

        $uf = $respModel->getUf($codUf);
        $object->setFkSwUf($uf);
        $object->setSequencia(1);
    }
}
