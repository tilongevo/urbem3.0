<?php
 
namespace Urbem\CoreBundle\Entity\Tcemg;

use Urbem\CoreBundle\Entity\Entity;

/**
 * MetasFiscais
 */
class MetasFiscais extends Entity
{
    const VALOR_CORRENTE_RECEITA_TOTAL = "valorCorrenteReceitaTotal";
    const VALOR_CORRENTE_RECEITA_PRIMARIA = "valorCorrenteReceitaPrimaria";
    const VALOR_CORRENTE_DESPESA_TOTAL = "valorCorrenteDespesaTotal";
    const VALOR_CORRENTE_DESPESA_PRIMARIA = "valorCorrenteDespesaPrimaria";
    const VALOR_CORRENTE_RESULTADO_PRIMARIO = "valorCorrenteResultadoPrimario";
    const VALOR_CORRENTE_RESULTADO_NOMINAL = "valorCorrenteResultadoNominal";
    const VALOR_CORRENTE_DIVIDA_PUBLICA_CONSOLIDADA = "valorCorrenteDividaPublicaConsolidada";
    const VALOR_CORRENTE_DIVIDA_CONSOLIDADA_LIQUIDA = "valorCorrenteDividaConsolidadaLiquida";
    const VALOR_CORRENTE_RECEITA_PRIMARIA_ADV = "valorCorrenteReceitaPrimariaAdv";
    const VALOR_CORRENTE_DESPESA_PRIMARIA_GERADA = "valorCorrenteDespesaPrimariaGerada";

    const VALOR_CONSTANTE_RECEITA_TOTAL = "valorConstanteReceitaTotal";
    const VALOR_CONSTANTE_RECEITA_PRIMARIA = "valorConstanteReceitaPrimaria";
    const VALOR_CONSTANTE_DESPESA_TOTAL = "valorConstanteDespesaTotal";
    const VALOR_CONSTANTE_DESPESA_PRIMARIA = "valorConstanteDespesaPrimaria";
    const VALOR_CONSTANTE_RESULTADO_PRIMARIO = "valorConstanteResultadoPrimario";
    const VALOR_CONSTANTE_RESULTADO_NOMINAL = "valorConstanteResultadoNominal";
    const VALOR_CONSTANTE_DIVIDA_PUBLICA_CONSOLIDADA = "valorConstanteDividaPublicaConsolidada";
    const VALOR_CONSTANTE_DIVIDA_CONSOLIDADA_LIQUIDA = "valorConstanteDividaConsolidadaLiquida";
    const VALOR_CONSTANTE_RECEITA_PRIMARIA_ADV = "valorConstanteReceitaPrimariaAdv";
    const VALOR_CONSTANTE_DESPESA_PRIMARIA_GERADA = "valorConstanteDespesaPrimariaGerada";

    const PERCENTUAL_PIB_RECEITA_TOTAL = "percentualPIBReceitaTotal";
    const PERCENTUAL_PIB_RECEITA_PRIMARIA = "percentualPIBReceitaPrimaria";
    const PERCENTUAL_PIB_DESPESA_TOTAL = "percentualPIBDespesaTotal";
    const PERCENTUAL_PIB_DESPESA_PRIMARIA = "percentualPIBDespesaPrimaria";
    const PERCENTUAL_PIB_RESULTADO_PRIMARIO = "percentualPIBResultadoPrimario";
    const PERCENTUAL_PIB_RESULTADO_NOMINAL = "percentualPIBResultadoNominal";
    const PERCENTUAL_PIB_DIVIDA_PUBLICA_CONSOLIDADE = "percentualPIBDividaPublicaConsolidada";
    const PERCENTUAL_PIB_DIVIDA_CONSOLIDADA_LIQUIDA = "percentualPIBDividaConsolidadaLiquida";
    const PERCENTUAL_PIB_RECEITA_PRIMARIA_ADV = "percentualPIBReceitaPrimariaAdv";
    const PERCENTUAL_PIB_DESPESA_PRIMARIA_ADV = "percentualPIBDespesaPrimariaAdv";

    /**
     * @var array
     */
    private static $mappingPercentage = [
        self::PERCENTUAL_PIB_RECEITA_TOTAL,
        self::PERCENTUAL_PIB_RECEITA_PRIMARIA,
        self::PERCENTUAL_PIB_DESPESA_TOTAL,
        self::PERCENTUAL_PIB_DESPESA_PRIMARIA,
        self::PERCENTUAL_PIB_RESULTADO_PRIMARIO,
        self::PERCENTUAL_PIB_RESULTADO_NOMINAL,
        self::PERCENTUAL_PIB_DIVIDA_PUBLICA_CONSOLIDADE,
        self::PERCENTUAL_PIB_DIVIDA_CONSOLIDADA_LIQUIDA,
        self::PERCENTUAL_PIB_RECEITA_PRIMARIA_ADV,
        self::PERCENTUAL_PIB_DESPESA_PRIMARIA_ADV ,
    ];

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $valorCorrenteReceitaTotal;

    /**
     * @var integer
     */
    private $valorCorrenteReceitaPrimaria;

    /**
     * @var integer
     */
    private $valorCorrenteDespesaTotal;

    /**
     * @var integer
     */
    private $valorCorrenteDespesaPrimaria;

    /**
     * @var integer
     */
    private $valorCorrenteResultadoPrimario;

    /**
     * @var integer
     */
    private $valorCorrenteResultadoNominal;

    /**
     * @var integer
     */
    private $valorCorrenteDividaPublicaConsolidada;

    /**
     * @var integer
     */
    private $valorCorrenteDividaConsolidadaLiquida;

    /**
     * @var integer
     */
    private $valorConstanteReceitaTotal;

    /**
     * @var integer
     */
    private $valorConstanteReceitaPrimaria;

    /**
     * @var integer
     */
    private $valorConstanteDespesaTotal;

    /**
     * @var integer
     */
    private $valorConstanteDespesaPrimaria;

    /**
     * @var integer
     */
    private $valorConstanteResultadoPrimario;

    /**
     * @var integer
     */
    private $valorConstanteResultadoNominal;

    /**
     * @var integer
     */
    private $valorConstanteDividaPublicaConsolidada;

    /**
     * @var integer
     */
    private $valorConstanteDividaConsolidadaLiquida;

    /**
     * @var integer
     */
    private $percentualPibReceitaTotal;

    /**
     * @var integer
     */
    private $percentualPibReceitaPrimaria;

    /**
     * @var integer
     */
    private $percentualPibDespesaTotal;

    /**
     * @var integer
     */
    private $percentualPibDespesaPrimaria;

    /**
     * @var integer
     */
    private $percentualPibResultadoPrimario;

    /**
     * @var integer
     */
    private $percentualPibResultadoNominal;

    /**
     * @var integer
     */
    private $percentualPibDividaPublicaConsolidada;

    /**
     * @var integer
     */
    private $percentualPibDividaConsolidadaLiquida;

    /**
     * @var integer
     */
    private $valorCorrenteReceitaPrimariaAdv;

    /**
     * @var integer
     */
    private $valorCorrenteDespesaPrimariaGerada;

    /**
     * @var integer
     */
    private $valorConstanteReceitaPrimariaAdv;

    /**
     * @var integer
     */
    private $valorConstanteDespesaPrimariaGerada;

    /**
     * @var integer
     */
    private $percentualPibReceitaPrimariaAdv;

    /**
     * @var integer
     */
    private $percentualPibDespesaPrimariaAdv;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return MetasFiscais
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
     * Set valorCorrenteReceitaTotal
     *
     * @param integer $valorCorrenteReceitaTotal
     * @return MetasFiscais
     */
    public function setValorCorrenteReceitaTotal($valorCorrenteReceitaTotal = null)
    {
        $this->valorCorrenteReceitaTotal = $valorCorrenteReceitaTotal;
        return $this;
    }

    /**
     * Get valorCorrenteReceitaTotal
     *
     * @return integer
     */
    public function getValorCorrenteReceitaTotal()
    {
        return $this->valorCorrenteReceitaTotal;
    }

    /**
     * Set valorCorrenteReceitaPrimaria
     *
     * @param integer $valorCorrenteReceitaPrimaria
     * @return MetasFiscais
     */
    public function setValorCorrenteReceitaPrimaria($valorCorrenteReceitaPrimaria = null)
    {
        $this->valorCorrenteReceitaPrimaria = $valorCorrenteReceitaPrimaria;
        return $this;
    }

    /**
     * Get valorCorrenteReceitaPrimaria
     *
     * @return integer
     */
    public function getValorCorrenteReceitaPrimaria()
    {
        return $this->valorCorrenteReceitaPrimaria;
    }

    /**
     * Set valorCorrenteDespesaTotal
     *
     * @param integer $valorCorrenteDespesaTotal
     * @return MetasFiscais
     */
    public function setValorCorrenteDespesaTotal($valorCorrenteDespesaTotal = null)
    {
        $this->valorCorrenteDespesaTotal = $valorCorrenteDespesaTotal;
        return $this;
    }

    /**
     * Get valorCorrenteDespesaTotal
     *
     * @return integer
     */
    public function getValorCorrenteDespesaTotal()
    {
        return $this->valorCorrenteDespesaTotal;
    }

    /**
     * Set valorCorrenteDespesaPrimaria
     *
     * @param integer $valorCorrenteDespesaPrimaria
     * @return MetasFiscais
     */
    public function setValorCorrenteDespesaPrimaria($valorCorrenteDespesaPrimaria = null)
    {
        $this->valorCorrenteDespesaPrimaria = $valorCorrenteDespesaPrimaria;
        return $this;
    }

    /**
     * Get valorCorrenteDespesaPrimaria
     *
     * @return integer
     */
    public function getValorCorrenteDespesaPrimaria()
    {
        return $this->valorCorrenteDespesaPrimaria;
    }

    /**
     * Set valorCorrenteResultadoPrimario
     *
     * @param integer $valorCorrenteResultadoPrimario
     * @return MetasFiscais
     */
    public function setValorCorrenteResultadoPrimario($valorCorrenteResultadoPrimario = null)
    {
        $this->valorCorrenteResultadoPrimario = $valorCorrenteResultadoPrimario;
        return $this;
    }

    /**
     * Get valorCorrenteResultadoPrimario
     *
     * @return integer
     */
    public function getValorCorrenteResultadoPrimario()
    {
        return $this->valorCorrenteResultadoPrimario;
    }

    /**
     * Set valorCorrenteResultadoNominal
     *
     * @param integer $valorCorrenteResultadoNominal
     * @return MetasFiscais
     */
    public function setValorCorrenteResultadoNominal($valorCorrenteResultadoNominal = null)
    {
        $this->valorCorrenteResultadoNominal = $valorCorrenteResultadoNominal;
        return $this;
    }

    /**
     * Get valorCorrenteResultadoNominal
     *
     * @return integer
     */
    public function getValorCorrenteResultadoNominal()
    {
        return $this->valorCorrenteResultadoNominal;
    }

    /**
     * Set valorCorrenteDividaPublicaConsolidada
     *
     * @param integer $valorCorrenteDividaPublicaConsolidada
     * @return MetasFiscais
     */
    public function setValorCorrenteDividaPublicaConsolidada($valorCorrenteDividaPublicaConsolidada = null)
    {
        $this->valorCorrenteDividaPublicaConsolidada = $valorCorrenteDividaPublicaConsolidada;
        return $this;
    }

    /**
     * Get valorCorrenteDividaPublicaConsolidada
     *
     * @return integer
     */
    public function getValorCorrenteDividaPublicaConsolidada()
    {
        return $this->valorCorrenteDividaPublicaConsolidada;
    }

    /**
     * Set valorCorrenteDividaConsolidadaLiquida
     *
     * @param integer $valorCorrenteDividaConsolidadaLiquida
     * @return MetasFiscais
     */
    public function setValorCorrenteDividaConsolidadaLiquida($valorCorrenteDividaConsolidadaLiquida = null)
    {
        $this->valorCorrenteDividaConsolidadaLiquida = $valorCorrenteDividaConsolidadaLiquida;
        return $this;
    }

    /**
     * Get valorCorrenteDividaConsolidadaLiquida
     *
     * @return integer
     */
    public function getValorCorrenteDividaConsolidadaLiquida()
    {
        return $this->valorCorrenteDividaConsolidadaLiquida;
    }

    /**
     * Set valorConstanteReceitaTotal
     *
     * @param integer $valorConstanteReceitaTotal
     * @return MetasFiscais
     */
    public function setValorConstanteReceitaTotal($valorConstanteReceitaTotal = null)
    {
        $this->valorConstanteReceitaTotal = $valorConstanteReceitaTotal;
        return $this;
    }

    /**
     * Get valorConstanteReceitaTotal
     *
     * @return integer
     */
    public function getValorConstanteReceitaTotal()
    {
        return $this->valorConstanteReceitaTotal;
    }

    /**
     * Set valorConstanteReceitaPrimaria
     *
     * @param integer $valorConstanteReceitaPrimaria
     * @return MetasFiscais
     */
    public function setValorConstanteReceitaPrimaria($valorConstanteReceitaPrimaria = null)
    {
        $this->valorConstanteReceitaPrimaria = $valorConstanteReceitaPrimaria;
        return $this;
    }

    /**
     * Get valorConstanteReceitaPrimaria
     *
     * @return integer
     */
    public function getValorConstanteReceitaPrimaria()
    {
        return $this->valorConstanteReceitaPrimaria;
    }

    /**
     * Set valorConstanteDespesaTotal
     *
     * @param integer $valorConstanteDespesaTotal
     * @return MetasFiscais
     */
    public function setValorConstanteDespesaTotal($valorConstanteDespesaTotal = null)
    {
        $this->valorConstanteDespesaTotal = $valorConstanteDespesaTotal;
        return $this;
    }

    /**
     * Get valorConstanteDespesaTotal
     *
     * @return integer
     */
    public function getValorConstanteDespesaTotal()
    {
        return $this->valorConstanteDespesaTotal;
    }

    /**
     * Set valorConstanteDespesaPrimaria
     *
     * @param integer $valorConstanteDespesaPrimaria
     * @return MetasFiscais
     */
    public function setValorConstanteDespesaPrimaria($valorConstanteDespesaPrimaria = null)
    {
        $this->valorConstanteDespesaPrimaria = $valorConstanteDespesaPrimaria;
        return $this;
    }

    /**
     * Get valorConstanteDespesaPrimaria
     *
     * @return integer
     */
    public function getValorConstanteDespesaPrimaria()
    {
        return $this->valorConstanteDespesaPrimaria;
    }

    /**
     * Set valorConstanteResultadoPrimario
     *
     * @param integer $valorConstanteResultadoPrimario
     * @return MetasFiscais
     */
    public function setValorConstanteResultadoPrimario($valorConstanteResultadoPrimario = null)
    {
        $this->valorConstanteResultadoPrimario = $valorConstanteResultadoPrimario;
        return $this;
    }

    /**
     * Get valorConstanteResultadoPrimario
     *
     * @return integer
     */
    public function getValorConstanteResultadoPrimario()
    {
        return $this->valorConstanteResultadoPrimario;
    }

    /**
     * Set valorConstanteResultadoNominal
     *
     * @param integer $valorConstanteResultadoNominal
     * @return MetasFiscais
     */
    public function setValorConstanteResultadoNominal($valorConstanteResultadoNominal = null)
    {
        $this->valorConstanteResultadoNominal = $valorConstanteResultadoNominal;
        return $this;
    }

    /**
     * Get valorConstanteResultadoNominal
     *
     * @return integer
     */
    public function getValorConstanteResultadoNominal()
    {
        return $this->valorConstanteResultadoNominal;
    }

    /**
     * Set valorConstanteDividaPublicaConsolidada
     *
     * @param integer $valorConstanteDividaPublicaConsolidada
     * @return MetasFiscais
     */
    public function setValorConstanteDividaPublicaConsolidada($valorConstanteDividaPublicaConsolidada = null)
    {
        $this->valorConstanteDividaPublicaConsolidada = $valorConstanteDividaPublicaConsolidada;
        return $this;
    }

    /**
     * Get valorConstanteDividaPublicaConsolidada
     *
     * @return integer
     */
    public function getValorConstanteDividaPublicaConsolidada()
    {
        return $this->valorConstanteDividaPublicaConsolidada;
    }

    /**
     * Set valorConstanteDividaConsolidadaLiquida
     *
     * @param integer $valorConstanteDividaConsolidadaLiquida
     * @return MetasFiscais
     */
    public function setValorConstanteDividaConsolidadaLiquida($valorConstanteDividaConsolidadaLiquida = null)
    {
        $this->valorConstanteDividaConsolidadaLiquida = $valorConstanteDividaConsolidadaLiquida;
        return $this;
    }

    /**
     * Get valorConstanteDividaConsolidadaLiquida
     *
     * @return integer
     */
    public function getValorConstanteDividaConsolidadaLiquida()
    {
        return $this->valorConstanteDividaConsolidadaLiquida;
    }

    /**
     * Set percentualPibReceitaTotal
     *
     * @param integer $percentualPibReceitaTotal
     * @return MetasFiscais
     */
    public function setPercentualPibReceitaTotal($percentualPibReceitaTotal = null)
    {
        $this->percentualPibReceitaTotal = $percentualPibReceitaTotal;
        return $this;
    }

    /**
     * Get percentualPibReceitaTotal
     *
     * @return integer
     */
    public function getPercentualPibReceitaTotal()
    {
        return $this->percentualPibReceitaTotal;
    }

    /**
     * Set percentualPibReceitaPrimaria
     *
     * @param integer $percentualPibReceitaPrimaria
     * @return MetasFiscais
     */
    public function setPercentualPibReceitaPrimaria($percentualPibReceitaPrimaria = null)
    {
        $this->percentualPibReceitaPrimaria = $percentualPibReceitaPrimaria;
        return $this;
    }

    /**
     * Get percentualPibReceitaPrimaria
     *
     * @return integer
     */
    public function getPercentualPibReceitaPrimaria()
    {
        return $this->percentualPibReceitaPrimaria;
    }

    /**
     * Set percentualPibDespesaTotal
     *
     * @param integer $percentualPibDespesaTotal
     * @return MetasFiscais
     */
    public function setPercentualPibDespesaTotal($percentualPibDespesaTotal = null)
    {
        $this->percentualPibDespesaTotal = $percentualPibDespesaTotal;
        return $this;
    }

    /**
     * Get percentualPibDespesaTotal
     *
     * @return integer
     */
    public function getPercentualPibDespesaTotal()
    {
        return $this->percentualPibDespesaTotal;
    }

    /**
     * Set percentualPibDespesaPrimaria
     *
     * @param integer $percentualPibDespesaPrimaria
     * @return MetasFiscais
     */
    public function setPercentualPibDespesaPrimaria($percentualPibDespesaPrimaria = null)
    {
        $this->percentualPibDespesaPrimaria = $percentualPibDespesaPrimaria;
        return $this;
    }

    /**
     * Get percentualPibDespesaPrimaria
     *
     * @return integer
     */
    public function getPercentualPibDespesaPrimaria()
    {
        return $this->percentualPibDespesaPrimaria;
    }

    /**
     * Set percentualPibResultadoPrimario
     *
     * @param integer $percentualPibResultadoPrimario
     * @return MetasFiscais
     */
    public function setPercentualPibResultadoPrimario($percentualPibResultadoPrimario = null)
    {
        $this->percentualPibResultadoPrimario = $percentualPibResultadoPrimario;
        return $this;
    }

    /**
     * Get percentualPibResultadoPrimario
     *
     * @return integer
     */
    public function getPercentualPibResultadoPrimario()
    {
        return $this->percentualPibResultadoPrimario;
    }

    /**
     * Set percentualPibResultadoNominal
     *
     * @param integer $percentualPibResultadoNominal
     * @return MetasFiscais
     */
    public function setPercentualPibResultadoNominal($percentualPibResultadoNominal = null)
    {
        $this->percentualPibResultadoNominal = $percentualPibResultadoNominal;
        return $this;
    }

    /**
     * Get percentualPibResultadoNominal
     *
     * @return integer
     */
    public function getPercentualPibResultadoNominal()
    {
        return $this->percentualPibResultadoNominal;
    }

    /**
     * Set percentualPibDividaPublicaConsolidada
     *
     * @param integer $percentualPibDividaPublicaConsolidada
     * @return MetasFiscais
     */
    public function setPercentualPibDividaPublicaConsolidada($percentualPibDividaPublicaConsolidada = null)
    {
        $this->percentualPibDividaPublicaConsolidada = $percentualPibDividaPublicaConsolidada;
        return $this;
    }

    /**
     * Get percentualPibDividaPublicaConsolidada
     *
     * @return integer
     */
    public function getPercentualPibDividaPublicaConsolidada()
    {
        return $this->percentualPibDividaPublicaConsolidada;
    }

    /**
     * Set percentualPibDividaConsolidadaLiquida
     *
     * @param integer $percentualPibDividaConsolidadaLiquida
     * @return MetasFiscais
     */
    public function setPercentualPibDividaConsolidadaLiquida($percentualPibDividaConsolidadaLiquida = null)
    {
        $this->percentualPibDividaConsolidadaLiquida = $percentualPibDividaConsolidadaLiquida;
        return $this;
    }

    /**
     * Get percentualPibDividaConsolidadaLiquida
     *
     * @return integer
     */
    public function getPercentualPibDividaConsolidadaLiquida()
    {
        return $this->percentualPibDividaConsolidadaLiquida;
    }

    /**
     * Set valorCorrenteReceitaPrimariaAdv
     *
     * @param integer $valorCorrenteReceitaPrimariaAdv
     * @return MetasFiscais
     */
    public function setValorCorrenteReceitaPrimariaAdv($valorCorrenteReceitaPrimariaAdv = null)
    {
        $this->valorCorrenteReceitaPrimariaAdv = $valorCorrenteReceitaPrimariaAdv;
        return $this;
    }

    /**
     * Get valorCorrenteReceitaPrimariaAdv
     *
     * @return integer
     */
    public function getValorCorrenteReceitaPrimariaAdv()
    {
        return $this->valorCorrenteReceitaPrimariaAdv;
    }

    /**
     * Set valorCorrenteDespesaPrimariaGerada
     *
     * @param integer $valorCorrenteDespesaPrimariaGerada
     * @return MetasFiscais
     */
    public function setValorCorrenteDespesaPrimariaGerada($valorCorrenteDespesaPrimariaGerada = null)
    {
        $this->valorCorrenteDespesaPrimariaGerada = $valorCorrenteDespesaPrimariaGerada;
        return $this;
    }

    /**
     * Get valorCorrenteDespesaPrimariaGerada
     *
     * @return integer
     */
    public function getValorCorrenteDespesaPrimariaGerada()
    {
        return $this->valorCorrenteDespesaPrimariaGerada;
    }

    /**
     * Set valorConstanteReceitaPrimariaAdv
     *
     * @param integer $valorConstanteReceitaPrimariaAdv
     * @return MetasFiscais
     */
    public function setValorConstanteReceitaPrimariaAdv($valorConstanteReceitaPrimariaAdv = null)
    {
        $this->valorConstanteReceitaPrimariaAdv = $valorConstanteReceitaPrimariaAdv;
        return $this;
    }

    /**
     * Get valorConstanteReceitaPrimariaAdv
     *
     * @return integer
     */
    public function getValorConstanteReceitaPrimariaAdv()
    {
        return $this->valorConstanteReceitaPrimariaAdv;
    }

    /**
     * Set valorConstanteDespesaPrimariaGerada
     *
     * @param integer $valorConstanteDespesaPrimariaGerada
     * @return MetasFiscais
     */
    public function setValorConstanteDespesaPrimariaGerada($valorConstanteDespesaPrimariaGerada = null)
    {
        $this->valorConstanteDespesaPrimariaGerada = $valorConstanteDespesaPrimariaGerada;
        return $this;
    }

    /**
     * Get valorConstanteDespesaPrimariaGerada
     *
     * @return integer
     */
    public function getValorConstanteDespesaPrimariaGerada()
    {
        return $this->valorConstanteDespesaPrimariaGerada;
    }

    /**
     * Set percentualPibReceitaPrimariaAdv
     *
     * @param integer $percentualPibReceitaPrimariaAdv
     * @return MetasFiscais
     */
    public function setPercentualPibReceitaPrimariaAdv($percentualPibReceitaPrimariaAdv = null)
    {
        $this->percentualPibReceitaPrimariaAdv = $percentualPibReceitaPrimariaAdv;
        return $this;
    }

    /**
     * Get percentualPibReceitaPrimariaAdv
     *
     * @return integer
     */
    public function getPercentualPibReceitaPrimariaAdv()
    {
        return $this->percentualPibReceitaPrimariaAdv;
    }

    /**
     * Set percentualPibDespesaPrimariaAdv
     *
     * @param integer $percentualPibDespesaPrimariaAdv
     * @return MetasFiscais
     */
    public function setPercentualPibDespesaPrimariaAdv($percentualPibDespesaPrimariaAdv = null)
    {
        $this->percentualPibDespesaPrimariaAdv = $percentualPibDespesaPrimariaAdv;
        return $this;
    }

    /**
     * Get percentualPibDespesaPrimariaAdv
     *
     * @return integer
     */
    public function getPercentualPibDespesaPrimariaAdv()
    {
        return $this->percentualPibDespesaPrimariaAdv;
    }

    /**
     * @param string $field
     * @return bool
     */
    public static function isPercentage($field)
    {
        return in_array($field, self::$mappingPercentage);
    }
}
