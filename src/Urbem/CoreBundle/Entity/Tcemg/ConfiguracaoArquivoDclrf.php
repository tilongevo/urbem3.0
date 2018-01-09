<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;
use Urbem\CoreBundle\Entity\Entity;

/**
 * ConfiguracaoArquivoDclrf
 */
class ConfiguracaoArquivoDclrf extends Entity
{
    const VALOR_SALDO_ATUAL_CONCESSOES_GARANTIA = "valorSaldoAtualConcessoesGarantia";
    const VALOR_SALDO_ATUAL_CONCESSOES_GARANTIA_INTERNA = "valorSaldoAtualConcessoesGarantiaInterna";
    const VALOR_SALDO_ATUAL_CONTRA_CONCESSOES_GARANTIA_INTERNA = "valorSaldoAtualContraConcessoesGarantiaInterna";
    const VALOR_SALDO_ATUAL_CONTRA_CONCESSOES_GARANTIA_EXTERNA = "valorSaldoAtualContraConcessoesGarantiaExterna";
    const RECEITA_PRIVATIZACAO = "receitaPrivatizacao";
    const VALOR_LIQUIDADO_INCENTIVO_CONTRIBUINTE = "valorLiquidadoIncentivoContribuinte";
    const VALOR_LIQUIDADO_INCENTIVO_INSTITUICAO_FINANCEIRA = "valorLiquidadoIncentivoInstituicaoFinanceira";
    const VALOR_INSCRITO_RPNP_INCENTIVO_CONTRIBUINTE = "valorInscritoRpnpIncentivoContribuinte";
    const VALOR_INSCRITO_RPNP_INCENTIVO_INSTITUICAO_FINANCEIRA = "valorInscritoRpnpIncentivoInstituicaoFinanceira";
    const VALOR_COMPROMISSADO = "valorCompromissado";
    const VALOR_RECURSOS_NAO_APLICADOS = "valorRecursosNaoAplicados";
    const MEDIDAS_CORRETIVAS = "medidasCorretivas";
    const PUBLICACAO_RELATORIO_LRF = "publicacaoRelatorioLrf";
    const DT_PUBLICACAO_RELATORIO_LRF = "dtPublicacaoRelatorioLrf";
    const BIMESTRE = "bimestre";
    const META_BIMESTRAL = "metaBimestral";
    const MEDIDA_ADOTADA = "medidaAdotada";

    /**
     * @var array
     */
    private static $mappingCurrency = [
        self::VALOR_SALDO_ATUAL_CONCESSOES_GARANTIA,
        self::VALOR_SALDO_ATUAL_CONCESSOES_GARANTIA_INTERNA,
        self::VALOR_SALDO_ATUAL_CONTRA_CONCESSOES_GARANTIA_INTERNA,
        self::VALOR_SALDO_ATUAL_CONTRA_CONCESSOES_GARANTIA_EXTERNA,
        self::RECEITA_PRIVATIZACAO,
        self::VALOR_LIQUIDADO_INCENTIVO_CONTRIBUINTE,
        self::VALOR_LIQUIDADO_INCENTIVO_INSTITUICAO_FINANCEIRA,
        self::VALOR_INSCRITO_RPNP_INCENTIVO_CONTRIBUINTE,
        self::VALOR_INSCRITO_RPNP_INCENTIVO_INSTITUICAO_FINANCEIRA,
        self::VALOR_COMPROMISSADO,
        self::VALOR_RECURSOS_NAO_APLICADOS,
    ];

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $mesReferencia;

    /**
     * @var integer
     */
    private $valorSaldoAtualConcessoesGarantia;

    /**
     * @var integer
     */
    private $receitaPrivatizacao;

    /**
     * @var integer
     */
    private $valorLiquidadoIncentivoContribuinte;

    /**
     * @var integer
     */
    private $valorLiquidadoIncentivoInstituicaoFinanceira;

    /**
     * @var integer
     */
    private $valorInscritoRpnpIncentivoContribuinte;

    /**
     * @var integer
     */
    private $valorInscritoRpnpIncentivoInstituicaoFinanceira;

    /**
     * @var integer
     */
    private $valorCompromissado;

    /**
     * @var integer
     */
    private $valorRecursosNaoAplicados;

    /**
     * @var integer
     */
    private $publicacaoRelatorioLrf;

    /**
     * @var \DateTime
     */
    private $dtPublicacaoRelatorioLrf;

    /**
     * @var integer
     */
    private $bimestre;

    /**
     * @var integer
     */
    private $metaBimestral;

    /**
     * @var string
     */
    private $medidaAdotada;

    /**
     * @var integer
     */
    private $contOpCredito;

    /**
     * @var string
     */
    private $descContOpCredito;

    /**
     * @var integer
     */
    private $realizOpCredito;

    /**
     * @var integer
     */
    private $tipoRealizOpCreditoCapta;

    /**
     * @var integer
     */
    private $tipoRealizOpCreditoReceb;

    /**
     * @var integer
     */
    private $tipoRealizOpCreditoAssunDir;

    /**
     * @var integer
     */
    private $tipoRealizOpCreditoAssunObg;

    /**
     * @var integer
     */
    private $valorSaldoAtualConcessoesGarantiaInterna;

    /**
     * @var integer
     */
    private $valorSaldoAtualContraConcessoesGarantiaInterna;

    /**
     * @var integer
     */
    private $valorSaldoAtualContraConcessoesGarantiaExterna;

    /**
     * @var string
     */
    private $medidasCorretivas;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return ConfiguracaoArquivoDclrf
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set mesReferencia
     *
     * @param integer $mesReferencia
     * @return ConfiguracaoArquivoDclrf
     */
    public function setMesReferencia($mesReferencia)
    {
        $this->mesReferencia = $mesReferencia;
        return $this;
    }

    /**
     * Get mesReferencia
     *
     * @return integer
     */
    public function getMesReferencia()
    {
        return $this->mesReferencia;
    }

    /**
     * Set valorSaldoAtualConcessoesGarantia
     *
     * @param integer $valorSaldoAtualConcessoesGarantia
     * @return ConfiguracaoArquivoDclrf
     */
    public function setValorSaldoAtualConcessoesGarantia($valorSaldoAtualConcessoesGarantia = null)
    {
        $this->valorSaldoAtualConcessoesGarantia = $valorSaldoAtualConcessoesGarantia;
        return $this;
    }

    /**
     * Get valorSaldoAtualConcessoesGarantia
     *
     * @return integer
     */
    public function getValorSaldoAtualConcessoesGarantia()
    {
        return $this->valorSaldoAtualConcessoesGarantia;
    }

    /**
     * Set receitaPrivatizacao
     *
     * @param integer $receitaPrivatizacao
     * @return ConfiguracaoArquivoDclrf
     */
    public function setReceitaPrivatizacao($receitaPrivatizacao = null)
    {
        $this->receitaPrivatizacao = $receitaPrivatizacao;
        return $this;
    }

    /**
     * Get receitaPrivatizacao
     *
     * @return integer
     */
    public function getReceitaPrivatizacao()
    {
        return $this->receitaPrivatizacao;
    }

    /**
     * Set valorLiquidadoIncentivoContribuinte
     *
     * @param integer $valorLiquidadoIncentivoContribuinte
     * @return ConfiguracaoArquivoDclrf
     */
    public function setValorLiquidadoIncentivoContribuinte($valorLiquidadoIncentivoContribuinte = null)
    {
        $this->valorLiquidadoIncentivoContribuinte = $valorLiquidadoIncentivoContribuinte;
        return $this;
    }

    /**
     * Get valorLiquidadoIncentivoContribuinte
     *
     * @return integer
     */
    public function getValorLiquidadoIncentivoContribuinte()
    {
        return $this->valorLiquidadoIncentivoContribuinte;
    }

    /**
     * Set valorLiquidadoIncentivoInstituicaoFinanceira
     *
     * @param integer $valorLiquidadoIncentivoInstituicaoFinanceira
     * @return ConfiguracaoArquivoDclrf
     */
    public function setValorLiquidadoIncentivoInstituicaoFinanceira($valorLiquidadoIncentivoInstituicaoFinanceira = null)
    {
        $this->valorLiquidadoIncentivoInstituicaoFinanceira = $valorLiquidadoIncentivoInstituicaoFinanceira;
        return $this;
    }

    /**
     * Get valorLiquidadoIncentivoInstituicaoFinanceira
     *
     * @return integer
     */
    public function getValorLiquidadoIncentivoInstituicaoFinanceira()
    {
        return $this->valorLiquidadoIncentivoInstituicaoFinanceira;
    }

    /**
     * Set valorInscritoRpnpIncentivoContribuinte
     *
     * @param integer $valorInscritoRpnpIncentivoContribuinte
     * @return ConfiguracaoArquivoDclrf
     */
    public function setValorInscritoRpnpIncentivoContribuinte($valorInscritoRpnpIncentivoContribuinte = null)
    {
        $this->valorInscritoRpnpIncentivoContribuinte = $valorInscritoRpnpIncentivoContribuinte;
        return $this;
    }

    /**
     * Get valorInscritoRpnpIncentivoContribuinte
     *
     * @return integer
     */
    public function getValorInscritoRpnpIncentivoContribuinte()
    {
        return $this->valorInscritoRpnpIncentivoContribuinte;
    }

    /**
     * Set valorInscritoRpnpIncentivoInstituicaoFinanceira
     *
     * @param integer $valorInscritoRpnpIncentivoInstituicaoFinanceira
     * @return ConfiguracaoArquivoDclrf
     */
    public function setValorInscritoRpnpIncentivoInstituicaoFinanceira($valorInscritoRpnpIncentivoInstituicaoFinanceira = null)
    {
        $this->valorInscritoRpnpIncentivoInstituicaoFinanceira = $valorInscritoRpnpIncentivoInstituicaoFinanceira;
        return $this;
    }

    /**
     * Get valorInscritoRpnpIncentivoInstituicaoFinanceira
     *
     * @return integer
     */
    public function getValorInscritoRpnpIncentivoInstituicaoFinanceira()
    {
        return $this->valorInscritoRpnpIncentivoInstituicaoFinanceira;
    }

    /**
     * Set valorCompromissado
     *
     * @param integer $valorCompromissado
     * @return ConfiguracaoArquivoDclrf
     */
    public function setValorCompromissado($valorCompromissado = null)
    {
        $this->valorCompromissado = $valorCompromissado;
        return $this;
    }

    /**
     * Get valorCompromissado
     *
     * @return integer
     */
    public function getValorCompromissado()
    {
        return $this->valorCompromissado;
    }

    /**
     * Set valorRecursosNaoAplicados
     *
     * @param integer $valorRecursosNaoAplicados
     * @return ConfiguracaoArquivoDclrf
     */
    public function setValorRecursosNaoAplicados($valorRecursosNaoAplicados = null)
    {
        $this->valorRecursosNaoAplicados = $valorRecursosNaoAplicados;
        return $this;
    }

    /**
     * Get valorRecursosNaoAplicados
     *
     * @return integer
     */
    public function getValorRecursosNaoAplicados()
    {
        return $this->valorRecursosNaoAplicados;
    }

    /**
     * Set publicacaoRelatorioLrf
     *
     * @param integer $publicacaoRelatorioLrf
     * @return ConfiguracaoArquivoDclrf
     */
    public function setPublicacaoRelatorioLrf($publicacaoRelatorioLrf = null)
    {
        $this->publicacaoRelatorioLrf = $publicacaoRelatorioLrf;
        return $this;
    }

    /**
     * Get publicacaoRelatorioLrf
     *
     * @return integer
     */
    public function getPublicacaoRelatorioLrf()
    {
        return $this->publicacaoRelatorioLrf;
    }

    /**
     * Set dtPublicacaoRelatorioLrf
     *
     * @param \DateTime $dtPublicacaoRelatorioLrf
     * @return ConfiguracaoArquivoDclrf
     */
    public function setDtPublicacaoRelatorioLrf(\DateTime $dtPublicacaoRelatorioLrf = null)
    {
        $this->dtPublicacaoRelatorioLrf = $dtPublicacaoRelatorioLrf;
        return $this;
    }

    /**
     * Get dtPublicacaoRelatorioLrf
     *
     * @return \DateTime
     */
    public function getDtPublicacaoRelatorioLrf()
    {
        return $this->dtPublicacaoRelatorioLrf;
    }

    /**
     * Set bimestre
     *
     * @param integer $bimestre
     * @return ConfiguracaoArquivoDclrf
     */
    public function setBimestre($bimestre = null)
    {
        $this->bimestre = $bimestre;
        return $this;
    }

    /**
     * Get bimestre
     *
     * @return integer
     */
    public function getBimestre()
    {
        return $this->bimestre;
    }

    /**
     * Set metaBimestral
     *
     * @param integer $metaBimestral
     * @return ConfiguracaoArquivoDclrf
     */
    public function setMetaBimestral($metaBimestral = null)
    {
        $this->metaBimestral = $metaBimestral;
        return $this;
    }

    /**
     * Get metaBimestral
     *
     * @return integer
     */
    public function getMetaBimestral()
    {
        return $this->metaBimestral;
    }

    /**
     * Set medidaAdotada
     *
     * @param string $medidaAdotada
     * @return ConfiguracaoArquivoDclrf
     */
    public function setMedidaAdotada($medidaAdotada = null)
    {
        $this->medidaAdotada = $medidaAdotada;
        return $this;
    }

    /**
     * Get medidaAdotada
     *
     * @return string
     */
    public function getMedidaAdotada()
    {
        return $this->medidaAdotada;
    }

    /**
     * Set contOpCredito
     *
     * @param integer $contOpCredito
     * @return ConfiguracaoArquivoDclrf
     */
    public function setContOpCredito($contOpCredito = null)
    {
        $this->contOpCredito = $contOpCredito;
        return $this;
    }

    /**
     * Get contOpCredito
     *
     * @return integer
     */
    public function getContOpCredito()
    {
        return $this->contOpCredito;
    }

    /**
     * Set descContOpCredito
     *
     * @param string $descContOpCredito
     * @return ConfiguracaoArquivoDclrf
     */
    public function setDescContOpCredito($descContOpCredito = null)
    {
        $this->descContOpCredito = $descContOpCredito;
        return $this;
    }

    /**
     * Get descContOpCredito
     *
     * @return string
     */
    public function getDescContOpCredito()
    {
        return $this->descContOpCredito;
    }

    /**
     * Set realizOpCredito
     *
     * @param integer $realizOpCredito
     * @return ConfiguracaoArquivoDclrf
     */
    public function setRealizOpCredito($realizOpCredito = null)
    {
        $this->realizOpCredito = $realizOpCredito;
        return $this;
    }

    /**
     * Get realizOpCredito
     *
     * @return integer
     */
    public function getRealizOpCredito()
    {
        return $this->realizOpCredito;
    }

    /**
     * Set tipoRealizOpCreditoCapta
     *
     * @param integer $tipoRealizOpCreditoCapta
     * @return ConfiguracaoArquivoDclrf
     */
    public function setTipoRealizOpCreditoCapta($tipoRealizOpCreditoCapta = null)
    {
        $this->tipoRealizOpCreditoCapta = $tipoRealizOpCreditoCapta;
        return $this;
    }

    /**
     * Get tipoRealizOpCreditoCapta
     *
     * @return integer
     */
    public function getTipoRealizOpCreditoCapta()
    {
        return $this->tipoRealizOpCreditoCapta;
    }

    /**
     * Set tipoRealizOpCreditoReceb
     *
     * @param integer $tipoRealizOpCreditoReceb
     * @return ConfiguracaoArquivoDclrf
     */
    public function setTipoRealizOpCreditoReceb($tipoRealizOpCreditoReceb = null)
    {
        $this->tipoRealizOpCreditoReceb = $tipoRealizOpCreditoReceb;
        return $this;
    }

    /**
     * Get tipoRealizOpCreditoReceb
     *
     * @return integer
     */
    public function getTipoRealizOpCreditoReceb()
    {
        return $this->tipoRealizOpCreditoReceb;
    }

    /**
     * Set tipoRealizOpCreditoAssunDir
     *
     * @param integer $tipoRealizOpCreditoAssunDir
     * @return ConfiguracaoArquivoDclrf
     */
    public function setTipoRealizOpCreditoAssunDir($tipoRealizOpCreditoAssunDir = null)
    {
        $this->tipoRealizOpCreditoAssunDir = $tipoRealizOpCreditoAssunDir;
        return $this;
    }

    /**
     * Get tipoRealizOpCreditoAssunDir
     *
     * @return integer
     */
    public function getTipoRealizOpCreditoAssunDir()
    {
        return $this->tipoRealizOpCreditoAssunDir;
    }

    /**
     * Set tipoRealizOpCreditoAssunObg
     *
     * @param integer $tipoRealizOpCreditoAssunObg
     * @return ConfiguracaoArquivoDclrf
     */
    public function setTipoRealizOpCreditoAssunObg($tipoRealizOpCreditoAssunObg = null)
    {
        $this->tipoRealizOpCreditoAssunObg = $tipoRealizOpCreditoAssunObg;
        return $this;
    }

    /**
     * Get tipoRealizOpCreditoAssunObg
     *
     * @return integer
     */
    public function getTipoRealizOpCreditoAssunObg()
    {
        return $this->tipoRealizOpCreditoAssunObg;
    }

    /**
     * Set valorSaldoAtualConcessoesGarantiaInterna
     *
     * @param integer $valorSaldoAtualConcessoesGarantiaInterna
     * @return ConfiguracaoArquivoDclrf
     */
    public function setValorSaldoAtualConcessoesGarantiaInterna($valorSaldoAtualConcessoesGarantiaInterna = null)
    {
        $this->valorSaldoAtualConcessoesGarantiaInterna = $valorSaldoAtualConcessoesGarantiaInterna;
        return $this;
    }

    /**
     * Get valorSaldoAtualConcessoesGarantiaInterna
     *
     * @return integer
     */
    public function getValorSaldoAtualConcessoesGarantiaInterna()
    {
        return $this->valorSaldoAtualConcessoesGarantiaInterna;
    }

    /**
     * Set valorSaldoAtualContraConcessoesGarantiaInterna
     *
     * @param integer $valorSaldoAtualContraConcessoesGarantiaInterna
     * @return ConfiguracaoArquivoDclrf
     */
    public function setValorSaldoAtualContraConcessoesGarantiaInterna($valorSaldoAtualContraConcessoesGarantiaInterna = null)
    {
        $this->valorSaldoAtualContraConcessoesGarantiaInterna = $valorSaldoAtualContraConcessoesGarantiaInterna;
        return $this;
    }

    /**
     * Get valorSaldoAtualContraConcessoesGarantiaInterna
     *
     * @return integer
     */
    public function getValorSaldoAtualContraConcessoesGarantiaInterna()
    {
        return $this->valorSaldoAtualContraConcessoesGarantiaInterna;
    }

    /**
     * Set valorSaldoAtualContraConcessoesGarantiaExterna
     *
     * @param integer $valorSaldoAtualContraConcessoesGarantiaExterna
     * @return ConfiguracaoArquivoDclrf
     */
    public function setValorSaldoAtualContraConcessoesGarantiaExterna($valorSaldoAtualContraConcessoesGarantiaExterna = null)
    {
        $this->valorSaldoAtualContraConcessoesGarantiaExterna = $valorSaldoAtualContraConcessoesGarantiaExterna;
        return $this;
    }

    /**
     * Get valorSaldoAtualContraConcessoesGarantiaExterna
     *
     * @return integer
     */
    public function getValorSaldoAtualContraConcessoesGarantiaExterna()
    {
        return $this->valorSaldoAtualContraConcessoesGarantiaExterna;
    }

    /**
     * Set medidasCorretivas
     *
     * @param string $medidasCorretivas
     * @return ConfiguracaoArquivoDclrf
     */
    public function setMedidasCorretivas($medidasCorretivas = null)
    {
        $this->medidasCorretivas = $medidasCorretivas;
        return $this;
    }

    /**
     * Get medidasCorretivas
     *
     * @return string
     */
    public function getMedidasCorretivas()
    {
        return $this->medidasCorretivas;
    }

    /**
     * @param string $field
     * @return bool
     */
    public static function isCurrency($field)
    {
        return in_array($field, self::$mappingCurrency);
    }
}
