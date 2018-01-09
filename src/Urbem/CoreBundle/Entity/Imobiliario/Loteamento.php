<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * Loteamento
 */
class Loteamento
{
    /**
     * PK
     * @var integer
     */
    private $codLoteamento;

    /**
     * @var string
     */
    private $nomLoteamento;

    /**
     * @var integer
     */
    private $areaLogradouro = 0;

    /**
     * @var integer
     */
    private $areaComunitaria = 0;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteamentoLoteOrigem
     */
    private $fkImobiliarioLoteamentoLoteOrigens;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ProcessoLoteamento
     */
    private $fkImobiliarioProcessoLoteamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteLoteamento
     */
    private $fkImobiliarioLoteLoteamentos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteLoteamento
     */
    private $fkImobiliarioLicencaLoteLoteamentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioLoteamentoLoteOrigens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioProcessoLoteamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLoteLoteamentos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLicencaLoteLoteamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLoteamento
     *
     * @param integer $codLoteamento
     * @return Loteamento
     */
    public function setCodLoteamento($codLoteamento)
    {
        $this->codLoteamento = $codLoteamento;
        return $this;
    }

    /**
     * Get codLoteamento
     *
     * @return integer
     */
    public function getCodLoteamento()
    {
        return $this->codLoteamento;
    }

    /**
     * Set nomLoteamento
     *
     * @param string $nomLoteamento
     * @return Loteamento
     */
    public function setNomLoteamento($nomLoteamento)
    {
        $this->nomLoteamento = $nomLoteamento;
        return $this;
    }

    /**
     * Get nomLoteamento
     *
     * @return string
     */
    public function getNomLoteamento()
    {
        return $this->nomLoteamento;
    }

    /**
     * Set areaLogradouro
     *
     * @param integer $areaLogradouro
     * @return Loteamento
     */
    public function setAreaLogradouro($areaLogradouro)
    {
        $this->areaLogradouro = $areaLogradouro;
        return $this;
    }

    /**
     * Get areaLogradouro
     *
     * @return integer
     */
    public function getAreaLogradouro()
    {
        return $this->areaLogradouro;
    }

    /**
     * Set areaComunitaria
     *
     * @param integer $areaComunitaria
     * @return Loteamento
     */
    public function setAreaComunitaria($areaComunitaria)
    {
        $this->areaComunitaria = $areaComunitaria;
        return $this;
    }

    /**
     * Get areaComunitaria
     *
     * @return integer
     */
    public function getAreaComunitaria()
    {
        return $this->areaComunitaria;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLoteamentoLoteOrigem
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteamentoLoteOrigem $fkImobiliarioLoteamentoLoteOrigem
     * @return Loteamento
     */
    public function addFkImobiliarioLoteamentoLoteOrigens(\Urbem\CoreBundle\Entity\Imobiliario\LoteamentoLoteOrigem $fkImobiliarioLoteamentoLoteOrigem)
    {
        if (false === $this->fkImobiliarioLoteamentoLoteOrigens->contains($fkImobiliarioLoteamentoLoteOrigem)) {
            $fkImobiliarioLoteamentoLoteOrigem->setFkImobiliarioLoteamento($this);
            $this->fkImobiliarioLoteamentoLoteOrigens->add($fkImobiliarioLoteamentoLoteOrigem);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLoteamentoLoteOrigem
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteamentoLoteOrigem $fkImobiliarioLoteamentoLoteOrigem
     */
    public function removeFkImobiliarioLoteamentoLoteOrigens(\Urbem\CoreBundle\Entity\Imobiliario\LoteamentoLoteOrigem $fkImobiliarioLoteamentoLoteOrigem)
    {
        $this->fkImobiliarioLoteamentoLoteOrigens->removeElement($fkImobiliarioLoteamentoLoteOrigem);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLoteamentoLoteOrigens
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteamentoLoteOrigem
     */
    public function getFkImobiliarioLoteamentoLoteOrigens()
    {
        return $this->fkImobiliarioLoteamentoLoteOrigens;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioProcessoLoteamento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ProcessoLoteamento $fkImobiliarioProcessoLoteamento
     * @return Loteamento
     */
    public function addFkImobiliarioProcessoLoteamentos(\Urbem\CoreBundle\Entity\Imobiliario\ProcessoLoteamento $fkImobiliarioProcessoLoteamento)
    {
        if (false === $this->fkImobiliarioProcessoLoteamentos->contains($fkImobiliarioProcessoLoteamento)) {
            $fkImobiliarioProcessoLoteamento->setFkImobiliarioLoteamento($this);
            $this->fkImobiliarioProcessoLoteamentos->add($fkImobiliarioProcessoLoteamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioProcessoLoteamento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ProcessoLoteamento $fkImobiliarioProcessoLoteamento
     */
    public function removeFkImobiliarioProcessoLoteamentos(\Urbem\CoreBundle\Entity\Imobiliario\ProcessoLoteamento $fkImobiliarioProcessoLoteamento)
    {
        $this->fkImobiliarioProcessoLoteamentos->removeElement($fkImobiliarioProcessoLoteamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioProcessoLoteamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ProcessoLoteamento
     */
    public function getFkImobiliarioProcessoLoteamentos()
    {
        return $this->fkImobiliarioProcessoLoteamentos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLoteLoteamento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteLoteamento $fkImobiliarioLoteLoteamento
     * @return Loteamento
     */
    public function addFkImobiliarioLoteLoteamentos(\Urbem\CoreBundle\Entity\Imobiliario\LoteLoteamento $fkImobiliarioLoteLoteamento)
    {
        if (false === $this->fkImobiliarioLoteLoteamentos->contains($fkImobiliarioLoteLoteamento)) {
            $fkImobiliarioLoteLoteamento->setFkImobiliarioLoteamento($this);
            $this->fkImobiliarioLoteLoteamentos->add($fkImobiliarioLoteLoteamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLoteLoteamento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteLoteamento $fkImobiliarioLoteLoteamento
     */
    public function removeFkImobiliarioLoteLoteamentos(\Urbem\CoreBundle\Entity\Imobiliario\LoteLoteamento $fkImobiliarioLoteLoteamento)
    {
        $this->fkImobiliarioLoteLoteamentos->removeElement($fkImobiliarioLoteLoteamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLoteLoteamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteLoteamento
     */
    public function getFkImobiliarioLoteLoteamentos()
    {
        return $this->fkImobiliarioLoteLoteamentos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaLoteLoteamento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteLoteamento $fkImobiliarioLicencaLoteLoteamento
     * @return Loteamento
     */
    public function addFkImobiliarioLicencaLoteLoteamentos(\Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteLoteamento $fkImobiliarioLicencaLoteLoteamento)
    {
        if (false === $this->fkImobiliarioLicencaLoteLoteamentos->contains($fkImobiliarioLicencaLoteLoteamento)) {
            $fkImobiliarioLicencaLoteLoteamento->setFkImobiliarioLoteamento($this);
            $this->fkImobiliarioLicencaLoteLoteamentos->add($fkImobiliarioLicencaLoteLoteamento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLicencaLoteLoteamento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteLoteamento $fkImobiliarioLicencaLoteLoteamento
     */
    public function removeFkImobiliarioLicencaLoteLoteamentos(\Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteLoteamento $fkImobiliarioLicencaLoteLoteamento)
    {
        $this->fkImobiliarioLicencaLoteLoteamentos->removeElement($fkImobiliarioLicencaLoteLoteamento);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLicencaLoteLoteamentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteLoteamento
     */
    public function getFkImobiliarioLicencaLoteLoteamentos()
    {
        return $this->fkImobiliarioLicencaLoteLoteamentos;
    }

    /**
     * @return LoteamentoLoteOrigem
     */
    public function getLoteamentoLoteOrigem()
    {
        return $this->getFkImobiliarioLoteamentoLoteOrigens()->current();
    }

    /**
     * @return Lote
     */
    public function getLote()
    {
        return $this->getLoteamentoLoteOrigem()->getFkImobiliarioLote();
    }

    /**
     * @return Localizacao
     */
    public function getLocalizacao()
    {
        return $this->getLote()->getFkImobiliarioLoteLocalizacao()->getFkImobiliarioLocalizacao();
    }

    /**
     * @return \DateTime
     */
    public function getDtAprovacao()
    {
        return $this->getLoteamentoLoteOrigem()->getDtAprovacao();
    }

    /**
     * @return \DateTime
     */
    public function getDtLiberacao()
    {
        return $this->getLoteamentoLoteOrigem()->getDtLiberacao();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codLoteamento, $this->nomLoteamento);
    }
}
