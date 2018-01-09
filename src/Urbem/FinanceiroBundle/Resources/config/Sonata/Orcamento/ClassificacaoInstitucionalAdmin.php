<?php

namespace Urbem\FinanceiroBundle\Resources\config\Sonata\Orcamento;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Economico\ResponsavelTecnico;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Entity\Orcamento\EntidadeLogotipo;
use Urbem\CoreBundle\Entity\Orcamento\UsuarioEntidade;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwCgmPessoaFisica;
use Urbem\CoreBundle\Entity\SwCgmPessoaJuridica;
use Urbem\CoreBundle\Helper\UploadHelper;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin as AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Validator\Constraints as Assert;

class ClassificacaoInstitucionalAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'urbem_financeiro_orcamento_classificacao_institucional';
    protected $baseRoutePattern = 'financeiro/orcamento/classificacao-institucional';
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => "DESC",
        '_sort_by' => 'codEntidade'
    ];

    protected $includeJs = array(
        '/financeiro/javascripts/orcamento/classificacaoinstitucional/classificacaoinstituicional.js'
    );

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'edit', 'create'));
        $collection->add('logotipo', '{_id}/logotipo', array('_controller' => 'FinanceiroBundle:Orcamento/ClassificacaoInstitucional:logotipo'), array('id' => $this->getRouterIdParameter()));
    }

    /**
     * @param string $context
     * @return \Sonata\AdminBundle\Datagrid\ProxyQueryInterface
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->where('o.exercicio = :exercicio');
        $query->setParameter('exercicio', $this->getExercicio());
        return $query;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $pager = $this->getDataGrid()->getPager();
        $pager->setCountColumn(array('codEntidade', 'exercicio'));

        $datagridMapper
            ->add('codEntidade', null, ['label' => 'label.codigo'])
            ->add('fkSwCgm.nomCgm', null, ['label' => 'label.nome'])
            ->add('exercicio', null, ['label' => 'label.exercicio'])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('codEntidade', 'text', ['label' => 'label.codigo'])
            ->add('fkSwCgm.nomCgm', 'text', ['label' => 'Nome'])
            ->add('exercicio')
        ;
        $this->addActionsGrid($listMapper);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $em = $this->getDoctrine();

        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /**
         * @var Entidade $entidade
         */
        $entidade = null;
        $usuariosEntidade = null;

        $isEdit = false;
        if ($id) {
            $isEdit = true;

            /**
             * @var Entidade $entidade
             */
            $entidade = $this->getSubject();
            $usuariosEntidade = $em->getRepository(UsuarioEntidade::class)
                ->findBy([
                    'fkOrcamentoEntidade' => $entidade
                ]);
        }

        /**
         * @var Entidade $entidade
         */
        $repo = $em->getRepository(Entidade::class);
        $usuariosDisponiveis = $repo->getUsuariosDisponiveis($this->getExercicio());
        $usuariosDisponiveisList = [];

        if (count($usuariosDisponiveis)) {
            foreach ($usuariosDisponiveis as $usuario) {
                $usuariosDisponiveisList[$usuario['numcgm'].' - '.strtoupper(trim($usuario['nom_cgm']))] = $usuario['numcgm'];
            }
        }
        $usuariosEntidadeLista = [];
        if ($isEdit) {
            $usuariosEntidade = $entidade->getFkOrcamentoUsuarioEntidades();

            if (count($usuariosEntidade)) {
                $cgmRepo = $em->getRepository(SwCgm::class);
                foreach ($usuariosEntidade as $usuario) {
                    $usuarioCgm = $cgmRepo->find($usuario->getNumcgm());
                    $usuariosEntidadeLista[strtoupper(trim($usuarioCgm->getNumcgm() . ' - ' . trim($usuarioCgm->getNomCgm())))] = $usuarioCgm->getNumcgm();
                }
            }
        }

        $file = "";
        if ($this->id($this->getSubject())) {
            if (!empty($this->getSubject()->getFkOrcamentoEntidadeLogotipo())) {
                $file = '<a href="'.$this->generateUrl('logotipo', ['_id' => $this->getSubject()->getFkOrcamentoEntidadeLogotipo()->getLogotipo()]).
                    '" target="_blank" >'.$this->getSubject()->getFkOrcamentoEntidadeLogotipo()->getLogotipo(). '</a>'
                ;
            }
        }

        $fieldOptions['numcgm'] = [
            'label' => 'entidade',
            'class' => SwCgmPessoaJuridica::class,
            'req_params' => array(),
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
            'mapped' => false,
            'required' => true,
            'data' => $isEdit ? $entidade->getFkSwCgm()->getFkSwCgmPessoaJuridica() : null
        ];

        $fieldOptions['responsavel'] = [
            'class' => SwCgmPessoaFisica::class,
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
            'label' => 'Responsável',
            'required' => true,
            'mapped' => false,
            'data' => $isEdit ? $entidade->getFkSwCgmPessoaFisica() : null,
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
            'label' => 'label.responsavelTecnico',
            'required' => true,
            'mapped' => false,
            'data' => !$isEdit ? null : $entidade->getFkEconomicoResponsavelTecnico(),
        ];

        $fieldOptions['usuarioEntidade'] = [
            'class' => UsuarioEntidade::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $er, $term, Request $request) {
                $qb = $er->createQueryBuilder('o');
                $qb->where('o.codEntidade = :codEntidade');
                $qb->andWhere('o.exercicio = :exercicio');
                $qb->andWhere('o.numcgm = :numcgm');
                $qb->setParameter('numcgm', (int) $term);
                $qb->setParameter('codEntidade', $this->getEntidade()->getCodEntidade());
                $qb->setParameter('exercicio', $this->getExercicio());
                $qb->orderBy('o.numcgm', ' ASC');
                return $qb;
            },
            'json_choice_label' => function (UsuarioEntidade $usuarioEntidade) {
                return (string) sprintf('%s - %s', $usuarioEntidade->getNumcgm(), $usuarioEntidade->getFkAdministracaoUsuario()->getFkSwCgm()->getNomCgm());
            },
            'label' => 'label.orcamentoInstitucional.usuarioDaEntidade',
            'required' => true,
            'mapped' => false,
        ];

        $formMapper
            ->with('label.orcamento.classificacaoInstitucional.dados')
            ->add(
                'numcgm',
                'autocomplete',
                $fieldOptions['numcgm']
            )
            ->add(
                'codResponsavel',
                'autocomplete',
                $fieldOptions['responsavel']
            )
            ->add(
                'responsavelTecnico',
                'autocomplete',
                $fieldOptions['responsavelTecnico']
            )
            ->add(
                'foto',
                'file',
                [
                    'mapped' => false,
                    'label' => 'label.logotipo',
                    'required' => false,
                    'help' => $file,
                    'constraints' => [
                        new Assert\File([
                            'mimeTypes' => ['image/jpeg', 'image/pjpeg'],
                            'mimeTypesMessage' => 'Somente arquivo JPEG'
                        ])
                    ]
                ]
            )
            ->add(
                'codUsuario',
                'choice',
                [
                    'mapped' => false,
                    'label'=> 'label.orcamentoInstitucional.usuarioDaEntidade',
                    'multiple' => true,
                    'data' => $usuariosEntidadeLista,
                    'choices' => $usuariosDisponiveisList,
                    'attr' => [
                        'class' => 'select2-parameters '
                    ],
                ],
                [
                    'placeholder' => 'label.selecione',
                ]
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('exercicio')
            ->add('codRespTecnico')
            ->add('codProfissao')
            ->add('sequencia')
        ;
    }

    public function prePersist($object)
    {
        try {
            $this->saveEntidade();
        } catch (\Exception $e) {
            $this
                ->getFlashBag()
                ->add('error', $e->getMessage());

            return $this->redirectByRoute(
                $this->baseRouteName . '_create'
            );
        }
    }

    public function preUpdate($object)
    {
        $id = $this->getAdminRequestId();
        try {
            $this->saveEntidade();
            return $this->redirectByRoute(
                $this->baseRouteName.'_list'
            );
        } catch (\Exception $e) {
            $this
                ->getFlashBag()
                ->add('error', $e->getMessage());

            return $this->redirectByRoute(
                $this->baseRouteName . '_edit',
                ['id' => $id]
            );
        }
    }

    private function saveEntidade()
    {
        $em = $this->getDoctrine();
        $entidadeRepository = $em->getRepository(Entidade::class);

        $data = $this
            ->getRequest()
            ->request
            ->all();

        $formData = $data[$this->getUniqid()];

        $swcgmResponsavel = $em
            ->getRepository(SwCgmPessoaFisica::class)
            ->find((int) $formData['codResponsavel']);

        $codResponsavelTecnico = explode("~", $formData['responsavelTecnico']);
        $responsavelTecnico = $em
            ->getRepository(ResponsavelTecnico::class)
            ->findOneBy(['numcgm' => (int) reset($codResponsavelTecnico)]);

        $swCgm = $em
            ->getRepository(SwCgm::class)
            ->find((int) $formData['numcgm']);

        $entidade = $this->getSubject();
        $findEntidade = $this->getDoctrine()->getRepository(Entidade::class)->findOneBy(['exercicio'=> $this->getExercicio(), 'codEntidade' => $entidade->getCodEntidade()]);

        if (empty($findEntidade)) {
            $entidade
                ->setFkSwCgm($swCgm)
                ->setFkSwCgmPessoaFisica($swcgmResponsavel)
                ->setFkEconomicoResponsavelTecnico($responsavelTecnico)
                ->setCodRespTecnico($responsavelTecnico->getNumCgm())
                ->setCodProfissao($responsavelTecnico->getCodProfissao())
                ->setExercicio($this->getExercicio());

            if (null === $entidade->getCodEntidade()) {
                $entidade->setCodEntidade($entidadeRepository->getNextEntidadeCod());
            }
            $em->persist($entidade);
        } else {
            $findEntidade
                ->setFkSwCgm($swCgm)
                ->setFkSwCgmPessoaFisica($swcgmResponsavel)
                ->setFkEconomicoResponsavelTecnico($responsavelTecnico)
                ->setCodRespTecnico($responsavelTecnico->getNumCgm())
                ->setCodProfissao($responsavelTecnico->getCodProfissao());
            $em->persist($entidade);
        }

        // Salvar usuarios
        $this->saveUsuariosEntidade($formData, $entidade);

        // Upload fotos
        $foto = $this
            ->getForm()
            ->get('foto')
            ->getData();

        if ($foto) {
            $this->uploadFoto($foto, $formData, $entidade);
        }

        $em->flush();
        return $entidade;
    }

    private function uploadFoto($foto, $formData, $entidade)
    {
        if (!$foto) {
            return;
        }
        try {
            $upload = new UploadHelper();

            $uploadParameters = $this
                ->getContainer()
                ->getParameter('financeirobundle');

            $upload
                ->setPath($uploadParameters['institucionalPath'])
                ->setFile($foto)
            ;

            $fullFileName = $upload->executeUpload(
                (int) $formData['numcgm'] . uniqid()
            );

            if (!empty($entidade->getFkOrcamentoEntidadeLogotipo())) {
                if ($entidade->getExercicio() != $this->getExercicio()) {
                    $this->saveLogotipo($entidade, $fullFileName);
                } else {
                    $entidade->getFkOrcamentoEntidadeLogotipo()->setLogotipo($fullFileName['name']);
                }
            } else {
                $this->saveLogotipo($entidade, $fullFileName);
            }
        } catch (\Exception $e) {
            throw new \Exception($this->getContainer()->get('translator')->transChoice('label.orcamentoInstitucional.errorUploadFile', 0, [], 'messages'));
        }
    }

    /**
     * @param $entidade
     * @param $fullFileName
     */
    private function saveLogotipo($entidade, $fullFileName)
    {
        $entidadeLogotipo = new EntidadeLogotipo();

        $entidadeLogotipo
            ->setFkOrcamentoEntidade($entidade)
            ->setExercicio($this->getExercicio())
            ->setLogotipo($fullFileName['name']);
        $entidade->setFkOrcamentoEntidadeLogotipo($entidadeLogotipo);
    }


    private function saveUsuariosEntidade($formData, Entidade $entidade)
    {
        $em = $this->getDoctrine();

        $em->getRepository(Entidade::class)
            ->removeUsuariosEntidade(
                $entidade->getCodEntidade(),
                $entidade->getExercicio()
            );

        foreach ($formData['codUsuario'] as $codUsuario) {
            $usuario = new UsuarioEntidade();
            $usuario
                ->setExercicio($this->getExercicio())
                ->setCodEntidade($entidade->getCodEntidade())
                ->setNumcgm($codUsuario);

            $em->persist($usuario);
        }
        $em->flush();
    }
}
