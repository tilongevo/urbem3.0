<?php
namespace Urbem\CoreBundle\Model\Arrecadacao;

use Doctrine\ORM;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery;
use Symfony\Component\Config\Definition\Exception\Exception;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoCalculo;
use Urbem\CoreBundle\Entity\Arrecadacao\CadastroEconomicoFaturamento;
use Urbem\CoreBundle\Entity\Arrecadacao\Calculo;
use Urbem\CoreBundle\Entity\Arrecadacao\CalculoCgm;
use Urbem\CoreBundle\Entity\Arrecadacao\CalculoGrupoCredito;
use Urbem\CoreBundle\Entity\Arrecadacao\Carne;
use Urbem\CoreBundle\Entity\Arrecadacao\GrupoCredito;
use Urbem\CoreBundle\Entity\Arrecadacao\ImovelCalculo;
use Urbem\CoreBundle\Entity\Arrecadacao\ImovelVVenal;
use Urbem\CoreBundle\Entity\Arrecadacao\Lancamento;
use Urbem\CoreBundle\Entity\Arrecadacao\LancamentoCalculo;
use Urbem\CoreBundle\Entity\Arrecadacao\LancamentoProcesso;
use Urbem\CoreBundle\Entity\Arrecadacao\Parcela;
use Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDesconto;
use Urbem\CoreBundle\Entity\Economico\CadastroEconomico;
use Urbem\CoreBundle\Entity\Imobiliario\Imovel;
use Urbem\CoreBundle\Entity\Imobiliario\Proprietario;
use Urbem\CoreBundle\Entity\Monetario\Credito;
use Urbem\CoreBundle\Entity\SwCgm;
use Urbem\TributarioBundle\Resources\config\Sonata\Arrecadacao\EfetuarLancamentoManualAdmin;

class LancamentoModel extends AbstractModel
{
    protected $entityManager = null;
    protected $repository = null;
    protected $tipoCalculo = null;

    /**
     * MapaCotacaoModel constructor.
     * @param ORM\EntityManager $entityManager
     */
    public function __construct(ORM\EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository(
            Lancamento::class
        );
    }

    /**
     * @param ProxyQuery $proxyQuery
     * @param $exercicio
     * @return ProxyQuery
     */
    public function getArrecadacao(ProxyQuery $proxyQuery, $params)
    {
        $cgm = $params['cgm']['value'] ? :null;
        $exercicio = '';
        if (!empty($params['fkArrecadacaoLancamentoCalculos__fkArrecadacaoCalculo__exercicio'])) {
            $exercicio = $params['fkArrecadacaoLancamentoCalculos__fkArrecadacaoCalculo__exercicio']['value'];
        }

        $cadastroEconomico = null;
        if (!empty($params['fkArrecadacaoLancamentoCalculos__fkArrecadacaoCalculo__fkArrecadacaoCadastroEconomicoCalculo__inscricaoEconomica'])) {
            $cadastroEconomico = $params['fkArrecadacaoLancamentoCalculos__fkArrecadacaoCalculo__fkArrecadacaoCadastroEconomicoCalculo__inscricaoEconomica']['value'];
        }

        $inscricaoImobiliaria = null;
        if (!empty($params['fkArrecadacaoLancamentoCalculos__fkArrecadacaoCalculo__fkArrecadacaoImovelCalculo__inscricaoMunicipal'])) {
            $inscricaoImobiliaria = $params['fkArrecadacaoLancamentoCalculos__fkArrecadacaoCalculo__fkArrecadacaoImovelCalculo__inscricaoMunicipal']['value'];
        }

        $numeracao = '';
        if (!empty($params['fkArrecadacaoLancamentoCalculos__fkArrecadacaoCalculo__fkArrecadacaoPagamentoCalculos__numeracao'])) {
            $numeracao = $params['fkArrecadacaoLancamentoCalculos__fkArrecadacaoCalculo__fkArrecadacaoPagamentoCalculos__numeracao']['value'];
        }

        $arrecadacao = $this->repository->getArrecadacao($cgm, $exercicio, $cadastroEconomico, $inscricaoImobiliaria, $numeracao);

        $ids = [0];

        foreach ((array) $arrecadacao as $lancamento) {
            if ($lancamento['cod_lancamento']) {
                $ids[] = $lancamento['cod_lancamento'];
            }
            if ($lancamento['tipo_calculo']) {
                $this->tipoCalculo = $lancamento['tipo_calculo'];
            }
        }

        $aliases = $proxyQuery->getRootAliases();

        $proxyQuery->andWhere(
            $proxyQuery->expr()->in("{$aliases[0]}.codLancamento", $ids)
        );

        return $proxyQuery;
    }

    /**
     * @param $inscricao
     * @return mixed
     */
    public function getArrecadacaoByInscricao($inscricao)
    {
        $res = $this->entityManager->getRepository(Lancamento::class)
            ->getArrecadacao(null, null, null, $inscricao, null);

        return $res;
    }

    /**
     * @param $lancamento
     * @return mixed
     */
    public function getListaCreditos(Lancamento $lancamento)
    {
        $res = $this->entityManager->getRepository(Lancamento::class)
            ->getListaCreditos($lancamento);

        return $res;
    }

    /**
     * @param $lancamento
     * @return mixed
     */
    public function getContribuinte(Lancamento $lancamento)
    {
        $res = $this->entityManager->getRepository(Lancamento::class)
            ->getContribuinte($lancamento);

        $res = array_shift($res);

        return ($this->getCgm($lancamento) .' - '. $res['buscacontribuintelancamento']);
    }

    /**
     * @param $lancamento
     * @return mixed
     */
    protected function getCgm(Lancamento $lancamento)
    {
        $res = $this->entityManager->getRepository(Lancamento::class)
            ->getCgm($lancamento);

        $res = array_shift($res);

        return $res['buscacgmlancamento'];
    }


    /**
     * @param $lancamento
     * @return mixed
     */
    public function getSituacao(Lancamento $lancamento)
    {
        $res = $this->entityManager->getRepository(Lancamento::class)
            ->getSituacao($lancamento);

        $res = array_shift($res);

        return $res['fn_busca_lancamento_situacao'];
    }

    /**
     * @param $lancamento
     * @return mixed
     */
    public function getOrigemCobranca(Lancamento $lancamento)
    {
        $res = $this->entityManager->getRepository(Lancamento::class)
            ->getOrigemCobranca($lancamento);

        $res = array_shift($res);

        return $res['fn_busca_origem_lancamento_sem_exercicio'];
    }

    /**
     * @param $inscricao
     * @param $type
     * @return array
     */
    public function getEndereco($inscricao, $type)
    {
        if ($type == 'Municipal') {
            $inscricao = $this->entityManager->getRepository(Lancamento::class)
                ->getEnderecoByInscricaoMunicipal($inscricao);

             $inscricao = array_shift($inscricao);

            return $inscricao['fn_consulta_endereco_imovel'];
        }

        if ($type == 'Economica') {
            $inscricao = $this->entityManager->getRepository(Lancamento::class)
                ->getEnderecoByInscricaoEconomica($inscricao);

            $inscricao = array_shift($inscricao);

            return $inscricao['fn_consulta_endereco_empresa'];
        }

        return;
    }

    /**
     * @param $param
     * @return array
     */
    public function getListaParcelas($param)
    {
        $listaParcelas = $this->entityManager->getRepository(Lancamento::class)
            ->getListaParcelas($param);

        return $listaParcelas;
    }

    /**
     * @param $codLancamento
     * @param $numeracao
     * @param $ocorrenciaPagamento
     * @param $codParcela
     * @return array
     */
    public function getDetalheParcela($codLancamento, $numeracao, $ocorrenciaPagamento, $codParcela)
    {
        $detalheParcela = $this->entityManager->getRepository(Lancamento::class)
            ->getDetalheParcela($codLancamento, $numeracao, $ocorrenciaPagamento, $codParcela);

        return $detalheParcela;
    }

    /**
     * @param $inscricaoMunicipal
     * @param $lancamento
     * @return array
     */
    public function getUltimoVenal($inscricaoMunicipal, $lancamento)
    {
        $ultimoVenal = $this->entityManager->getRepository(Lancamento::class)
            ->getUltimoVenal($inscricaoMunicipal, $lancamento);

        return $ultimoVenal;
    }

    /**
     * @param $inscricaoMunicipal
     * @param $data
     * @return array
     */
    public function getSituacaoImovel($inscricaoMunicipal, $data)
    {
        $situacao = $this->entityManager->getRepository(Lancamento::class)
            ->getSituacaoImovel($inscricaoMunicipal, $data);

        return $situacao;
    }

    /**
     * @param $inscricaoEconomica
     * @return array
     */
    public function getLancamentoByInscricaoEconomica($inscricaoEconomica)
    {
        $lancamento = $this->entityManager->getRepository(Lancamento::class)
            ->getLancamentoByInscricaoEconomica($inscricaoEconomica);

        return $lancamento;
    }

    /**
     * @param $codLancamento
     * @return array
     */
    public function getOrigemFormated($codLancamento)
    {
        $origemFormated = $this->entityManager->getRepository(Lancamento::class)
            ->getOrigemFormated($codLancamento);

        return $origemFormated;
    }

    /**
     * @param Lancamento $lancamento
     * @param $form
     * @param $request
     */
    public function salvarLancamento(Lancamento $lancamento, $form, $request)
    {
        if (!$form->get('lancamentoManualDe')->getData()) {
            $this->salvarLancamentoCredito($lancamento, $form, $request);
        } else {
            $this->salvarLancamentoGrupoCredito($lancamento, $form, $request);
        }
    }

    /**
     * @param Lancamento $lancamento
     * @param $form
     * @param $request
     */
    public function salvarLancamentoCredito(Lancamento $lancamento, $form, $request)
    {
        $lancamento->setCodLancamento($this->getCodLancamento());

        $vencimentos = $request->get('vencimento');
        $tiposParcela = $request->get('tipo_parcela');
        $formasDesconto = $request->get('forma_desconto');
        $descontos = $request->get('desconto');
        $valor = $form->get('valor')->getData();
        $exercicio = $form->get('exercicio')->getData();
        $nroParcelas = 0;

        foreach ($vencimentos as $key => $vencimento) {
            if (!$lancamento->getVencimento()) {
                $lancamento->setVencimento($this->textToDate($vencimento));
            }
            $nroParcelas += (int) $tiposParcela[$key];
        }

        if ($nroParcelas) {
            $valorParcela = $valor / $nroParcelas;
        }

        /** @var Credito $credito */
        $credito = $form->get('fkMonetarioCredito')->getData();

        $codParcela = (new ParcelaModel($this->entityManager))->getCodParcela();

        $carneModel = new CarneModel($this->entityManager);
        $codConvenio = $carneModel->getCodConvenio($credito->getCodCredito(), $credito->getCodEspecie(), $credito->getCodGenero(), $credito->getCodNatureza());
        $codCarteira = $carneModel->getCodCarteira($codConvenio);
        $numeracao = (int) $carneModel->getNumeracao($codConvenio, $codCarteira);
        $nrParcela = 1;
        foreach ($descontos as $key => $desconto) {
            $carne = new Carne();
            $carne->setNumeracao((string) $numeracao);
            $carne->setExercicio($exercicio);
            $carne->setCodConvenio($codConvenio);
            $carne->setCodCarteira($codCarteira);

            $parcela = new Parcela();
            $parcela->setCodParcela($codParcela);
            $parcela->setVencimento($this->textToDate($vencimentos[$key]));
            if ((int) $tiposParcela[$key]) {
                $parcela->setValor($valorParcela);
                $parcela->setNrParcela($nrParcela);
                $nrParcela++;
            } else {
                $parcela->setValor($valor);
                $parcela->setNrParcela(0);
            }

            if ($this->convertTextToFloat($desconto)) {
                $parcelaDesconto = new ParcelaDesconto();
                if ((int) $formasDesconto[$key]) {
                    $valorDesconto = round(($parcela->getValor() - $this->convertTextToFloat($desconto)), 2);
                    $parcelaDesconto->setValor($valorDesconto);
                } else {
                    $valorDesconto = round(($parcela->getValor() - (($parcela->getValor() * $this->convertTextToFloat($desconto)) / 100)), 2);
                    $parcelaDesconto->setValor($valorDesconto);
                }
                $parcelaDesconto->setVencimento($parcela->getVencimento());

                $parcela->setFkArrecadacaoParcelaDesconto($parcelaDesconto);
            }
            $parcela->addFkArrecadacaoCarnes($carne);

            $lancamento->addFkArrecadacaoParcelas($parcela);
            $codParcela++;
            $numeracao++;
        }

        $lancamento->setTotalParcelas($nroParcelas);
        $lancamento->setAtivo(true);
        $lancamento->setValor($valor);

        // Processo
        if ($form->get('codProcesso')->getData()) {
            $lancamentoProcesso = new LancamentoProcesso();
            $lancamentoProcesso->setFkSwProcesso($form->get('codProcesso')->getData());
            $lancamento->addFkArrecadacaoLancamentoProcessos($lancamentoProcesso);
        }

        // Calculo
        $calculoModel = new CalculoModel($this->entityManager);
        $codCalculo = $calculoModel->getCodCalculo();

        $calculo = new Calculo();
        $calculo->setCodCalculo($codCalculo);
        $calculo->setAtivo(true);
        $calculo->setCalculado(false);
        $calculo->setNroParcelas($nroParcelas);
        $calculo->setValor($valor);
        $calculo->setFkMonetarioCredito($credito);
        $calculo->setExercicio($exercicio);

        /** @var SwCgm $swCgm */
        $swCgm = $form->get('fkSwCgm')->getData();
        if ($form->get('filtrarPor')->getData() == EfetuarLancamentoManualAdmin::REFERENCIA_INSCRICAO_ECONOMICA) {
            /** @var CadastroEconomico $cadastroEconomica */
            $cadastroEconomica = $form->get('fkEconomicoCadastroEconomico')->getData();

            /** @var CadastroEconomicoFaturamento $cadastroEconomicoFaturamento */
            $cadastroEconomicoFaturamento = $this->entityManager->getRepository(CadastroEconomicoFaturamento::class)->findOneBy([
                'inscricaoEconomica' => $cadastroEconomica->getInscricaoEconomica()
            ], ['timestamp' => 'DESC']);

            $cadastroEconomicoCalculo = new CadastroEconomicoCalculo();
            $cadastroEconomicoCalculo->setFkArrecadacaoCadastroEconomicoFaturamento($cadastroEconomicoFaturamento);
            $calculo->setFkArrecadacaoCadastroEconomicoCalculo($cadastroEconomicoCalculo);

            $numcgm = $calculoModel->getNumCgmByInscricaoEconomica($cadastroEconomica->getInscricaoEconomica());
            /** @var SwCgm $swCgm */
            $swCgm = $this->entityManager->getRepository(SwCgm::class)->find($numcgm);
        } elseif ($form->get('filtrarPor')->getData() == EfetuarLancamentoManualAdmin::REFERENCIA_INSCRICAO_IMOBILIARIA) {
            /** @var Imovel $imovel */
            $imovel = $form->get('fkImobiliarioImovel')->getData();

            /** @var ImovelVVenal $imovelVVenal */
            $imovelVVenal = $this->entityManager->getRepository(ImovelVVenal::class)->findOneBy([
                'inscricaoMunicipal' => $imovel->getInscricaoMunicipal()
            ], ['timestamp' => 'DESC']);

            if ($imovelVVenal) {
                $imovelCalculo = new ImovelCalculo();
                $imovelCalculo->setFkArrecadacaoImovelVVenal($imovelVVenal);
                $calculo->setFkArrecadacaoImovelCalculo($imovelCalculo);
            }

            /** @var Proprietario $proprietario */
            $proprietario = $this->entityManager->getRepository(Proprietario::class)->findOneBy([
                'inscricaoMunicipal' => $imovel->getInscricaoMunicipal(),
                'promitente' => false
            ], ['ordem' => 'ASC']);

            /** @var SwCgm $swCgm */
            $swCgm = $proprietario->getFkSwCgm();
        }

        $calculoCgm = new CalculoCgm();
        $calculoCgm->setFkSwCgm($swCgm);
        $calculo->addFkArrecadacaoCalculoCgns($calculoCgm);

        $lancamentoCalculo = new LancamentoCalculo();
        $lancamentoCalculo->setFkArrecadacaoCalculo($calculo);
        $lancamentoCalculo->setValor($valor);
        $lancamento->addFkArrecadacaoLancamentoCalculos($lancamentoCalculo);
    }

    /**
     * @param Lancamento $lancamento
     * @param $form
     * @param $request
     */
    public function salvarLancamentoGrupoCredito(Lancamento $lancamento, $form, $request)
    {
        $lancamento->setCodLancamento($this->getCodLancamento());

        /** @var GrupoCredito $grupoCredito */
        $grupoCredito = $form->get('fkArrecadacaoGrupoCredito')->getData();
        $exercicio = $grupoCredito->getAnoExercicio();

        $creditos = $request->get('credito');
        $valores = $request->get('valor');

        $valorTotal = 0;
        foreach ($valores as $key => $valor) {
            $valorTotal += $valor;
        }

        $vencimentos = $request->get('vencimento');
        $tiposParcela = $request->get('tipo_parcela');
        $formasDesconto = $request->get('forma_desconto');
        $descontos = $request->get('desconto');
        $nroParcelas = 0;

        foreach ($vencimentos as $key => $vencimento) {
            if (!$lancamento->getVencimento()) {
                $lancamento->setVencimento($this->textToDate($vencimento));
            }
            $nroParcelas += (int) $tiposParcela[$key];
        }

        if ($nroParcelas) {
            $valorParcela = $valorTotal / $nroParcelas;
        }

        // Calculo
        $calculoModel = new CalculoModel($this->entityManager);
        $codCalculo = $calculoModel->getCodCalculo();

        foreach ($creditos as $key => $codsCredito) {
            list($codCredito, $codGenero, $codEspecie, $codNatureza) = explode('~', $codsCredito);
            /** @var Credito $credito */
            $credito = $this->entityManager->getRepository(Credito::class)->findOneBy([
                'codCredito' => $codCredito,
                'codGenero' => $codGenero,
                'codEspecie' => $codEspecie,
                'codNatureza' => $codNatureza
            ]);

            $calculo = new Calculo();
            $calculo->setCodCalculo($codCalculo);
            $calculo->setAtivo(true);
            $calculo->setCalculado(false);
            $calculo->setNroParcelas($nroParcelas);
            $calculo->setValor($valores[$key]);
            $calculo->setFkMonetarioCredito($credito);
            $calculo->setExercicio($exercicio);

            /** @var SwCgm $swCgm */
            $swCgm = $form->get('fkSwCgm')->getData();
            if ($form->get('filtrarPor')->getData() == EfetuarLancamentoManualAdmin::REFERENCIA_INSCRICAO_ECONOMICA) {
                /** @var CadastroEconomico $cadastroEconomica */
                $cadastroEconomica = $form->get('fkEconomicoCadastroEconomico')->getData();

                /** @var CadastroEconomicoFaturamento $cadastroEconomicoFaturamento */
                $cadastroEconomicoFaturamento = $this->entityManager->getRepository(CadastroEconomicoFaturamento::class)->findOneBy([
                    'inscricaoEconomica' => $cadastroEconomica->getInscricaoEconomica()
                ], ['timestamp' => 'DESC']);

                $cadastroEconomicoCalculo = new CadastroEconomicoCalculo();
                $cadastroEconomicoCalculo->setFkArrecadacaoCadastroEconomicoFaturamento($cadastroEconomicoFaturamento);
                $calculo->setFkArrecadacaoCadastroEconomicoCalculo($cadastroEconomicoCalculo);

                $numcgm = $calculoModel->getNumCgmByInscricaoEconomica($cadastroEconomica->getInscricaoEconomica());
                /** @var SwCgm $swCgm */
                $swCgm = $this->entityManager->getRepository(SwCgm::class)->find($numcgm);
            } elseif ($form->get('filtrarPor')->getData() == EfetuarLancamentoManualAdmin::REFERENCIA_INSCRICAO_IMOBILIARIA) {
                /** @var Imovel $imovel */
                $imovel = $form->get('fkImobiliarioImovel')->getData();

                /** @var ImovelVVenal $imovelVVenal */
                $imovelVVenal = $this->entityManager->getRepository(ImovelVVenal::class)->findOneBy([
                    'inscricaoMunicipal' => $imovel->getInscricaoMunicipal()
                ], ['timestamp' => 'DESC']);

                if ($imovelVVenal) {
                    $imovelCalculo = new ImovelCalculo();
                    $imovelCalculo->setFkArrecadacaoImovelVVenal($imovelVVenal);
                    $calculo->setFkArrecadacaoImovelCalculo($imovelCalculo);
                }

                /** @var Proprietario $proprietario */
                $proprietario = $this->entityManager->getRepository(Proprietario::class)->findOneBy([
                    'inscricaoMunicipal' => $imovel->getInscricaoMunicipal(),
                    'promitente' => false
                ], ['ordem' => 'ASC']);

                /** @var SwCgm $swCgm */
                $swCgm = $proprietario->getFkSwCgm();
            }

            $calculoCgm = new CalculoCgm();
            $calculoCgm->setFkSwCgm($swCgm);
            $calculo->addFkArrecadacaoCalculoCgns($calculoCgm);

            $calculoGrupoCredito = new CalculoGrupoCredito();
            $calculoGrupoCredito->setFkArrecadacaoGrupoCredito($grupoCredito);
            $calculo->setFkArrecadacaoCalculoGrupoCredito($calculoGrupoCredito);

            $lancamentoCalculo = new LancamentoCalculo();
            $lancamentoCalculo->setFkArrecadacaoCalculo($calculo);
            $lancamentoCalculo->setValor($valores[$key]);
            $lancamento->addFkArrecadacaoLancamentoCalculos($lancamentoCalculo);
            $codCalculo++;
        }

        $codParcela = (new ParcelaModel($this->entityManager))->getCodParcela();

        $carneModel = new CarneModel($this->entityManager);
        $codConvenio = $carneModel->getCodConvenio($credito->getCodCredito(), $credito->getCodEspecie(), $credito->getCodGenero(), $credito->getCodNatureza());
        $codCarteira = $carneModel->getCodCarteira($codConvenio);
        $numeracao = (int) $carneModel->getNumeracao($codConvenio, $codCarteira);
        $nrParcela = 1;
        foreach ($descontos as $key => $desconto) {
            $carne = new Carne();
            $carne->setNumeracao((string) $numeracao);
            $carne->setExercicio($exercicio);
            $carne->setCodConvenio($codConvenio);
            $carne->setCodCarteira($codCarteira);

            $parcela = new Parcela();
            $parcela->setCodParcela($codParcela);
            $parcela->setVencimento($this->textToDate($vencimentos[$key]));
            if ((int) $tiposParcela[$key]) {
                $parcela->setValor($valorParcela);
                $parcela->setNrParcela($nrParcela);
                $nrParcela++;
            } else {
                $parcela->setValor($valorTotal);
                $parcela->setNrParcela(0);
            }

            if ($this->convertTextToFloat($desconto)) {
                $parcelaDesconto = new ParcelaDesconto();
                if ((int) $formasDesconto[$key]) {
                    $valorDesconto = round(($parcela->getValor() - $this->convertTextToFloat($desconto)), 2);
                    $parcelaDesconto->setValor($valorDesconto);
                } else {
                    $valorDesconto = round(($parcela->getValor() - (($parcela->getValor() * $this->convertTextToFloat($desconto)) / 100)), 2);
                    $parcelaDesconto->setValor($valorDesconto);
                }
                $parcelaDesconto->setVencimento($parcela->getVencimento());

                $parcela->setFkArrecadacaoParcelaDesconto($parcelaDesconto);
            }
            $parcela->addFkArrecadacaoCarnes($carne);

            $lancamento->addFkArrecadacaoParcelas($parcela);
            $codParcela++;
            $numeracao++;
        }

        $lancamento->setTotalParcelas($nroParcelas);
        $lancamento->setAtivo(true);
        $lancamento->setValor($valorTotal);

        // Processo
        if ($form->get('codProcesso')->getData()) {
            $lancamentoProcesso = new LancamentoProcesso();
            $lancamentoProcesso->setFkSwProcesso($form->get('codProcesso')->getData());
            $lancamento->addFkArrecadacaoLancamentoProcessos($lancamentoProcesso);
        }
    }

    /**
     * @param $date
     * @return \DateTime
     */
    public function textToDate($date)
    {
        list($day, $month, $year) = explode('/', $date);
        return new \DateTime(sprintf('%s-%s-%s', $year, $month, $day));
    }

    /**
     * @param $valor
     * @return float
     */
    public function convertTextToFloat($valor)
    {
        $valor = str_replace('.', '', $valor);
        $valor = str_replace(',', '.', $valor);
        return (float) $valor;
    }

    /**
     * @return integer
     */
    public function getCodLancamento()
    {
        return $this->repository->getNextVal();
    }

    /**
     * @param $codGrupo
     * @param $anoExercicio
     * @return array
     */
    public function getCreditosByGrupoCreditos($codGrupo, $anoExercicio)
    {
        return $this->repository->getCreditosByGrupoCreditos($codGrupo, $anoExercicio);
    }
}
