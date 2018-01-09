<?php
namespace Urbem\PatrimonialBundle\Controller\Compras;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Urbem\CoreBundle\Controller as ControllerCore;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CentroCustoModel;
use Urbem\CoreBundle\Entity\Compras;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\SwCgmModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoModel;
use Urbem\CoreBundle\Model\Empenho\EmpenhoModel;
use Urbem\CoreBundle\Model\Empenho\AutorizacaoEmpenhoModel;
use Urbem\CoreBundle\Model\Orcamento\DespesaModel;

class SolicitacaoController extends ControllerCore\BaseController
{
    const COD_MODULO_COMPRAS = ConfiguracaoModel::MODULO_PATRIMONIAL_COMPRAS;

    public function anularAction(Request $request)
    {
        $this->setBreadCrumb();
        return $this->redirectToRoute(
            'urbem_patrimonial_compras_solicitacao_anulacao_create',
            [
                'id' => $request->query->get('id'),
            ]
        );
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function recuperaSaldoSolicitacaoAction(Request $request)
    {
        $exercicio = $request->get('exercicio');
        $codDotacao = $request->get('codDotacao');

        $em = $this->getDoctrine()->getManager();
        $despesaModel = new DespesaModel($em);
        $saldoDotacao = $despesaModel->recuperaSaldoDotacao($exercicio, $codDotacao);

        $response = new Response();
        $response->setContent(json_encode($saldoDotacao));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function recuperaSaldoDotacaoAction(Request $request)
    {
        $solicitacao = $request->get('solicitacao');
        $codDespesa = $request->get('codDespesa');

        list($exercicio, $codEntidade, $codSolicitacao) = explode('~', $solicitacao);

        $entityManager = $this->container->get('doctrine.orm.entity_manager');
        $saldoDotacao = (new DespesaModel($entityManager))->recuperaSaldoDotacaoDataEmpenho($exercicio, $codDespesa, $codEntidade);

        return new JsonResponse($saldoDotacao);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function recuperaListaDotacaoAction(Request $request)
    {
        $exercicio = $request->get('exercicio');
        $codEntidade = $request->get('codEntidade');

        $em = $this->getDoctrine('Urbem\CoreBundle\Entity\Compras\Solicitacao')->getManager();
        /** @var CentroCustoModel $ccModel */
        $ccModel = new CentroCustoModel($em);
        $usuarioLogado = $this->get('security.token_storage')->getToken()->getUser()->getNumcgm();
        $ccDotacao = $ccModel->getDotacaoByEntidade($codEntidade, $exercicio, $usuarioLogado);

        $response = new Response();
        $response->setContent(json_encode($ccDotacao));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function recuperaCodEstruturalAction(Request $request)
    {
        $exercicio = $request->get('exercicio');
        $codDotacao = $request->get('codDotacao');

        $em = $this->getDoctrine()->getManager();
        $despesaModel = new DespesaModel($em);
        $codEstrutural = $despesaModel->recuperaCodEstrutural($exercicio, $codDotacao);
        $response = new Response();
        $response->setContent(json_encode($codEstrutural));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function getDataFixaSolicitacaoAction(Request $request)
    {
        $liberaData = true; // Trava campo input [dataSolicitacao]. Inicia liberado para edição
        $dataFixaSolicitacao = '';
        $dataUltimoEmpenho = '';
        $maiorDataAutorizacaoEmpenho = '';
        $dados['dataFixaSolicitacao'] = '';
        $exercicio = $request->get('exercicio');
        $codEntidade = $request->get('codEntidade');
        $codModulo = ConfiguracaoModel::MODULO_PATRIMONIAL_COMPRAS;

        $em = $this->getDoctrine()->getManager();

        // Verificação se as variáveis foram enviadas
        if ($codEntidade && $exercicio && $codModulo) {
            // Consulta se existe uma data fixa de solicitação registrada
            $solicitacaoModel = new SolicitacaoModel($em);
            $dqlSolicitacaoModel = $solicitacaoModel->getDataFixaSolicitacao($exercicio, $codEntidade, $codModulo);
            if ($dqlSolicitacaoModel != null) {
                $dataFixaSolicitacao = $dqlSolicitacaoModel->getValor();
            }
        }

        /* Não existindo uma data fixa de solicitação faremos outras consultas para encontrar uma data para setar #data de solicitacao#
        * #Data do último empenho# ou #Data autorização empenho#
        */
        if (empty($dataFixaSolicitacao)) {
            // Verifica a existencia data do empenho
            $solicitacaoModel = new EmpenhoModel($em);
            $dqlUltimoEmpenho = $solicitacaoModel->recuperaUltimaDataEmpenho($exercicio, $codEntidade);
            if ($dqlUltimoEmpenho != null) {
                $dataUltimoEmpenhoDB = $dqlUltimoEmpenho->dt_empenho;
                $timeFormat = strtotime($dataUltimoEmpenhoDB);
                $dataUltimoEmpenho = date("d/m/Y", $timeFormat);
            }

            // Verifica a existencia de uma data de autorizacao de empenho, havendo mais de uma data, pega a data mais recente
            $autorizacaoEmpenhoModel = new AutorizacaoEmpenhoModel($em);
            $dqlDataAutorizacaoEmpenho = $autorizacaoEmpenhoModel->listarMaiorData($exercicio, $codEntidade);
            if ($dqlDataAutorizacaoEmpenho != null) {
                $maiorDataAutorizacaoEmpenhoDB = $dqlDataAutorizacaoEmpenho->dt_autorizacao;
                $timeFormat = strtotime($maiorDataAutorizacaoEmpenhoDB);
                $maiorDataAutorizacaoEmpenho = date("d/m/Y", $timeFormat);
            }

            /*
             * Havendo uma data de autorização assumimos esse dado para data da solicitacao
             * Caso não exista data de autorização assumiremos a data de empenho, caso exista o registro dessa data
             * Caso contrário setamos a data para 01/01/data do exercicio vigente
            */
            if ($maiorDataAutorizacaoEmpenho != "") {
                $dados['dataFixaSolicitacao'] = $maiorDataAutorizacaoEmpenho;
            } elseif ($dataUltimoEmpenho != "") {
                $dados['dataFixaSolicitacao'] = $dataUltimoEmpenho;
            } else {
                $dados['dataFixaSolicitacao'] = "01/01/".$this->getExercicio();
            }
        } else {
            $dados['dataFixaSolicitacao'] = $dataFixaSolicitacao;
            // Travamos a edição do campo dataSolicitacao apenas quando existe uma data fixa
            $liberaData = false;
        }

        // Aguarda alteração da variável $liberaData
        $dados['liberaDataSolicitacao'] = $liberaData;

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @param Request $request
     * @deprecated
     * @return Response
     */
    public function perfilAction(Request $request)
    {
        $this->setBreadCrumb();

        $id = $request->query->get('id');
        list($exercicio, $codEntidade, $codSolicitacao) = explode("~", $id);
        $entityManager = $this->getDoctrine()->getManager();

        /** @var  $solicitacao Compras\Solicitacao */
        $solicitacao = $entityManager
            ->getRepository(Compras\Solicitacao::class)
            ->findOneBy(
                [
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'codSolicitacao' => $codSolicitacao,
                ]
            );

        $cgmModel = new SwCgmModel($entityManager);
        $solicitacao->requisitante = $cgmModel->findOneByNumcgm($solicitacao->getCgmRequisitante());

        $solicitacaoItem = $solicitacao->getFkComprasSolicitacaoItens();
        $anulacao = $solicitacao->getFkComprasSolicitacaoAnulacoes();

        $phomologado = $entityManager->getRepository('CoreBundle:Compras\Solicitacao')->getSolicitacaoNotHomologadoAndNotAnulada($solicitacao->getExercicio(), $codSolicitacao);
        $solicitacao->getFkComprasSolicitacaoHomologada();
        $passivelHomologacao = (count($phomologado) > 0) ? true : false;

        $anularHomogacao = $entityManager
            ->getRepository(Compras\SolicitacaoHomologadaAnulacao::class)
            ->findOneBy(
                [
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'codSolicitacao' => $codSolicitacao,
                ]
            );

        $homologado = $entityManager
            ->getRepository(Compras\SolicitacaoHomologada::class)
            ->findOneBy(
                [
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'codSolicitacao' => $codSolicitacao,
                ]
            );

        return $this->render('PatrimonialBundle::Compras/SolicitacaoCompra/perfil.html.twig', [
            'solicitacao' => $solicitacao,
            'solicitacaoItem' => $solicitacaoItem,
            'anulacao' => $anulacao,
            'passivel_homologacao' => $passivelHomologacao,
            'passivel_anulacao_homologacao' => $anularHomogacao,
            'homologado' => $homologado,
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function montaRecuperaRelacionamentoSolicitacaoItensAction(Request $request)
    {
        $exercicio = $request->get('exercicio');
        $codEntidade = $request->get('codEntidade');
        $codSolicitacaoPai = $request->get('codSolicitacaoPai');

        /** @var EntityManager $entityManager */
        $entityManager = $this->getDoctrine()->getManager();

        $solicitacaoModel = new SolicitacaoModel($entityManager);
        $solicitacoes = $solicitacaoModel->montaRecuperaRelacionamentoSolicitacao($exercicio, $codEntidade, $codSolicitacaoPai);

        $dados = [];
        /** @var Compras\Solicitacao $solicitacao */
        foreach ($solicitacoes as $index => $solicitacao) {
            $dados[$index]['label'] = (string) $solicitacao;
            $dados[$index]['value'] = $solicitacaoModel->getObjectIdentifier($solicitacao);
        }

        $response = new Response();
        $response->setContent(json_encode($dados));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function montaRecuperaItemSolicitacaoAction(Request $request)
    {
        $solicitacao = $request->get('solicitacao');
        $exercicio = $this->getExercicio();

        $modelManager = $this->container->get('sonata.admin.manager.orm');
        $entityManager = $modelManager->getEntityManager(Compras\Solicitacao::class);

        /** @var Compras\Solicitacao $solicitacao */
        $solicitacao = $modelManager->find(Compras\Solicitacao::class, $solicitacao);

        $solicitacaoModel = new SolicitacaoModel($entityManager);
        $itemsSolicitacao = $solicitacaoModel
            ->montaRecuperaItemSolicitacao($solicitacao->getCodSolicitacao(), $solicitacao->getCodEntidade(), $solicitacao->getExercicio());

        $retorno = [];
        foreach ($itemsSolicitacao as $itemSolicitacao) {
            $exercicioSolicitacao = $itemSolicitacao->exercicio;

            $key = $itemSolicitacao->cod_item;

            $formMapper['descricaoResumida'] = [
                'label'    => 'label.itens.item',
                'required' => false,
                'disabled' => true,
                'mapped'   => false,
                'data'     => $itemSolicitacao->descricao_resumida,
            ];

            $formMapper['nomUnidade'] = [
                'label'    => 'label.itens.unidade',
                'required' => false,
                'disabled' => true,
                'mapped'   => false,
                'data'     => $itemSolicitacao->nom_unidade,
            ];

            $formMapper['descricao'] = [
                'label'    => 'label.itens.centroCusto',
                'required' => false,
                'disabled' => true,
                'mapped'   => false,
                'data'     => $itemSolicitacao->descricao,
            ];

            $formMapper['quantidade'] = [
                'attr'     => ['class' => 'quantity '],
                'label'    => 'label.itens.qtde',
                'required' => false,
                'disabled' => true,
                'mapped'   => false,
                'data'     => number_format($itemSolicitacao->quantidade_item, 4, ',', '.'),
            ];

            $vlTotal = $itemSolicitacao->vl_unitario * $itemSolicitacao->quantidade_item;

            $formMapper['vlTotal'] = [
                'attr'     => ['class' => 'money '],
                'label'    => 'label.itens.valorTotal',
                'required' => false,
                'disabled' => true,
                'mapped'   => false,
                'data'     => $vlTotal,
            ];

            /** @var CentroCustoModel $ccModel */
            $ccModel = new CentroCustoModel($entityManager);
            $usuarioLogado = $this->getCurrentUser()->getNumcgm();
            $codEntidade = $solicitacao->getCodEntidade();

            $ccDotacao = $ccModel->getDotacaoByEntidade($codEntidade, $exercicio, $usuarioLogado);

            $ccDotacaoChoices = [];

            foreach ($ccDotacao as $dotacao) {
                $descricao = $dotacao['descricao'];
                $choiceValue = $dotacao['cod_despesa'];
                $choiceKey = $descricao;
                $ccDotacaoChoices[$choiceValue . ' - ' . $choiceKey] = $choiceValue;
            }

            $formMapper['codDespesa'] = [
                'label'       => 'label.patrimonial.compras.solicitacao.dotacaoorcamentaria',
                'mapped'      => false,
                'choices'     => $ccDotacaoChoices,
                'attr'        => [
                    'class' => 'select2-parameters ',
                ],
                'required'    => true,
                'placeholder' => 'label.selecione',
            ];

            $formMapper['codEstrutural'] = [
                'mapped'      => false,
                'label'       => 'label.patrimonial.compras.solicitacao.desdobramento',
                'required'    => true,
                'choices'     => [],
                'attr'        => ['class' => 'select2-parameters ',],
                'placeholder' => 'label.selecione',
            ];

            /** @var DespesaModel $despesaModel */
            $despesaModel = new DespesaModel($entityManager);
            $arrCodEstrutural = $despesaModel->recuperaCodEstrutural($exercicio, $itemSolicitacao->cod_despesa);
            $arrChoicesCodEstrutural = [];

            if (is_array($arrCodEstrutural)) {
                foreach ($arrCodEstrutural as $codEstrutural) {
                    $index = (string) ($codEstrutural->cod_estrutural . ' - ' . $codEstrutural->descricao);
                    $arrChoicesCodEstrutural[$index] = $codEstrutural->cod_conta . '-' . $codEstrutural->exercicio;
                }
            }

            $formMapper['codEstrutural']['choices'] = $arrChoicesCodEstrutural;

            $formMapper['saldoDotacao'] = [
                'attr'     => ['class' => 'money '],
                'label'    => 'label.itens.saldoDotacao',
                'required' => false,
                'disabled' => true,
                'mapped'   => false,
                'data'     => 0
            ];

            if ($exercicio == $exercicioSolicitacao) {
                $formMapper['codDespesa']['data'] = $itemSolicitacao->cod_despesa;
                $formMapper['saldoDotacao']['data'] = $itemSolicitacao->saldo;
                $formMapper['codEstrutural']['data'] = sprintf('%d-%s', $itemSolicitacao->cod_conta, $itemSolicitacao->exercicio);
            }

            if ($solicitacao->getRegistroPrecos()) {
                $formMapper['codDespesa']['required'] =  false;
                $formMapper['codEstrutural']['required'] = false;
            }

            $formSolicitacaoItem = $this->createFormBuilder();
            $formSolicitacaoItem
                ->add('descricaoResumida_' . $key, TextType::class, $formMapper['descricaoResumida'])
                ->add('nomUnidade_' . $key, TextType::class, $formMapper['nomUnidade'])
                ->add('descricao_' . $key, TextType::class, $formMapper['descricao'])
                ->add('quantidade_' . $key, TextType::class, $formMapper['quantidade'])
                ->add('vlTotal_' . $key, TextType::class, $formMapper['vlTotal'])
                ->add('codDespesa_' . $key, ChoiceType::class, $formMapper['codDespesa'])
                ->add('codEstrutural_' . $key, ChoiceType::class, $formMapper['codEstrutural'])
                ->add('saldoDotacao_' . $key, TextType::class, $formMapper['saldoDotacao'])
                ->add('reservaSaldo_' . $key, HiddenType::class, [
                    'data' => $itemSolicitacao->saldo - $vlTotal
                ])
            ;

            $retorno[$key] = $formSolicitacaoItem->getForm()->createView();
        }

        return $this->render('PatrimonialBundle::Compras/SolicitacaoCompra/items.html.twig', [
            'formCollection'   => $retorno,
            'registroDePrecos' => $solicitacao->getRegistroPrecos(),
        ]);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getItemDescricaoAction(Request $request)
    {
        $find = $request->get('q');
        $entityManager = $this->getDoctrine()->getManager();

        $solicitacaoModel = new SolicitacaoModel($entityManager);
        $getItens = $solicitacaoModel->getItensDescricao($find);

        $itens = [];

        foreach ($getItens as $item) {
            array_push($itens, ['id' => $item->cod_item, 'label' => $item->descricao]);
        }
        $items = [
            'items' => $itens,
        ];

        return new JsonResponse($items);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getDotacaoOrcamentariaAction(Request $request)
    {
        $find = $request->get('q');
        $entityManager = $this->getDoctrine()->getManager();

        $solicitacaoModel = new SolicitacaoModel($entityManager);
        $getItens = $solicitacaoModel->getItensDescricao($find);

        $itens = [];

        foreach ($getItens as $item) {
            array_push($itens, ['id' => $item->cod_item, 'label' => $item->descricao]);
        }
        $items = [
            'items' => $itens,
        ];

        return new JsonResponse($items);
    }
}
