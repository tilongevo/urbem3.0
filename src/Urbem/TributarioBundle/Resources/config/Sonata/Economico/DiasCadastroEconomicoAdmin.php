<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use DateTime;
use Exception;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Administracao\DiasSemana;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\DiasCadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\ProcessoDiasCadEcon;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class DiasCadastroEconomicoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_dias_cadastro_economico';
    protected $baseRoutePattern = 'tributario/cadastro-economico/inscricao-economica/alterar-horario';
    protected $includeJs = ['/tributario/javascripts/economico/atividade-cadastro-economico.js'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add(
            'alterar',
            sprintf(
                '%s',
                $this->getRouterIdParameter()
            )
        );

        $routes->clearExcept(['edit', 'alterar']);
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $this->populateObject($object);
        $this->saveObject($object, 'label.DiasCadastroEconomicoAdmin.msgSucesso');
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

        if ($diasCadastroEconomico = $cadastroEconomico->getFkEconomicoDiasCadastroEconomicos()->first()) {
            $processoDias = $diasCadastroEconomico->getFkEconomicoProcessoDiasCadEcons()->first();
            if ($processoDias) {
                $processo = $em->getRepository(SwProcesso::class)->findOneBy(['codProcesso' => $processoDias->getCodProcesso(), 'anoExercicio' => $processoDias->getAnoExercicio()]);
                $fieldOptions['fkSwClassificacao']['data'] = $processo->getFkSwAssunto()->getFkSwClassificacao();
                $fieldOptions['fkSwAssunto']['data'] = $processo->getFkSwAssunto();
                $fieldOptions['fkSwProcesso']['data'] = $processo;
            }
        }

        $formMapper
            ->with('label.DiasCadastroEconomicoAdmin.cabecalhoProcesso')
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
            ->with('label.DiasCadastroEconomicoAdmin.cabecalhoDia')
                ->add('diaSemana', 'choice', $fieldOptions['diaSemana'])
                ->add('incluirDia', 'customField', $fieldOptions['incluirDia'])
            ->end()
            ->with('label.DiasCadastroEconomicoAdmin.cabecalhoListaDias')
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

        foreach ($object->getFkEconomicoDiasCadastroEconomicos() as $diasCadastroEconomico) {
            $object->removeFkEconomicoDiasCadastroEconomicos($diasCadastroEconomico);
        }

        foreach ($object->getFkEconomicoProcessoAtividadeCadEcons() as $processoAtividadeCadastroEconomico) {
            $object->removeFkEconomicoProcessoAtividadeCadEcons($processoAtividadeCadastroEconomico);
        }

        $em->persist($object);
        $em->flush();

        $processo = $form->get('fkSwProcesso')->getData();

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
