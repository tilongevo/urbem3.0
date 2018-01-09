<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LoteUrbano
 */
class LoteUrbano
{
    /**
     * PK
     * @var integer
     */
    private $codLote;

    /**
     * OneToOne (owning side)
     * @var \Urbem\CoreBundle\Entity\Imobiliario\Lote
     */
    private $fkImobiliarioLote;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteUrbanoValor
     */
    private $fkImobiliarioAtributoLoteUrbanoValores;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioAtributoLoteUrbanoValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LoteUrbano
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
     * Add ImobiliarioAtributoLoteUrbanoValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteUrbanoValor $fkImobiliarioAtributoLoteUrbanoValor
     * @return LoteUrbano
     */
    public function addFkImobiliarioAtributoLoteUrbanoValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteUrbanoValor $fkImobiliarioAtributoLoteUrbanoValor)
    {
        if (false === $this->fkImobiliarioAtributoLoteUrbanoValores->contains($fkImobiliarioAtributoLoteUrbanoValor)) {
            $fkImobiliarioAtributoLoteUrbanoValor->setFkImobiliarioLoteUrbano($this);
            $this->fkImobiliarioAtributoLoteUrbanoValores->add($fkImobiliarioAtributoLoteUrbanoValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoLoteUrbanoValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteUrbanoValor $fkImobiliarioAtributoLoteUrbanoValor
     */
    public function removeFkImobiliarioAtributoLoteUrbanoValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteUrbanoValor $fkImobiliarioAtributoLoteUrbanoValor)
    {
        $this->fkImobiliarioAtributoLoteUrbanoValores->removeElement($fkImobiliarioAtributoLoteUrbanoValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoLoteUrbanoValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteUrbanoValor
     */
    public function getFkImobiliarioAtributoLoteUrbanoValores()
    {
        return $this->fkImobiliarioAtributoLoteUrbanoValores;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote
     * @return LoteUrbano
     */
    public function setFkImobiliarioLote(\Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote)
    {
        $this->codLote = $fkImobiliarioLote->getCodLote();
        $this->fkImobiliarioLote = $fkImobiliarioLote;
        return $this;
    }

    /**
     * OneToOne (owning side)
     * Get fkImobiliarioLote
     *
     * @return \Urbem\CoreBundle\Entity\Imobiliario\Lote
     */
    public function getFkImobiliarioLote()
    {
        return $this->fkImobiliarioLote;
    }
}
