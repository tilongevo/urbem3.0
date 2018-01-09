<?php

namespace Urbem\TributarioBundle\Resources\config\Sonata\Economico;

use Exception;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito;
use Urbem\CoreBundle\Entity\Economico\ProcessoSociedade;
use Urbem\CoreBundle\Entity\Economico\Sociedade;
use Urbem\CoreBundle\Entity\SwAssunto;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\CoreBundle\Entity\SwClassificacao;
use Urbem\CoreBundle\Entity\SwProcesso;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class EmpresaDireitoSociedadeAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_tributario_economico_empresa_direito_sociedade';
    protected $baseRoutePattern = 'tributario/cadastro-economico/inscricao-economica/alterar-sociedade';
    protected $includeJs = ['/tributario/javascripts/economico/empresa-direito-sociedade.js'];

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
        $this->saveObject($object, 'label.EmpresaDireitoSociedadeAdmin.msgSucesso');
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
        $empresaDireito = $cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaDireito();

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

        $fieldOptions['socio'] = [
            'class' => SwCgm::class,
            'mapped' => false,
            'json_from_admin_code' => $this->code,
            'json_query_builder' => function ($em, $term, Request $request) {
                $qb = $em->createQueryBuilder('o');

                $qb->andWhere('LOWER(o.nomCgm) LIKE :nomCgm');
                $qb->setParameter('nomCgm', sprintf('%%%s%%', strtolower($term)));

                $qb->orderBy('o.numcgm', 'ASC');

                return $qb;
            },
            'json_choice_label' => function (SwCgm $cgm) {
                return sprintf('%s - %s', $cgm->getNumcgm(), $cgm->getNomCgm());
            },
            'required' => false,
            'attr' => [
                'class' => 'select2-parameters js-socio ',
            ],
            'label' => 'label.EmpresaDireitoSociedadeAdmin.socio',
        ];

        $fieldOptions['quota'] = [
            'mapped' => false,
            'required' => false,
            'currency' => 'BRL',
            'attr' => [
                'class' => 'money js-quota-socio '
            ],
            'label' => 'label.EmpresaDireitoSociedadeAdmin.quota',
        ];

        $fieldOptions['incluirSocio'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/EmpresaDireitoSociedade/incluir_socio.html.twig',
            'data' => [],
        ];

        $fieldOptions['listaSocios'] = [
            'mapped' => false,
            'label' => false,
            'template' => 'TributarioBundle::Economico/EmpresaDireitoSociedade/lista_socios.html.twig',
            'data' => [
                'itens' => $empresaDireito ? $empresaDireito->getFkEconomicoSociedades() : [],
            ],
        ];

        if ($empresaDireito
            && $empresaDireitoSociedade = $empresaDireito->getFkEconomicoSociedades()->last()) {
            if ($processoEmpresaDireitoSociedade = $empresaDireitoSociedade->getFkEconomicoProcessoSociedades()->last()) {
                $processo = $processoEmpresaDireitoSociedade->getFkSwProcesso();
                $fieldOptions['fkSwClassificacao']['data'] = $processo->getFkSwAssunto()->getFkSwClassificacao();
                $fieldOptions['fkSwAssunto']['data'] = $processo->getFkSwAssunto();
                $fieldOptions['fkSwProcesso']['data'] = $processo;
            }
        }

        $formMapper
            ->with('label.EmpresaDireitoSociedadeAdmin.cabecalhoCadastroEconomico')
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
                        'data' => $empresaDireito ? $empresaDireito->getFkSwCgmPessoaJuridica()->getFkSwCgm() : null,
                        'label' => 'label.economicoBaixaCadastroEconomico.cgm',
                    ]
                )
            ->end()
            ->with('label.EmpresaDireitoSociedadeAdmin.cabecalhoProcesso')
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
            ->with('label.EmpresaDireitoSociedadeAdmin.cabecalhoDadosSociedade')
                ->add(
                    'capitalSocial',
                    'text',
                    [
                        'mapped' => false,
                        'attr' => [
                            'readonly' => true,
                        ],
                        'label' => 'label.EmpresaDireitoSociedadeAdmin.capitalSocial',
                    ]
                )
            ->end()
            ->with('label.EmpresaDireitoSociedadeAdmin.cabecalhoSociedade')
                ->add(
                    'socio',
                    'autocomplete',
                    $fieldOptions['socio'],
                    [
                        'admin_code' => 'core.admin.filter.sw_cgm'
                    ]
                )
                ->add('quota', 'money', $fieldOptions['quota'])
                ->add('incluirSocio', 'customField', $fieldOptions['incluirSocio'])
            ->end()
            ->with('label.EmpresaDireitoSociedadeAdmin.cabecalhoListaSocios')
                ->add('listaSocios', 'customField', $fieldOptions['listaSocios'])
            ->end();
    }

    /**
    * @param CadastroEconomico $object
    */
    protected function populateObject(CadastroEconomico $object)
    {
        $em = $this->modelManager->getEntityManager($this->getClass());

        $cadastroEconomico = $this->getSubject() ?: new CadastroEconomico();
        $empresaDireito = $cadastroEconomico->getFkEconomicoCadastroEconomicoEmpresaDireito() ?: new CadastroEconomicoEmpresaDireito();

        foreach ($empresaDireito->getFkEconomicoSociedades() as $sociedade) {
            $empresaDireito->removeFkEconomicoSociedades($sociedade);
        }

        foreach ((array) $this->getRequest()->get('socios') as $socio) {
            $empresaDireitoSociedade = new Sociedade();

            $cgm = $em->getRepository(SwCgm::class)->find($socio['numcgm']);
            $empresaDireitoSociedade->setFkSwCgm($cgm);
            $empresaDireitoSociedade->setQuotaSocio((float) $socio['quotaSocio']);
            $empresaDireitoSociedade->setFkEconomicoCadastroEconomicoEmpresaDireito($empresaDireito);

            $processo = $this->getForm()->get('fkSwProcesso')->getData();
            if ($processo) {
                $processoSociedade = new ProcessoSociedade();
                $processoSociedade->setFkEconomicoSociedade($empresaDireitoSociedade);
                $processoSociedade->setFkSwProcesso($processo);

                $empresaDireitoSociedade->addFkEconomicoProcessoSociedades($processoSociedade);
            }

            $empresaDireito->addFkEconomicoSociedades($empresaDireitoSociedade);
        }

        $cadastroEconomico->setFkEconomicoCadastroEconomicoEmpresaDireito($empresaDireito);
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
            $this->forceRedirect('/tributario/cadastro-economico/inscricao-economica/empresa-direito/list');
        }
    }
}
