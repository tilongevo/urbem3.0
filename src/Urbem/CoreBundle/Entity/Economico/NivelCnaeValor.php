<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * NivelCnaeValor
 */
class NivelCnaeValor
{
    /**
     * PK
     * @var integer
     */
    private $codNivel;

    /**
     * PK
     * @var integer
     */
    private $codVigencia;

    /**
     * PK
     * @var integer
     */
    private $codCnae;

    /**
     * @var string
     */
    private $valor;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\NivelCnae
     */
    private $fkEconomicoNivelCnae;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\CnaeFiscal
     */
    private $fkEconomicoCnaeFiscal;


    /**
     * Set codNivel
     *
     * @param integer $codNivel
     * @return NivelCnaeValor
     */
    public function setCodNivel($codNivel)
    {
        $this->codNivel = $codNivel;
        return $this;
    }

    /**
     * Get codNivel
     *
     * @return integer
     */
    public function getCodNivel()
    {
        return $this->codNivel;
    }

    /**
     * Set codVigencia
     *
     * @param integer $codVigencia
     * @return NivelCnaeValor
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
     * Set codCnae
     *
     * @param integer $codCnae
     * @return NivelCnaeValor
     */
    public function setCodCnae($codCnae)
    {
        $this->codCnae = $codCnae;
        return $this;
    }

    /**
     * Get codCnae
     *
     * @return integer
     */
    public function getCodCnae()
    {
        return $this->codCnae;
    }

    /**
     * Set valor
     *
     * @param string $valor
     * @return NivelCnaeValor
     */
    public function setValor($valor)
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoNivelCnae
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelCnae $fkEconomicoNivelCnae
     * @return NivelCnaeValor
     */
    public function setFkEconomicoNivelCnae(\Urbem\CoreBundle\Entity\Economico\NivelCnae $fkEconomicoNivelCnae)
    {
        $this->codNivel = $fkEconomicoNivelCnae->getCodNivel();
        $this->codVigencia = $fkEconomicoNivelCnae->getCodVigencia();
        $this->fkEconomicoNivelCnae = $fkEconomicoNivelCnae;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoNivelCnae
     *
     * @return \Urbem\CoreBundle\Entity\Economico\NivelCnae
     */
    public function getFkEconomicoNivelCnae()
    {
        return $this->fkEconomicoNivelCnae;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoCnaeFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CnaeFiscal $fkEconomicoCnaeFiscal
     * @return NivelCnaeValor
     */
    public function setFkEconomicoCnaeFiscal(\Urbem\CoreBundle\Entity\Economico\CnaeFiscal $fkEconomicoCnaeFiscal)
    {
        $this->codCnae = $fkEconomicoCnaeFiscal->getCodCnae();
        $this->fkEconomicoCnaeFiscal = $fkEconomicoCnaeFiscal;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoCnaeFiscal
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CnaeFiscal
     */
    public function getFkEconomicoCnaeFiscal()
    {
        return $this->fkEconomicoCnaeFiscal;
    }
}
