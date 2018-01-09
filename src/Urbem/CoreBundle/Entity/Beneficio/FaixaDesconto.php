<?php
 
namespace Urbem\CoreBundle\Entity\Beneficio;

/**
 * FaixaDesconto
 */
class FaixaDesconto
{
    /**
     * PK
     * @var integer
     */
    private $codFaixa;

    /**
     * PK
     * @var integer
     */
    private $codVigencia;

    /**
     * @var integer
     */
    private $vlInicial;

    /**
     * @var integer
     */
    private $vlFinal;

    /**
     * @var integer
     */
    private $percentualDesconto;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Beneficio\Vigencia
     */
    private $fkBeneficioVigencia;


    /**
     * Set codFaixa
     *
     * @param integer $codFaixa
     * @return FaixaDesconto
     */
    public function setCodFaixa($codFaixa)
    {
        $this->codFaixa = $codFaixa;
        return $this;
    }

    /**
     * Get codFaixa
     *
     * @return integer
     */
    public function getCodFaixa()
    {
        return $this->codFaixa;
    }

    /**
     * Set codVigencia
     *
     * @param integer $codVigencia
     * @return FaixaDesconto
     */
    public function setCodVigencia($codVigencia)
    {
        $this->codVigencia = $codVigencia;
        return $this;
    }

    /**
     * Get codVigencia
     *
     * @return integer
     */
    public function getCodVigencia()
    {
        return $this->codVigencia;
    }

    /**
     * Set vlInicial
     *
     * @param integer $vlInicial
     * @return FaixaDesconto
     */
    public function setVlInicial($vlInicial = null)
    {
        $this->vlInicial = $vlInicial;
        return $this;
    }

    /**
     * Get vlInicial
     *
     * @return integer
     */
    public function getVlInicial()
    {
        return $this->vlInicial;
    }

    /**
     * Set vlFinal
     *
     * @param integer $vlFinal
     * @return FaixaDesconto
     */
    public function setVlFinal($vlFinal = null)
    {
        $this->vlFinal = $vlFinal;
        return $this;
    }

    /**
     * Get vlFinal
     *
     * @return integer
     */
    public function getVlFinal()
    {
        return $this->vlFinal;
    }

    /**
     * Set percentualDesconto
     *
     * @param integer $percentualDesconto
     * @return FaixaDesconto
     */
    public function setPercentualDesconto($percentualDesconto = null)
    {
        $this->percentualDesconto = $percentualDesconto;
        return $this;
    }

    /**
     * Get percentualDesconto
     *
     * @return integer
     */
    public function getPercentualDesconto()
    {
        return $this->percentualDesconto;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkBeneficioVigencia
     *
     * @param \Urbem\CoreBundle\Entity\Beneficio\Vigencia $fkBeneficioVigencia
     * @return FaixaDesconto
     */
    public function setFkBeneficioVigencia(\Urbem\CoreBundle\Entity\Beneficio\Vigencia $fkBeneficioVigencia)
    {
        $this->codVigencia = $fkBeneficioVigencia->getCodVigencia();
        $this->fkBeneficioVigencia = $fkBeneficioVigencia;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkBeneficioVigencia
     *
     * @return \Urbem\CoreBundle\Entity\Beneficio\Vigencia
     */
    public function getFkBeneficioVigencia()
    {
        return $this->fkBeneficioVigencia;
    }
}
