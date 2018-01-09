<?php

namespace Urbem\RecursosHumanosBundle\Resources\config\Sonata\FolhaPagamento;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Urbem\CoreBundle\Entity\Folhapagamento\Complementar;
use Urbem\CoreBundle\Entity\Folhapagamento\ComplementarSituacao;
use Urbem\CoreBundle\Entity\Folhapagamento\FolhaSituacao;
use Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao;
use Urbem\CoreBundle\Model\Folhapagamento\ComplementarSituacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaComplementarModel;
use Urbem\CoreBundle\Model\Folhapagamento\FolhaSituacaoModel;
use Urbem\CoreBundle\Model\Folhapagamento\PeriodoMovimentacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;

class ComplementarAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_recursos_humanos_folha_pagamento_complementar';
    protected $baseRoutePattern = 'recursos-humanos/folha-pagamento/complementar';

    protected $includeJs = [
        '/recursoshumanos/javascripts/folhapagamento/complementar.js',
    ];

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['create']);
    }

    /**
     * @param FormMapper $formMapper
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $this->setBreadCrumb($id ? ['id' => $id] : []);

        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao');

        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        if (empty($periodoFinal)) {
            $container = $this->getConfigurationPool()->getContainer();
            $message = $this->trans('recursosHumanos.folhaSituacao.errors.periodoMovimentacaoNaoAberto', [], 'validators');
            $container->get('session')->getFlashBag()->add('error', $message);

            return $this->redirectByRoute('urbem_recursos_humanos_folha_pagamento_periodo_movimentacao_list');
        }

        $dtFinal = $periodoFinal->getDtFinal();
        $dtInicial = $periodoFinal->getDtInicial();

        $formOptions['dtInicial'] = [
            'label' => 'label.recursosHumanos.folhaSituacao.dataInicial',
            'data' => $dtInicial->format('d/m/Y'),
            'attr' => [
                'readonly' => 'readonly'
            ],
            'mapped' => false
        ];

        $formOptions['dtFinal'] = [
            'label' => 'label.recursosHumanos.folhaSituacao.dataFinal',
            'data' => $dtFinal->format('d/m/Y'),
            'attr' => [
                'readonly' => 'readonly'
            ],
            'mapped' => false
        ];
        $arMes = explode("/", $dtInicial->format('d/m/Y'));
        $arDescMes = ["Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho",
            "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

        $competencia = $arDescMes[($arMes[1] - 1)];

        $formOptions['competencia'] = [
            'label' => 'label.recursosHumanos.folhaSituacao.competencia',
            'data' => $competencia,
            'attr' => [
                'readonly' => 'readonly'
            ],
            'mapped' => false
        ];

        /** @var FolhaSituacao $folhaSituacao */
        $folhaSituacao = $em->getRepository(FolhaSituacao::class)
            ->findOneBy(
                [
                    'codPeriodoMovimentacao' => $periodoFinal->getCodPeriodoMovimentacao(),
                ],
                [
                    'timestamp' => 'DESC'
                ]
            );

        if ($folhaSituacao->getSituacao() == 'f') {
            $situacaoSalarioAtual = 'Fechado em ' . $folhaSituacao->getTimestamp()->format('d/m/Y H:i:s');
        } else {
            $situacaoSalarioAtual = 'Aberto em ' . $folhaSituacao->getTimestamp()->format('d/m/Y H:i:s');
        }

        $complementarModel = new FolhaComplementarModel($em);
        $complementarSituacao = $complementarModel->consultaFolhaComplementar($periodoFinal->getCodPeriodoMovimentacao());

        if (empty($complementarSituacao)) {
            $situacaoAtual = "Nenhuma Folha Aberta";
        } else {
            $dtData = date("d/m/Y", strtotime(substr($complementarSituacao['timestamp'], 0, 19)));

            if ($complementarSituacao['situacao'] == 'f') {
                $situacaoAtual = 'Fechado em ' . $dtData;
            } else {
                $situacaoAtual = 'Aberto em ' . $dtData;
            }
        }

        /** @var FolhaSituacaoModel $folhaSituacaoModel */
        $folhaSituacaoModel = new FolhaSituacaoModel($em);
        $folhaSituacaoFechada = $folhaSituacaoModel->montaRecuperaRelacionamento($periodoFinal->getCodPeriodoMovimentacao());
        if (is_null($folhaSituacaoFechada)) {
            $folhaSituacaoFechada = $folhaSituacaoModel->montaRecuperaRelacionamento($periodoFinal->getCodPeriodoMovimentacao(), 'a');
        }

        $folhaSituacaoContador = $folhaSituacaoModel->montaRecuperaVezesFecharAbrirFolhaPagamento($periodoFinal->getCodPeriodoMovimentacao(), 'f');

        $formOptions['situacaoSalarioAtual'] = [
            'label' => 'label.recursosHumanos.folhaSituacao.situacaoAtual',
            'data' => $situacaoSalarioAtual,
            'attr' => [
                'readonly' => 'readonly'
            ],
            'mapped' => false
        ];

        $formOptions['situacaoAtual'] = [
            'label' => 'label.recursosHumanos.folhaSituacao.situacao',
            'data' => $situacaoAtual,
            'attr' => [
                'readonly' => 'readonly'
            ],
            'mapped' => false
        ];


        $formOptions['situacao'] = [
            'label' => 'label.recursosHumanos.folhaSituacao.situacao',
            'expanded' => false,
            'multiple' => false,
            'mapped' => false,
            'attr' => ['class' => 'select2-parameters '],
        ];

        if (!empty($complementarSituacao)) {
            $formOptions['situacao']['choices'] = [
                'Abrir' => 'a',
                'Fechar' => 'f',
                'Excluir' => 'e',
                'Reabrir' => 'r'
            ];

            $formOptions['situacao']['choice_attr'] = function ($situacao, $key, $index) use ($complementarSituacao) {
                if ($index == $complementarSituacao['situacao']) {
                    return [
                        'disabled' => true
                    ];
                }
                if ($complementarSituacao['situacao'] == 'f' && $index == 'e') {
                    return [
                        'disabled' => true
                    ];
                }
                if ($complementarSituacao['situacao'] == 'e' && $index == 'f') {
                    return [
                        'disabled' => true
                    ];
                }
                if ($complementarSituacao['situacao'] == 'e' && $index == 'r') {
                    return [
                        'disabled' => true
                    ];
                }
                if ($complementarSituacao['situacao'] == 'a' && $index == 'r') {
                    return [
                        'disabled' => true
                    ];
                }

                return [];
            };
            $formOptions['situacao']['data'] = ($complementarSituacao['situacao'] == 'a') ? 'f' : 'a';
        } else {
            /** @var ComplementarSituacao $complementarSituacao */
            $complementarSituacao = $em->getRepository(ComplementarSituacao::class)
                ->findOneBy(
                    [
                        'codPeriodoMovimentacao' => $periodoFinal->getCodPeriodoMovimentacao(),
                    ],
                    [
                        'timestamp' => 'DESC'
                    ]
                );

            if (!is_null($complementarSituacao)) {
                if (($complementarSituacao->getSituacao() == 'f') && ($situacaoAtual == "Nenhuma Folha Aberta")) {
                    $choices = [
                        'Abrir' => 'a',
                        'Fechar' => 'f',
                        'Excluir' => 'e',
                        'Reabrir' => 'r'
                    ];

                    $formOptions['situacao']['choice_attr'] = function ($situacao, $key, $index) {
                        if ($index == 'e') {
                            return [
                                'disabled' => true
                            ];
                        }
                        if ($index == 'f') {
                            return [
                                'disabled' => true
                            ];
                        }
                        return [];
                    };
                } else {
                    $choices = [
                        'Abrir' => 'a',
                        'Fechar' => 'f',
                        'Excluir' => 'e',
                        'Reabrir' => 'r'
                    ];
                    $formOptions['situacao']['choice_attr'] = function ($situacao, $key, $index) {
                        if ($index == 'e') {
                            return [
                                'disabled' => true
                            ];
                        }
                        if ($index == 'f') {
                            return [
                                'disabled' => true
                            ];
                        }
                        if ($index == 'r') {
                            return [
                                'disabled' => true
                            ];
                        }
                        return [];
                    };
                }
            } else {
                $choices = [
                    'Abrir' => 'a',
                    'Fechar' => 'f',
                    'Excluir' => 'e',
                    'Reabrir' => 'r'
                ];

                $formOptions['situacao']['choice_attr'] = function ($situacao, $key, $index) {
                    if ($index == 'e') {
                        return [
                            'disabled' => true
                        ];
                    }
                    if ($index == 'f') {
                        return [
                            'disabled' => true
                        ];
                    }
                    if ($index == 'r') {
                        return [
                            'disabled' => true
                        ];
                    }
                    return [];
                };
            }

            $formOptions['situacao']['choices'] = $choices;
        }

        $titulo = ($folhaSituacaoContador['contador'] >= 1) ? 'label.recursosHumanos.folhaComplementar.folhaComplementarFechadaPosterior' : 'label.recursosHumanos.folhaComplementar.folhaComplementarFechada';

        $formMapper
            ->with('label.recursosHumanos.folhaSituacao.periodoAberto')
            ->add('dtInicial', 'text', $formOptions['dtInicial'])
            ->add('dtFinal', 'text', $formOptions['dtFinal'])
            ->end()
            ->with('label.recursosHumanos.folhaSituacao.folhaSalario')
            ->add('competencia', 'text', $formOptions['competencia'])
            ->add('situacaoSalarioAtual', 'text', $formOptions['situacaoSalarioAtual'])
            ->end()
            ->with('label.recursosHumanos.folhaComplementar.folhaComplementarFechadaAnterior', [
                'class' => 'col s12 folhasComplementares box-body'
            ])
            ->end()
            ->with($titulo, [
                'class' => 'col s12 fechadaAnterior box-body'
            ])
            ->end();

        $formMapper->with('label.recursosHumanos.folhaComplementar.folhaComplementar')
            ->add('situacaoAtual', 'text', $formOptions['situacaoAtual'])
            ->add('situacaoComplementar', 'choice', $formOptions['situacao'])
            ->end();
    }

    /**
     * @param Complementar $complementar
     */
    public function prePersist($complementar)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Folhapagamento\PeriodoMovimentacao');

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        $form = $this->getForm();
        $situacao = $form->get('situacaoComplementar')->getData();

        $complementar->setFkFolhapagamentoPeriodoMovimentacao($periodoFinal);
        $complementarModel = new FolhaComplementarModel($em);
        if ($situacao == 'a') {
            $complementar->setCodComplementar($complementarModel->getNextCodComplementar($periodoFinal->getCodPeriodoMovimentacao()));
        } else {
            $this->postPersist($complementar);
        }
    }

    /**
     * @param Complementar $complementar
     */
    public function postPersist($complementar)
    {
        /** @var EntityManager $em */
        $em = $this->modelManager->getEntityManager($this->getClass());
        $form = $this->getForm();
        $situacao = $form->get('situacaoComplementar')->getData();
        $exercicio = $this->getExercicio();
        $container = $this->getContainer();

        /** @var PeriodoMovimentacaoModel $periodoMovimentacao */
        $periodoMovimentacao = new PeriodoMovimentacaoModel($em);
        $periodoUnico = $periodoMovimentacao->listPeriodoMovimentacao();
        /** @var PeriodoMovimentacao $periodoFinal */
        $periodoFinal = $periodoMovimentacao->getOnePeriodo($periodoUnico);

        /** @var ComplementarSituacao $complementarSituacao */
        $complementarSituacao = $em->getRepository(ComplementarSituacao::class)
            ->findOneBy(
                [
                    'codPeriodoMovimentacao' => $periodoFinal->getCodPeriodoMovimentacao(),
                ],
                [
                    'timestamp' => 'DESC'
                ]
            );

        if ($situacao == 'f' || $situacao == 'e') {
            /** @var Complementar $complementar */
            $complementar = $complementarSituacao->getFkFolhapagamentoComplementar();
        }

        if ($situacao == 'r') {
            /** @var Complementar $complementar */
            $complementar = $complementarSituacao->getFkFolhapagamentoComplementar();
            $situacao = 'a';
            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('flash_create_success'));
        }

        /** @var ComplementarSituacaoModel $complementarSituacaoModel */
        $complementarSituacaoModel = new ComplementarSituacaoModel($em);
        $complementarSituacaoModel->buildOneBasedComplementar($complementar, $situacao, $exercicio);

        if ($situacao == 'f' || $situacao == 'e') {
            $container->get('session')->getFlashBag()->add('success', $this->getTranslator()->trans('flash_create_success'));
        }

        (new RedirectResponse($this->generateUrl('create')))->send();
    }
}
