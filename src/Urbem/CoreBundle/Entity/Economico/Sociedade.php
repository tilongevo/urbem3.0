<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * Sociedade
 */
class Sociedade
{
    /**
     * PK
     * @var integer
     */
    private $numcgm;

    /**
     * PK
     * @var integer
     */
    private $inscricaoEconomica;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $quotaSocio;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoSociedade
     */
    private $fkEconomicoProcessoSociedades;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\SwCgm
     */
    private $fkSwCgm;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito
     */
    private $fkEconomicoCadastroEconomicoEmpresaDireito;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoProcessoSociedades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set numcgm
     *
     * @param integer $numcgm
     * @return Sociedade
     */
    public function setNumcgm($numcgm)
    {
        $this->numcgm = $numcgm;
        return $this;
    }

    /**
     * Get numcgm
     *
     * @return integer
     */
    public function getNumcgm()
    {
        return $this->numcgm;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return Sociedade
     */
    public function setInscricaoEconomica($inscricaoEconomica)
    {
        $this->inscricaoEconomica = $inscricaoEconomica;
        return $this;
    }

    /**
     * Get inscricaoEconomica
     *
     * @return integer
     */
    public function getInscricaoEconomica()
    {
        return $this->inscricaoEconomica;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return Sociedade
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
     * Set quotaSocio
     *
     * @param integer $quotaSocio
     * @return Sociedade
     */
    public function setQuotaSocio($quotaSocio)
    {
        $this->quotaSocio = $quotaSocio;
        return $this;
    }

    /**
     * Get quotaSocio
     *
     * @return integer
     */
    public function getQuotaSocio()
    {
        return $this->quotaSocio;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoSociedade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoSociedade $fkEconomicoProcessoSociedade
     * @return Sociedade
     */
    public function addFkEconomicoProcessoSociedades(\Urbem\CoreBundle\Entity\Economico\ProcessoSociedade $fkEconomicoProcessoSociedade)
    {
        if (false === $this->fkEconomicoProcessoSociedades->contains($fkEconomicoProcessoSociedade)) {
            $fkEconomicoProcessoSociedade->setFkEconomicoSociedade($this);
            $this->fkEconomicoProcessoSociedades->add($fkEconomicoProcessoSociedade);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoSociedade
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoSociedade $fkEconomicoProcessoSociedade
     */
    public function removeFkEconomicoProcessoSociedades(\Urbem\CoreBundle\Entity\Economico\ProcessoSociedade $fkEconomicoProcessoSociedade)
    {
        $this->fkEconomicoProcessoSociedades->removeElement($fkEconomicoProcessoSociedade);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoSociedades
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoSociedade
     */
    public function getFkEconomicoProcessoSociedades()
    {
        return $this->fkEconomicoProcessoSociedades;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkSwCgm
     *
     * @param \Urbem\CoreBundle\Entity\SwCgm $fkSwCgm
     * @return Sociedade
     */
    public function setFkSwCgm(\Urbem\CoreBundle\Entity\SwCgm $fkSwCgm)
    {
        $this->numcgm = $fkSwCgm->getNumcgm();
        $this->fkSwCgm = $fkSwCgm;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkSwCgm
     *
     * @return \Urbem\CoreBundle\Entity\SwCgm
     */
    public function getFkSwCgm()
    {
        return $this->fkSwCgm;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoCadastroEconomicoEmpresaDireito
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito $fkEconomicoCadastroEconomicoEmpresaDireito
     * @return Sociedade
     */
    public function setFkEconomicoCadastroEconomicoEmpresaDireito(\Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito $fkEconomicoCadastroEconomicoEmpresaDireito)
    {
        $this->inscricaoEconomica = $fkEconomicoCadastroEconomicoEmpresaDireito->getInscricaoEconomica();
        $this->fkEconomicoCadastroEconomicoEmpresaDireito = $fkEconomicoCadastroEconomicoEmpresaDireito;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoCadastroEconomicoEmpresaDireito
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomicoEmpresaDireito
     */
    public function getFkEconomicoCadastroEconomicoEmpresaDireito()
    {
        return $this->fkEconomicoCadastroEconomicoEmpresaDireito;
    }
}
