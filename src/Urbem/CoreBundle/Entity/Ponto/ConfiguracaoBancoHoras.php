<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * ConfiguracaoBancoHoras
 */
class ConfiguracaoBancoHoras
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * PK
     * @var \Urbem\CoreBundle\Helper\DateTimePK
     */
    private $timestamp;

    /**
     * @var boolean
     */
    private $ativarBanco = false;

    /**
     * @var string
     */
    private $contagemLimites;

    /**
     * @var string
     */
    private $horasExcesso;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\BancoHorasMaximoDebito
     */
    private $fkPontoBancoHorasMaximoDebito;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\BancoHorasMaximoExtras
     */
    private $fkPontoBancoHorasMaximoExtras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\BancoHorasDias
     */
    private $fkPontoBancoHorasDias;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPonto
     */
    private $fkPontoConfiguracaoRelogioPonto;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPontoBancoHorasDias = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoBancoHoras
     */
    public function setCodConfiguracao($codConfiguracao)
    {
        $this->codConfiguracao = $codConfiguracao;
        return $this;
    }

    /**
     * Get codConfiguracao
     *
     * @return integer
     */
    public function getCodConfiguracao()
    {
        return $this->codConfiguracao;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimePK $timestamp
     * @return ConfiguracaoBancoHoras
     */
    public function setTimestamp(\Urbem\CoreBundle\Helper\DateTimePK $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \Urbem\CoreBundle\Helper\DateTimePK
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set ativarBanco
     *
     * @param boolean $ativarBanco
     * @return ConfiguracaoBancoHoras
     */
    public function setAtivarBanco($ativarBanco)
    {
        $this->ativarBanco = $ativarBanco;
        return $this;
    }

    /**
     * Get ativarBanco
     *
     * @return boolean
     */
    public function getAtivarBanco()
    {
        return $this->ativarBanco;
    }

    /**
     * Set contagemLimites
     *
     * @param string $contagemLimites
     * @return ConfiguracaoBancoHoras
     */
    public function setContagemLimites($contagemLimites)
    {
        $this->contagemLimites = $contagemLimites;
        return $this;
    }

    /**
     * Get contagemLimites
     *
     * @return string
     */
    public function getContagemLimites()
    {
        return $this->contagemLimites;
    }

    /**
     * Set horasExcesso
     *
     * @param string $horasExcesso
     * @return ConfiguracaoBancoHoras
     */
    public function setHorasExcesso($horasExcesso)
    {
        $this->horasExcesso = $horasExcesso;
        return $this;
    }

    /**
     * Get horasExcesso
     *
     * @return string
     */
    public function getHorasExcesso()
    {
        return $this->horasExcesso;
    }

    /**
     * OneToMany (owning side)
     * Add PontoBancoHorasDias
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\BancoHorasDias $fkPontoBancoHorasDias
     * @return ConfiguracaoBancoHoras
     */
    public function addFkPontoBancoHorasDias(\Urbem\CoreBundle\Entity\Ponto\BancoHorasDias $fkPontoBancoHorasDias)
    {
        if (false === $this->fkPontoBancoHorasDias->contains($fkPontoBancoHorasDias)) {
            $fkPontoBancoHorasDias->setFkPontoConfiguracaoBancoHoras($this);
            $this->fkPontoBancoHorasDias->add($fkPontoBancoHorasDias);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoBancoHorasDias
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\BancoHorasDias $fkPontoBancoHorasDias
     */
    public function removeFkPontoBancoHorasDias(\Urbem\CoreBundle\Entity\Ponto\BancoHorasDias $fkPontoBancoHorasDias)
    {
        $this->fkPontoBancoHorasDias->removeElement($fkPontoBancoHorasDias);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoBancoHorasDias
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\BancoHorasDias
     */
    public function getFkPontoBancoHorasDias()
    {
        return $this->fkPontoBancoHorasDias;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoConfiguracaoRelogioPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPonto $fkPontoConfiguracaoRelogioPonto
     * @return ConfiguracaoBancoHoras
     */
    public function setFkPontoConfiguracaoRelogioPonto(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPonto $fkPontoConfiguracaoRelogioPonto)
    {
        $this->codConfiguracao = $fkPontoConfiguracaoRelogioPonto->getCodConfiguracao();
        $this->fkPontoConfiguracaoRelogioPonto = $fkPontoConfiguracaoRelogioPonto;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoConfiguracaoRelogioPonto
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPonto
     */
    public function getFkPontoConfiguracaoRelogioPonto()
    {
        return $this->fkPontoConfiguracaoRelogioPonto;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoBancoHorasMaximoDebito
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\BancoHorasMaximoDebito $fkPontoBancoHorasMaximoDebito
     * @return ConfiguracaoBancoHoras
     */
    public function setFkPontoBancoHorasMaximoDebito(\Urbem\CoreBundle\Entity\Ponto\BancoHorasMaximoDebito $fkPontoBancoHorasMaximoDebito)
    {
        $fkPontoBancoHorasMaximoDebito->setFkPontoConfiguracaoBancoHoras($this);
        $this->fkPontoBancoHorasMaximoDebito = $fkPontoBancoHorasMaximoDebito;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoBancoHorasMaximoDebito
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\BancoHorasMaximoDebito
     */
    public function getFkPontoBancoHorasMaximoDebito()
    {
        return $this->fkPontoBancoHorasMaximoDebito;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoBancoHorasMaximoExtras
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\BancoHorasMaximoExtras $fkPontoBancoHorasMaximoExtras
     * @return ConfiguracaoBancoHoras
     */
    public function setFkPontoBancoHorasMaximoExtras(\Urbem\CoreBundle\Entity\Ponto\BancoHorasMaximoExtras $fkPontoBancoHorasMaximoExtras)
    {
        $fkPontoBancoHorasMaximoExtras->setFkPontoConfiguracaoBancoHoras($this);
        $this->fkPontoBancoHorasMaximoExtras = $fkPontoBancoHorasMaximoExtras;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoBancoHorasMaximoExtras
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\BancoHorasMaximoExtras
     */
    public function getFkPontoBancoHorasMaximoExtras()
    {
        return $this->fkPontoBancoHorasMaximoExtras;
    }
}
