<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * DomicilioFiscal
 */
class DomicilioFiscal
{
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
    private $inscricaoMunicipal;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioFiscal
     */
    private $fkEconomicoProcessoDomicilioFiscais;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    private $fkEconomicoCadastroEconomico;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    private $fkImobiliarioImovel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoProcessoDomicilioFiscais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set inscricaoEconomica
     *
     * @param integer $inscricaoEconomica
     * @return DomicilioFiscal
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
     * @return DomicilioFiscal
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
     * Set inscricaoMunicipal
     *
     * @param integer $inscricaoMunicipal
     * @return DomicilioFiscal
     */
    public function setInscricaoMunicipal($inscricaoMunicipal)
    {
        $this->inscricaoMunicipal = $inscricaoMunicipal;
        return $this;
    }

    /**
     * Get inscricaoMunicipal
     *
     * @return integer
     */
    public function getInscricaoMunicipal()
    {
        return $this->inscricaoMunicipal;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoProcessoDomicilioFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioFiscal $fkEconomicoProcessoDomicilioFiscal
     * @return DomicilioFiscal
     */
    public function addFkEconomicoProcessoDomicilioFiscais(\Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioFiscal $fkEconomicoProcessoDomicilioFiscal)
    {
        if (false === $this->fkEconomicoProcessoDomicilioFiscais->contains($fkEconomicoProcessoDomicilioFiscal)) {
            $fkEconomicoProcessoDomicilioFiscal->setFkEconomicoDomicilioFiscal($this);
            $this->fkEconomicoProcessoDomicilioFiscais->add($fkEconomicoProcessoDomicilioFiscal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoProcessoDomicilioFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioFiscal $fkEconomicoProcessoDomicilioFiscal
     */
    public function removeFkEconomicoProcessoDomicilioFiscais(\Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioFiscal $fkEconomicoProcessoDomicilioFiscal)
    {
        $this->fkEconomicoProcessoDomicilioFiscais->removeElement($fkEconomicoProcessoDomicilioFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoProcessoDomicilioFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\ProcessoDomicilioFiscal
     */
    public function getFkEconomicoProcessoDomicilioFiscais()
    {
        return $this->fkEconomicoProcessoDomicilioFiscais;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoCadastroEconomico
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico
     * @return DomicilioFiscal
     */
    public function setFkEconomicoCadastroEconomico(\Urbem\CoreBundle\Entity\Economico\CadastroEconomico $fkEconomicoCadastroEconomico)
    {
        $this->inscricaoEconomica = $fkEconomicoCadastroEconomico->getInscricaoEconomica();
        $this->fkEconomicoCadastroEconomico = $fkEconomicoCadastroEconomico;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkEconomicoCadastroEconomico
     *
     * @return \Urbem\CoreBundle\Entity\Economico\CadastroEconomico
     */
    public function getFkEconomicoCadastroEconomico()
    {
        return $this->fkEconomicoCadastroEconomico;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioImovel
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel
     * @return DomicilioFiscal
     */
    public function setFkImobiliarioImovel(\Urbem\CoreBundle\Entity\Imobiliario\Imovel $fkImobiliarioImovel)
    {
        $this->inscricaoMunicipal = $fkImobiliarioImovel->getInscricaoMunicipal();
        $this->fkImobiliarioImovel = $fkImobiliarioImovel;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioImovel
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Imovel
     */
    public function getFkImobiliarioImovel()
    {
        return $this->fkImobiliarioImovel;
    }
}
