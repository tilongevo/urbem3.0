<?php

namespace Urbem\FinanceiroBundle\Controller\Contabilidade;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Urbem\CoreBundle\Controller\BaseController;
use Urbem\CoreBundle\Entity\Administracao\Configuracao;
use Urbem\CoreBundle\Entity\Administracao\ConfiguracaoEntidade;
use Urbem\CoreBundle\Entity\Administracao\Modulo;
use Urbem\CoreBundle\Entity\Contabilidade\Lancamento;
use Urbem\CoreBundle\Entity\Orcamento\Entidade;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoEntidadeModel;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;

/**
 * Class EncerramentoController
 * @package Urbem\FinanceiroBundle\Controller\Contabilidade
 */
class EncerramentoController extends BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        $this->setBreadCrumb();
        return $this->render('FinanceiroBundle::Contabilidade/Encerramento/home.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function efetuarLancamentoContabilAction(Request $request)
    {
        $this->setBreadCrumb();

        $data = array();
        $form = $this->generateForm($data);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $container = $this->container;

            try {
                $em = $this->getDoctrine()->getManager();

                $formData = $request->request->get('form');

                $entidades = $formData['entidade'];

                $opcao = $formData['opcao'];

                $lancamentoRepository = $em->getRepository(Lancamento::class);

                $exercicio = $this->getExercicio();
                foreach ($entidades as $entidade) {
                    $lancouVariacoes = array_shift($lancamentoRepository->fezEncerramentoAnualLancamentosVariacoesPatrimoniais2013($exercicio, $entidade));

                    $lancouOrcamentario = array_shift($lancamentoRepository->fezEncerramentoAnualLancamentosOrcamentario2013($exercicio, $entidade));

                    $lancouControle = array_shift($lancamentoRepository->fezencerramentoanuallancamentoscontrole2013($exercicio, $entidade));

                    // Lança Variações Patrimoniais se ainda não foi lançada e se foi selecionada a opção
                    if (in_array('todos', $opcao) || in_array('variacoes_patrimoniais', $opcao)) {
                        if ($lancouVariacoes['fez']) {
                            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.lancamentoContabil.sucessoVariacoesPatrimoniais'));
                            return $this->redirectToRoute('financeiro_contabilidade_encerramento_efetuar_lancamento_contabil_encerramento');
                        }
                        $lancamentoRepository->encerramentoAnualLancamentosVariacoesPatrimoniais2013($exercicio, $entidade);
                    }

                     // Lança Orçamentaria se ainda não foi lançada e se foi selecionada a opção
                    if (in_array('todos', $opcao) || in_array('orcamentario', $opcao)) {
                        if ($lancouOrcamentario['fez']) {
                            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.lancamentoContabil.sucessoLancamentoOrcamentario'));
                            return $this->redirectToRoute('financeiro_contabilidade_encerramento_efetuar_lancamento_contabil_encerramento');
                        }
                        $lancamentoRepository->encerramentoAnualLancamentosOrcamentario2013($exercicio, $entidade);
                    }

                    // Lança Controle se ainda não foi lançada e se foi selecionada a opção
                    if (in_array('todos', $opcao) || in_array('controle', $opcao)) {
                        if ($lancouControle['fez']) {
                            $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.lancamentoContabil.sucessoLancamentoControle'));
                            return $this->redirectToRoute('financeiro_contabilidade_encerramento_efetuar_lancamento_contabil_encerramento');
                        }
                        $lancamentoRepository->encerramentoAnualLancamentosControle2013($exercicio, $entidade);
                    }
                }

                $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.lancamentoContabil.sucesso'));
            } catch (\Exception $e) {
                $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.lancamentoContabil.erro'));
                throw $e;
            }
        }

        return $this->render(
            'FinanceiroBundle::Contabilidade/Encerramento/efetuarLancamento.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @param $data
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    private function generateForm($data)
    {
        $form = $this->createFormBuilder($data)
            ->add(
                'entidade',
                EntityType::class,
                array (
                    'class' => Entidade::class,
                    'label' => 'label.entidades',
                    'required' => true,
                    'placeholder' => 'label.selecione',
                    'attr' => array(
                        'class' => 'select2-parameters',
                    ),
                    'multiple' => true,
                    'choice_label' => function ($entidade) {
                        return $entidade->getFkSwCgm()->getNomCgm();
                    },
                    'choice_value' => 'codEntidade',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder("e")
                            ->where("e.exercicio = '" . $this->getExercicio() . "'")
                            ->orderBy('e.codEntidade', 'ASC');
                    },
                )
            )
            ->add(
                'opcao',
                ChoiceType::class,
                array (
                    'choices' => array(
                        'Todos' => 'todos',
                        'Variações Patrimoniais' => 'variacoes_patrimoniais',
                        'Orçamentário' => 'orcamentario',
                        'Controle' => 'controle',
                    ),
                    'required' => true,
                    'label' => 'label.escolhaOpcao',
                    'expanded' => true,
                    'multiple' => true,
                )
            )
            ->setAction($this->generateUrl('financeiro_contabilidade_encerramento_efetuar_lancamento_contabil_encerramento'))
            ->getForm();

        return $form;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function excluirLancamentoContabilAction(Request $request)
    {
        $this->setBreadCrumb();

        $data = array();
        $url = 'financeiro_contabilidade_encerramento_excluir_lancamento_contabil_encerramento';
        $form = $this->generateFormEntidade($data, $url);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $container = $this->container;

            try {
                $em = $this->getDoctrine()->getManager();

                $formData = $request->request->get('form');

                $entidades = $formData['entidade'];

                $lancamentoRepository = $em->getRepository(Lancamento::class);

                $exercicio = $this->getExercicio();
                foreach ($entidades as $entidade) {
                    $lancouVariacoes = array_shift($lancamentoRepository->fezEncerramentoAnualLancamentosVariacoesPatrimoniais2013($exercicio, $entidade));

                    $lancouOrcamentario = array_shift($lancamentoRepository->fezEncerramentoAnualLancamentosOrcamentario2013($exercicio, $entidade));

                    $lancouControle = array_shift($lancamentoRepository->fezencerramentoanuallancamentoscontrole2013($exercicio, $entidade));

                    // Exclui todos os lançamentos que ainda não foram excluidos
                    if ($lancouVariacoes['fez']) {
                        $lancamentoRepository->excluiEncerramentoAnualLancamentosVariacoesPatrimoniais2013($exercicio, $entidade);
                    }

                    if ($lancouOrcamentario['fez']) {
                        $lancamentoRepository->excluiEncerramentoAnualLancamentosOrcamentario2013($exercicio, $entidade);
                    }

                    if ($lancouControle['fez']) {
                        $lancamentoRepository->excluiencerramentoanuallancamentoscontrole2013($exercicio, $entidade);
                    }
                }

                $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.lancamentoContabil.excluiLancamentoContabilSucesso'));
            } catch (\Exception $e) {
                $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.lancamentoContabil.excluiLancamentoContabilErro'));
                throw $e;
            }
        }

        return $this->render(
            'FinanceiroBundle::Contabilidade/Encerramento/excluirLancamento.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @param $data
     * @param $url
     * @param bool $multiple
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */
    private function generateFormEntidade($data, $url, $multiple = true)
    {
        $form = $this->createFormBuilder($data)
            ->add(
                'entidade',
                EntityType::class,
                array (
                    'class' => 'CoreBundle:Orcamento\Entidade',
                    'label' => 'label.entidades',
                    'required' => true,
                    'placeholder' => 'label.selecione',
                    'attr' => array(
                        'class' => 'select2-parameters',
                    ),
                    'multiple' => $multiple,
                    'choice_label' => function ($entidade) {
                        return $entidade->getFkSwCgm()->getNomCgm();
                    },
                    'choice_value' => 'codEntidade',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder("e")
                            ->where("e.exercicio = '" . $this->getExercicio() . "'")
                            ->orderBy('e.codEntidade', 'ASC');
                    },
                )
            )
            ->setAction($this->generateUrl($url))
            ->getForm();

        return $form;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function gerarRestosPagarAction(Request $request)
    {
        $this->setBreadCrumb();

        $data = array();
        $retorno = array();

        $url = 'financeiro_contabilidade_encerramento_gerar_restos_pagar';
        $form = $this->generateFormEntidade($data, $url, false);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $container = $this->container;

            $em = $this->getDoctrine()->getManager();
            try {
                $em->getConnection()->beginTransaction();

                $formData = $request->request->get('form');

                $entidade = $formData['entidade'];

                $valida = $this->validaGerarRestosPagar();

                if ($valida) {
                    $message = 'label.restosAPagar.processoJaExecutado';
                    $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans($message));
                    return $this->render(
                        'FinanceiroBundle::Contabilidade/Encerramento/gerarRestosPagar.html.twig',
                        array('form' => $form->createView())
                    );
                }

                $lancamentoRepository = $em->getRepository(Lancamento::class);

                // Busca informações para o relatório
                $dtFinal = '31/12/' . $this->getExercicio();
                $retorno = $lancamentoRepository->geraRelatorioInsuficiencia($this->getExercicio(), $entidade, $dtFinal);

                $em->getConnection()->commit();

                return $this->render(
                    'FinanceiroBundle::Contabilidade/Encerramento/gerarRestosPagarResultado.html.twig',
                    array(
                        'form' => $form->createView(),
                        'entidade' => $entidade,
                        'retorno' => $retorno
                    )
                );
            } catch (\Exception $e) {
                $em->getConnection()->rollback();
                $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.restosAPagar.erroExclusao'));
                throw $e;
            }
        }

        return $this->render(
            'FinanceiroBundle::Contabilidade/Encerramento/gerarRestosPagar.html.twig',
            array(
                'form' => $form->createView(),
                'retorno' => $retorno
            )
        );
    }

    /**
     * @return int
     */
    private function validaGerarRestosPagar()
    {
        $em = $this->getDoctrine()->getManager();

        $configuracaoRepository = $em->getRepository(Configuracao::class);

        $valida = $configuracaoRepository->findOneBy([
            'exercicio' => $this->getExercicio(),
            'parametro' => ConfiguracaoModel::PARAM_VIRADA_GF,
            'codModulo' => ConfiguracaoModel::MODULO_FINANCEIRO_EMPENHO,
            'valor' => 'T'
        ]);

        return count($valida);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function efetuarGerarRestosPagarAction(Request $request)
    {
        $this->setBreadCrumb();

        if ($request->getMethod() == 'POST') {
            $container = $this->container;

            $em = $this->getDoctrine()->getManager();
            try {
                $em->getConnection()->beginTransaction();

                $entidade = $request->request->get('entidade');
                $exercicio = $this->getExercicio();

                $lancamentoRepository = $em->getRepository(Lancamento::class);

                $lancamentoRepository->anularRestosEncerramento($exercicio, $entidade);

                $this->salvaConfiguracoes($entidade);

                $em->getConnection()->commit();
                $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.restosAPagar.sucesso'));
            } catch (\Exception $e) {
                $em->getConnection()->rollback();
                $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.restosAPagar.erro'));
                throw $e;
            }
        }

        return $this->redirectToRoute('financeiro_contabilidade_encerramento_gerar_restos_pagar');
    }

    /**
     * @param $entidade
     * @param string $ativa
     */
    public function salvaConfiguracoes($entidade, $ativa = 'T')
    {
        $em = $this->getDoctrine()->getManager();

        $moduloObj = $em->getRepository(Modulo::class)
            ->findOneByCodModulo(ConfiguracaoModel::MODULO_FINANCEIRO_EMPENHO);

        $configuracaoRepository = $em->getRepository(Configuracao::class);

        $configuracao = $configuracaoRepository->findOneBy([
            'exercicio' => $this->getExercicio(),
            'parametro' => ConfiguracaoModel::PARAM_VIRADA_GF,
            'codModulo' => ConfiguracaoModel::MODULO_FINANCEIRO_EMPENHO
        ]);

        if (!$configuracao) {
            $configuracao = new Configuracao();
            $configuracao->setExercicio($this->getExercicio());
            $configuracao->setParametro(ConfiguracaoModel::PARAM_VIRADA_GF);
            $configuracao->setFkAdministracaoModulo($moduloObj);
        }

        $configuracao->setValor($ativa);

        $configuracaoModel = new ConfiguracaoModel($em);
        $configuracaoModel->save($configuracao);

        $configuracao = $configuracaoRepository->findOneBy([
            'exercicio' => $this->getExercicio(),
            'parametro' => 'virada_GF_entidade_' . $entidade,
            'codModulo' => ConfiguracaoModel::MODULO_FINANCEIRO_EMPENHO
        ]);

        if (!$configuracao) {
            $configuracao = new Configuracao();
            $configuracao->setExercicio($this->getExercicio());
            $configuracao->setParametro('virada_GF_entidade_' . $entidade);
            $configuracao->setFkAdministracaoModulo($moduloObj);
        }

        $configuracao->setValor($ativa);

        $configuracaoModel = new ConfiguracaoModel($em);
        $configuracaoModel->save($configuracao);

        $entidadeObj = $em->getRepository(Entidade::class)
            ->findOneBy([
                'codEntidade' => $entidade,
                'exercicio' => $this->getExercicio()
            ]);

        $configuracaoEntidadeRepository = $em->getRepository(ConfiguracaoEntidade::class);

        $configuracaoEntidade = $configuracaoEntidadeRepository->findOneBy([
            'exercicio' => $this->getExercicio(),
            'parametro' => ConfiguracaoModel::PARAM_VIRADA_GF,
            'codModulo' => ConfiguracaoModel::MODULO_FINANCEIRO_EMPENHO,
            'codEntidade' => $entidadeObj->getCodEntidade()
        ]);

        if (!$configuracaoEntidade) {
            $configuracaoEntidade = new ConfiguracaoEntidade();
            $configuracaoEntidade->setExercicio($this->getExercicio());
            $configuracaoEntidade->setParametro(ConfiguracaoModel::PARAM_VIRADA_GF);
            $configuracaoEntidade->setFkAdministracaoModulo($moduloObj);
            $configuracaoEntidade->setFkOrcamentoEntidade($entidadeObj);
        }

        $configuracaoEntidade->setValor($ativa);

        $configuracaoEntidadeModel = new ConfiguracaoEntidadeModel($em);
        $configuracaoEntidadeModel->save($configuracaoEntidade);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function anularRestosPagarAction(Request $request)
    {
        $this->setBreadCrumb();

        $data = array();

        $url = 'financeiro_contabilidade_encerramento_anular_restos_pagar';
        $form = $this->generateFormEntidade($data, $url, false);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $request->getMethod() == 'POST') {
            $container = $this->container;

            $em = $this->getDoctrine()->getManager();
            try {
                $em->getConnection()->beginTransaction();

                $formData = $request->request->get('form');

                $entidade = $formData['entidade'];

                $lancamentoRepository = $em->getRepository(Lancamento::class);

                $lancamentoRepository->anularRestosEncerramento($this->getExercicio(), $entidade);

                $this->salvaConfiguracoes($entidade, 'F');

                $em->getConnection()->commit();
                $container->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('label.anularRestosAPagar.sucesso'));
            } catch (\Exception $e) {
                $em->getConnection()->rollback();
                $container->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('label.anularRestosAPagar.erro'));
                throw $e;
            }
        }

        return $this->render(
            'FinanceiroBundle::Contabilidade/Encerramento/anularRestosPagar.html.twig',
            array(
                'form' => $form->createView(),
                'mensagem' => 'Esta rotina desfaz os lançamentos de Inscrição de Restos a pagar do exercício de ' . $this->getExercicio()
            )
        );
    }
}
