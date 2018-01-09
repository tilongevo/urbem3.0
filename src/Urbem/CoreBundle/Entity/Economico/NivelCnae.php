<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * NivelCnae
 */
class NivelCnae
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
     * @var string
     */
    private $nomNivel;

    /**
     * @var string
     */
    private $mascara;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CnaeFiscal
     */
    private $fkEconomicoCnaeFiscais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\NivelCnaeValor
     */
    private $fkEconomicoNivelCnaeValores;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\VigenciaCnae
     */
    private $fkEconomicoVigenciaCnae;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoCnaeFiscais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoNivelCnaeValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codNivel
     *
     * @param integer $codNivel
     * @return NivelCnae
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
     * @return NivelCnae
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
     * Set nomNivel
     *
     * @param string $nomNivel
     * @return NivelCnae
     */
    public function setNomNivel($nomNivel)
    {
        $this->nomNivel = $nomNivel;
        return $this;
    }

    /**
     * Get nomNivel
     *
     * @return string
     */
    public function getNomNivel()
    {
        return $this->nomNivel;
    }

    /**
     * Set mascara
     *
     * @param string $mascara
     * @return NivelCnae
     */
    public function setMascara($mascara)
    {
        $this->mascara = $mascara;
        return $this;
    }

    /**
     * Get mascara
     *
     * @return string
     */
    public function getMascara()
    {
        return $this->mascara;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return NivelCnae
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoCnaeFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CnaeFiscal $fkEconomicoCnaeFiscal
     * @return NivelCnae
     */
    public function addFkEconomicoCnaeFiscais(\Urbem\CoreBundle\Entity\Economico\CnaeFiscal $fkEconomicoCnaeFiscal)
    {
        if (false === $this->fkEconomicoCnaeFiscais->contains($fkEconomicoCnaeFiscal)) {
            $fkEconomicoCnaeFiscal->setFkEconomicoNivelCnae($this);
            $this->fkEconomicoCnaeFiscais->add($fkEconomicoCnaeFiscal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoCnaeFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CnaeFiscal $fkEconomicoCnaeFiscal
     */
    public function removeFkEconomicoCnaeFiscais(\Urbem\CoreBundle\Entity\Economico\CnaeFiscal $fkEconomicoCnaeFiscal)
    {
        $this->fkEconomicoCnaeFiscais->removeElement($fkEconomicoCnaeFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoCnaeFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\CnaeFiscal
     */
    public function getFkEconomicoCnaeFiscais()
    {
        return $this->fkEconomicoCnaeFiscais;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoNivelCnaeValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelCnaeValor $fkEconomicoNivelCnaeValor
     * @return NivelCnae
     */
    public function addFkEconomicoNivelCnaeValores(\Urbem\CoreBundle\Entity\Economico\NivelCnaeValor $fkEconomicoNivelCnaeValor)
    {
        if (false === $this->fkEconomicoNivelCnaeValores->contains($fkEconomicoNivelCnaeValor)) {
            $fkEconomicoNivelCnaeValor->setFkEconomicoNivelCnae($this);
            $this->fkEconomicoNivelCnaeValores->add($fkEconomicoNivelCnaeValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoNivelCnaeValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelCnaeValor $fkEconomicoNivelCnaeValor
     */
    public function removeFkEconomicoNivelCnaeValores(\Urbem\CoreBundle\Entity\Economico\NivelCnaeValor $fkEconomicoNivelCnaeValor)
    {
        $this->fkEconomicoNivelCnaeValores->removeElement($fkEconomicoNivelCnaeValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoNivelCnaeValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\NivelCnaeValor
     */
    public function getFkEconomicoNivelCnaeValores()
    {
        return $this->fkEconomicoNivelCnaeValores;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoVigenciaCnae
     *
     * @param \Urbem\CoreBundle\Entity\Economico\VigenciaCnae $fkEconomicoVigenciaCnae
     * @return NivelCnae
     */
    public function setFkEconomicoVigenciaCnae(\Urbem\CoreBundle\Entity\Economico\VigenciaCnae $fkEconomicoVigenciaCnae)
    {
        $this->codVigencia = $fkEconomicoVigenciaCnae->getCodVigencia();
        $this->fkEconomicoVigenciaCnae = $fkEconomicoVigenciaCnae;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoVigenciaCnae
     *
     * @return \Urbem\CoreBundle\Entity\Economico\VigenciaCnae
     */
    public function getFkEconomicoVigenciaCnae()
    {
        return $this->fkEconomicoVigenciaCnae;
    }
}
