<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * ConfiguracaoRelogioPonto
 */
class ConfiguracaoRelogioPonto
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * @var \DateTime
     */
    private $ultimoTimestamp;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPontoExclusao
     */
    private $fkPontoConfiguracaoRelogioPontoExclusao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais
     */
    private $fkPontoConfiguracaoParametrosGerais;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoBancoHoras
     */
    private $fkPontoConfiguracaoBancoHoras;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoHorasExtras2
     */
    private $fkPontoConfiguracaoHorasExtras2s;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPontoConfiguracaoParametrosGerais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoConfiguracaoBancoHoras = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkPontoConfiguracaoHorasExtras2s = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ultimoTimestamp = new \DateTime;
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoRelogioPonto
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
     * Set ultimoTimestamp
     *
     * @param \DateTime $ultimoTimestamp
     * @return ConfiguracaoRelogioPonto
     */
    public function setUltimoTimestamp(\DateTime $ultimoTimestamp)
    {
        $this->ultimoTimestamp = $ultimoTimestamp;
        return $this;
    }

    /**
     * Get ultimoTimestamp
     *
     * @return \DateTime
     */
    public function getUltimoTimestamp()
    {
        return $this->ultimoTimestamp;
    }

    /**
     * OneToMany (owning side)
     * Add PontoConfiguracaoParametrosGerais
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais $fkPontoConfiguracaoParametrosGerais
     * @return ConfiguracaoRelogioPonto
     */
    public function addFkPontoConfiguracaoParametrosGerais(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais $fkPontoConfiguracaoParametrosGerais)
    {
        if (false === $this->fkPontoConfiguracaoParametrosGerais->contains($fkPontoConfiguracaoParametrosGerais)) {
            $fkPontoConfiguracaoParametrosGerais->setFkPontoConfiguracaoRelogioPonto($this);
            $this->fkPontoConfiguracaoParametrosGerais->add($fkPontoConfiguracaoParametrosGerais);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoConfiguracaoParametrosGerais
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais $fkPontoConfiguracaoParametrosGerais
     */
    public function removeFkPontoConfiguracaoParametrosGerais(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais $fkPontoConfiguracaoParametrosGerais)
    {
        $this->fkPontoConfiguracaoParametrosGerais->removeElement($fkPontoConfiguracaoParametrosGerais);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoConfiguracaoParametrosGerais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoParametrosGerais
     */
    public function getFkPontoConfiguracaoParametrosGerais()
    {
        return $this->fkPontoConfiguracaoParametrosGerais;
    }

    /**
     * OneToMany (owning side)
     * Add PontoConfiguracaoBancoHoras
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoBancoHoras $fkPontoConfiguracaoBancoHoras
     * @return ConfiguracaoRelogioPonto
     */
    public function addFkPontoConfiguracaoBancoHoras(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoBancoHoras $fkPontoConfiguracaoBancoHoras)
    {
        if (false === $this->fkPontoConfiguracaoBancoHoras->contains($fkPontoConfiguracaoBancoHoras)) {
            $fkPontoConfiguracaoBancoHoras->setFkPontoConfiguracaoRelogioPonto($this);
            $this->fkPontoConfiguracaoBancoHoras->add($fkPontoConfiguracaoBancoHoras);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoConfiguracaoBancoHoras
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoBancoHoras $fkPontoConfiguracaoBancoHoras
     */
    public function removeFkPontoConfiguracaoBancoHoras(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoBancoHoras $fkPontoConfiguracaoBancoHoras)
    {
        $this->fkPontoConfiguracaoBancoHoras->removeElement($fkPontoConfiguracaoBancoHoras);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoConfiguracaoBancoHoras
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoBancoHoras
     */
    public function getFkPontoConfiguracaoBancoHoras()
    {
        return $this->fkPontoConfiguracaoBancoHoras;
    }

    /**
     * OneToMany (owning side)
     * Add PontoConfiguracaoHorasExtras2
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoHorasExtras2 $fkPontoConfiguracaoHorasExtras2
     * @return ConfiguracaoRelogioPonto
     */
    public function addFkPontoConfiguracaoHorasExtras2s(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoHorasExtras2 $fkPontoConfiguracaoHorasExtras2)
    {
        if (false === $this->fkPontoConfiguracaoHorasExtras2s->contains($fkPontoConfiguracaoHorasExtras2)) {
            $fkPontoConfiguracaoHorasExtras2->setFkPontoConfiguracaoRelogioPonto($this);
            $this->fkPontoConfiguracaoHorasExtras2s->add($fkPontoConfiguracaoHorasExtras2);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoConfiguracaoHorasExtras2
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoHorasExtras2 $fkPontoConfiguracaoHorasExtras2
     */
    public function removeFkPontoConfiguracaoHorasExtras2s(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoHorasExtras2 $fkPontoConfiguracaoHorasExtras2)
    {
        $this->fkPontoConfiguracaoHorasExtras2s->removeElement($fkPontoConfiguracaoHorasExtras2);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoConfiguracaoHorasExtras2s
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoHorasExtras2
     */
    public function getFkPontoConfiguracaoHorasExtras2s()
    {
        return $this->fkPontoConfiguracaoHorasExtras2s;
    }

    /**
     * OneToOne (inverse side)
     * Set PontoConfiguracaoRelogioPontoExclusao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPontoExclusao $fkPontoConfiguracaoRelogioPontoExclusao
     * @return ConfiguracaoRelogioPonto
     */
    public function setFkPontoConfiguracaoRelogioPontoExclusao(\Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPontoExclusao $fkPontoConfiguracaoRelogioPontoExclusao)
    {
        $fkPontoConfiguracaoRelogioPontoExclusao->setFkPontoConfiguracaoRelogioPonto($this);
        $this->fkPontoConfiguracaoRelogioPontoExclusao = $fkPontoConfiguracaoRelogioPontoExclusao;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkPontoConfiguracaoRelogioPontoExclusao
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\ConfiguracaoRelogioPontoExclusao
     */
    public function getFkPontoConfiguracaoRelogioPontoExclusao()
    {
        return $this->fkPontoConfiguracaoRelogioPontoExclusao;
    }
}
