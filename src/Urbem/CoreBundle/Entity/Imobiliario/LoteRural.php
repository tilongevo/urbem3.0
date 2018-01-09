<?php
 
namespace Urbem\CoreBundle\Entity\Imobiliario;

/**
 * LoteRural
 */
class LoteRural
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
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteRuralValor
     */
    private $fkImobiliarioAtributoLoteRuralValores;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkImobiliarioAtributoLoteRuralValores = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codLote
     *
     * @param integer $codLote
     * @return LoteRural
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
     * Add ImobiliarioAtributoLoteRuralValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteRuralValor $fkImobiliarioAtributoLoteRuralValor
     * @return LoteRural
     */
    public function addFkImobiliarioAtributoLoteRuralValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteRuralValor $fkImobiliarioAtributoLoteRuralValor)
    {
        if (false === $this->fkImobiliarioAtributoLoteRuralValores->contains($fkImobiliarioAtributoLoteRuralValor)) {
            $fkImobiliarioAtributoLoteRuralValor->setFkImobiliarioLoteRural($this);
            $this->fkImobiliarioAtributoLoteRuralValores->add($fkImobiliarioAtributoLoteRuralValor);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ImobiliarioAtributoLoteRuralValor
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteRuralValor $fkImobiliarioAtributoLoteRuralValor
     */
    public function removeFkImobiliarioAtributoLoteRuralValores(\Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteRuralValor $fkImobiliarioAtributoLoteRuralValor)
    {
        $this->fkImobiliarioAtributoLoteRuralValores->removeElement($fkImobiliarioAtributoLoteRuralValor);
    }

    /**
     * OneToMany (owning side)
     * Get fkImobiliarioAtributoLoteRuralValores
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Imobiliario\AtributoLoteRuralValor
     */
    public function getFkImobiliarioAtributoLoteRuralValores()
    {
        return $this->fkImobiliarioAtributoLoteRuralValores;
    }

    /**
     * OneToOne (owning side)
     * Set ImobiliarioLote
     *
     * @param \Urbem\CoreBundle\Entity\Imobiliario\Lote $fkImobiliarioLote
     * @return LoteRural
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
