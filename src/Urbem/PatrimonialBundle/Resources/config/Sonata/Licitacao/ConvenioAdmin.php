<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao;

use Doctrine\ORM\EntityRepository;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Entity\Licitacao\Convenio;
use Urbem\CoreBundle\Entity\Normas;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Normas\NormaModel;
use Urbem\CoreBundle\Model\Patrimonial\Licitacao\ConvenioModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

/**
 * Class ConvenioAdmin
 * @package Urbem\PatrimonialBundle\Resources\config\Sonata\Licitacao
 */
class ConvenioAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_licitacao_convenio';
    protected $baseRoutePattern = 'patrimonial/licitacao/convenio';
    protected $includeJs = [
        '/patrimonial/javascripts/licitacao/convenio.js',
    ];

    protected $exibirBotaoExcluir = false;

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        $collection->add('gerar_relatorio', '{id}/gerar_relatorio');
    }


    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        $exercicio = $this->getExercicio();

        $query = parent::createQuery($context);
        if (!$this->getRequest()->query->get('filter')) {
            $query->andWhere("{$query->getRootAliases()[0]}.exercicio = :exercicio")->setParameters(['exercicio' => $exercicio]);
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $exercicio = $this->getExercicio();
        $configuracaoModel = new ConfiguracaoModel($entityManager);
        $codUf = $configuracaoModel->pegaConfiguracao('cod_uf', $configuracaoModel::MODULO_ADMINISTRACAO, $exercicio);

        $datagridMapper
            ->add('numConvenio', null, ['label' => 'label.convenioAdmin.numConvenio'])
            ->add(
                'exercicio',
                null,
                [
                    'label' => 'label.convenioAdmin.exercicio',
                    'data' => $exercicio
                ]
            )
            ->add('fkLicitacaoTipoConvenio', 'composite_filter', ['label' => 'label.convenioAdmin.codTipoConvenio'], null, [
                'choice_label' => 'descricao',
                'class' => 'CoreBundle:Licitacao\TipoConvenio',
                'query_builder' => function (EntityRepository $entityRepository) use ($codUf) {
                    $qb = $entityRepository->createQueryBuilder('o')
                        ->andWhere("o.codUfTipoConvenio = :codUf")
                        ->setParameter(":codUf", $codUf);
                    return $qb;
                }
            ])
            ->add('fkComprasObjeto', null, ['label' => 'label.convenioAdmin.codObjeto'], null, [
                'choice_label' => 'descricao',
                'query_builder' => function (EntityRepository $entityRepository) use ($exercicio) {
                    $queryBuilder = $entityRepository->createQueryBuilder('objeto');
                    $queryBuilder
                        ->join('objeto.fkLicitacaoConvenios', 'fkLicitacaoConvenios')
                        ->andWhere('fkLicitacaoConvenios.exercicio = :exercicio')
                        ->setParameter('exercicio', $exercicio);

                    return $queryBuilder;
                }
            ])
            ->add(
                'valor',
                null
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $this->setBreadCrumb();

        $listMapper
            ->add('numConvenio', 'string', [
                'label' => 'label.convenioAdmin.numConvenio',
                'template' => 'PatrimonialBundle:Sonata/Licitacao/Convenio/CRUD:list__numConvenio.html.twig'
            ])
            ->add('fkLicitacaoTipoConvenio.descricao', null, ['label' => 'label.convenioAdmin.codTipoConvenio'])
            ->add('fkComprasObjeto.descricao', null, ['label' => 'label.convenioAdmin.codObjeto'])
            ->add('valor', 'currency', [
                'label' => 'label.convenioAdmin.valor',
                'currency' => 'R$ '
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => ['template' => 'CoreBundle:Sonata/CRUD:list__action_show.html.twig'],
                    'anulacao' => ['template' => 'PatrimonialBundle:Sonata/Licitacao/Convenio/CRUD:list__action_anular.html.twig'],
                ]
            ]);
    }

    /**
     * @param Convenio $convenio
     */
    public function getTotais(Convenio $convenio)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $convenioModel = new ConvenioModel($entityManager);

        $convenio->totais = $convenioModel->getValorEPercentualConvenioDisponivel($convenio);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $id = $this->getAdminRequestId();

        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $normalModel = new NormaModel($entityManager);

        $defaultFormMapperOptionsDate = [
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => true
        ];

        $formMapperOptions = [];
        $formMapperOptions['numConvenio'] = [
            'label' => 'label.convenioAdmin.numConvenio'
        ];
        $formMapperOptions['exercicio'] = [
            'data' => $this->getExercicio()
        ];
        $exercicio = $this->getExercicio();
        $configuracaoModel = new ConfiguracaoModel($entityManager);
        $codUf = $configuracaoModel->pegaConfiguracao('cod_uf', $configuracaoModel::MODULO_ADMINISTRACAO, $exercicio);
        $formMapperOptions['fkLicitacaoTipoConvenio'] = [
            'attr' => ['class' => 'select2-parameters '],
            'choice_label' => 'descricao',
            'label' => 'label.convenioAdmin.codTipoConvenio',
            'query_builder' => function (EntityRepository $entityRepository) use ($codUf) {
                $qb = $entityRepository->createQueryBuilder('o')
                    ->andWhere("o.codUfTipoConvenio = :codUf")
                    ->setParameter(":codUf", $codUf);
                return $qb;
            },
            'placeholder' => 'label.selecione',
            'required' => true
        ];
        $formMapperOptions['fkComprasObjeto'] = [
            'label' => 'label.convenioAdmin.codObjeto',
            'property' => 'descricao',
            'to_string_callback' => function (Compras\Objeto $objeto, $property) {
                return strtoupper($objeto->getDescricao());
            },
            'placeholder' => 'Selecione',
            'container_css_class' => 'select2-v4-parameters ',
        ];

        $formMapperOptions['dtAssinatura'] = $defaultFormMapperOptionsDate;
        $formMapperOptions['dtAssinatura']['label'] = 'label.convenioAdmin.dtAssinatura';

        $formMapperOptions['inicioExecucao'] = $defaultFormMapperOptionsDate;
        $formMapperOptions['inicioExecucao']['label'] = 'label.convenioAdmin.inicioExecucao';

        $formMapperOptions['dtVigencia'] = $defaultFormMapperOptionsDate;
        $formMapperOptions['dtVigencia']['label'] = 'label.convenioAdmin.dtVigencia';

        $formMapperOptions['valor'] = [
            'attr' => [
                'class' => 'money '
            ],
            'currency' => 'BRL',
            'label' => 'label.convenioAdmin.valor'
        ];

        $formMapperOptions['observacao'] = [
            'label' => 'label.convenioAdmin.observacao'
        ];

        $formMapperOptions['fkNormasNorma'] = [
            'attr' => ['class' => 'select2-parameters '],
            'choice_label' => function (Normas\Norma $norma) use ($entityManager) {
                $normalModel = new NormaModel($entityManager);

                return strtoupper($normalModel->getFormattedNormaString($norma));
            },
            'label' => 'label.convenioAdmin.fundamentacao',
            'placeholder' => 'label.selecione',
            'query_builder' => $normalModel->getCustomNormasComTipos($this->getExercicio()),
            'required' => true
        ];

        $formMapperOptions['fkSwCgm'] = [
            'label' => 'label.convenioAdmin.cgmResponsavel',
            'class' => SwCgm::class,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function (EntityRepository $repository, $term, Request $request) {
                $queryBuilder = $repository->createQueryBuilder('swCgm');
                $queryBuilder
                    ->join('swCgm.fkSwCgmPessoaFisica', 'fkSwCgmPessoaFisica');
                if (!is_numeric($term)) {
                    $queryBuilder->where(
                        $queryBuilder->expr()->like(
                            $queryBuilder->expr()->lower('swCgm.nomCgm'),
                            $queryBuilder->expr()->lower(':term')
                        )
                    )
                        ->setParameter('term', '%'.$term.'%');
                } else {
                    $term = (int) $term;
                    $queryBuilder
                        ->where('swCgm.numcgm = :term')
                        ->setParameter('term', $term);
                }

                $queryBuilder->orderBy('swCgm.nomCgm');
                return $queryBuilder;
            }
        ];

        if (!is_null($id)) {
            $formMapperOptions['numConvenio']['disabled'] = true;
            $formMapperOptions['exercicio']['disabled'] = true;
            $formMapperOptions['fkLicitacaoTipoConvenio']['disabled'] = true;
            $formMapperOptions['fkComprasObjeto']['disabled'] = true;
            $formMapperOptions['dtAssinatura']['disabled'] = true;
            $formMapperOptions['inicioExecucao']['disabled'] = true;
            $formMapperOptions['dtVigencia']['disabled'] = true;
            $formMapperOptions['valor']['disabled'] = true;
        }

        $formMapper
            ->with('Dados do Convênio')
            ->add('numConvenio', null, $formMapperOptions['numConvenio'])
            ->add('exercicio', 'hidden', $formMapperOptions['exercicio'])
            ->add('fkLicitacaoTipoConvenio', null, $formMapperOptions['fkLicitacaoTipoConvenio'])
            ->add('fkComprasObjeto', 'sonata_type_model_autocomplete', $formMapperOptions['fkComprasObjeto'])
            ->add('dtAssinatura', 'sonata_type_date_picker', $formMapperOptions['dtAssinatura'])
            ->add('inicioExecucao', 'sonata_type_date_picker', $formMapperOptions['inicioExecucao'])
            ->add('dtVigencia', 'sonata_type_date_picker', $formMapperOptions['dtVigencia'])
            ->add('valor', 'money', $formMapperOptions['valor'])
//                ->add('fundamentacao', 'choice', $formMapperOptions['fundamentacao'])
            ->add('fkNormasNorma', null, $formMapperOptions['fkNormasNorma'])
            ->add('fkSwCgm', 'autocomplete', $formMapperOptions['fkSwCgm'], ['admin_code' => 'core.admin.filter.sw_cgm'])
            ->add('observacao', null, $formMapperOptions['observacao'])
            ->end();
    }

    /**
     * @param Convenio $convenio
     */
    public function preValidate($convenio)
    {
        $container = $this->getConfigurationPool()->getContainer();

        $entityManager = $this->modelManager->getEntityManager($this->getClass());
        $normaPesquisada = $entityManager->getRepository(Convenio::class)
            ->findBy([
                'numConvenio' => $convenio->getNumConvenio(),
                'exercicio' => $convenio->getExercicio(),
            ]);

        $routeEditPattern = '/\/edit\?uniqid\=/';
        $route = $this->getRequest()->getUri();

        // Valida se nao e uma rota de ediçao.
        if (!preg_match($routeEditPattern, $route)) {
            if (is_null($normaPesquisada) == true || count($normaPesquisada) > 0) {
                $message = $this->trans('convenio.exists', [
                    '%exercicio%' => $convenio->getExercicio(),
                    '%numConvenio%' => $convenio->getNumConvenio(),
                ], 'validators');

                $container
                    ->get('session')
                    ->getFlashBag()
                    ->add('error', $message);

                (new RedirectResponse($this->request->headers->get('referer')))->send();
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        /** @var Convenio $convenio */
        $convenio = $this->getSubject();

        $this->getTotais($convenio);
    }

    /**
     * @param Convenio $convenio
     */
    public function prePersist($convenio)
    {
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $normaModel = new NormaModel($entityManager);

        $convenio->setFundamentacao(
            $normaModel->getFormattedNormaString(
                $convenio->getFkNormasNorma()
            )
        );
    }

    /**
     * @param Convenio $convenio
     */
    public function postPersist($convenio)
    {
        $this->forceRedirect("/patrimonial/licitacao/convenio/{$this->getObjectKey($convenio)}/show");
    }

    /**
     * @param Convenio $convenio
     */
    public function preUpdate($convenio)
    {
        $entityManager = $this->getModelManager()->getEntityManager($this->getClass());
        $normaModel = new NormaModel($entityManager);

        $convenio->setFundamentacao(
            $normaModel->getFormattedNormaString(
                $convenio->getFkNormasNorma()
            )
        );
    }

    /**
     * @param Convenio $convenio
     */
    public function postUpdate($convenio)
    {
        $this->forceRedirect("/patrimonial/licitacao/convenio/{$this->getObjectKey($convenio)}/show");
    }
}
