<?php
 
namespace Urbem\CoreBundle\Entity\Economico;

/**
 * CnaeFiscal
 */
class CnaeFiscal
{
    /**
     * PK
     * @var integer
     */
    private $codCnae;

    /**
     * @var string
     */
    private $nomAtividade;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var integer
     */
    private $codVigencia;

    /**
     * @var integer
     */
    private $codNivel;

    /**
     * @var string
     */
    private $codEstrutural;

    /**
     * @var string
     */
    private $risco = 'N';

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\NivelCnaeValor
     */
    private $fkEconomicoNivelCnaeValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoCaged
     */
    private $fkImaConfiguracaoCageds;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeCnaeFiscal
     */
    private $fkEconomicoAtividadeCnaeFiscais;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Economico\NivelCnae
     */
    private $fkEconomicoNivelCnae;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkEconomicoNivelCnaeValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImaConfiguracaoCageds = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkEconomicoAtividadeCnaeFiscais = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK;
    }

    /**
     * Set codCnae
     *
     * @param integer $codCnae
     * @return CnaeFiscal
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
     * Set nomAtividade
     *
     * @param string $nomAtividade
     * @return CnaeFiscal
     */
    public function setNomAtividade($nomAtividade)
    {
        $this->nomAtividade = $nomAtividade;
        return $this;
    }

    /**
     * Get nomAtividade
     *
     * @return string
     */
    public function getNomAtividade()
    {
        return $this->nomAtividade;
    }

    /**
     * Set timestamp
     *
     * @param \Urbem\CoreBundle\Helper\DateTimeMicrosecondPK $timestamp
     * @return CnaeFiscal
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
     * Set codVigencia
     *
     * @param integer $codVigencia
     * @return CnaeFiscal
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
     * Set codNivel
     *
     * @param integer $codNivel
     * @return CnaeFiscal
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
     * Set codEstrutural
     *
     * @param string $codEstrutural
     * @return CnaeFiscal
     */
    public function setCodEstrutural($codEstrutural)
    {
        $this->codEstrutural = $codEstrutural;
        return $this;
    }

    /**
     * Get codEstrutural
     *
     * @return string
     */
    public function getCodEstrutural()
    {
        return $this->codEstrutural;
    }

    /**
     * Set risco
     *
     * @param string $risco
     * @return CnaeFiscal
     */
    public function setRisco($risco)
    {
        $this->risco = $risco;
        return $this;
    }

    /**
     * Get risco
     *
     * @return string
     */
    public function getRisco()
    {
        return $this->risco;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoNivelCnaeValor
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelCnaeValor $fkEconomicoNivelCnaeValor
     * @return CnaeFiscal
     */
    public function addFkEconomicoNivelCnaeValores(\Urbem\CoreBundle\Entity\Economico\NivelCnaeValor $fkEconomicoNivelCnaeValor)
    {
        if (false === $this->fkEconomicoNivelCnaeValores->contains($fkEconomicoNivelCnaeValor)) {
            $fkEconomicoNivelCnaeValor->setFkEconomicoCnaeFiscal($this);
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
     * OneToMany (owning side)
     * Add ImaConfiguracaoCaged
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoCaged $fkImaConfiguracaoCaged
     * @return CnaeFiscal
     */
    public function addFkImaConfiguracaoCageds(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoCaged $fkImaConfiguracaoCaged)
    {
        if (false === $this->fkImaConfiguracaoCageds->contains($fkImaConfiguracaoCaged)) {
            $fkImaConfiguracaoCaged->setFkEconomicoCnaeFiscal($this);
            $this->fkImaConfiguracaoCageds->add($fkImaConfiguracaoCaged);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImaConfiguracaoCaged
     *
     * @param \Urbem\CoreBundle\Entity\Ima\ConfiguracaoCaged $fkImaConfiguracaoCaged
     */
    public function removeFkImaConfiguracaoCageds(\Urbem\CoreBundle\Entity\Ima\ConfiguracaoCaged $fkImaConfiguracaoCaged)
    {
        $this->fkImaConfiguracaoCageds->removeElement($fkImaConfiguracaoCaged);
    }

    /**
     * OneToMany (owning side)
     * Get fkImaConfiguracaoCageds
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ima\ConfiguracaoCaged
     */
    public function getFkImaConfiguracaoCageds()
    {
        return $this->fkImaConfiguracaoCageds;
    }

    /**
     * OneToMany (owning side)
     * Add EconomicoAtividadeCnaeFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeCnaeFiscal $fkEconomicoAtividadeCnaeFiscal
     * @return CnaeFiscal
     */
    public function addFkEconomicoAtividadeCnaeFiscais(\Urbem\CoreBundle\Entity\Economico\AtividadeCnaeFiscal $fkEconomicoAtividadeCnaeFiscal)
    {
        if (false === $this->fkEconomicoAtividadeCnaeFiscais->contains($fkEconomicoAtividadeCnaeFiscal)) {
            $fkEconomicoAtividadeCnaeFiscal->setFkEconomicoCnaeFiscal($this);
            $this->fkEconomicoAtividadeCnaeFiscais->add($fkEconomicoAtividadeCnaeFiscal);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove EconomicoAtividadeCnaeFiscal
     *
     * @param \Urbem\CoreBundle\Entity\Economico\AtividadeCnaeFiscal $fkEconomicoAtividadeCnaeFiscal
     */
    public function removeFkEconomicoAtividadeCnaeFiscais(\Urbem\CoreBundle\Entity\Economico\AtividadeCnaeFiscal $fkEconomicoAtividadeCnaeFiscal)
    {
        $this->fkEconomicoAtividadeCnaeFiscais->removeElement($fkEconomicoAtividadeCnaeFiscal);
    }

    /**
     * OneToMany (owning side)
     * Get fkEconomicoAtividadeCnaeFiscais
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Economico\AtividadeCnaeFiscal
     */
    public function getFkEconomicoAtividadeCnaeFiscais()
    {
        return $this->fkEconomicoAtividadeCnaeFiscais;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkEconomicoNivelCnae
     *
     * @param \Urbem\CoreBundle\Entity\Economico\NivelCnae $fkEconomicoNivelCnae
     * @return CnaeFiscal
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
}
