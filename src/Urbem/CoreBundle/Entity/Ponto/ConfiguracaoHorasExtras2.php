<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * ConfiguracaoHorasExtras2
 */
class ConfiguracaoHorasExtras2
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
    private $anteriorPeriodo1 = false;

    /**
     * @var boolean
     */
    private $entrePeriodo12 = false;

    /**
     * @var boolean
     */
    private $posteriorPeriodo2 = false;

    /**
     * @var boolean
     */
    private $autorizacao = false;

    /**
     * @var boolean
     */
    private $atrasos = false;

    /**
     * @var boolean
     */
    private $faltas = false;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\FaixasHorasExtra
     */
    private $fkPontoFaixasHorasExtras;

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
        $this->fkPontoFaixasHorasExtras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimePK;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoHorasExtras2
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
     * @return ConfiguracaoHorasExtras2
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
     * Set anteriorPeriodo1
     *
     * @param boolean $anteriorPeriodo1
     * @return ConfiguracaoHorasExtras2
     */
    public function setAnteriorPeriodo1($anteriorPeriodo1)
    {
        $this->anteriorPeriodo1 = $anteriorPeriodo1;
        return $this;
    }

    /**
     * Get anteriorPeriodo1
     *
     * @return boolean
     */
    public function getAnteriorPeriodo1()
    {
        return $this->anteriorPeriodo1;
    }

    /**
     * Set entrePeriodo12
     *
     * @param boolean $entrePeriodo12
     * @return ConfiguracaoHorasExtras2
     */
    public function setEntrePeriodo12($entrePeriodo12)
    {
        $this->entrePeriodo12 = $entrePeriodo12;
        return $this;
    }

    /**
     * Get entrePeriodo12
     *
     * @return boolean
     */
    public function getEntrePeriodo12()
    {
        return $this->entrePeriodo12;
    }

    /**
     * Set posteriorPeriodo2
     *
     * @param boolean $posteriorPeriodo2
     * @return ConfiguracaoHorasExtras2
     */
    public function setPosteriorPeriodo2($posteriorPeriodo2)
    {
        $this->posteriorPeriodo2 = $posteriorPeriodo2;
        return $this;
    }

    /**
     * Get posteriorPeriodo2
     *
     * @return boolean
     */
    public function getPosteriorPeriodo2()
    {
        return $this->posteriorPeriodo2;
    }

    /**
     * Set autorizacao
     *
     * @param boolean $autorizacao
     * @return ConfiguracaoHorasExtras2
     */
    public function setAutorizacao($autorizacao)
    {
        $this->autorizacao = $autorizacao;
        return $this;
    }

    /**
     * Get autorizacao
     *
     * @return boolean
     */
    public function getAutorizacao()
    {
        return $this->autorizacao;
    }

    /**
     * Set atrasos
     *
     * @param boolean $atrasos
     * @return ConfiguracaoHorasExtras2
     */
    public function setAtrasos($atrasos)
    {
        $this->atrasos = $atrasos;
        return $this;
    }

    /**
     * Get atrasos
     *
     * @return boolean
     */
    public function getAtrasos()
    {
        return $this->atrasos;
    }

    /**
     * Set faltas
     *
     * @param boolean $faltas
     * @return ConfiguracaoHorasExtras2
     */
    public function setFaltas($faltas)
    {
        $this->faltas = $faltas;
        return $this;
    }

    /**
     * Get faltas
     *
     * @return boolean
     */
    public function getFaltas()
    {
        return $this->faltas;
    }

    /**
     * OneToMany (owning side)
     * Add PontoFaixasHorasExtra
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FaixasHorasExtra $fkPontoFaixasHorasExtra
     * @return ConfiguracaoHorasExtras2
     */
    public function addFkPontoFaixasHorasExtras(\Urbem\CoreBundle\Entity\Ponto\FaixasHorasExtra $fkPontoFaixasHorasExtra)
    {
        if (false === $this->fkPontoFaixasHorasExtras->contains($fkPontoFaixasHorasExtra)) {
            $fkPontoFaixasHorasExtra->setFkPontoConfiguracaoHorasExtras2($this);
            $this->fkPontoFaixasHorasExtras->add($fkPontoFaixasHorasExtra);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoFaixasHorasExtra
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FaixasHorasExtra $fkPontoFaixasHorasExtra
     */
    public function removeFkPontoFaixasHorasExtras(\Urbem\CoreBundle\Entity\Ponto\FaixasHorasExtra $fkPontoFaixasHorasExtra)
    {
        $this->fkPontoFaixasHorasExtras->removeElement($fkPontoFaixasHorasExtra);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoFaixasHorasExtras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\FaixasHorasExtra
     */
    public function getFkPontoFaixasHorasExtras()
    {
        return $this->fkPontoFaixasHorasExtras;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoConfiguracaoRelogioPonto
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPonto $fkPontoConfiguracaoRelogioPonto
     * @return ConfiguracaoHorasExtras2
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
}
