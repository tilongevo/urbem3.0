<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * ParcelamentoSolo
 */
class ParcelamentoSolo
{
    /**
     * PK
     * @var integer
     */
    private $codParcelamento;

    /**
     * @var integer
     */
    private $codLote;

    /**
     * @var integer
     */
    private $codTipo;

    /**
     * @var \DateTime
     */
    private $dtParcelamento;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteParcelamentoSolo
     */
    private $fkImobiliarioLicencaLoteParcelamentoSolos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteParcelado
     */
    private $fkImobiliarioLoteParcelados;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Lote
     */
    private $fkImobiliarioLote;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\TipoParcelamento
     */
    private $fkImobiliarioTipoParcelamento;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioLicencaLoteParcelamentoSolos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLoteParcelados = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codParcelamento
     *
     * @param integer $codParcelamento
     * @return ParcelamentoSolo
     */
    public function setCodParcelamento($codParcelamento)
    {
        $this->codParcelamento = $codParcelamento;
        return $this;
    }

    /**
     * Get codParcelamento
     *
     * @return integer
     */
    public function getCodParcelamento()
    {
        return $this->codParcelamento;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return ParcelamentoSolo
     */
    public function setCodLote($codLote)
    {
        $this->codLote = $codLote;
        return $this;
    }

    /**
     * Get codLote
     *
     * @return integer
     */
    public function getCodLote()
    {
        return $this->codLote;
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return ParcelamentoSolo
     */
    public function setCodTipo($codTipo)
    {
        $this->codTipo = $codTipo;
        return $this;
    }

    /**
     * Get codTipo
     *
     * @return integer
     */
    public function getCodTipo()
    {
        return $this->codTipo;
    }

    /**
     * Set dtParcelamento
     *
     * @param \DateTime $dtParcelamento
     * @return ParcelamentoSolo
     */
    public function setDtParcelamento(\DateTime $dtParcelamento)
    {
        $this->dtParcelamento = $dtParcelamento;
        return $this;
    }

    /**
     * Get dtParcelamento
     *
     * @return \DateTime
     */
    public function getDtParcelamento()
    {
        return $this->dtParcelamento;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaLoteParcelamentoSolo
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteParcelamentoSolo $fkImobiliarioLicencaLoteParcelamentoSolo
     * @return ParcelamentoSolo
     */
    public function addFkImobiliarioLicencaLoteParcelamentoSolos(\Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteParcelamentoSolo $fkImobiliarioLicencaLoteParcelamentoSolo)
    {
        if (false === $this->fkImobiliarioLicencaLoteParcelamentoSolos->contains($fkImobiliarioLicencaLoteParcelamentoSolo)) {
            $fkImobiliarioLicencaLoteParcelamentoSolo->setFkImobiliarioParcelamentoSolo($this);
            $this->fkImobiliarioLicencaLoteParcelamentoSolos->add($fkImobiliarioLicencaLoteParcelamentoSolo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLicencaLoteParcelamentoSolo
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteParcelamentoSolo $fkImobiliarioLicencaLoteParcelamentoSolo
     */
    public function removeFkImobiliarioLicencaLoteParcelamentoSolos(\Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteParcelamentoSolo $fkImobiliarioLicencaLoteParcelamentoSolo)
    {
        $this->fkImobiliarioLicencaLoteParcelamentoSolos->removeElement($fkImobiliarioLicencaLoteParcelamentoSolo);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLicencaLoteParcelamentoSolos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteParcelamentoSolo
     */
    public function getFkImobiliarioLicencaLoteParcelamentoSolos()
    {
        return $this->fkImobiliarioLicencaLoteParcelamentoSolos;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLoteParcelado
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteParcelado $fkImobiliarioLoteParcelado
     * @return ParcelamentoSolo
     */
    public function addFkImobiliarioLoteParcelados(\Urbem\CoreBundle\Entity\Imobiliario\LoteParcelado $fkImobiliarioLoteParcelado)
    {
        if (false === $this->fkImobiliarioLoteParcelados->contains($fkImobiliarioLoteParcelado)) {
            $fkImobiliarioLoteParcelado->setFkImobiliarioParcelamentoSolo($this);
            $this->fkImobiliarioLoteParcelados->add($fkImobiliarioLoteParcelado);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioLoteParcelado
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LoteParcelado $fkImobiliarioLoteParcelado
     */
    public function removeFkImobiliarioLoteParcelados(\Urbem\CoreBundle\Entity\Imobiliario\LoteParcelado $fkImobiliarioLoteParcelado)
    {
        $this->fkImobiliarioLoteParcelados->removeElement($fkImobiliarioLoteParcelado);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioLoteParcelados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LoteParcelado
     */
    public function getFkImobiliarioLoteParcelados()
    {
        return $this->fkImobiliarioLoteParcelados;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote
     * @return ParcelamentoSolo
     */
    public function setFkImobiliarioLote(\Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote)
    {
        $this->codLote = $fkImobiliarioLote->getCodLote();
        $this->fkImobiliarioLote = $fkImobiliarioLote;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioLote
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Lote
     */
    public function getFkImobiliarioLote()
    {
        return $this->fkImobiliarioLote;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioTipoParcelamento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\TipoParcelamento $fkImobiliarioTipoParcelamento
     * @return ParcelamentoSolo
     */
    public function setFkImobiliarioTipoParcelamento(\Urbem\CoreBundle\Entity\Imobiliario\TipoParcelamento $fkImobiliarioTipoParcelamento)
    {
        $this->codTipo = $fkImobiliarioTipoParcelamento->getCodTipo();
        $this->fkImobiliarioTipoParcelamento = $fkImobiliarioTipoParcelamento;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioTipoParcelamento
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\TipoParcelamento
     */
    public function getFkImobiliarioTipoParcelamento()
    {
        return $this->fkImobiliarioTipoParcelamento;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s - %s', $this->codParcelamento, $this->dtParcelamento->format('d/m/Y'));
    }
}
