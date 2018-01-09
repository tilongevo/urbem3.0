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
use Urbem\CoreBundle\Entity\Economico\BaixaCadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\ProcessoBaixaCadEconomico;
use Urbem\CoreBundle\Entity\Economico\TipoBaixaInscricao;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Helper\DatePK;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class BaixaCadastroEconomicoAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_baixa_cadastro_economico';
    protected $baseRoutePattern = 'tributario/cadastro-economico/inscricao-economica/baixa';
    protected $includeJs = ['/tributario/javascripts/economico/baixa-cadastro-economico.js'];
    protected $legendButtonSave = ['icon' => 'arrow_downward', 'text' => 'Baixar'];

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $routes)
    {
        $routes->add(
            'certidao',
            sprintf(
                'certidao/%s',
                $this->getRouterIdParameter()
            )
        );

        $routes->add(
            'reativar',
            'reativar/{inscricaoEconomica}'
        );

        $routes->add(
            'oficio',
            'oficio/{inscricaoEconomica}'
        );

        $routes->clearExcept(['create', 'edit', 'certidao', 'reativar', 'oficio']);
    }

    /**
     * @return array
     */
    public function getPersistentParameters()
    {
        if (!$this->getRequest()) {
            return [];
        }

        return [
            'inscricaoEconomica' => $this->getRequest()->get('inscricaoEconomica'),
        ];
    }

    /**
     * @param mixed $object
     */
    public function prePersist($object)
    {
        $this->populateObject($object);

        $this->saveObject($object, 'label.economicoBaixaCadastroEconomico.baixar.msgBaixar');
    }

    /**
     * @param mixed $object
     */
    public function preUpdate($object)
    {
        $this->saveObject($object, 'label.economicoBaixaCadastroEconomico.baixar.msgReativar');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $this->setBreadCrumb();

        $em = $this->modelManager->getEntityManager($this->getClass());

        $cadastroEconomico = $em->getRepository(CadastroEconomico::class)->findOneByInscricaoEconomica($this->getRequest()->get('inscricaoEconomica'));

        $baixaCadastroEconomico = null;
        if ($this->isCurrentRoute('reativar') || $this->isCurrentRoute('edit')) {
            $this->setLegendButtonSave('arrow_upward', 'Reativar');
            $baixaCadastroEconomico = $em->getRepository(BaixaCadastroEconomico::class)
            ->findOneBy(['inscricaoEconomica' => $cadastroEconomico->getInscricaoEconomica(), 'dtTermino' => null], ['timestamp' => 'desc']);
        }

        $fieldOptions = [];
        $fieldOptions['dtInicio'] = [
            'pk_class' => DatePK::class,
            'dp_default_date' => (new DateTime())->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'label' => 'label.economicoBaixaCadastroEconomico.dtInicio',
        ];

        $fieldOptions['dtTermino'] = [
            'pk_class' => DatePK::class,
            'dp_default_date' => (new DateTime())->format('d/m/Y'),
            'format' => 'dd/MM/yyyy',
            'label' => 'label.economicoBaixaCadastroEconomico.dtTermino',
        ];

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

        if ($baixaCadastroEconomico) {
            $fieldOptions['dtInicio']['attr']['readonly'] = true;
            $fieldOptions['dtInicio']['data'] = $baixaCadastroEconomico->getDtInicio();
        }

        if ($cadastroEconomico) {
            if ($cadastroEconomico->getFkEconomicoProcessoCadastroEconomicos()->count()) {
                $processo = $cadastroEconomico->getFkEconomicoProcessoCadastroEconomicos()->first();
                $fieldOptions['fkSwClassificacao']['data'] = $processo->getFkSwProcesso()->getFkSwAssunto()->getFkSwClassificacao();
                $fieldOptions['fkSwAssunto']['data'] = $processo->getFkSwProcesso()->getFkSwAssunto();
                $fieldOptions['fkSwProcesso']['data'] = $processo->getFkSwProcesso();
            }
        }

        $formMapper
            ->with('label.economicoCadastroEconomico.cabecalho')
            ->add(
                'inscricaoEconomica',
                null,
                [
                    'disabled' => true,
                    'data' => $cadastroEconomico->getInscricaoEconomica(),
                    'attr' => [
                        'class' => 'js-inscricao-economica ',
                    ],
                    'label' => 'label.economicoCadastroEconomico.codInscricao',
                ]
            )
            ->add(
                'fkSwCgm',
                'text',
                [
                    'mapped' => false,
                    'disabled' => true,
                    'data' => $this->getCgm($cadastroEconomico),
                    'label' => 'label.economicoBaixaCadastroEconomico.cgm',
                ]
            )
            ->add(
                'dtInicio',
                'datepkpicker',
                $fieldOptions['dtInicio']
            );

        if ($baixaCadastroEconomico) {
            $formMapper->add(
                'dtInicio',
                'datepkpicker',
                $fieldOptions['dtInicio']
            )
            ->add(
                'dtTermino',
                'datepkpicker',
                $fieldOptions['dtTermino']
            );

            return;
        }

        $formMapper->end()
            ->with('label.economicoCadastroEconomico.cabecalhoProcesso')
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
            ->with('label.economicoBaixaCadastroEconomico.cabecalhoMotivo')
            ->add(
                'motivo',
                'textarea',
                [
                    'label' => false,
                ]
            )
            ->end()
            ->with('label.economicoBaixaCadastroEconomico.cabecalhoCodTipo')
            ->add(
                'codTipo',
                'choice',
                [
                    'mapped' => false,
                    'choices' => $em->getRepository(TipoBaixaInscricao::class)->findBy([]),
                    'choice_value' => 'codTipo',
                    'choice_label' => 'nomTipo',
                    'attr' => [
                        'class' => 'select2-parameters',
                    ],
                    'label' => false,
                ]
            )
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
    protected function populateObject($object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $form = $this->getForm();

        $cadastroEconomico = $em->getRepository(CadastroEconomico::class)->findOneByInscricaoEconomica($this->getRequest()->get('inscricaoEconomica'));
        $object->setFkEconomicoCadastroEconomico($cadastroEconomico);

        $object->setCodTipo($form->get('codTipo')->getData()->getCodTipo());

        foreach ($object->getFkEconomicoProcessoBaixaCadEconomicos() as $processoBaixaCadastroEconomico) {
            $object->removeFkEconomicoProcessoBaixaCadEconomicos($processoBaixaCadastroEconomico);
        }

        if ($processo = $form->get('fkSwProcesso')->getData()) {
            $processoBaixaCadastroEconomico = (new ProcessoBaixaCadEconomico())->setFkSwProcesso($processo);
            $object->addFkEconomicoProcessoBaixaCadEconomicos($processoBaixaCadastroEconomico);
        }

        $object->setDeOficio(false);
        if ($this->isCurrentRoute('oficio')) {
            $object->setDeOficio(true);
        }
    }

    /**
    * @param CadastroEconomico $object
    * @param string $label
    */
    protected function saveObject($object, $label = '')
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
            $cadastroEconomico = $object->getFkEconomicoCadastroEconomico();
            if ($cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaFato()) {
                $this->forceRedirect('/tributario/cadastro-economico/inscricao-economica/empresa-fato/list');
            }

            if ($cadastroEconomico->getFkEconomicoCadastroEconomicoAutonomo()) {
                $this->forceRedirect('/tributario/cadastro-economico/inscricao-economica/autonomo/list');
            }

            if ($cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaDireito()) {
                $this->forceRedirect('/tributario/cadastro-economico/inscricao-economica/empresa-direito/list');
            }
        }
    }
}
