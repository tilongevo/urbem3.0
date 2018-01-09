<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LicencaLote
 */
class LicencaLote
{
    /**
     * PK
     * @var integer
     */
    private $codLicenca;

    /**
     * PK
     * @var string
     */
    private $exercicio;

    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * OneToOne (inverse side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteArea
     */
    private $fkImobiliarioLicencaLoteArea;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaLoteValor
     */
    private $fkImobiliarioAtributoTipoLicencaLoteValores;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteParcelamentoSolo
     */
    private $fkImobiliarioLicencaLoteParcelamentoSolos;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteLoteamento
     */
    private $fkImobiliarioLicencaLoteLoteamentos;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Licenca
     */
    private $fkImobiliarioLicenca;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Lote
     */
    private $fkImobiliarioLote;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioAtributoTipoLicencaLoteValores = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLicencaLoteParcelamentoSolos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->fkImobiliarioLicencaLoteLoteamentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLicenca
     *
     * @param integer $codLicenca
     * @return LicencaLote
     */
    public function setCodLicenca($codLicenca)
    {
        $this->codLicenca = $codLicenca;
        return $this;
    }

    /**
     * Get codLicenca
     *
     * @return integer
     */
    public function getCodLicenca()
    {
        return $this->codLicenca;
    }

    /**
     * Set exercicio
     *
     * @param string $exercicio
     * @return LicencaLote
     */
    public function setExercicio($exercicio)
    {
        $this->exercicio = $exercicio;
        return $this;
    }

    /**
     * Get exercicio
     *
     * @return string
     */
    public function getExercicio()
    {
        return $this->exercicio;
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LicencaLote
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
     * OneToMany (owning side)
     * Add ImobiliarioAtributoTipoLicencaLoteValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaLoteValor $fkImobiliarioAtributoTipoLicencaLoteValor
     * @return LicencaLote
     */
    public function addFkImobiliarioAtributoTipoLicencaLoteValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaLoteValor $fkImobiliarioAtributoTipoLicencaLoteValor)
    {
        if (false === $this->fkImobiliarioAtributoTipoLicencaLoteValores->contains($fkImobiliarioAtributoTipoLicencaLoteValor)) {
            $fkImobiliarioAtributoTipoLicencaLoteValor->setFkImobiliarioLicencaLote($this);
            $this->fkImobiliarioAtributoTipoLicencaLoteValores->add($fkImobiliarioAtributoTipoLicencaLoteValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoTipoLicencaLoteValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaLoteValor $fkImobiliarioAtributoTipoLicencaLoteValor
     */
    public function removeFkImobiliarioAtributoTipoLicencaLoteValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaLoteValor $fkImobiliarioAtributoTipoLicencaLoteValor)
    {
        $this->fkImobiliarioAtributoTipoLicencaLoteValores->removeElement($fkImobiliarioAtributoTipoLicencaLoteValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoTipoLicencaLoteValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoTipoLicencaLoteValor
     */
    public function getFkImobiliarioAtributoTipoLicencaLoteValores()
    {
        return $this->fkImobiliarioAtributoTipoLicencaLoteValores;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioLicencaLoteParcelamentoSolo
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteParcelamentoSolo $fkImobiliarioLicencaLoteParcelamentoSolo
     * @return LicencaLote
     */
    public function addFkImobiliarioLicencaLoteParcelamentoSolos(\Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteParcelamentoSolo $fkImobiliarioLicencaLoteParcelamentoSolo)
    {
        if (false === $this->fkImobiliarioLicencaLoteParcelamentoSolos->contains($fkImobiliarioLicencaLoteParcelamentoSolo)) {
            $fkImobiliarioLicencaLoteParcelamentoSolo->setFkImobiliarioLicencaLote($this);
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
     * Add ImobiliarioLicencaLoteLoteamento
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteLoteamento $fkImobiliarioLicencaLoteLoteamento
     * @return LicencaLote
     */
    public function addFkImobiliarioLicencaLoteLoteamentos(\Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteLoteamento $fkImobiliarioLicencaLoteLoteamento)
    {
        if (false === $this->fkImobiliarioLicencaLoteLoteamentos->contains($fkImobiliarioLicencaLoteLoteamento)) {
            $fkImobiliarioLicencaLoteLoteamento->setFkImobiliarioLicencaLote($this);
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
     * ManyToOne (inverse side)
     * Set fkImobiliarioLicenca
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Licenca $fkImobiliarioLicenca
     * @return LicencaLote
     */
    public function setFkImobiliarioLicenca(\Urbem\CoreBundle\Entity\Imobiliario\Licenca $fkImobiliarioLicenca)
    {
        $this->codLicenca = $fkImobiliarioLicenca->getCodLicenca();
        $this->exercicio = $fkImobiliarioLicenca->getExercicio();
        $this->fkImobiliarioLicenca = $fkImobiliarioLicenca;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkImobiliarioLicenca
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Licenca
     */
    public function getFkImobiliarioLicenca()
    {
        return $this->fkImobiliarioLicenca;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkImobiliarioLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote
     * @return LicencaLote
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
     * OneToOne (inverse side)
     * Set ImobiliarioLicencaLoteArea
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteArea $fkImobiliarioLicencaLoteArea
     * @return LicencaLote
     */
    public function setFkImobiliarioLicencaLoteArea(\Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteArea $fkImobiliarioLicencaLoteArea)
    {
        $fkImobiliarioLicencaLoteArea->setFkImobiliarioLicencaLote($this);
        $this->fkImobiliarioLicencaLoteArea = $fkImobiliarioLicencaLoteArea;
        return $this;
    }

    /**
     * OneToOne (inverse side)
     * Get fkImobiliarioLicencaLoteArea
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\LicencaLoteArea
     */
    public function getFkImobiliarioLicencaLoteArea()
    {
        return $this->fkImobiliarioLicencaLoteArea;
    }
}
