<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * TipoParcelamento
 */
class TipoParcelamento
{
    const TIPO_PARCELAMENTO_AGLUTINACAO = 1;
    const TIPO_PARCELAMENTO_DESMEMBRAMENTO = 2;

    /**
     * PK
     * @var integer
     */
    private $codTipo;

    /**
     * @var string
     */
    private $nomTipo;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo
     */
    private $fkImobiliarioParcelamentoSolos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioParcelamentoSolos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codTipo
     *
     * @param integer $codTipo
     * @return TipoParcelamento
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
     * Set nomTipo
     *
     * @param string $nomTipo
     * @return TipoParcelamento
     */
    public function setNomTipo($nomTipo)
    {
        $this->nomTipo = $nomTipo;
        return $this;
    }

    /**
     * Get nomTipo
     *
     * @return string
     */
    public function getNomTipo()
    {
        return $this->nomTipo;
    }

    /**
     * OneToMany (owning side)
     * Add ImobiliarioParcelamentoSolo
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo $fkImobiliarioParcelamentoSolo
     * @return TipoParcelamento
     */
    public function addFkImobiliarioParcelamentoSolos(\Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo $fkImobiliarioParcelamentoSolo)
    {
        if (false === $this->fkImobiliarioParcelamentoSolos->contains($fkImobiliarioParcelamentoSolo)) {
            $fkImobiliarioParcelamentoSolo->setFkImobiliarioTipoParcelamento($this);
            $this->fkImobiliarioParcelamentoSolos->add($fkImobiliarioParcelamentoSolo);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioParcelamentoSolo
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo $fkImobiliarioParcelamentoSolo
     */
    public function removeFkImobiliarioParcelamentoSolos(\Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo $fkImobiliarioParcelamentoSolo)
    {
        $this->fkImobiliarioParcelamentoSolos->removeElement($fkImobiliarioParcelamentoSolo);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioParcelamentoSolos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\ParcelamentoSolo
     */
    public function getFkImobiliarioParcelamentoSolos()
    {
        return $this->fkImobiliarioParcelamentoSolos;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->nomTipo;
    }
}
