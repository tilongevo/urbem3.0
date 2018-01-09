<?php

namespace Urbem\PatrimonialBundle\Resources\config\Sonata\Compras;

use Doctrine\ORM\EntityManager;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Urbem\CoreBundle\Entity\Compras\Solicitacao;
use Urbem\CoreBundle\Entity\Compras\SolicitacaoItem;
use Urbem\CoreBundle\Entity\Orcamento\ContaDespesa;
use Urbem\CoreBundle\Entity\Orcamento\Despesa;
use Urbem\CoreBundle\Model\Orcamento\ReservaSaldosModel;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CatalogoItemModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoHomologadaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoHomologadaReservaModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoItemDotacaoModel;
use Urbem\CoreBundle\Resources\config\Sonata\AbstractSonataAdmin;
use Urbem\CoreBundle\Model\Patrimonial\Almoxarifado\CentroCustoModel;
use Urbem\CoreBundle\Model\Patrimonial\Compras\SolicitacaoModel;
use Urbem\CoreBundle\Entity\Almoxarifado\CatalogoItem;
use Urbem\CoreBundle\Model\Administracao\ConfiguracaoModel;
use Urbem\CoreBundle\Model\Orcamento\DespesaModel;
use Sonata\CoreBundle\Validator\ErrorElement;

class SolicitacaoItemAdmin extends AbstractSonataAdmin
{
    protected $baseRouteName = 'urbem_patrimonial_compras_solicitacao_item';
    protected $baseRoutePattern = 'patrimonial/compras/solicitacao/solicitacao-item';
    protected $inCodModulo = ConfiguracaoModel::MODULO_PATRIMONIAL_COMPRAS;
    protected $msgErroHomologacao = null;

    protected $includeJs = [
        '/patrimonial/javascripts/compras/solicitacaoitem.js',
    ];

    /**
     * @param ErrorElement $errorElement
     * @param SolicitacaoItem $solicitacaoItem
     */
    public function validate(ErrorElement $errorElement, $solicitacaoItem)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\Solicitacao');

        $formData = $this->getRequest()->request->get($this->getUniqid());
        $form = $this->getForm();


        $exercicio = $formData['exercicio'];
        $codEntidade = $formData['codEntidade'];
        $codSolicitacao = $formData['codSolicitacao'];
        $codCentro = $form->get('fkAlmoxarifadoCentroCusto')->getData()->getCodCentro();
        $codItem = is_null($solicitacaoItem->getCodItem()) ? $form->get('fkAlmoxarifadoCatalogoItem')->getData() : $solicitacaoItem->getCodItem();

        $solicitacaoItem->setFkAlmoxarifadoCentroCusto($form->get('fkAlmoxarifadoCentroCusto')->getData());

        $boDotacaoObrigatoria = true;

        $solicitacao = $entityManager
            ->getRepository('CoreBundle:Compras\Solicitacao')->findOneBy(
                [
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'codSolicitacao' => $codSolicitacao
                ]
            );

        /** @var SolicitacaoItem $solicitacaoItemNovo */
        $solicitacaoItemNovo = $entityManager
            ->getRepository('CoreBundle:Compras\SolicitacaoItem')->findOneBy(
                [
                    'exercicio' => $exercicio,
                    'codEntidade' => $codEntidade,
                    'codSolicitacao' => $codSolicitacao,
                    'codCentro' => $codCentro,
                    'codItem' => $codItem
                ]
            );

        // Início do trecho para validação do valor da reserva
        $em = $this->modelManager->getEntityManager('CoreBundle:Administracao\Configuracao');
        $coModel = new ConfiguracaoModel($em);
        $inExercicio = $this->getExercicio();

        //pega as configurações do sistema
        $boReservaRigida = $coModel->pegaConfiguracao('reserva_rigida', $this->inCodModulo, $inExercicio);
        $boReservaRigida = ($boReservaRigida[0]['valor'] == 'true') ? true : false;

        //Se a Solicitação for Registro de Preço, Não efetua Reserva de Saldo e Dotação Orçamentária Não é Obrigatória
        if ($solicitacao->getRegistroPrecos() == 'true') {
            $boReservaRigida = false;
        }

        if ($boReservaRigida) {
            $exercicioSolicitacaoItem = !is_null($solicitacaoItem->getExercicio()) ? $solicitacaoItem->getExercicio() : $exercicio;
            $despesa = $entityManager
                ->getRepository('CoreBundle:Orcamento\Despesa')->findOneBy(
                    [
                        'codDespesa' => $formData['codDespesa'],
                        'exercicio' => $exercicioSolicitacaoItem
                    ]
                );

            $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Orcamento\Despesa');
            $despesaModel = new DespesaModel($entityManager);
            $despesaDotacao = $despesaModel->recuperaSaldoDotacao($despesa->getExercicio(), $despesa->getCodDespesa());

            $valorDespesa = $despesaDotacao[0]['saldo_dotacao'] -= $formData['vlTotalHidden'];

            if ($valorDespesa < 0) {
                $vlSaldoDotacao = explode('.', $formData['saldoDotacao']);
                $formData['saldoDotacao'] = $vlSaldoDotacao[0];
                $message = $this->trans('solicitacao_compra.errors.valorDespesa', [ '%valor_despesa%' => (string) $valorDespesa ], 'validators');
                $errorElement->with('saldoDotacao')->addViolation($message)->end();
                $this->getRequest()->getSession()->getFlashBag()->add("custom_erro", $message);
            }
        }


        if (!is_null($solicitacaoItem) and !is_null($solicitacaoItemNovo)) {
            if (($solicitacaoItem->getCodSolicitacao() != $solicitacaoItemNovo->getCodSolicitacao())) {
                if (!is_null($solicitacaoItem)) {
                    $message = $this->trans('solicitacao_compra.errors.fkAlmoxarifadoCatalogoItem', [], 'validators');
                    $errorElement->with('fkAlmoxarifadoCatalogoItem')->addViolation($message)->end();
                }
            }
            //Se a Solicitação for Registro de Preço, Não efetua Reserva de Saldo e Dotação Orçamentária Não é Obrigatória
            if ($solicitacao->getRegistroPrecos() == true) {
                $boDotacaoObrigatoria = false;
            }

            $codDespesa = (isset($formData['codDespesa'])) ? $formData['codDespesa'] : null;

            if ($boDotacaoObrigatoria) {
                if (is_null($codDespesa)) {
                    $message = $this->trans('solicitacao_compra.errors.codDespesa', [], 'validators');
                    $errorElement->with('codDespesa')->addViolation($message)->end();
                }
            }
        }
    }

    /**
     * @param SolicitacaoItem $solicitacaoItem
     */
    public function prePersist($solicitacaoItem)
    {
        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\Solicitacao');
        $catalogoItemModel = new CatalogoItemModel($entityManager);

        $intCatalogoItem = !is_null($solicitacaoItem->getFkAlmoxarifadoCatalogoItem()) ? $solicitacaoItem->getFkAlmoxarifadoCatalogoItem()->getCodItem() : $this->getForm()->get('fkAlmoxarifadoCatalogoItem')->getData();
        $catalogoItem = $catalogoItemModel->getOneByCodItem($intCatalogoItem);

        $formData = $this->getRequest()->request->get($this->getUniqid());

        $solicitacao = $entityManager
            ->getRepository('CoreBundle:Compras\Solicitacao')->findOneBy(
                [
                    'exercicio' => $formData['exercicio'],
                    'codEntidade' => $formData['codEntidade'],
                    'codSolicitacao' => $formData['codSolicitacao']
                ]
            );

        $solicitacaoItem->setFkComprasSolicitacao($solicitacao);
        $solicitacaoItem->setvlTotal($formData['vlTotalHidden']);
        $solicitacaoItem->setFkAlmoxarifadoCatalogoItem($catalogoItem);
    }

    /**
     * @param SolicitacaoItem $solicitacaoItem
     */
    public function postPersist($solicitacaoItem)
    {

        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\Solicitacao');

        $formData = $this->getRequest()->request->get($this->getUniqid());
        $solicitacaoItem->setvlTotal($formData['vlTotalHidden']);

        $despesa = new Despesa();
        if ($formData['codDespesa'] != "") {
            $despesa = $entityManager
                ->getRepository('CoreBundle:Orcamento\Despesa')->findOneBy(
                    [
                        'codDespesa' => $formData['codDespesa'],
                        'exercicio' => $solicitacaoItem->getExercicio()
                    ]
                );

            if (!is_null($despesa->getFkOrcamentoContaDespesa())) {
                $despesa->getFkOrcamentoContaDespesa()->setCodEstrutural($formData['codEstrutural']);
            }
        }

        try {
            $this->saveRelationships($solicitacaoItem, $solicitacaoItem->getFkComprasSolicitacao(), $despesa, $formData);
        } catch (Exception $e) {
            throw $e;
        }


        if ($this->msgErroHomologacao == true) {
            $message = $this->trans('solicitacao_compra.errors.homologacao', [], 'validators');
            $this->getRequest()->getSession()->getFlashBag()->add("warning", $message);
        }

        $this->forceRedirect("/patrimonial/compras/solicitacao/{$this->getObjectKey($solicitacaoItem->getFkComprasSolicitacao())}/show");
    }

    /**
     * @param SolicitacaoItem $solicitacaoItem
     */
    public function preUpdate($solicitacaoItem)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());
        $this->prePersist($solicitacaoItem);
    }

    /**
     * @param SolicitacaoItem $solicitacaoItem
     */
    public function postUpdate($solicitacaoItem)
    {
        $formData = $this->getRequest()->request->get($this->getUniqid());

        $this->postPersist($solicitacaoItem);
    }

    /**
     * @param SolicitacaoItem $solicitacaoItem
     */
    public function postRemove($solicitacaoItem)
    {
        $this->forceRedirect("/patrimonial/compras/solicitacao/{$this->getObjectKey($solicitacaoItem->getFkComprasSolicitacao())}/show");
    }

    /**
     * @param SolicitacaoItem $solicitacaoItem
     * @param Solicitacao $solicitacao
     * @param Despesa $despesa
     * @param $formData
     */
    public function saveRelationships(SolicitacaoItem $solicitacaoItem, Solicitacao $solicitacao, Despesa $despesa, $formData)
    {

        $em = $this->modelManager->getEntityManager('CoreBundle:Administracao\Configuracao');
        $coModel = new ConfiguracaoModel($em);

        $inExercicio = $this->getExercicio();

        //pega as configurações do sistema
        $inCodUf = $coModel->pegaConfiguracao('cod_uf', 2, $inExercicio);

        $boHomologaAutomatico = $coModel->pegaConfiguracao('homologacao_automatica', $this->inCodModulo, $inExercicio);
        $boReservaRigida = $coModel->pegaConfiguracao('reserva_rigida', $this->inCodModulo, $inExercicio);
        $boDotacaoObrigatoria = $coModel->pegaConfiguracao('dotacao_obrigatoria_solicitacao', $this->inCodModulo, $inExercicio);

        $boReservaRigida = ($boReservaRigida[0]['valor'] == 'true') ? true : false;
        $boDotacaoObrigatoria = ($boDotacaoObrigatoria[0]['valor'] == 'true') ? true : false;
        $boHomologaAutomatico = ($boHomologaAutomatico[0]['valor'] == 'true') ? true : false;

        //Se a Solicitação for Registro de Preço, Não efetua Reserva de Saldo e Dotação Orçamentária Não é Obrigatória
        if ($solicitacao->getRegistroPrecos() == 'true') {
            $boReservaRigida = false;
            $boDotacaoObrigatoria = false;
        }

        /*
         * Salva o Item dotação
         */
        if (isset($formData['codEstrutural']) and $formData['codEstrutural'] != "") {
            $ormCodConta = $em
                ->getRepository('CoreBundle:Orcamento\ContaDespesa')->findOneBy(
                    [
                        'exercicio' => $inExercicio,
                        'codEstrutural' => $formData['codEstrutural']
                    ]
                );
            $codConta = $ormCodConta;

            if (!is_null($despesa)) {
                $emItemDotacao = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\SolicitacaoItem');
                $siModel = new SolicitacaoItemDotacaoModel($emItemDotacao);
                $comprasSolicitacaoItemDotacao = $siModel->salvaSolicitacaoItemDotacao($solicitacaoItem, $codConta, $despesa);
            }
        } else {
            $despesa = null;
        }

        $nuVlReserva = str_replace(',', '.', str_replace('.', '', $solicitacaoItem->getVlTotal()));
        $motivo = "Entidade: " . $solicitacao->getFkOrcamentoEntidade()->getCodEntidade() . " - " . $solicitacao->getFkOrcamentoEntidade()->getFkSwCgm()->getNomCgm() . ", solicitação de compras: " . $solicitacao->getCodSolicitacao() . "/" . $this->getExercicio() . ', Item:' . $solicitacaoItem->getCodItem();
        $dataFinal = $inExercicio . '-12-31';
        $dataFinal = new \DateTime($dataFinal);

        $orcamentoReservaSaldo = null;
        $temReserva = false;
        $cod_reserva = null;
        if ($nuVlReserva > 0 && $solicitacao->getRegistroPrecos() == 'false' && !is_null($despesa)) {
            $emReserva = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Orcamento\ReservaSaldos');
            $rsModel = new ReservaSaldosModel($emReserva);

            $data = $solicitacao->getTimestamp();
            $dataInicial = new \DateTime($data);

            $orcamentoReservaSaldo = $rsModel->saveReservaSaldos($inExercicio, $despesa, $solicitacao, $motivo, $nuVlReserva, $dataInicial, $dataFinal);

            //Caso for estado de MG não deve validar a homologacao automatica já que lá é tudo manual
            //Atribuindo o valor de true na variavel de homolagacao para nao afetar outros estados
            if ($inCodUf == 11) {
                $boHomologaAutomatico = true;
            }

            if ($boHomologaAutomatico && $boReservaRigida) {
                $em = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\Solicitacao');
                $solicitacaoModel = new SolicitacaoModel($em);
                $cod_reserva = ($solicitacaoModel->getProximaCodReservaSaldo()) > 0 ? $solicitacaoModel->getProximaCodReservaSaldo() : 1;
                if ($solicitacaoModel->montaincluiReservaSaldo($cod_reserva, $inExercicio, $despesa->getCodDespesa(), $solicitacao->getTimestamp(), $dataFinal, $nuVlReserva, 'A', $motivo)) {
                    $temReserva = true;
                } else {
                    $temReserva = false;
                }
            }
        }

        $boIncluiHomologacaoReserva = false;
        if ($boReservaRigida) {
            if ($boHomologaAutomatico) {
                !is_null($cod_reserva) ? $boIncluiHomologacaoReserva = $this->registraHomologacaoSolicitacao($inExercicio, $solicitacao) : $this->msgErroHomologacao = true;
            }
        } else {
            if ($boHomologaAutomatico) {
                $boIncluiHomologacaoReserva = $this->registraHomologacaoSolicitacao($inExercicio, $solicitacao);
            }
        }

        //Faz a inclusão na tabela compras.solicitacao_homologada_reserva se NÃO for Registro de Preço
        if ($boIncluiHomologacaoReserva == true && $solicitacao->getRegistroPrecos() == false && $boReservaRigida  && !is_null($despesa)) {
            if ($nuVlReserva > 0) {
                if ($temReserva == true) {
                    // inclusão na tabela compras.solicitacao_homologada_reserva
                    $emHReserva = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologadaReserva');
                    $solicitacaoHReversa = new SolicitacaoHomologadaReservaModel($emHReserva);

                    $solicitacaoHReversa->salvaSolicitacaoHomologadaReserva($this->getExercicio(), $solicitacao, $solicitacaoItem, $orcamentoReservaSaldo, $comprasSolicitacaoItemDotacao, $despesa);
                }
            }
        }
    }

    /**
     * @param $inExercicio
     * @param $solicitacao
     * @return bool
     */
    public function registraHomologacaoSolicitacao($inExercicio, $solicitacao)
    {
        $emHomologada = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\SolicitacaoHomologada');
        $solicitacaoHomologacao = new SolicitacaoHomologadaModel($emHomologada);
        $solicitacaoHomologacao->salvaSolicitacaoHomologada($inExercicio, $solicitacao);
        return true;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $id = $this->getAdminRequestId();
        $route = $this->getRequest()->get('_sonata_name');

        $this->setBreadCrumb($id ? ['id' => $id] : []);
        $catalogoItem = null;
        $codItem = null;
        if (!$this->getRequest()->isMethod('GET')) {
            $formData = $this->getRequest()->request->get($this->getUniqid());
            $codSolicitacao = $formData['codSolicitacao'];
            $exercicioSolicitacao = $formData['exercicio'];
            $codEntidade = $formData['codEntidade'];
        } else {
            if ($this->baseRouteName . "_edit" == $route) {
                list($exercicioSolicitacao, $codEntidade, $codSolicitacao, $codCentro, $codItem) = explode("~", $id);
            } else {
                list($exercicioSolicitacao, $codEntidade, $codSolicitacao) = explode("~", $id);
            }
        }

        $exercicio = $this->getExercicio();

        $entityManager = $this->modelManager->getEntityManager('Urbem\CoreBundle\Entity\Compras\Solicitacao');

        /** @var CentroCustoModel $ccModel */
        $ccModel = new CentroCustoModel($entityManager);
        $usuarioLogado = $this->getCurrentUser()->getNumcgm();
        $ccDotacao = $ccModel->getDotacaoByEntidade($codEntidade, $exercicio, $usuarioLogado);

        $ccDotacaoChoices = [];

        foreach ($ccDotacao as $dotacao) {
            $descricao = $dotacao['descricao'];
            $mascara = $dotacao['mascara_classificacao'];
            $choiceValue = $dotacao['cod_despesa'];
            $choiceKey = $descricao;
            $ccDotacaoChoices[$choiceValue . ' - ' . $choiceKey] = $choiceValue;
        }

        $fieldOptions['codItem'] = [
            'class' => CatalogoItem::class,
            'route' => ['name' => 'carrega_almoxarifado_catalogo_item'],
            'label' => 'label.almoxarifado.item',
            'attr' => ['class' => 'select2-parameters '],
            'placeholder' => 'Selecione',
        ];

        $fieldOptions['unidadeMedida'] = [
            'mapped' => false,
            'label' => 'label.almoxarifado.unidadeMedida',
            'data' => 'Indefinido',
            'required' => false,
            'attr' => [
                'readonly' => 'readonly'
            ]
        ];

        $fieldOptions['saldoCentroCusto'] = [
            'mapped' => false,
            'label' => 'label.patrimonial.compras.solicitacao.saldoCentroCusto',
            'required' => false,
            'attr' => [
                'class' => 'money ',
                'readonly' => 'readonly'
            ]
        ];

        $fieldOptions['codDespesa'] = [
            'label' => 'label.patrimonial.compras.solicitacao.dotacaoorcamentaria',
            'mapped' => false,
            'choices' => $ccDotacaoChoices,
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
        ];

        $fieldOptions['codEstrutural'] = [
            'mapped' => false,
            'label' => 'label.patrimonial.compras.solicitacao.desdobramento',
            'required' => true,
            'choices' => [],
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
        ];

        if ($this->getSubject()->getFkAlmoxarifadoCatalogoItem()) {
            $codItemFk = $this->getSubject()->getFkAlmoxarifadoCatalogoItem();
            $fieldOptions['codItem']['data'] = $codItemFk;

            $codItem = $codItemFk->getCodItem();
            $catalogoItemModel = new CatalogoItemModel($entityManager);
            $result = $catalogoItemModel->carregaAlmoxarifadoCatalogoUnidadeQuery($codItem);

            $unidadeMedida = $result == null ? 'Não Informada' : $result[0]->nom_unidade;
            $fieldOptions['unidadeMedida']['data'] = $unidadeMedida;

            if (!is_null($this->getSubject()->getCodCentro())) {
                $result = $catalogoItemModel->carregaAlmoxarifadoSaldoCentroCustoQuery($this->getSubject()->getCodCentro(), $codItem);
                $saldoCentroCusto = $result == null ? 0 : $result[0]->saldo_estoque;
                $fieldOptions['saldoCentroCusto']['data'] = intval($saldoCentroCusto);
            }
        }

        $despesa = $centroCusto = null;

        /** @var SolicitacaoItem $solicitacaoItem */
        $solicitacaoItem = $this->getSubject();
        if (null == $solicitacaoItem->getCodSolicitacao()) {
            /** @var Solicitacao $solicitacao */
            $solicitacao = $entityManager
                ->getRepository(Solicitacao::class)
                ->findOneBy([
                    'codSolicitacao' => $codSolicitacao,
                    'codEntidade' => $codEntidade,
                    'exercicio' => $exercicioSolicitacao
                ]);

            $registraPreco = $solicitacao->getRegistroPrecos();
        } else {
            $registraPreco = $solicitacaoItem->getFkComprasSolicitacao()->getRegistroPrecos();
            $solicitacao = $solicitacaoItem->getFkComprasSolicitacao();
            $registraPreco = $solicitacaoItem->getFkComprasSolicitacao()->getRegistroPrecos();
        }

        //Se a Solicitação for Registro de Preço, Não será necessário efetuar Reserva de Saldo e Dotação Orçamentária Não é Obrigatória
        if ($registraPreco == true) {
            $fieldOptions['codDespesa']['required'] =  false;
            $fieldOptions['codEstrutural']['required'] = false;
        }

        /** @var SolicitacaoItem $items */
        foreach ($solicitacao->getFkComprasSolicitacaoItens() as $items) {
            if ($items->getFkComprasSolicitacaoItemDotacoes()->first()) {
                $itemDotacao[] = $items->getFkComprasSolicitacaoItemDotacoes()->first()->getFkOrcamentoDespesa()->getCodDespesa();
                $despesa = $itemDotacao[0];
                break;
            }
        }

        if ($this->getSubject()->getFkComprasSolicitacaoItemDotacoes()->last() && $this->baseRouteName . "_edit" == $route) {
            $despesa = $this->getSubject()->getFkComprasSolicitacaoItemDotacoes()->last()->getFkOrcamentoDespesa()->getCodDespesa();
        };

        /**
         * Bloco para recuperar saldo dotação
         */
        $despesaModel = new DespesaModel($entityManager);
        $saldoDotacaoItem = 0;
        if (!is_null($despesa) && $this->baseRouteName . "_edit" == $route) {

            /** @var DespesaModel $despesaModel */
            $despesaModel = new DespesaModel($entityManager);
            $saldoDotacao = $despesaModel->recuperaSaldoDotacao($exercicio, $despesa);

            if (!is_null($saldoDotacao)) {
                $saldoDotacaoItem = $saldoDotacao[0]['saldo_dotacao'];
            }

            $arrCodEstrutural = $despesaModel->recuperaCodEstrutural($exercicio, $despesa);

            if (is_array($arrCodEstrutural)) {
                $arrChoicesCodEstrutural = [];
                foreach ($arrCodEstrutural as $codEstrutural) {
                    $key = (string) ($codEstrutural->cod_estrutural . ' - ' . $codEstrutural->descricao);
                    $arrChoicesCodEstrutural[$key] = $codEstrutural->cod_estrutural;
                }
            }

            $fieldOptions['codEstrutural']['choices'] = $arrChoicesCodEstrutural;

            $codEstrutural = $despesaModel->recuperaCodEstruturalUnico($exercicio, $codItem);

            if (sizeof($codEstrutural) > 0) {
                $fieldOptions['codEstrutural']['data'] = (string) $codEstrutural[0]->cod_estrutural;
            }
            $fieldOptions['codDespesa']['data'] = $despesa;
        }

        if ($this->getSubject()->getQuantidade() > 0) {
            $valorUnitario = ($this->getSubject()->getVlTotal() / $this->getSubject()->getQuantidade());
        }

        if ($this->getSubject()->getFkAlmoxarifadoCentroCusto()) {
            $centroCusto = $this->getSubject()->getFkAlmoxarifadoCentroCusto();
        }


        $fieldOptions['fkAlmoxarifadoCentroCusto'] = [
            'label' => 'label.patrimonial.compras.solicitacao.centrocusto',
            'required' => true,
            'mapped' => false,
            'choice_label' => 'descricao',
            'attr' => [
                'class' => 'select2-parameters '
            ],
            'placeholder' => 'label.selecione',
            'data' => $centroCusto
        ];


        $fieldOptions['valorUnitario'] = [
            'mapped' => false,
            'label' => 'label.patrimonial.compras.solicitacao.valorUnitario',
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['quantidade'] = [
            'label' => 'label.patrimonial.compras.solicitacao.quantidade',
            'attr' => [
                'class' => 'quantity '
            ]
        ];

        $fieldOptions['vlTotal'] = [
            'disabled' => 'disabled',
            'label' => 'label.patrimonial.compras.solicitacao.vlTotal',
            'attr' => [
                'class' => 'money '
            ]
        ];

        $fieldOptions['saldoDotacao'] = [
            'label' => 'label.patrimonial.compras.solicitacao.saldodotacao',
            'mapped' => false,
            'required' => false,
            'attr' => [
                'class' => 'money ',
                'readonly' => 'readonly'
            ]
        ];

        $fieldOptions['vlTotalHidden'] = ['mapped' => false, 'required' => false];

        if ($this->baseRouteName . "_edit" == $route) {
            $fieldOptions['valorUnitario']['data'] = $valorUnitario;
            $fieldOptions['saldoDotacao']['data'] = $saldoDotacaoItem;
            $fieldOptions['vlTotalHidden']['data'] = $this->getSubject()->getVlTotal();
            $fieldOptions['fkAlmoxarifadoCentroCusto']['disabled'] = 'disabled';
            $fieldOptions['codItem']['disabled'] = 'disabled';

            if ($solicitacaoItem->getFkComprasSolicitacaoItemDotacoes()->count() > 0) {
                $codconta = $solicitacaoItem->getFkComprasSolicitacaoItemDotacoes()->last()->getCodConta();
                $getCodEstrutural = $entityManager->getRepository(ContaDespesa::class)->findOneBy([
                    'exercicio' => $exercicio,
                    'codConta' => $codconta
                ]);
                $fieldOptions['codEstrutural']['data'] = $getCodEstrutural->getCodEstrutural();
            }
        }

        $formMapper
            ->with('label.patrimonial.compras.solicitacao.itenssolicitacao')
            ->add('codSolicitacao', 'hidden', ['data' => $codSolicitacao, 'mapped' => false, 'required' => false])
            ->add('codEntidade', 'hidden', ['data' => $codEntidade, 'mapped' => false, 'required' => false])
            ->add('exercicio', 'hidden', ['data' => $exercicio, 'mapped' => false, 'required' => false])
            ->add('vlTotalHidden', 'hidden', $fieldOptions['vlTotalHidden'])
            ->add('fkAlmoxarifadoCatalogoItem', 'autocomplete', $fieldOptions['codItem'])
            ->add('unidadeMedida', 'text', $fieldOptions['unidadeMedida'])
            ->add('complemento', null, ['label' => 'label.patrimonial.compras.solicitacao.complemento'])
            ->add('fkAlmoxarifadoCentroCusto', null, $fieldOptions['fkAlmoxarifadoCentroCusto'])
            ->add('saldoCentroCusto', 'number', $fieldOptions['saldoCentroCusto'])
            ->add('valorUnitario', 'number', $fieldOptions['valorUnitario'])
            ->add('quantidade', 'number', $fieldOptions['quantidade'])
            ->add('vlTotal', 'number', $fieldOptions['vlTotal'])
            ->add('codDespesa', 'choice', $fieldOptions['codDespesa'])
            ->add('codEstrutural', 'choice', $fieldOptions['codEstrutural'])
            ->add('saldoDotacao', 'number', $fieldOptions['saldoDotacao'])
            ->end();


        $admin = $this;
        $formMapper->getFormBuilder()->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMapper, $admin, $despesaModel) {
                $form = $event->getForm();
                $data = $event->getData();
                $exercicio = $this->getExercicio();
                if (isset($data['codDespesa']) && $data['codDespesa'] != "") {
                    $arrCodEstrutural = $despesaModel->recuperaCodEstrutural($exercicio, $data['codDespesa']);

                    if (is_array($arrCodEstrutural)) {
                        $arrChoicesCodEstrutural = [];
                        foreach ($arrCodEstrutural as $codEstrutural) {
                            $key = (string) ($codEstrutural->cod_estrutural . ' - ' . $codEstrutural->descricao);
                            $arrChoicesCodEstrutural[$key] = $codEstrutural->cod_estrutural;
                        }
                    }

                    $comCodEstrutural = $formMapper->getFormBuilder()
                        ->getFormFactory()
                        ->createNamed(
                            'codEstrutural',
                            'choice',
                            null,
                            [
                                'mapped' => false,
                                'label' => 'label.patrimonial.compras.solicitacao.desdobramento',
                                'required' => true,
                                'choices' => $arrChoicesCodEstrutural,
                                'attr' => [
                                    'class' => 'select2-parameters '
                                ],
                                'expanded' => false,
                                'auto_initialize' => false,
                            ]
                        );
                    $form->add($comCodEstrutural);
                }
            }
        );
    }
}
