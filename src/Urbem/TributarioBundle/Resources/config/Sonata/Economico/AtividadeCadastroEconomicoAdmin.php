<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use DateTime;
use Exception;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\DiasSemana;
use Urbem\CoreBundle\Entity\Economico\Atividade;
use Urbem\CoreBundle\Entity\Economico\AtividadeCadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\DiasCadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\ProcessoAtividadeCadEcon;
use Urbem\CoreBundle\Entity\Economico\ProcessoDiasCadEcon;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class AtividadeCadastroEconomicoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_atividade_cadastro_economico';
    protected $baseRoutePattern = 'tributario/cadastro-economico/inscricao-economica/definir-atividades';
    protected $includeJs = ['/tributario/javascripts/economico/atividade-cadastro-economico.js'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add(
            'definir',
            sprintf(
                '%s',
                $this->getRouterIdParameter()
            )
        );

        $routes->clearExcept(['edit', 'definir']);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $this->populateObject($object);
        $this->saveObject($object, 'label.economicoAtividadeCadastroEconomico.msgSucesso');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager($this->getClass());

        $cadastroEconomico = $this->getSubject() ?: new CadastroEconomico();

        $fieldOptions = [];
        $fieldOptions['fkSwClassificacao'] = array(
            'class' => SwClassificacao::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                return $em->createQueryBuilder('o')
                    ->orderBy('o.codClassificacao', 'ASC');
            },
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters js-select-processo-classificacao'
            ),
            'label' => 'label.economicoCadastroEconomico.processoClassificacao',
        );

        $fieldOptions['fkSwAssunto'] = array(
            'class' => SwAssunto::class,
            'mapped' => false,
            'query_builder' => function ($em) {
                return $em->createQueryBuilder('o')
                    ->orderBy('o.codAssunto', 'ASC');
            },
            'choice_value' => 'codAssunto',
            'required' => false,
            'placeholder' => 'label.selecione',
            'attr' => array(
                'class' => 'select2-parameters js-select-processo-assunto'
            ),
            'label' => 'label.economicoCadastroEconomico.processoAssunto',
        );

        $fieldOptions['fkSwProcesso'] = [
            'class' => SwProcesso::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');
                $qb->innerJoin('o.fkAdministracaoUsuario', 'u');
                $qb->innerJoin('u.fkSwCgm', 'cgm');
                if ($request->get('codClassificacao') != '') {
                    $qb->andWhere('o.codClassificacao = :codClassificacao');
                    $qb->setParameter('codClassificacao', (int) $request->get('codClassificacao'));
                }
                if ($request->get('codAssunto') != '') {
                    $qb->andWhere('o.codAssunto = :codAssunto');
                    $qb->setParameter('codAssunto', (int) $request->get('codAssunto'));
                }
                $qb->andWhere($qb->expr()->orX(
                    $qb->expr()->eq('o.codProcesso', ':codProcesso'),
                    $qb->expr()->eq('cgm.numcgm', ':numCgm'),
                    $qb->expr()->like('LOWER(cgm.nomCgm)', $qb->expr()->literal('%' . strtolower($term) . '%'))
                ));
                $qb->setParameter('numCgm', (int) $term);
                $qb->setParameter('codProcesso', (int) $term);
                $qb->orderBy('o.codProcesso', 'ASC');
                return $qb;
            },
            'required' => false,
            'req_params' => [
                'inscricaoEconomica' => 'varJsInscricaoEconomica',
                'codClassificacao' => 'varJsCodClassificacao',
                'codAssunto' => 'varJsCodAssunto',
            ],
            'attr' => [
                'class' => 'select2-parameters js-processo',
            ],
            'label' => 'label.economicoCadastroEconomico.processo',
        ];

        $fieldOptions['atividade'] = [
            'class' => Atividade::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->andWhere('LOWER(o.codEstrutural) LIKE :term');
                $qb->orWhere('LOWER(o.nomAtividade) LIKE :term');
                $qb->setParameter('term', sprintf('%%%s%%', $term));

                $qb->addOrderBy('o.codEstrutural', 'ASC');
                $qb->addOrderBy('o.nomAtividade', 'ASC');

                return $qb;
            },
            'json_choice_label' => function (Atividade $atividade) {
                return (string) sprintf('%s - %s', $atividade->getCodEstrutural(), $atividade->getNomAtividade());
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters',
            ],
            'label' => 'label.economicoAtividadeCadastroEconomico.atividade',
        ];

        $fieldOptions['atividadePrincipal'] = [
            'mapped' => false,
            'choices' => [
                'Sim' => 1,
                'Não' => 0,
            ],
            'expanded' => true,
            'multiple' => false,
            'required' => true,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata',
            ],
            'label' => 'label.economicoAtividadeCadastroEconomico.atividadePrincipal',
        ];

        $fieldOptions['dtInicio'] = [
            'mapped' => false,
            'required' => false,
            'pk_class' => DatePK::class,
            'dp_default_date' => (new DateTime())->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'attr' => [
                'class' => 'js-date-dt-inicio '
            ],
            'label' => 'label.economicoAtividadeCadastroEconomico.dtInicio',
        ];

        $fieldOptions['dtTermino'] = [
            'mapped' => false,
            'required' => false,
            'pk_class' => DatePK::class,
            'dp_default_date' => (new DateTime())->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'attr' => [
                'class' => 'js-date-dt-termino '
            ],
            'label' => 'label.economicoAtividadeCadastroEconomico.dtTermino',
        ];

        $fieldOptions['incluirAtividade'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/AtividadeCadastroEconomico/incluir_atividade.html.twig',
            'data' => [],
        ];

        $fieldOptions['listaAtividades'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/AtividadeCadastroEconomico/lista_atividades.html.twig',
            'data' => [
                'itens' => $cadastroEconomico->getFkEconomicoAtividadeCadastroEconomicos(),
            ],
        ];

        $fieldOptions['diaSemana'] = [
            'mapped' => false,
            'choices' => $em->getRepository(DiasSemana::class)->findBy([]),
            'choice_value' => 'codDia',
            'choice_label' => function (DiasSemana $diaSemana) {
                return (string) $diaSemana->getNomDia();
            },
            'expanded' => true,
            'multiple' => true,
            'required' => false,
            'label_attr' => [
                'class' => 'checkbox-sonata'
            ],
            'attr' => [
                'class' => 'checkbox-sonata',
            ],
            'label' => 'label.economicoAtividadeCadastroEconomico.diaSemana',
        ];

        $fieldOptions['incluirDia'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/AtividadeCadastroEconomico/incluir_dia.html.twig',
            'data' => [],
        ];

        $fieldOptions['listaDias'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/AtividadeCadastroEconomico/lista_dias.html.twig',
            'data' => [
                'itens' => $cadastroEconomico->getFkEconomicoDiasCadastroEconomicos(),
            ],
        ];

        if ($cadastroEconomico) {
            if ($cadastroEconomico->getFkEconomicoProcessoAtividadeCadEcons()->count()) {
                $processoAtividade = $cadastroEconomico->getFkEconomicoProcessoAtividadeCadEcons()->first();
                $processo = $em->getRepository(SwProcesso::class)->findOneBy(['codProcesso' => $processoAtividade->getCodProcesso(), 'anoExercicio' => $processoAtividade->getAnoExercicio()]);
                $fieldOptions['fkSwClassificacao']['data'] = $processo->getFkSwAssunto()->getFkSwClassificacao();
                $fieldOptions['fkSwAssunto']['data'] = $processo->getFkSwAssunto();
                $fieldOptions['fkSwProcesso']['data'] = $processo;
            }
        }

        $formMapper
            ->with('label.economicoAtividadeCadastroEconomico.cabecalhoCadastroEconomico')
                ->add(
                    'fkSwCgm',
                    'text',
                    [
                        'mapped' => false,
                        'disabled' => true,
                        'required' => false,
                        'data' => $this->getCgm($cadastroEconomico),
                        'label' => 'label.economicoAtividadeCadastroEconomico.cgm',
                    ]
                )
                ->add(
                    'inscricaoEconomica',
                    null,
                    [
                        'disabled' => true,
                        'required' => false,
                        'data' => $cadastroEconomico->getInscricaoEconomica(),
                        'label' => 'label.economicoAtividadeCadastroEconomico.codInscricaoEconomica',
                    ]
                )
            ->end()
            ->with('label.economicoAtividadeCadastroEconomico.cabecalhoProcesso')
                ->add('fkSwClassificacao', 'entity', $fieldOptions['fkSwClassificacao'])
                ->add('fkSwAssunto', 'entity', $fieldOptions['fkSwAssunto'])
                ->add(
                    'fkSwProcesso',
                    'autocomplete',
                    $fieldOptions['fkSwProcesso'],
                    [
                        'admin_code' => 'administrativo.admin.processo'
                    ]
                )
            ->end()
            ->with('label.economicoAtividadeCadastroEconomico.cabecalhoAtividade')
                ->add(
                    'atividade',
                    'autocomplete',
                    $fieldOptions['atividade'],
                    [
                        'admin_code' => 'tributario.admin.economico_atividade'
                    ]
                )
                ->add('atividadePrincipal', 'choice', $fieldOptions['atividadePrincipal'])
                ->add('dtInicio', 'datepkpicker', $fieldOptions['dtInicio'])
                ->add('dtTermino', 'datepkpicker', $fieldOptions['dtTermino'])
                ->add('incluirAtividade', 'customField', $fieldOptions['incluirAtividade'])
            ->end()
            ->with('label.economicoAtividadeCadastroEconomico.cabecalhoListaAtividades')
                ->add('listaAtividades', 'customField', $fieldOptions['listaAtividades'])
            ->end()
            ->with('label.economicoAtividadeCadastroEconomico.cabecalhoDia')
                ->add('diaSemana', 'choice', $fieldOptions['diaSemana'])
                ->add('incluirDia', 'customField', $fieldOptions['incluirDia'])
            ->end()
            ->with('label.economicoAtividadeCadastroEconomico.cabecalhoListaDias')
                ->add('listaDias', 'customField', $fieldOptions['listaDias'])
            ->end();
    }

    /**
    * @param CadastroEconomico $cadastroEconomico
    * @return Urbem\CoreBundle\Entity\SwCgm
    */
    protected function getCgm(CadastroEconomico $cadastroEconomico)
    {
        if ($empresaFato = $cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaFato()) {
            return $empresaFato->getFkSwCgmPessoaFisica()->getFkSwCgm();
        }

        if ($autonomo = $cadastroEconomico->getFkEconomicoCadastroEconomicoAutonomo()) {
            return $autonomo->getFkSwCgmPessoaFisica()->getFkSwCgm();
        }

        if ($empresaDireito = $cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaDireito()) {
            return $empresaDireito->getFkSwCgmPessoaJuridica()->getFkSwCgm();
        }
    }

    /**
    * @param CadastroEconomico $object
    */
    protected function populateObject(CadastroEconomico $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();

        foreach ($object->getFkEconomicoProcessoAtividadeCadEcons() as $processoAtividadeCadastroEconomico) {
            $object->removeFkEconomicoProcessoAtividadeCadEcons($processoAtividadeCadastroEconomico);
        }

        foreach ($object->getFkEconomicoAtividadeCadastroEconomicos() as $atividadeCadastroEconomico) {
            $object->removeFkEconomicoAtividadeCadastroEconomicos($atividadeCadastroEconomico);
        }

        foreach ($object->getFkEconomicoDiasCadastroEconomicos() as $diasCadastroEconomico) {
            $object->removeFkEconomicoDiasCadastroEconomicos($diasCadastroEconomico);
        }

        foreach ($object->getFkEconomicoProcessoAtividadeCadEcons() as $processoAtividadeCadastroEconomico) {
            $object->removeFkEconomicoProcessoAtividadeCadEcons($processoAtividadeCadastroEconomico);
        }

        $em->persist($object);
        $em->flush();

        $processo = $form->get('fkSwProcesso')->getData();

        foreach ((array) $this->getRequest()->get('atividades') as $atividade) {
            $atividadeCadastroEconomico = new AtividadeCadastroEconomico();
            $atividadeCadastroEconomico->setCodAtividade($atividade['codAtividade']);
            $atividadeCadastroEconomico->setPrincipal((bool) ((int) $atividade['atividadePrincipal']));

            $dtInicio = (new DateTime())->createFromFormat('d/m/Y', $atividade['dtInicio']);
            $atividadeCadastroEconomico->setDtInicio($dtInicio);

            if ($atividade['dtTermino']) {
                $dtTermino = (new DateTime())->createFromFormat('d/m/Y', $atividade['dtTermino']);
                $atividadeCadastroEconomico->setDtTermino($dtTermino);
            }

            $atividadeCadastroEconomico->setOcorrenciaAtividade(1);

            if ($processo) {
                $processoAtividadeCadastroEconomico = new ProcessoAtividadeCadEcon();
                $processoAtividadeCadastroEconomico->setCodProcesso($processo->getCodProcesso());
                $processoAtividadeCadastroEconomico->setAnoExercicio($processo->getAnoExercicio());
                $processoAtividadeCadastroEconomico->setCodAtividade($atividadeCadastroEconomico->getCodAtividade());
                $processoAtividadeCadastroEconomico->setOcorrenciaAtividade($atividadeCadastroEconomico->getOcorrenciaAtividade());

                $object->addFkEconomicoProcessoAtividadeCadEcons($processoAtividadeCadastroEconomico);
            }

            $atividadeCadastroEconomico->setFkEconomicoCadastroEconomico($object);

            $object->addFkEconomicoAtividadeCadastroEconomicos($atividadeCadastroEconomico);
        }

        foreach ((array) $this->getRequest()->get('dias') as $dia) {
            $diasCadastroEconomico = new DiasCadastroEconomico();
            $diasCadastroEconomico->setCodDia($dia['diaSemana']);
            $diasCadastroEconomico->setInscricaoEconomica($object->getInscricaoEconomica());

            $hrInicio = (new DateTime())->createFromFormat('H:i', $dia['hrInicio']);
            $diasCadastroEconomico->setHrInicio($hrInicio);

            if ($dia['hrTermino']) {
                $hrTermino = (new DateTime())->createFromFormat('H:i', $dia['hrTermino']);
                $diasCadastroEconomico->setHrTermino($hrTermino);
            }

            if ($processo) {
                $processoDiaCadastroEconomico = new ProcessoDiasCadEcon();
                $processoDiaCadastroEconomico->setFkEconomicoDiasCadastroEconomico($diasCadastroEconomico);
                $processoDiaCadastroEconomico->setFkSwProcesso($processo);
                $processoDiaCadastroEconomico->setInscricaoEconomica($object->getInscricaoEconomica());

                $diasCadastroEconomico->addFkEconomicoProcessoDiasCadEcons($processoDiaCadastroEconomico);
            }

            $diasCadastroEconomico->setFkEconomicoCadastroEconomico($object);

            $object->addFkEconomicoDiasCadastroEconomicos($diasCadastroEconomico);
        }
    }

    /**
    * @param CadastroEconomico $object
    * @param string $label
    */
    protected function saveObject(CadastroEconomico $object, $label = '')
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $container = $this->getConfigurationPool()->getContainer();
        $em->getConnection()->beginTransaction();

        try {
            $em->persist($object);
            $em->flush();
            $em->getConnection()->commit();

            $container->get('session')
                ->getFlashBag()
                ->add(
                    'success',
                    $this->getTranslator()->trans($label)
                );
        } catch (Exception $e) {
            $em->getConnection()->rollBack();
            $container->get('session')->getFlashBag()->add('error', $this->getTranslator()->trans('contactSupport'));
        } finally {
            if ($object->getFkEconomicoCadastroEconomicoEmpresaFato()) {
                $this->forceRedirect('/tributario/cadastro-economico/inscricao-economica/empresa-fato/list');
            }

            if ($object->getFkEconomicoCadastroEconomicoAutonomo()) {
                $this->forceRedirect('/tributario/cadastro-economico/inscricao-economica/autonomo/list');
            }

            if ($object->getFkEconomicoCadastroEconomicoEmpresaDireito()) {
                $this->forceRedirect('/tributario/cadastro-economico/inscricao-economica/empresa-direito/list');
            }
        }
    }
}
