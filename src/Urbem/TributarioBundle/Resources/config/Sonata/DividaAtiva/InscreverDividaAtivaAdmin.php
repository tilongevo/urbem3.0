<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\DividaAtiva;

use DateTime;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito;
use Urbem\CoreBundle\Entity\Divida\Modalidade;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Imobiliario\Lote;
use Urbem\CoreBundle\Entity\Monetario\Credito;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Model\Divida\InscreverDividaAtivaModel;
use Urbem\CoreBundle\Repository\Tributario\DividaAtiva\InscreverDividaAtivaRepository;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class InscreverDividaAtivaAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_divida_ativa_inscrever_divida_ativa';
    protected $baseRoutePattern = 'tributario/divida-ativa/inscrever-divida-ativa';
    protected $legendButtonSave = ['icon' => 'search', 'text' => 'Pesquisar'];

    /**
    * @return array
    */
    public function getIncludeJs()
    {
        $includeJs = [
            '/tributario/javascripts/dividaAtiva/inscricao-divida-ativa/inscrever-divida-ativa.js',
        ];

        if ($this->isCurrentRoute('detalhe')) {
            $includeJs[] = '/core/javascripts/sw-processo.js';
        }

        return $includeJs;
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $request = $this->getRequest();

        $redirectUrl = $this->generateObjectUrl('detalhe', $object, ['uniqid' => $request->get('uniqid')]);

        (new RedirectResponse($redirectUrl, RedirectResponse::HTTP_TEMPORARY_REDIRECT))->send();
    }

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add('detalhe', 'detalhe');
        $routes->add('inscrever', 'inscrever');

        $routes->clearExcept(['create', 'detalhe', 'inscrever']);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb();

        $fieldOptions = [];
        $fieldOptions['grupoCredito'] = [
            'class' => GrupoCredito::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->andWhere('(o.anoExercicio = :anoExercicio OR LOWER(o.descricao) LIKE :descricao)');
                $qb->setParameter('anoExercicio', (int) $term);
                $qb->setParameter('descricao', sprintf('%%%s%%', strtolower($term)));

                $qb->addOrderBy('o.anoExercicio', 'ASC');
                $qb->addOrderBy('o.descricao', 'ASC');

                return $qb;
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.dividaAtivaInscreverDividaAtiva.grupoCredito',
        ];

        $fieldOptions['credito'] = [
            'class' => Credito::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                if ($request->get('codGrupoCredito')) {
                    $qb->join('o.fkArrecadacaoCreditoGrupos', 'cg');
                    $qb->join('cg.fkArrecadacaoGrupoCredito', 'gc');

                    list($codGrupo, $anoExercicio) = explode('~', $request->get('codGrupoCredito'));
                    $qb->andWhere('gc.codGrupo = :codGrupo');
                    $qb->setParameter('codGrupo', $codGrupo);

                    $qb->andWhere('gc.anoExercicio = :anoExercicio');
                    $qb->setParameter('anoExercicio', $anoExercicio);
                }

                $qb->andWhere('LOWER(o.descricaoCredito) LIKE :descricaoCredito');
                $qb->setParameter('descricaoCredito', sprintf('%%%s%%', strtolower($term)));

                $qb->addOrderBy('o.descricaoCredito', 'ASC');

                return $qb;
            },
            'required' => false,
            'req_params' => [
                'codGrupoCredito' => 'varJsCodGrupoCredito',
            ],
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.dividaAtivaInscreverDividaAtiva.credito',
        ];

        $fieldOptions['exercicio'] = [
            'mapped' => false,
            'required' => false,
            'label' => 'label.dividaAtivaInscreverDividaAtiva.exercicio',
        ];

        $fieldOptions['cgmInicial'] = [
            'class' => SwCgm::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->andWhere('(o.numcgm = :numcgm OR LOWER(o.nomCgm) LIKE :nomCgm)');
                $qb->setParameter('numcgm', (int) $term);
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));

                $qb->orderBy('o.numcgm', 'ASC');

                return $qb;
            },
            'required' => false,
            'req_params' => [
                'filtro' => 1,
            ],
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.dividaAtivaInscreverDividaAtiva.cgmInicial',
        ];

        $fieldOptions['cgmFinal'] = [
            'class' => SwCgm::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->andWhere('(o.numcgm = :numcgm OR LOWER(o.nomCgm) LIKE :nomCgm)');
                $qb->setParameter('numcgm', (int) $term);
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));

                $qb->orderBy('o.numcgm', 'ASC');

                return $qb;
            },
            'required' => false,
            'req_params' => [
                'filtro' => 1,
            ],
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.dividaAtivaInscreverDividaAtiva.cgmFinal',
        ];

        $fieldOptions['cadastroEconomicoInicial'] = [
            'class' => CadastroEconomico::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->leftJoin('o.fkEconomicoCadastroEconomicoAutonomo', 'cea');
                $qb->leftJoin('o.fkEconomicoCadastroEconomicoEmpresaFato', 'ceef');
                $qb->leftJoin('o.fkEconomicoCadastroEconomicoEmpresaDireito', 'ceed');
                $qb->join(Swcgm::class, 'cgm', 'WITH', 'COALESCE(cea.numcgm, ceef.numcgm, ceed.numcgm) = cgm.numcgm');

                $qb->andWhere('(o.inscricaoEconomica = :inscricaoEconomica OR cgm.numcgm = :numcgm OR LOWER(cgm.nomCgm) LIKE :nomCgm)');
                $qb->setParameter('inscricaoEconomica', (int) $term);
                $qb->setParameter('numcgm', (int) $term);
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));

                $qb->orderBy('cgm.numcgm', 'ASC');

                return $qb;
            },
            'required' => false,
            'req_params' => [
                'filtro' => 1,
            ],
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.dividaAtivaInscreverDividaAtiva.cadastroEconomicoInicial',
        ];

        $fieldOptions['cadastroEconomicoFinal'] = [
            'class' => CadastroEconomico::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->leftJoin('o.fkEconomicoCadastroEconomicoAutonomo', 'cea');
                $qb->leftJoin('o.fkEconomicoCadastroEconomicoEmpresaFato', 'ceef');
                $qb->leftJoin('o.fkEconomicoCadastroEconomicoEmpresaDireito', 'ceed');
                $qb->join(Swcgm::class, 'cgm', 'WITH', 'COALESCE(cea.numcgm, ceef.numcgm, ceed.numcgm) = cgm.numcgm');

                $qb->andWhere('(o.inscricaoEconomica = :inscricaoEconomica OR cgm.numcgm = :numcgm OR LOWER(cgm.nomCgm) LIKE :nomCgm)');
                $qb->setParameter('inscricaoEconomica', (int) $term);
                $qb->setParameter('numcgm', (int) $term);
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));

                $qb->orderBy('cgm.numcgm', 'ASC');

                return $qb;
            },
            'required' => false,
            'req_params' => [
                'filtro' => 1,
            ],
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.dividaAtivaInscreverDividaAtiva.cadastroEconomicoFinal',
        ];

        $fieldOptions['inscricaoMunicipalInicial'] = [
            'class' => Lote::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->join('o.fkImobiliarioImovelLotes', 'il');

                $qb->where('o.codLote >= :codLote');
                $qb->setParameter('codLote', (int) $term);

                $qb->orderBy('o.codLote', 'ASC');

                return $qb;
            },
            'json_choice_value' => function (Lote $lote) {
                return (int) $lote->getFkImobiliarioImovelLotes()->last()->getInscricaoMunicipal();
            },
            'required' => false,
            'req_params' => [
                'filtro' => 1,
            ],
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.dividaAtivaInscreverDividaAtiva.loteInicial',
        ];

        $fieldOptions['inscricaoMunicipalFinal'] = [
            'class' => Lote::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->join('o.fkImobiliarioImovelLotes', 'il');

                $qb->where('o.codLote >= :codLote');
                $qb->setParameter('codLote', (int) $term);

                $qb->orderBy('o.codLote', 'ASC');

                return $qb;
            },
            'json_choice_value' => function (Lote $lote) {
                return (int) $lote->getFkImobiliarioImovelLotes()->last()->getInscricaoMunicipal();
            },
            'required' => false,
            'req_params' => [
                'filtro' => 1,
            ],
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.dividaAtivaInscreverDividaAtiva.loteFinal',
        ];

        $fieldOptions['periodoInicial'] = [
            'mapped' => false,
            'pk_class' => DatePK::class,
            'format' => 'dd/MM/yyyy',
            'required' => false,
            'label' => 'label.dividaAtivaInscreverDividaAtiva.periodoInicial',
        ];

        $fieldOptions['periodoFinal'] = [
            'mapped' => false,
            'pk_class' => DatePK::class,
            'format' => 'dd/MM/yyyy',
            'required' => false,
            'label' => 'label.dividaAtivaInscreverDividaAtiva.periodoFinal',
        ];

        $fieldOptions['valorInicial'] = [
            'mapped' => false,
            'required' => false,
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money '
            ],
            'label' => 'label.dividaAtivaInscreverDividaAtiva.valorInicial'
        ];

        $fieldOptions['valorFinal'] = [
            'mapped' => false,
            'required' => false,
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money '
            ],
            'label' => 'label.dividaAtivaInscreverDividaAtiva.valorFinal'
        ];

        $fieldOptions['modalidade'] = [
            'class' => Modalidade::class,
            'mapped' => false,
            'placeholder' => 'Selecione',
            'attr' => [
                'class' => 'select2-parameters ',
            ],
            'label' => 'label.dividaAtivaInscreverDividaAtiva.modalidade',
        ];

        $fieldOptions['dtInscricao'] = [
            'mapped' => false,
            'pk_class' => DatePK::class,
            'dp_default_date' => (new DateTime())->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'label' => 'label.dividaAtivaInscreverDividaAtiva.dtInscricao',
        ];

        $formMapper
            ->with('label.dividaAtivaInscreverDividaAtiva.cabecalhoFiltro')
                ->add('grupoCredito', 'autocomplete', $fieldOptions['grupoCredito'])
                ->add('credito', 'autocomplete', $fieldOptions['credito'])
                ->add('exercicio', 'text', $fieldOptions['exercicio'])
                ->add(
                    'cgmInicial',
                    'autocomplete',
                    $fieldOptions['cgmInicial'],
                    [
                        'admin_code' => 'core.admin.filter.sw_cgm',
                    ]
                )
                ->add(
                    'cgmFinal',
                    'autocomplete',
                    $fieldOptions['cgmFinal'],
                    [
                        'admin_code' => 'core.admin.filter.sw_cgm',
                    ]
                )
                ->add(
                    'cadastroEconomicoInicial',
                    'autocomplete',
                    $fieldOptions['cadastroEconomicoInicial'],
                    [
                        'admin_code' => 'tributario.admin.economico_cadastro_economico_empresa_fato',
                    ]
                )
                ->add(
                    'cadastroEconomicoFinal',
                    'autocomplete',
                    $fieldOptions['cadastroEconomicoFinal'],
                    [
                        'admin_code' => 'tributario.admin.economico_cadastro_economico_empresa_fato',
                    ]
                )
                ->add(
                    'inscricaoMunicipalInicial',
                    'autocomplete',
                    $fieldOptions['inscricaoMunicipalInicial'],
                    [
                        'admin_code' => 'tributario.admin.lote',
                    ]
                )
                ->add(
                    'inscricaoMunicipalFinal',
                    'autocomplete',
                    $fieldOptions['inscricaoMunicipalFinal'],
                    [
                        'admin_code' => 'tributario.admin.lote',
                    ]
                )
                ->add('periodoInicial', 'datepkpicker', $fieldOptions['periodoInicial'])
                ->add('periodoFinal', 'datepkpicker', $fieldOptions['periodoFinal'])
                ->add('valorInicial', 'money', $fieldOptions['valorInicial'])
                ->add('valorFinal', 'money', $fieldOptions['valorFinal'])
            ->end()
            ->with('label.dividaAtivaInscreverDividaAtiva.cabecalhoInscricao')
                ->add('modalidade', 'entity', $fieldOptions['modalidade'])
                ->add('dtInscricao', 'datepkpicker', $fieldOptions['dtInscricao'])
            ->end();
    }

    /**
    * @param array $filtro
    * @return bool|array
    */
    public function inscreverDividaAtiva(array $filtro = [])
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $repository = new InscreverDividaAtivaRepository($em);
        $model = new InscreverDividaAtivaModel($em);

        $livro = $repository->fetchLivro();
        $modalidades = $repository->fetchModalidades($filtro['modalidade']);

        if (empty($livro)) {
            return false;
        }

        if (empty($filtro['dividas'])) {
            return [];
        }

        if (empty($filtro['exercicio'])) {
            $filtro['exercicio'] = $this->getExercicio();
        }

        $dividas = [];
        foreach ($filtro['dividas'] as $divida) {
            if (empty($divida['inscrever'])) {
                continue;
            }

            $dividas[] = json_decode($divida['row'], true);
        }

        $dividasAtivas = [];
        foreach ($dividas as $divida) {
            array_merge($dividasAtivas, $model->inscreverDividaAtiva($divida, $livro, $modalidades, $filtro));
        }

        return $dividasAtivas;
    }

    /**
    * @param array $dividasAtivas
    */
    public function emitirDocumentos(array $dividasAtivas = [])
    {
        $em = $this->modelManager->getEntityManager($this->getClass());
        $model = new InscreverDividaAtivaModel($em);

        foreach ($dividasAtivas as $dividaAtiva) {
            $model->emitirDocumentos($dividaAtiva);
        }
    }
}
