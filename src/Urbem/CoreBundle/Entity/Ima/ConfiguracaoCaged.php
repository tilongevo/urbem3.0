<?php
 
namespace Urbem\CoreBundle\Entity\Ima;

/**
 * ConfiguracaoCaged
 */
class ConfiguracaoCaged
{
    /**
     * PK
     * @var integer
     */
    private $codConfiguracao;

    /**
     * @var integer
     */
    private $codCnae;

    /**
     * @var string
     */
    private $tipoDeclaracao;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ima\CagedAutorizadoCgm
     */
    private $fkImaCagedAutorizadoCgm;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ima\CagedAutorizadoCei
     */
    private $fkImaCagedAutorizadoCei;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Ima\CagedEstabelecimento
     */
    private $fkImaCagedEstabelecimento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\CagedEvento
     */
    private $fkImaCagedEventos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\CagedSubDivisao
     */
    private $fkImaCagedSubDivisoes;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\CnaeFiscal
     */
    private $fkEconomicoCnaeFiscal;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImaCagedEventos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaCagedSubDivisoes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codConfiguracao
     *
     * @param integer $codConfiguracao
     * @return ConfiguracaoCaged
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
     * Set codCnae
     *
     * @param integer $codCnae
     * @return ConfiguracaoCaged
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
     * Set tipoDeclaracao
     *
     * @param string $tipoDeclaracao
     * @return ConfiguracaoCaged
     */
    public function setTipoDeclaracao($tipoDeclaracao)
    {
        $this->tipoDeclaracao = $tipoDeclaracao;
        return $this;
    }

    /**
     * Get tipoDeclaracao
     *
     * @return string
     */
    public function getTipoDeclaracao()
    {
        return $this->tipoDeclaracao;
    }

    /**
     * OneToMany (owning side)
     * Add ImaCagedEvento
     *
     * @param \Urbem\CoreBundle\Entity\Ima\CagedEvento $fkImaCagedEvento
     * @return ConfiguracaoCaged
     */
    public function addFkImaCagedEventos(\Urbem\CoreBundle\Entity\Ima\CagedEvento $fkImaCagedEvento)
    {
        if (false === $this->fkImaCagedEventos->contains($fkImaCagedEvento)) {
            $fkImaCagedEvento->setFkImaConfiguracaoCaged($this);
            $this->fkImaCagedEventos->add($fkImaCagedEvento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaCagedEvento
     *
     * @param \Urbem\CoreBundle\Entity\Ima\CagedEvento $fkImaCagedEvento
     */
    public function removeFkImaCagedEventos(\Urbem\CoreBundle\Entity\Ima\CagedEvento $fkImaCagedEvento)
    {
        $this->fkImaCagedEventos->removeElement($fkImaCagedEvento);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaCagedEventos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\CagedEvento
     */
    public function getFkImaCagedEventos()
    {
        return $this->fkImaCagedEventos;
    }

    /**
     * OneToMany (owning side)
     * Add ImaCagedSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\CagedSubDivisao $fkImaCagedSubDivisao
     * @return ConfiguracaoCaged
     */
    public function addFkImaCagedSubDivisoes(\Urbem\CoreBundle\Entity\Ima\CagedSubDivisao $fkImaCagedSubDivisao)
    {
        if (false === $this->fkImaCagedSubDivisoes->contains($fkImaCagedSubDivisao)) {
            $fkImaCagedSubDivisao->setFkImaConfiguracaoCaged($this);
            $this->fkImaCagedSubDivisoes->add($fkImaCagedSubDivisao);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaCagedSubDivisao
     *
     * @param \Urbem\CoreBundle\Entity\Ima\CagedSubDivisao $fkImaCagedSubDivisao
     */
    public function removeFkImaCagedSubDivisoes(\Urbem\CoreBundle\Entity\Ima\CagedSubDivisao $fkImaCagedSubDivisao)
    {
        $this->fkImaCagedSubDivisoes->removeElement($fkImaCagedSubDivisao);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaCagedSubDivisoes
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\CagedSubDivisao
     */
    public function getFkImaCagedSubDivisoes()
    {
        return $this->fkImaCagedSubDivisoes;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoCnaeFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Economico\CnaeFiscal $fkEconomicoCnaeFiscal
     * @return ConfiguracaoCaged
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

    /**
     * OneToOne (inverse side)
     * Set ImaCagedAutorizadoCgm
     *
     * @param \Urbem\CoreBundle\Entity\Ima\CagedAutorizadoCgm $fkImaCagedAutorizadoCgm
     * @return ConfiguracaoCaged
     */
    public function setFkImaCagedAutorizadoCgm(\Urbem\CoreBundle\Entity\Ima\CagedAutorizadoCgm $fkImaCagedAutorizadoCgm)
    {
        $fkImaCagedAutorizadoCgm->setFkImaConfiguracaoCaged($this);
        $this->fkImaCagedAutorizadoCgm = $fkImaCagedAutorizadoCgm;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImaCagedAutorizadoCgm
     *
     * @return \Urbem\CoreBundle\Entity\Ima\CagedAutorizadoCgm
     */
    public function getFkImaCagedAutorizadoCgm()
    {
        return $this->fkImaCagedAutorizadoCgm;
    }

    /**
     * OneToOne (inverse side)
     * Set ImaCagedAutorizadoCei
     *
     * @param \Urbem\CoreBundle\Entity\Ima\CagedAutorizadoCei $fkImaCagedAutorizadoCei
     * @return ConfiguracaoCaged
     */
    public function setFkImaCagedAutorizadoCei(\Urbem\CoreBundle\Entity\Ima\CagedAutorizadoCei $fkImaCagedAutorizadoCei)
    {
        $fkImaCagedAutorizadoCei->setFkImaConfiguracaoCaged($this);
        $this->fkImaCagedAutorizadoCei = $fkImaCagedAutorizadoCei;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImaCagedAutorizadoCei
     *
     * @return \Urbem\CoreBundle\Entity\Ima\CagedAutorizadoCei
     */
    public function getFkImaCagedAutorizadoCei()
    {
        return $this->fkImaCagedAutorizadoCei;
    }

    /**
     * OneToOne (inverse side)
     * Set ImaCagedEstabelecimento
     *
     * @param \Urbem\CoreBundle\Entity\Ima\CagedEstabelecimento $fkImaCagedEstabelecimento
     * @return ConfiguracaoCaged
     */
    public function setFkImaCagedEstabelecimento(\Urbem\CoreBundle\Entity\Ima\CagedEstabelecimento $fkImaCagedEstabelecimento)
    {
        $fkImaCagedEstabelecimento->setFkImaConfiguracaoCaged($this);
        $this->fkImaCagedEstabelecimento = $fkImaCagedEstabelecimento;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImaCagedEstabelecimento
     *
     * @return \Urbem\CoreBundle\Entity\Ima\CagedEstabelecimento
     */
    public function getFkImaCagedEstabelecimento()
    {
        return $this->fkImaCagedEstabelecimento;
    }
}
