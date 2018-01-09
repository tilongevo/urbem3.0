<?php
 
namespace Urbem\CoreBundle\Entity\Tcmgo;

/**
 * MetasFiscaisLdo
 */
class MetasFiscaisLdo
{
    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * @var integer
     */
    private $valorCorrenteReceita;

    /**
     * @var integer
     */
    private $valorCorrenteDespesa;

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
    private $valorCorrenteDividaConsolidadaLiquida;


    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return MetasFiscaisLdo
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
     * Set valorCorrenteReceita
     *
     * @param integer $valorCorrenteReceita
     * @return MetasFiscaisLdo
     */
    public function setValorCorrenteReceita($valorCorrenteReceita = null)
    {
        $this->valorCorrenteReceita = $valorCorrenteReceita;
        return $this;
    }

    /**
     * Get valorCorrenteReceita
     *
     * @return integer
     */
    public function getValorCorrenteReceita()
    {
        return $this->valorCorrenteReceita;
    }

    /**
     * Set valorCorrenteDespesa
     *
     * @param integer $valorCorrenteDespesa
     * @return MetasFiscaisLdo
     */
    public function setValorCorrenteDespesa($valorCorrenteDespesa = null)
    {
        $this->valorCorrenteDespesa = $valorCorrenteDespesa;
        return $this;
    }

    /**
     * Get valorCorrenteDespesa
     *
     * @return integer
     */
    public function getValorCorrenteDespesa()
    {
        return $this->valorCorrenteDespesa;
    }

    /**
     * Set valorCorrenteResultadoPrimario
     *
     * @param integer $valorCorrenteResultadoPrimario
     * @return MetasFiscaisLdo
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
     * @return MetasFiscaisLdo
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
     * Set valorCorrenteDividaConsolidadaLiquida
     *
     * @param integer $valorCorrenteDividaConsolidadaLiquida
     * @return MetasFiscaisLdo
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
}
